{{-- EDX Product Category — matches edx-category.html (banner cards, text left / image right) --}}
@php
    $categoryCards = ($categories ?? collect())->take(6);
@endphp
@if($categoryCards->isNotEmpty())
<div class="banner-block md:pt-16 pt-10 md:pb-6 pb-4 border-b border-line bg-white">
    <div class="container">
        <div class="heading text-center mb-10">
            <div class="heading3">EDX Product Category</div>
        </div>
        <div class="list-banner grid sm:grid-cols-2 md:grid-cols-3 gap-5 md:gap-[20px] mt-8">
            @foreach($categoryCards as $category)
                @php
                    $imgUrl = $category->image
                        ? storage_asset($category->image)
                        : asset('assets/images/PhotoshopExtension_Image-1.webp');
                    $desc = trim(strip_tags((string) ($category->description ?? '')));
                    if ($desc === '') {
                        $desc = 'Effortless rotation for precision and speed.';
                    } else {
                        $desc = \Illuminate\Support\Str::limit($desc, 140);
                    }
                @endphp
                <a href="{{ route('frontend.range', ['category' => $category->slug]) }}"
                   class="banner-ads-item block bg-linear rounded-2xl relative overflow-hidden cursor-pointer edxpro border border-line no-underline text-inherit">
                    <div class="text-content relative z-[1] py-10 md:py-12 pl-6 md:pl-8 pr-[36%] md:pr-32">
                        <div class="heading4 mt-2 text-black">{{ $category->name }}</div>
                        <div class="body1 mt-3 text-secondary">{{ $desc }}</div>
                        <span class="add-cart-btn button-main whitespace-nowrap text-center edx-red mt-8 md:mt-10 inline-flex items-center justify-center gap-2 uppercase text-[0.6875rem] font-bold tracking-[0.06em] rounded-lg py-3 px-5">
                            <i class="ph ph-files text-base" aria-hidden="true"></i>
                            View product
                        </span>
                    </div>
                    <img src="{{ $imgUrl }}" alt="{{ $category->name }}" class="w-[36%] md:w-[40%] absolute right-0 top-0 object-contain object-right-top pointer-events-none" loading="lazy" width="200" height="200">
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
