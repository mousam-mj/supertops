@extends('layouts.app')

@section('title', ($product->name ?? 'Customize Tumbler') . ' | Perch')

@section('content')
<style>
.customize-page{font-family:'Inter',sans-serif;background:#f4f4f2;color:#161616;padding:20px 14px;min-height:72vh}
.customize-page .modal{max-width:1240px;margin:0 auto;background:#fff;border:1px solid #e8e8e8;border-radius:20px;overflow:hidden;box-shadow:0 10px 45px rgba(0,0,0,.08)}
.customize-page .top-nav{display:flex;align-items:center;gap:14px;padding:14px 18px;border-bottom:1px solid #ececec;background:#fbfbfb}
.customize-page .nav-steps{display:flex;align-items:center;gap:8px;overflow-x:auto;flex:1;scrollbar-width:thin}
.customize-page .nav-step{font-size:13px;padding:8px 12px;border-radius:999px;border:1px solid #ddd;background:#fff;color:#666;cursor:pointer;white-space:nowrap;transition:.15s}
.customize-page .nav-step.active{background:#161616;color:#fff;border-color:#161616}
.customize-page .nav-step.done:not(.active){color:#222;border-color:#bbb}
.customize-page .nav-right{display:flex;align-items:center;gap:10px}
.customize-page .nav-cart-wrap{display:flex;flex-direction:column;align-items:flex-end;gap:3px}
.customize-page .add-cart-btn{background:#161616;color:#fff;border:none;border-radius:10px;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer}
.customize-page .add-cart-btn:hover{background:#2c2c2c}
.customize-page .price-hint{font-size:11px;color:#8a8a8a;text-align:right}
.customize-page .close-btn{width:34px;height:34px;border:1px solid #ddd;border-radius:50%;display:flex;align-items:center;justify-content:center;text-decoration:none;color:#777;background:#fff}
.customize-page .close-btn:hover{color:#111;border-color:#bdbdbd}
.customize-page .content{display:flex;min-height:660px}
.customize-page .left-col{flex:0 0 57%;padding:18px;border-right:1px solid #ececec;background:#f9f9f7;display:flex;flex-direction:column;position:relative}
.customize-page .bottle-title{font-size:18px;font-weight:700;margin-bottom:12px}
.customize-page #three-wrap{position:relative;flex:1;min-height:420px;background:#efefeb;border:1px solid #e2e2dc;border-radius:14px;display:flex;align-items:center;justify-content:center}
.customize-page #three-wrap canvas{display:block;border-radius:14px}
.customize-page .loading-msg{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;background:#efefeb;border-radius:14px;z-index:10}
.customize-page .spinner{width:34px;height:34px;border:3px solid #ddd;border-top-color:#161616;border-radius:50%;animation:customize-spin .8s linear infinite}
.customize-page .loading-text{font-size:12px;color:#7b7b7b}
.customize-page .view-controls{position:absolute;left:10px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:8px;z-index:5}
.customize-page .view-btn{width:34px;height:34px;border:1px solid #d9d9d9;background:#fff;border-radius:8px;font-size:14px;cursor:pointer}
.customize-page .side-wish{position:absolute;right:10px;top:10px;z-index:5}
.customize-page .wish-btn{width:34px;height:34px;border:1px solid #d9d9d9;border-radius:8px;background:#fff;font-size:18px;color:#c4c4c4;cursor:pointer}
.customize-page .wish-btn.active{color:#e14565}
.customize-page .hint-label{position:absolute;bottom:10px;right:12px;font-size:11px;color:#8a8a8a}
.customize-page .bottom-links{display:flex;gap:16px;margin-top:10px}
.customize-page .bottom-link{font-size:12px;color:#161616;text-decoration:underline;text-underline-offset:3px}
.customize-page .bottom-note{font-size:11px;color:#8a8a8a;margin-top:6px}
.customize-page .right-col{flex:1;padding:22px;display:flex;flex-direction:column;overflow-y:auto}
.customize-page .step-panel{display:none;flex-direction:column;flex:1}
.customize-page .step-panel.active{display:flex}
.customize-page .step-heading{font-size:24px;font-weight:700}
.customize-page .step-counter{font-size:12px;color:#8a8a8a;margin-top:3px}
.customize-page .step-subtext{font-size:13px;color:#666;margin:8px 0 16px}
.customize-page .size-cards{display:flex;flex-direction:column;gap:10px;margin-bottom:16px}
.customize-page .size-card{display:flex;align-items:center;gap:12px;border:1px solid #ddd;border-radius:12px;padding:12px;cursor:pointer;background:#fff;transition:.15s}
.customize-page .size-card.selected{border-color:#161616;box-shadow:0 0 0 1px #161616 inset}
.customize-page .option-card{display:flex;align-items:center;gap:12px;border:1px solid #ddd;border-radius:12px;padding:12px;background:#fff;margin-bottom:16px}
.customize-page .option-thumb{width:44px;height:44px;border-radius:10px;background:#f2f2f2;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.customize-page .option-thumb svg{width:28px;height:28px}
.customize-page .option-info{flex:1}
.customize-page .option-name{font-size:14px;font-weight:700}
.customize-page .option-desc{font-size:12px;color:#7c7c7c}
.customize-page .option-price{font-size:14px;font-weight:700}
.customize-page .color-label{font-size:13px;color:#666;margin-bottom:8px}
.customize-page .color-row{display:flex;align-items:center;gap:8px}
.customize-page .color-arrow{width:30px;height:30px;border:1px solid #ddd;border-radius:50%;background:#fff;color:#777;cursor:pointer}
.customize-page .swatches-track{display:flex;gap:8px;align-items:center;overflow:hidden;flex:1;padding:5px}
.customize-page .swatch{width:34px;height:34px;border-radius:50%;border:2px solid transparent;cursor:pointer;position:relative}
.customize-page .swatch.selected{border-color:#161616}
.customize-page .swatch.out-of-stock{opacity:.55;cursor:not-allowed}
.customize-page .swatch.out-of-stock::after{content:'';position:absolute;inset:0;border-radius:50%;background:linear-gradient(135deg,transparent 46%,#bdbdbd 46%,#bdbdbd 54%,transparent 54%)}
.customize-page .color-name-label{font-size:12px;color:#777;margin:6px 0 4px;text-align:center;min-height:16px}
.customize-page .engrave-skip-label{display:flex;align-items:center;gap:8px;font-size:13px;color:#555;margin-bottom:10px;cursor:pointer}
.customize-page .engrave-mode{display:flex;gap:16px;margin-bottom:14px;font-size:13px}
.customize-page .engrave-header{display:flex;align-items:center;gap:8px;margin-bottom:12px;flex-wrap:wrap}
.customize-page .cat-btn{padding:6px 12px;border:1px solid #ccc;border-radius:999px;background:#fff;font-size:12px;cursor:pointer}
.customize-page .cat-btn.active{background:#161616;color:#fff;border-color:#161616}
.customize-page .engrave-sel-label{font-size:12px;color:#666;margin-left:auto}
.customize-page .engrave-sel-label span{font-weight:700;color:#111}
.customize-page .engrave-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:14px}
.customize-page .engrave-grid.engrave-off{opacity:.42;pointer-events:none}
.customize-page .engrave-tile{aspect-ratio:1;border:1px solid #ddd;border-radius:8px;background:#fafafa;display:flex;align-items:center;justify-content:center;padding:5px;cursor:pointer}
.customize-page .engrave-tile.selected{border-color:#161616;box-shadow:0 0 0 1px #161616 inset;background:#fff}
.customize-page .engrave-tile svg{width:100%;height:100%}
.customize-page .bottom-nav{display:flex;gap:10px;justify-content:flex-end;align-items:center;flex-wrap:wrap;margin-top:auto;padding-top:14px}
.customize-page .prev-btn,.customize-page .next-btn{border-radius:10px;padding:10px 16px;font-size:13px;font-weight:600;cursor:pointer}
.customize-page .prev-btn{background:#fff;border:1px solid #161616;color:#161616}
.customize-page .next-btn{background:#161616;border:1px solid #161616;color:#fff}
.customize-page .qty-select{padding:9px 12px;border:1px solid #ccc;border-radius:8px;background:#fff}
.customize-page .flow-hint{font-size:12px;color:#8a8a8a;margin-top:8px}
@keyframes customize-spin{to{transform:rotate(360deg)}}
@media(max-width:980px){
  .customize-page .content{flex-direction:column}
  .customize-page .left-col{flex:0 0 auto;border-right:none;border-bottom:1px solid #ececec}
  .customize-page #three-wrap{min-height:320px}
}
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div class="customize-page">
  <div class="modal">
    <div class="top-nav">
      <div class="nav-steps">
        <div class="nav-step active" data-step="1" onclick="goTo(1)">Body</div>
        <div class="nav-step" data-step="2" onclick="goTo(2)">Lid Ring</div>
        <div class="nav-step" data-step="3" onclick="goTo(3)">Straw</div>
        <div class="nav-step" data-step="4" onclick="goTo(4)">Handle</div>
        <div class="nav-step" data-step="5" onclick="goTo(5)">Bottom Base</div>
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
          <div class="step-heading">Body</div>
          <div class="step-counter">1 of 5</div>
          <div class="step-subtext">Main tumbler body ka color yahan set karein. Baaki marked parts next steps me milenge.</div>
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
          <div class="color-label">Choose color for Body</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('bottle',-1)">&#8249;</button>
            <div class="swatches-track" id="bottle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('bottle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="bottle-color-label">{{ ($config['bottle_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav"><button class="next-btn" onclick="goTo(2)">Next – Lid Ring</button></div>
          <p class="flow-hint">Tip: complete each step left to right, or jump using the tabs above. Your 3D preview updates live.</p>
        </div>

        <!-- Step 2: Lid -->
        <div class="step-panel" id="panel-2">
          <div class="step-heading">Lid Ring</div>
          <div class="step-counter">2 of 5</div>
          <div class="step-subtext">Top ring/lid section ka color select karein.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><circle cx="15" cy="15" r="11" stroke="#222" stroke-width="2"/><path d="M15 4 Q22 4 22 12" stroke="#555" stroke-width="3.5" fill="none" stroke-linecap="round"/></svg></div>
            <div class="option-info"><div class="option-name">Top Lid Ring</div><div class="option-desc">Straw opening ke around wala upper part.</div></div>
          </div>
          <div class="color-label">Choose color for Lid Ring</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('cap',-1)">&#8249;</button>
            <div class="swatches-track" id="cap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('cap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="cap-color-label">{{ ($config['cap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(1)">Previous – Body</button>
            <button class="next-btn" onclick="goTo(3)">Next – Straw</button>
          </div>
        </div>

        <!-- Step 3: Straw -->
        <div class="step-panel" id="panel-3">
          <div class="step-heading">Straw</div>
          <div class="step-counter">3 of 5</div>
          <div class="step-subtext">Marked straw ka color yahan change hoga.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 30" fill="none"><path d="M8 26 Q8 6 15 6 Q22 6 22 26" stroke="#222" stroke-width="4" stroke-linecap="round" fill="none"/></svg></div>
            <div class="option-info"><div class="option-name">Silicone Tumbler Straw</div><div class="option-desc">Soft, flexible straw.</div></div>
          </div>
          <div class="color-label">Choose color for Straw</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('strap',-1)">&#8249;</button>
            <div class="swatches-track" id="strap-swatches"></div>
            <button class="color-arrow" onclick="shiftS('strap',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="strap-color-label">{{ ($config['strap_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(2)">Previous – Lid Ring</button>
            <button class="next-btn" onclick="goTo(4)">Next – Handle</button>
          </div>
        </div>

        <!-- Step 4: Handle -->
        <div class="step-panel" id="panel-4">
          <div class="step-heading">Handle</div>
          <div class="step-counter">4 of 5</div>
          <div class="step-subtext">Side handle ka color alag set karein.</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><path d="M22 8 Q28 8 28 18 L28 48 Q28 56 22 56 Q16 56 16 48 L16 18 Q16 8 22 8Z" stroke="#222" stroke-width="2.2" fill="#e8e8e8"/></svg></div>
            <div class="option-info"><div class="option-name">Side Handle</div><div class="option-desc">Bottle side grip handle color.</div></div>
          </div>
          <div class="color-label">Choose color for Handle</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('handle',-1)">&#8249;</button>
            <div class="swatches-track" id="handle-swatches"></div>
            <button class="color-arrow" onclick="shiftS('handle',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="handle-color-label">{{ ($config['handle_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(3)">Previous – Straw</button>
            <button class="next-btn" onclick="goTo(5)">Next – Bottom Base</button>
          </div>
        </div>

        <!-- Step 5: Bottom Base -->
        <div class="step-panel" id="panel-5">
          <div class="step-heading">Bottom Base</div>
          <div class="step-counter">5 of 5</div>
          <div class="step-subtext">Neeche ka base/boot ring color yahan alag se set karein (image ke bottom marked area).</div>
          <div class="option-card">
            <div class="option-thumb"><svg viewBox="0 0 30 60" fill="none"><path d="M5 47 H25 V55 H5 Z" stroke="#222" stroke-width="2" fill="#e8e8e8"/></svg></div>
            <div class="option-info"><div class="option-name">Bottom Base Ring</div><div class="option-desc">Protective base/boot color.</div></div>
          </div>
          <div class="color-label">Choose color for Bottom Base</div>
          <div class="color-row">
            <button class="color-arrow" onclick="shiftS('boot',-1)">&#8249;</button>
            <div class="swatches-track" id="boot-swatches"></div>
            <button class="color-arrow" onclick="shiftS('boot',1)">&#8250;</button>
          </div>
          <div class="color-name-label" id="boot-color-label">{{ ($config['boot_colors'][0]['name'] ?? 'Lavender') }}</div>
          <div class="bottom-nav">
            <button class="prev-btn" onclick="goTo(4)">Previous – Handle</button>
            <select class="qty-select" id="customize-qty" title="Quantity" onchange="onCustomizeQtyChange(this)"><option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
            <button class="next-btn" onclick="addToCart()">Add to Cart – <span id="final-price">{{ $config['currency'] }}{{ number_format($config['base_price'] + ($config['has_engraving'] ? $config['engraving_price'] : 0), 2) }}</span></button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Hidden compatibility hooks for legacy engraving JS -->
  <div style="display:none;">
    <label><input type="checkbox" id="engrave-none-cb"> No engraving</label>
    <label><input type="radio" name="engrave-side" value="single" checked></label>
    <label><input type="radio" name="engrave-side" value="double"></label>
    <button class="cat-btn active" type="button">All</button>
    <div id="engrave-sel">None</div>
    <div id="engrave-grid"></div>
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
