@extends('layouts.app')

@section('title', ($product->name ?? 'Customize Tumbler') . ' | Perch')

@section('content')
<style>
.customize-page{font-family:'Inter',sans-serif;background:#efefed;color:#1a1a1a;padding:24px 16px;min-height:70vh;display:flex;align-items:center;justify-content:center;}
.customize-page .modal{background:#fff;border-radius:18px;width:100%;max-width:1120px;min-height:650px;display:flex;flex-direction:column;overflow:hidden;box-shadow:0 12px 70px rgba(0,0,0,0.2);}
.customize-page .top-nav{display:flex;align-items:center;padding:0 28px;height:58px;border-bottom:1px solid #e5e5e5;flex-shrink:0;}
.customize-page .nav-steps{display:flex;align-items:center;flex:1;}
.customize-page .nav-step{font-size:14px;font-weight:400;color:#999;padding:0 20px;cursor:pointer;height:58px;display:flex;align-items:center;border-bottom:2.5px solid transparent;margin-bottom:-1px;transition:all .2s;white-space:nowrap;}
.customize-page .nav-step:first-child{padding-left:0;}
.customize-page .nav-step:hover{color:#1a1a1a;}
.customize-page .nav-step.active{font-weight:700;color:#1a1a1a;border-bottom-color:#1a1a1a;}
.customize-page .nav-step.done:not(.active){color:#555;font-weight:600;}
.customize-page .nav-steps{overflow-x:auto;flex-wrap:nowrap;scrollbar-width:thin;-webkit-overflow-scrolling:touch;}
.customize-page .flow-hint{font-size:12px;color:#888;margin-top:10px;line-height:1.45;}
.customize-page .engrave-skip-label{display:flex;align-items:center;gap:8px;font-size:13px;color:#555;margin-bottom:12px;cursor:pointer;}
.customize-page .engrave-skip-label input{width:16px;height:16px;accent-color:#1a1a1a;}
.customize-page .nav-right{display:flex;align-items:center;gap:12px;margin-left:auto;}
.customize-page .nav-cart-wrap{display:flex;flex-direction:column;align-items:flex-end;gap:2px;}
.customize-page .price-hint{font-size:11px;color:#888;font-weight:400;max-width:220px;text-align:right;line-height:1.3;}
.customize-page .add-cart-btn{background:#1a1a1a;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;cursor:pointer;white-space:nowrap;transition:background .2s;}
.customize-page .add-cart-btn:hover{background:#333;}
.customize-page .close-btn{width:32px;height:32px;border:none;background:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#999;font-size:18px;border-radius:50%;transition:background .2s;text-decoration:none;color:inherit;}
.customize-page .close-btn:hover{background:#f0f0f0;color:#1a1a1a;}
.customize-page .content{display:flex;flex:1;min-height:0;}
.customize-page .left-col{flex:0 0 56%;background:#f0f0ee;display:flex;flex-direction:column;align-items:center;padding:24px 28px 18px;position:relative;border-right:1px solid #e8e8e8;}
.customize-page .bottle-title{font-size:17px;font-weight:700;align-self:flex-start;margin-bottom:12px;}
.customize-page #three-wrap{width:100%;flex:1;position:relative;min-height:390px;display:flex;align-items:center;justify-content:center;}
.customize-page #three-wrap canvas{border-radius:10px;cursor:grab;display:block;}
.customize-page #three-wrap canvas:active{cursor:grabbing;}
.customize-page .loading-msg{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:14px;background:#f0f0ee;border-radius:10px;z-index:10;}
.customize-page .spinner{width:36px;height:36px;border:3px solid #ddd;border-top-color:#1a1a1a;border-radius:50%;animation:customize-spin .8s linear infinite;}
@keyframes customize-spin{to{transform:rotate(360deg)}}
.customize-page .loading-text{font-size:13px;color:#888;}
.customize-page .view-controls{position:absolute;left:10px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:6px;z-index:5;}
.customize-page .view-btn{width:30px;height:30px;border:1px solid #ddd;background:rgba(255,255,255,.92);border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;transition:background .15s;}
.customize-page .view-btn:hover{background:#fff;border-color:#bbb;}
.customize-page .side-wish{position:absolute;left:10px;top:12px;z-index:5;}
.customize-page .wish-btn{width:34px;height:34px;border:none;background:none;cursor:pointer;font-size:20px;color:#ccc;transition:color .2s;display:flex;align-items:center;justify-content:center;}
.customize-page .wish-btn:hover{color:#e05;}.customize-page .wish-btn.active{color:#e05;}
.customize-page .hint-label{position:absolute;bottom:10px;right:12px;font-size:10px;color:#aaa;pointer-events:none;}
.customize-page .bottom-links{display:flex;gap:20px;margin-top:10px;align-self:flex-start;}
.customize-page .bottom-link{font-size:12px;color:#1a1a1a;cursor:pointer;text-decoration:underline;text-underline-offset:3px;}
.customize-page .bottom-note{font-size:11px;color:#aaa;margin-top:6px;align-self:flex-start;}
.customize-page .right-col{flex:1;padding:28px 30px 20px;display:flex;flex-direction:column;overflow-y:auto;}
.customize-page .step-heading{font-size:22px;font-weight:700;margin-bottom:2px;}
.customize-page .step-counter{font-size:13px;color:#999;margin-bottom:5px;}
.customize-page .step-subtext{font-size:13px;color:#666;margin-bottom:18px;}
.customize-page .size-cards{display:flex;flex-direction:column;gap:12px;margin-bottom:18px;}
.customize-page .size-card{border:1.5px solid #e0e0e0;border-radius:10px;padding:13px 15px;display:flex;align-items:center;gap:13px;cursor:pointer;transition:all .2s;background:#fff;}
.customize-page .size-card:hover{border-color:#999;}
.customize-page .size-card.selected{border:2.5px solid #1a1a1a;box-shadow:0 0 0 1px #1a1a1a;}
.customize-page .option-card{border:1.5px solid #1a1a1a;border-radius:10px;padding:13px 15px;display:flex;align-items:center;gap:13px;margin-bottom:18px;background:#fff;}
.customize-page .option-thumb{width:44px;height:44px;border-radius:6px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.customize-page .option-thumb svg{width:30px;height:30px;}
.customize-page .option-info{flex:1;}.customize-page .option-name{font-size:14px;font-weight:700;margin-bottom:3px;}.customize-page .option-desc{font-size:12px;color:#888;}.customize-page .option-price{font-size:14px;font-weight:600;}
.customize-page .color-label{font-size:13px;color:#666;margin-bottom:10px;text-align:center;}
.customize-page .color-row{display:flex;align-items:center;margin-bottom:4px;}
.customize-page .color-arrow{width:28px;height:28px;border:none;background:none;cursor:pointer;font-size:20px;color:#888;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:background .15s;flex-shrink:0;}
.customize-page .color-arrow:hover{background:#f0f0f0;color:#1a1a1a;}
.customize-page .swatches-track{display:flex;gap:8px;align-items:center;overflow:hidden;flex:1;padding:4px;}
.customize-page .swatch{width:36px;height:36px;border-radius:50%;cursor:pointer;border:3px solid transparent;flex-shrink:0;transition:transform .15s,border-color .15s;box-shadow:0 1px 5px rgba(0,0,0,0.2);position:relative;}
.customize-page .swatch:hover:not(.out-of-stock){transform:scale(1.12);}.customize-page .swatch.selected{border-color:#1a1a1a;transform:scale(1.1);}
.customize-page .swatch.out-of-stock{cursor:not-allowed;opacity:0.6;}
.customize-page .swatch.out-of-stock::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,transparent 45%,#ccc 45%,#ccc 55%,transparent 55%);border-radius:50%;}
.customize-page .color-name-label{text-align:center;font-size:12px;color:#777;min-height:16px;margin-bottom:4px;}
.customize-page .engrave-mode{margin-bottom:14px;}
.customize-page .engrave-mode label{margin-right:16px;cursor:pointer;font-size:13px;}
.customize-page .engrave-header{display:flex;align-items:center;gap:10px;margin-bottom:14px;flex-wrap:wrap;}
.customize-page .cat-btn{padding:5px 13px;border:1px solid #ccc;border-radius:20px;font-size:12px;font-weight:500;cursor:pointer;background:#fff;color:#666;transition:all .15s;}
.customize-page .cat-btn.active{background:#1a1a1a;color:#fff;border-color:#1a1a1a;}
.customize-page .engrave-sel-label{margin-left:auto;font-size:12px;color:#666;}
.customize-page .engrave-sel-label span{font-weight:700;color:#1a1a1a;}
.customize-page .engrave-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:18px;transition:opacity .2s;}
.customize-page .engrave-grid.engrave-off{opacity:0.42;pointer-events:none;}
.customize-page .engrave-tile{aspect-ratio:1;border:1.5px solid #e0e0e0;border-radius:8px;background:#fafafa;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all .15s;padding:5px;overflow:hidden;}
.customize-page .engrave-tile:hover{border-color:#aaa;background:#efefef;}.customize-page .engrave-tile.selected{border:2.5px solid #1a1a1a;background:#fff;}
.customize-page .engrave-tile svg{width:100%;height:100%;stroke:#1a1a1a;fill:none;stroke-width:1.4;stroke-linecap:round;stroke-linejoin:round;}
.customize-page .bottom-nav{display:flex;justify-content:flex-end;gap:10px;margin-top:auto;padding-top:16px;flex-shrink:0;align-items:center;flex-wrap:wrap;}
.customize-page .prev-btn{padding:11px 20px;border:1.5px solid #1a1a1a;border-radius:8px;background:#fff;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;cursor:pointer;color:#1a1a1a;transition:background .15s;}
.customize-page .prev-btn:hover{background:#f5f5f5;}
.customize-page .next-btn{padding:11px 22px;border:none;border-radius:8px;background:#1a1a1a;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;cursor:pointer;color:#fff;transition:background .15s;}
.customize-page .next-btn:hover{background:#333;}
.customize-page .qty-select{padding:9px 12px;border:1px solid #ccc;border-radius:6px;font-family:'Inter',sans-serif;font-size:13px;}
.customize-page .step-panel{display:none;flex-direction:column;flex:1;}.customize-page .step-panel.active{display:flex;}
@media(max-width:700px){.customize-page .content{flex-direction:column;}.customize-page .left-col{flex:0 0 auto;border-right:none;border-bottom:1px solid #e8e8e8;padding:16px;min-height:300px;}.customize-page .right-col{padding:18px;}.customize-page #three-wrap{min-height:260px;}.customize-page .engrave-grid{grid-template-columns:repeat(3,1fr);}.customize-page .nav-step{padding:0 10px;font-size:12px;}}
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="customize-page">
  <div class="modal">
    <div class="top-nav">
      <div class="nav-steps">
        <div class="nav-step active" data-step="1" onclick="goTo(1)">Tumbler</div>
        <div class="nav-step" data-step="2" onclick="goTo(2)">Lid</div>
        <div class="nav-step" data-step="3" onclick="goTo(3)">Straw</div>
        <div class="nav-step" data-step="4" onclick="goTo(4)">Handle</div>
        <div class="nav-step" data-step="5" onclick="goTo(5)">Engraving</div>
      </div>
      <div class="nav-right">
        <div class="nav-cart-wrap">
          <button class="add-cart-btn" id="top-cart-btn" onclick="addToCart()">Add to Cart – {{ $config['currency'] }}{{ number_format($config['base_price'] + ($config['has_engraving'] ? $config['engraving_price'] : 0), 2) }}</button>
          <span class="price-hint" id="price-hint"></span>
        </div>
        <a href="{{ route('home') }}" class="close-btn" title="Close">✕</a>
      </div>
    </div>
    <div class="content">
      <div class="left-col">
        <div class="bottle-title">{{ $product->name }}</div>
        <div id="three-wrap">
          <div class="loading-msg" id="loading-msg">
            <div class="spinner"></div>
            <div class="loading-text">Loading 3D model…</div>
          </div>
          <div class="view-controls">
            <button class="view-btn" title="Reset" onclick="resetCam()">⟳</button>
            <button class="view-btn" title="Zoom in" onclick="zoomIn()">＋</button>
            <button class="view-btn" title="Zoom out" onclick="zoomOut()">－</button>
          </div>
          <div class="side-wish">
            <button class="wish-btn" id="wish-btn" onclick="toggleWish()">♡</button>
          </div>
          <div class="hint-label">Drag to rotate · Scroll to zoom · Preview shows all parts; use tabs to change each</div>
        </div>
        <div class="bottom-links">
          <button type="button" class="bottom-link" style="background:none;border:none;padding:0;font:inherit;" onclick="shareCustomizeDesign()">↑ Share link</button>
          <button type="button" class="bottom-link" style="background:none;border:none;padding:0;font:inherit;" onclick="startOverCustomize()">↺ Start over</button>
        </div>
        <div class="bottom-note">Please be aware that customized products are not eligible for returns.</div>
      </div>
      <div class="right-col">
        <!-- Step 1: Tumbler -->
        <div class="step-panel active" id="panel-1">
          <div class="step-heading">Tumbler</div>
          <div class="step-counter">1 of 5</div>
          <div class="step-subtext">Choose size and body color. Lid, straw and handle use their own colors — set them in the next steps.</div>
          <div class="size-cards" id="size-cards">
            @php $sz = $config['sizes'] ?? []; $lastIdx = count($sz) ? count($sz)-1 : 0; @endphp
            @foreach($sz as $i => $size)
            <div class="size-card {{ $i === $lastIdx ? 'selected' : '' }}" data-size-idx="{{ $i }}" onclick="selectSize({{ $i }})">
              <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><rect x="6" y="14" width="18" height="38" rx="1" fill="#222"/><path d="M7 14 Q4 18 3 24 L27 24 Q26 18 23 14Z" fill="#444"/><rect x="9" y="8" width="12" height="8" rx="2" fill="#555"/></svg></div>
              <div class="option-info"><div class="option-name">{{ $size['name'] ?? '40 oz' }}</div><div class="option-desc">{{ $size['desc'] ?? 'Large insulated tumbler with handle and straw.' }}</div></div>
              @if(!empty($size['price']))
              <div class="option-price">{{ $config['currency'] }}{{ number_format($size['price'], 2) }}</div>
              @endif
            </div>
            @endforeach
          </div>
          <div class="color-label">Choose a color for your tumbler</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('bottle',-1)">&#8249;</button>
            <div class="swatches-track" id="bottle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('bottle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="bottle-color-label">{{ ($config['bottle_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav"><button class="next-btn" onclick="goTo(2)">Next – Lid</button></div>
          <p class="flow-hint">Tip: complete each step left to right, or jump using the tabs above. Your 3D preview updates live.</p>
        </div>

        <!-- Step 2: Lid -->
        <div class="step-panel" id="panel-2">
          <div class="step-heading">Lid</div>
          <div class="step-counter">2 of 5</div>
          <div class="step-subtext">Select a lid for your tumbler</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="11" stroke="#222" stroke-width="2"/><path d="M15 4 Q22 4 22 12" stroke="#555" stroke-width="3.5" fill="none" stroke-linecap="round"/></svg></div>
            <div class="option-info"><div class="option-name">Large Press in Straw Lid</div><div class="option-desc">Secure, splash-resistant straw lid.</div></div>
          </div>
          <div class="color-label">Choose a color for your lid</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('cap',-1)">&#8249;</button>
            <div class="swatches-track" id="cap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('cap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="cap-color-label">{{ ($config['cap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(1)">Previous – Tumbler</button>
            <button class="next-btn" onclick="goTo(3)">Next – Straw</button>
          </div>
        </div>

        <!-- Step 3: Straw -->
        <div class="step-panel" id="panel-3">
          <div class="step-heading">Straw</div>
          <div class="step-counter">3 of 5</div>
          <div class="step-subtext">Select your straw</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><path d="M8 26 Q8 6 15 6 Q22 6 22 26" stroke="#222" stroke-width="4" stroke-linecap="round" fill="none"/></svg></div>
            <div class="option-info"><div class="option-name">Silicone Tumbler Straw</div><div class="option-desc">Soft, flexible straw.</div></div>
          </div>
          <div class="color-label">Choose a color for your straw</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('strap',-1)">&#8249;</button>
            <div class="swatches-track" id="strap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('strap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="strap-color-label">{{ ($config['strap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(2)">Previous – Lid</button>
            <button class="next-btn" onclick="goTo(4)">Next – Handle</button>
          </div>
        </div>

        <!-- Step 4: Handle (side grip; silicone boot at base matches handle color) -->
        <div class="step-panel" id="panel-4">
          <div class="step-heading">Handle</div>
          <div class="step-counter">4 of 5</div>
          <div class="step-subtext">Choose a color for your handle. The protective base ring uses the same color.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><path d="M22 8 Q28 8 28 18 L28 48 Q28 56 22 56 Q16 56 16 48 L16 18 Q16 8 22 8Z" stroke="#222" stroke-width="2.2" fill="#e8e8e8"/></svg></div>
            <div class="option-info"><div class="option-name">Ergonomic side handle</div><div class="option-desc">Matches the silicone boot at the bottom of your tumbler.</div></div>
          </div>
          <div class="color-label">Choose a color for your handle</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('handle',-1)">&#8249;</button>
            <div class="swatches-track" id="handle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('handle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="handle-color-label">{{ ($config['handle_colors'][0]['name'] ?? ($config['boot_colors'][0]['name'] ?? 'Lavender')) }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(3)">Previous – Straw</button>
            <button class="next-btn" onclick="goTo(5)">Next – Engraving</button>
          </div>
        </div>

        <!-- Step 5: Engraving -->
        <div class="step-panel" id="panel-5">
          <div class="step-heading">Engraving</div>
          <div class="step-counter">5 of 5</div>
          <div class="step-subtext">Pick a graphic or skip engraving to pay only the tumbler price.</div>
          <label class="engrave-skip-label"><input type="checkbox" id="engrave-none-cb"> No engraving (price without engraving)</label>
          <div class="engrave-mode">
            <label><input type="radio" name="engrave-side" value="single" checked> Single</label>
            <label><input type="radio" name="engrave-side" value="double"> Double</label>
          </div>
          <div class="engrave-header">
            <button class="cat-btn active" onclick="filterCat(this)">← All</button>
            <div class="engrave-sel-label">Graphic: <span id="engrave-sel">Love Volleyball</span></div>
          </div>
          <div class="engrave-grid" id="engrave-grid"></div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(4)">Previous – Handle</button>
            <select class="qty-select" id="customize-qty" title="Quantity" onchange="onCustomizeQtyChange(this)"><option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
            <button class="next-btn" onclick="addToCart()">Add to Cart – <span id="final-price">{{ $config['currency'] }}{{ number_format($config['base_price'] + ($config['has_engraving'] ? $config['engraving_price'] : 0), 2) }}</span></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@php
    $customizeAppPath = public_path('assets/js/customize-app.js');
    $customizeAppV = is_readable($customizeAppPath) ? filemtime($customizeAppPath) : (int) time();
@endphp
<script>window.CUSTOMIZE_CONFIG = @json($config);</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="{{ route('customize.app.js', ['v' => $customizeAppV]) }}"></script>
@endpush
