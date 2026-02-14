@extends('layouts.app')

@section('title', 'Ricimart - Premium Mobile Accessories Store | Phone Cases, Chargers & More')

@section('content')
<div id="home-content" style="background: transparent !important; color: white !important;">
    <!-- Hero Section -->
    <section class="hero text-center" style="padding: 100px 10% 60px; background: transparent !important; color: white !important;">
        <h1 style="font-size: 42px; font-weight: 700; background: linear-gradient(to right, #00ffee, #ff00cc); -webkit-background-clip: text; color: transparent; margin-bottom: 15px;">Premium Mobile Accessories</h1>
        <p style="margin-top: 15px; color: #ccc !important; font-size: 18px;">Best quality chargers, headphones, cases & more at unbeatable prices.</p>
        <a href="{{{ route('shop') }}}" style="display: inline-block; margin-top: 25px; padding: 12px 30px; border: none; border-radius: 30px; background: linear-gradient(45deg, #ff00cc, #3333ff); color: white !important; font-weight: 600; cursor: pointer; transition: 0.4s; text-decoration: none;" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 0 20px #ff00cc';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">Shop Now</a>
    </section>

    <!-- Products Section -->
    <section class="products" style="padding: 60px 8%; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; background: transparent !important;">
        @forelse($featuredProducts->take(6) as $product)
            <div class="card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border-radius: 15px; padding: 20px; text-align: center; transition: 0.4s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 0 25px #00ffee';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; border-radius: 10px; margin-bottom: 15px;" />
                @else
                    <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #ff00cc, #3333ff); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 15px;">📱</div>
                @endif
                <h3 style="margin-top: 15px; font-size: 20px; font-weight: 600; color: white !important;">{{ $product->name }}</h3>
                <p style="color: #aaa !important; margin: 10px 0;">{{ Str::limit($product->short_description ?? $product->description, 50) }}</p>
                <div style="margin-top: 15px; font-size: 18px; font-weight: 600; color: #00ffee !important;">₹{{ number_format($product->sale_price ?? $product->price, 2) }}</div>
                <a href="{{ route('product.show', $product->slug) }}" style="display: inline-block; margin-top: 15px; padding: 8px 20px; background: linear-gradient(45deg, #ff00cc, #3333ff); color: white !important; border-radius: 20px; text-decoration: none; font-size: 14px;">View Details</a>
            </div>
        @empty
            <div class="card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border-radius: 15px; padding: 20px; text-align: center; transition: 0.4s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 0 25px #00ffee';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #ff00cc, #3333ff); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 15px;">🎧</div>
                <h3 style="margin-top: 15px; font-size: 20px; font-weight: 600; color: white !important;">Wireless Earbuds</h3>
                <p style="color: #aaa !important; margin: 10px 0;">High bass sound with long battery life.</p>
                <div style="margin-top: 15px; font-size: 18px; font-weight: 600; color: #00ffee !important;">₹1,999</div>
            </div>
            <div class="card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border-radius: 15px; padding: 20px; text-align: center; transition: 0.4s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 0 25px #00ffee';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #3333ff, #00ffee); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 15px;">🔌</div>
                <h3 style="margin-top: 15px; font-size: 20px; font-weight: 600; color: white !important;">Fast Charger</h3>
                <p style="color: #aaa !important; margin: 10px 0;">Super fast charging for all devices.</p>
                <div style="margin-top: 15px; font-size: 18px; font-weight: 600; color: #00ffee !important;">₹599</div>
            </div>
            <div class="card" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border-radius: 15px; padding: 20px; text-align: center; transition: 0.4s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 0 25px #00ffee';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <div style="width: 100%; height: 200px; background: linear-gradient(45deg, #00ffee, #ff00cc); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 48px; margin-bottom: 15px;">📱</div>
                <h3 style="margin-top: 15px; font-size: 20px; font-weight: 600; color: white !important;">Premium Phone Case</h3>
                <p style="color: #aaa !important; margin: 10px 0;">Stylish & shockproof protection.</p>
                <div style="margin-top: 15px; font-size: 18px; font-weight: 600; color: #00ffee !important;">₹899</div>
            </div>
        @endforelse
    </section>
</div>
@endsection
