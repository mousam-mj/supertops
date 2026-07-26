@php
    $productBenefitItems = $productBenefitItems ?? product_benefit_items();
    $wrapperClass = $wrapperClass ?? 'get-it mt-6';
@endphp
<div class="{{ $wrapperClass }}">
    @if(!empty($heading))
        <div class="heading5">{{ $heading }}</div>
    @endif
    @foreach($productBenefitItems as $item)
        <div class="item flex items-center gap-3 mt-4">
            <div class="{{ $item['icon'] }} text-4xl"></div>
            <div>
                <div class="text-title">{{ $item['title'] }}</div>
                <div class="caption1 text-secondary mt-1">{{ $item['text'] }}</div>
            </div>
        </div>
    @endforeach
</div>
