<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\QuotaRequestAdminMail;
use App\Mail\QuotaRequestCustomerMail;
use App\Models\Product;
use App\Models\QuotaRequest;
use App\Models\QuotaRequestItem;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class QuotaListController extends Controller
{
    private const SESSION_KEY = 'edx_quota_list';

    public function index(Request $request): View
    {
        $lines = $this->sessionLines($request);
        $productIds = collect($lines)->pluck('product_id')->unique()->filter()->all();
        $products = $productIds === []
            ? collect()
            : Product::edxBearingsCatalog()
                ->where('is_active', true)
                ->whereIn('id', $productIds)
                ->with('category')
                ->get()
                ->keyBy('id');

        $rows = [];
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            $product = $products->get($pid);
            $rows[] = [
                'product_id' => $pid,
                'quantity' => $qty,
                'product' => $product,
            ];
        }

        $hasValidRows = collect($rows)->contains(fn ($r) => $r['product'] !== null);
        $hasStaleRows = collect($rows)->contains(fn ($r) => $r['product'] === null && $r['product_id'] > 0);
        $hasAnyLines = count($rows) > 0;

        return view('frontend.quota-list', compact('rows', 'hasValidRows', 'hasStaleRows', 'hasAnyLines'));
    }

    public function count(Request $request): JsonResponse
    {
        return response()->json([
            'count' => $this->distinctProductCount($request),
        ]);
    }

    /**
     * JSON payload for header quota modal (SKU, qty, links).
     */
    public function preview(Request $request): JsonResponse
    {
        $lines = $this->sessionLines($request);
        $excludeIds = collect($lines)->pluck('product_id')->unique()->filter()->map(fn ($id) => (int) $id)->all();
        $suggestions = $this->suggestionProductsForModal($excludeIds);

        if ($lines === []) {
            return response()->json([
                'empty' => true,
                'count' => 0,
                'items' => [],
                'suggestions' => $suggestions,
            ]);
        }

        $productIds = collect($lines)->pluck('product_id')->unique()->filter()->all();
        $products = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereIn('id', $productIds)
            ->with('category')
            ->get()
            ->keyBy('id');

        $items = [];
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            $product = $products->get($pid);
            if (! $product) {
                continue;
            }
            $items[] = [
                'product_id' => $pid,
                'quantity' => $qty,
                'sku' => $product->sku,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => $product->category->name ?? '',
                'image_url' => $product->image_url,
            ];
        }

        return response()->json([
            'empty' => $items === [],
            'count' => $this->distinctProductCount($request),
            'items' => $items,
            'suggestions' => $suggestions,
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
            'quantity' => 'nullable|integer|min:1|max:99999',
        ]);

        $quantity = max(1, (int) ($validated['quantity'] ?? 1));
        $productId = (int) $validated['product_id'];

        if (! $this->productAllowed($productId)) {
            return response()->json(['ok' => false, 'message' => 'Product not found.'], 422);
        }

        $lines = $this->sessionLines($request);
        $found = false;
        foreach ($lines as &$line) {
            if ((int) $line['product_id'] === $productId) {
                $line['quantity'] = min(99999, (int) $line['quantity'] + $quantity);
                $found = true;
                break;
            }
        }
        unset($line);

        if (! $found) {
            $lines[] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        $request->session()->put(self::SESSION_KEY, $lines);

        return response()->json([
            'ok' => true,
            'count' => $this->distinctProductCount($request),
            'message' => 'Added to your quota list.',
        ]);
    }

    public function updateLine(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1|max:99999',
        ]);

        $lines = $this->sessionLines($request);
        $updated = false;
        foreach ($lines as &$line) {
            if ((int) $line['product_id'] === (int) $validated['product_id']) {
                $line['quantity'] = (int) $validated['quantity'];
                $updated = true;
                break;
            }
        }
        unset($line);

        if (! $updated) {
            if ($request->wantsJson()) {
                return response()->json(['ok' => false, 'message' => 'Line not found.'], 404);
            }

            return back()->with('error', 'Line not found.');
        }

        $request->session()->put(self::SESSION_KEY, $lines);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'count' => $this->distinctProductCount($request)]);
        }

        return back()->with('success', 'Quantity updated.');
    }

    public function remove(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|integer|min:1',
        ]);

        $lines = array_values(array_filter(
            $this->sessionLines($request),
            fn ($line) => (int) ($line['product_id'] ?? 0) !== (int) $validated['product_id']
        ));

        $request->session()->put(self::SESSION_KEY, $lines);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'count' => $this->distinctProductCount($request)]);
        }

        return back()->with('success', 'Removed from quota list.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return back()->with('success', 'Your quota list was cleared.');
    }

    public function submit(Request $request): RedirectResponse
    {
        $lines = $this->sessionLines($request);
        if ($lines === []) {
            return back()->with('error', 'Your quota list is empty. Add products before submitting.');
        }

        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:64',
            'message' => 'nullable|string|max:5000',
        ]);

        $productIds = collect($lines)->pluck('product_id')->unique()->all();
        $products = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        if ($products->isEmpty()) {
            return back()->with('error', 'No valid products in your list.');
        }

        $quotaRequest = QuotaRequest::create([
            'reference' => QuotaRequest::generateReference(),
            'company_name' => $validated['company_name'] ?? null,
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        $createdItems = 0;
        foreach ($lines as $line) {
            $pid = (int) ($line['product_id'] ?? 0);
            $product = $products->get($pid);
            if (! $product) {
                continue;
            }
            QuotaRequestItem::create([
                'quota_request_id' => $quotaRequest->id,
                'product_id' => $product->id,
                'quantity' => max(1, (int) ($line['quantity'] ?? 1)),
                'product_sku' => $product->sku,
                'product_name' => $product->name,
            ]);
            $createdItems++;
        }

        if ($createdItems === 0) {
            $quotaRequest->delete();

            return back()->with('error', 'None of the products in your list are available anymore. Please add current products and try again.');
        }

        $quotaRequest->load('items');

        $customerEmail = $validated['email'];
        $adminEmail = Setting::get('contact_email') ?: config('mail.from.address');
        $adminOk = is_string($adminEmail) && filter_var($adminEmail, FILTER_VALIDATE_EMAIL);

        if ($adminOk && strcasecmp($adminEmail, $customerEmail) === 0) {
            try {
                Mail::to($adminEmail)->send(new QuotaRequestAdminMail($quotaRequest));
            } catch (\Throwable $e) {
                Log::warning('Quota request email failed', [
                    'reference' => $quotaRequest->reference,
                    'message' => $e->getMessage(),
                ]);
            }
        } else {
            try {
                Mail::to($customerEmail)->send(new QuotaRequestCustomerMail($quotaRequest));
            } catch (\Throwable $e) {
                Log::warning('Quota request customer email failed', [
                    'reference' => $quotaRequest->reference,
                    'message' => $e->getMessage(),
                ]);
            }
            if ($adminOk) {
                try {
                    Mail::to($adminEmail)->send(new QuotaRequestAdminMail($quotaRequest));
                } catch (\Throwable $e) {
                    Log::warning('Quota request admin email failed', [
                        'reference' => $quotaRequest->reference,
                        'message' => $e->getMessage(),
                    ]);
                }
            }
        }

        $request->session()->forget(self::SESSION_KEY);

        return redirect()
            ->route('frontend.quota-list.index')
            ->with('success', 'Your quota request '.$quotaRequest->reference.' was sent. Our team will contact you shortly.');
    }

    /**
     * @param  list<int>  $excludeProductIds
     * @return list<array{slug: string, sku: ?string, name: string, image_url: string}>
     */
    private function suggestionProductsForModal(array $excludeProductIds): array
    {
        $q = Product::edxBearingsCatalog()->where('is_active', true);
        if ($excludeProductIds !== []) {
            $q->whereNotIn('id', $excludeProductIds);
        }

        return $q->inRandomOrder()
            ->limit(6)
            ->get(['id', 'slug', 'sku', 'name'])
            ->map(fn (Product $p) => [
                'slug' => $p->slug,
                'sku' => $p->sku,
                'name' => $p->name,
                'image_url' => $p->image_url,
            ])
            ->values()
            ->all();
    }

    private function sessionLines(Request $request): array
    {
        $raw = $request->session()->get(self::SESSION_KEY, []);

        return is_array($raw) ? $raw : [];
    }

    private function distinctProductCount(Request $request): int
    {
        $ids = collect($this->sessionLines($request))->pluck('product_id')->unique()->filter();

        return $ids->count();
    }

    private function productAllowed(int $productId): bool
    {
        return Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereKey($productId)
            ->exists();
    }
}
