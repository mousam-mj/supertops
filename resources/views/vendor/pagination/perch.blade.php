@if ($paginator->hasPages())
    <nav class="shop-pagination-nav flex items-center justify-center gap-2 flex-wrap w-full" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        @if ($paginator->currentPage() > 2)
            <a href="{{ $paginator->url(1) }}" class="shop-page-btn" aria-label="{{ __('Go to page 1') }}">&laquo;</a>
        @endif

        @if ($paginator->onFirstPage())
            <span class="shop-page-btn shop-page-btn--disabled" aria-disabled="true">&lsaquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="shop-page-btn" rel="prev" aria-label="{{ __('pagination.previous') }}">&lsaquo;</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="shop-page-btn shop-page-btn--ellipsis" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="shop-page-btn active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="shop-page-btn" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="shop-page-btn" rel="next" aria-label="{{ __('pagination.next') }}">&rsaquo;</a>
        @else
            <span class="shop-page-btn shop-page-btn--disabled" aria-disabled="true">&rsaquo;</span>
        @endif

        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
            <a href="{{ $paginator->url($paginator->lastPage()) }}" class="shop-page-btn" aria-label="{{ __('Go to last page') }}">&raquo;</a>
        @endif
    </nav>

    @if ($paginator->total() > 0)
        <p class="caption1 text-secondary text-center w-full mt-3 mb-0">
            Showing {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} products
        </p>
    @endif
@endif
