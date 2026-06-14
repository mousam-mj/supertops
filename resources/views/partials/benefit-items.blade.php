<div class="list-benefit grid items-start lg:grid-cols-4 grid-cols-2 gap-[30px]">
    @foreach($benefitItems as $item)
        <div class="benefit-item flex flex-col items-center justify-center">
            <i class="{{ $item['icon'] }} lg:text-7xl text-5xl"></i>
            <div class="heading6 text-center mt-5">{{ $item['title'] }}</div>
            <div class="caption1 text-secondary text-center mt-3">{{ $item['text'] }}</div>
        </div>
    @endforeach
</div>
