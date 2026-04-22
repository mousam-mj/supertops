<?php

namespace App\Support;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final class CatalogFilterOptions
{
    /**
     * Bearing catalog categories that appear in the storefront sidebar, with product counts.
     */
    public static function categories(): Collection
    {
        $bearingsMainId = MainCategory::bearingsCatalogId();

        $catalogCategoryIds = Product::edxBearingsCatalog()
            ->where('is_active', true)
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id');

        return Category::query()
            ->where('is_active', true)
            ->whereIn('id', $catalogCategoryIds)
            ->when($bearingsMainId, function ($q) use ($bearingsMainId) {
                $q->where('main_category_id', $bearingsMainId);
            })
            ->withCount([
                'products as catalog_product_count' => function ($q) {
                    $q->edxBearingsCatalog()->where('is_active', true);
                },
            ])
            ->orderBy('name')
            ->get();
    }

    /**
     * Distinct overview-style spec values for sidebar chips (labels are HTML-stripped).
     *
     * @return array{rows: list<string>}
     */
    public static function facets(): array
    {
        $rows = [];

        foreach (Product::edxBearingsCatalog()->where('is_active', true)->pluck('specifications') as $raw) {
            $s = is_array($raw) ? $raw : (json_decode((string) $raw, true) ?: []);
            if (! is_array($s)) {
                continue;
            }
            $row = isset($s['number_of_rows']) ? trim(strip_tags((string) $s['number_of_rows'])) : '';
            if ($row !== '') {
                $rows[$row] = true;
            }
        }

        $rowKeys = array_keys($rows);
        natcasesort($rowKeys);

        return [
            'rows' => array_slice(array_values($rowKeys), 0, 12),
        ];
    }

    public static function parseSpecNumeric(mixed $specifications, string $key): ?float
    {
        if (is_string($specifications)) {
            $specifications = json_decode($specifications, true);
        }
        if (! is_array($specifications) || ! array_key_exists($key, $specifications)) {
            return null;
        }
        $raw = $specifications[$key];
        if ($raw === null || $raw === '') {
            return null;
        }
        $s = strtolower(trim(strip_tags((string) $raw)));
        if (preg_match('/-?\d+(?:[.,]\d+)?/', $s, $m)) {
            return (float) str_replace(',', '.', $m[0]);
        }

        return null;
    }

    /**
     * Narrow a bearings-catalog product query using sidebar / URL filters.
     */
    public static function applyListingFilters(Builder $query, Request $request): void
    {
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('sku', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('bore')) {
            $bounds = match ($request->get('bore')) {
                '0-20' => [0.0, 20.0],
                '20-50' => [20.0, 50.0],
                '50-100' => [50.0, 100.0],
                '100+' => [100.0, null],
                default => null,
            };
            if ($bounds !== null) {
                [$min, $max] = $bounds;
                $ids = Product::edxBearingsCatalog()
                    ->where('is_active', true)
                    ->pluck('specifications', 'id')
                    ->filter(function ($specs, $id) use ($min, $max) {
                        $n = self::parseSpecNumeric($specs, 'bore_diameter');
                        if ($n === null) {
                            return false;
                        }
                        if ($max === null) {
                            return $n >= $min;
                        }

                        return $n >= $min && $n < $max;
                    })
                    ->keys()
                    ->values()
                    ->all();
                if ($ids === []) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereIn('id', $ids);
                }
            }
        }

        if ($request->filled('rows')) {
            $want = trim(strip_tags((string) $request->get('rows')));
            if ($want !== '') {
                $ids = Product::edxBearingsCatalog()
                    ->where('is_active', true)
                    ->pluck('specifications', 'id')
                    ->filter(function ($specs) use ($want) {
                        if (is_string($specs)) {
                            $specs = json_decode($specs, true);
                        }
                        if (! is_array($specs)) {
                            return false;
                        }
                        $r = isset($specs['number_of_rows']) ? trim(strip_tags((string) $specs['number_of_rows'])) : '';

                        return $r !== '' && strcasecmp($r, $want) === 0;
                    })
                    ->keys()
                    ->values()
                    ->all();
                if ($ids === []) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->whereIn('id', $ids);
                }
            }
        }
    }
}
