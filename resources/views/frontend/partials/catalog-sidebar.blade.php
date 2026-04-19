@php
    $facets = $facets ?? ['cages' => [], 'rows' => []];
    $cageList = $facets['cages'] ?? [];
    $rowList = $facets['rows'] ?? [];
@endphp
<!-- Category filter (catalog categories + counts) -->
<div class="filter-type-block pb-8 border-b border-line">
    <div class="heading6">Products type</div>
    <div class="list-type filter-type menu-tab mt-4">
        <a href="{{ route('frontend.range', request()->except(['category', 'page'])) }}"
           class="item tab-item flex items-center justify-between cursor-pointer {{ ! request()->filled('category') ? 'active' : '' }}">
            <div class="type-name text-secondary has-line-before hover:text-black capitalize">All types</div>
            <div class="text-secondary2 number">{{ $categories->sum('catalog_product_count') }}</div>
        </a>
        @foreach($categories as $category)
            <a href="{{ route('frontend.range', array_merge(request()->except(['category', 'page']), ['category' => $category->slug])) }}"
               class="item tab-item flex items-center justify-between cursor-pointer {{ request('category') === $category->slug ? 'active' : '' }}"
               data-item="{{ $category->slug }}">
                <div class="type-name text-secondary has-line-before hover:text-black capitalize">{{ $category->name }}</div>
                <div class="text-secondary2 number">{{ $category->catalog_product_count ?? 0 }}</div>
            </a>
        @endforeach
    </div>
</div>

<!-- Search -->
<div class="filter-search pb-8 border-b border-line mt-8">
    <div class="heading6">Search</div>
    <form action="{{ route('frontend.range') }}" method="GET" class="mt-4">
        @foreach (['bore', 'cage', 'rows', 'sort', 'category'] as $preserveKey)
            @if (request()->filled($preserveKey))
                <input type="hidden" name="{{ $preserveKey }}" value="{{ request($preserveKey) }}">
            @endif
        @endforeach
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or SKU…"
                   class="w-full py-3 pl-4 pr-10 rounded-lg border border-line">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2" aria-label="Search">
                <i class="ph ph-magnifying-glass text-xl"></i>
            </button>
        </div>
    </form>
</div>

<!-- Bore (overview boundary dimension) -->
<div class="filter-size pb-8 border-b border-line mt-8">
    <div class="heading6">Bore diameter (mm)</div>
    <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
        <a href="{{ route('frontend.range', request()->except(['bore', 'page'])) }}"
           class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ ! request()->filled('bore') ? 'bg-black text-white' : '' }}">All</a>
        @foreach (['0-20' => '0–20', '20-50' => '20–50', '50-100' => '50–100', '100+' => '100+'] as $bKey => $bLabel)
            <a href="{{ route('frontend.range', array_merge(request()->except(['bore', 'page']), ['bore' => $bKey])) }}"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('bore') === $bKey ? 'bg-black text-white' : '' }}">{{ $bLabel }}</a>
        @endforeach
    </div>
</div>

@if(count($cageList) > 0)
    <div class="filter-size pb-8 border-b border-line mt-8">
        <div class="heading6">Cage (overview)</div>
        <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
            <a href="{{ route('frontend.range', request()->except(['cage', 'page'])) }}"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ ! request()->filled('cage') ? 'bg-black text-white' : '' }}">All</a>
            @foreach($cageList as $cage)
                <a href="{{ route('frontend.range', array_merge(request()->except(['cage', 'page']), ['cage' => $cage])) }}"
                   class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('cage') === $cage ? 'bg-black text-white' : '' }}">{{ $cage }}</a>
            @endforeach
        </div>
    </div>
@endif

@if(count($rowList) > 0)
    <div class="filter-size pb-8 border-b border-line mt-8">
        <div class="heading6">Number of rows</div>
        <div class="list-size flex items-center flex-wrap gap-3 gap-y-4 mt-4">
            <a href="{{ route('frontend.range', request()->except(['rows', 'page'])) }}"
               class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ ! request()->filled('rows') ? 'bg-black text-white' : '' }}">All</a>
            @foreach($rowList as $row)
                <a href="{{ route('frontend.range', array_merge(request()->except(['rows', 'page']), ['rows' => $row])) }}"
                   class="size-item text-button px-4 py-2 flex items-center justify-center rounded-full border border-line {{ request('rows') === $row ? 'bg-black text-white' : '' }}">{{ $row }}</a>
            @endforeach
        </div>
    </div>
@endif
