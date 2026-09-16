<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * List all product reviews for admin.
     */
    public function index(Request $request)
    {
        $reviews = ProductReview::with(['product', 'user'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show form to add a review without a customer order.
     */
    public function create(Request $request)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get(['id', 'name']);
        $preselectedProductId = $request->integer('product_id') ?: null;

        return view('admin.reviews.create', compact('products', 'preselectedProductId'));
    }

    /**
     * Store an admin-created review.
     */
    public function store(Request $request)
    {
        $validated = $this->validateReview($request);

        $review = ProductReview::create([
            'product_id' => $validated['product_id'],
            'user_id' => null,
            'guest_name' => trim($validated['guest_name']),
            'guest_email' => $validated['guest_email'] ?? null,
            'rating' => (int) $validated['rating'],
            'comment' => isset($validated['comment']) ? trim($validated['comment']) : null,
            'is_approved' => $request->boolean('is_approved', true),
        ]);

        $this->applyReviewDate($review, $validated['reviewed_at'] ?? null);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review added successfully.');
    }

    /**
     * Show form to edit a review.
     */
    public function edit(ProductReview $review)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return view('admin.reviews.edit', compact('review', 'products'));
    }

    /**
     * Update a review.
     */
    public function update(Request $request, ProductReview $review)
    {
        $validated = $this->validateReview($request);

        $review->update([
            'product_id' => $validated['product_id'],
            'guest_name' => trim($validated['guest_name']),
            'guest_email' => $validated['guest_email'] ?? null,
            'rating' => (int) $validated['rating'],
            'comment' => isset($validated['comment']) ? trim($validated['comment']) : null,
            'is_approved' => $request->boolean('is_approved', true),
        ]);

        $this->applyReviewDate($review, $validated['reviewed_at'] ?? null);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Delete a product review (admin only).
     */
    public function destroy(Request $request, ProductReview $review)
    {
        $product = $review->product;
        $review->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }
        if (request()->has('from') && request('from') === 'admin') {
            return redirect()->route('admin.reviews.index')->with('success', 'Review deleted.');
        }

        return redirect()
            ->route('product.show', $product->slug)
            ->with('success', 'Review deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateReview(Request $request): array
    {
        return $request->validate([
            'product_id' => 'required|exists:products,id',
            'guest_name' => 'required|string|max:100',
            'guest_email' => 'nullable|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
            'reviewed_at' => 'nullable|date',
            'is_approved' => 'nullable|boolean',
        ]);
    }

    private function applyReviewDate(ProductReview $review, ?string $reviewedAt): void
    {
        if (! $reviewedAt) {
            return;
        }

        $review->created_at = Carbon::parse($reviewedAt);
        $review->save();
    }
}
