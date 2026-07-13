@php
    $imageSizeGuide = [
        'General' => [
            ['where' => 'Site logo (header)', 'admin' => 'Settings → General', 'size' => '280×80px', 'ratio' => 'Flexible (wide)', 'format' => 'PNG (transparent)'],
            ['where' => 'About Us hero background (desktop)', 'admin' => 'Settings / Policy Pages → About Us', 'size' => '1920×700px', 'ratio' => 'Wide banner (~27:10)', 'format' => 'WebP / JPG'],
            ['where' => 'About Us hero background (mobile)', 'admin' => 'Settings / Policy Pages → About Us', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'About Us section images (2 blocks)', 'admin' => 'Settings / Policy Pages → About Us', 'size' => '900×1100px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'About Us section images (mobile)', 'admin' => 'Settings / Policy Pages → About Us', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
        ],
        'Homepage' => [
            ['where' => 'Hero slider — each slide (desktop)', 'admin' => 'Hero Banners', 'size' => '1920×820px', 'ratio' => 'Full-width hero (~21:9)', 'format' => 'WebP / JPG'],
            ['where' => 'Hero slider — each slide (mobile)', 'admin' => 'Hero Banners', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Two-block category cards (Drinkware / Barware)', 'admin' => 'Main Categories → Category Image', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Two-block category cards (mobile)', 'admin' => 'Main Categories → Category Image (mobile)', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Best Sellers wide banner (desktop)', 'admin' => 'Settings → Content', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
            ['where' => 'Best Sellers wide banner (mobile)', 'admin' => 'Settings → Content', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Discover collection — left / right images', 'admin' => 'Settings → Content', 'size' => '900×1100px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Discover collection — mobile', 'admin' => 'Settings → Content', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Flash sale — product cutout', 'admin' => 'Settings → Content', 'size' => '800×800px', 'ratio' => '1:1 square', 'format' => 'PNG (transparent)'],
            ['where' => 'Flash sale — background (desktop)', 'admin' => 'Settings → Content', 'size' => '1920×700px', 'ratio' => 'Wide banner', 'format' => 'WebP / JPG'],
            ['where' => 'Flash sale — background (mobile)', 'admin' => 'Settings → Content', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Instagram reels / posts', 'admin' => 'Instagram Reels (URL sync)', 'size' => '1080×1920px', 'ratio' => '9:16 vertical', 'format' => 'Synced from Instagram'],
        ],
        'Category pages (Drinkware / Barware)' => [
            ['where' => 'Top hero banner (desktop)', 'admin' => 'Main Categories → Hero Image', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
            ['where' => 'Top hero banner (mobile)', 'admin' => 'Main Categories → Hero Image (mobile)', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Subcategory grid cards', 'admin' => 'Subcategories → Card image', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Promo blocks (small banners)', 'admin' => 'Main Categories → Promo banners', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Promo blocks (mobile)', 'admin' => 'Main Categories → Promo banners (mobile)', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom sale banner — background', 'admin' => 'Main Categories → Bottom Banner Section', 'size' => '1920×700px', 'ratio' => 'Wide banner', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom sale banner — product image', 'admin' => 'Main Categories → Bottom Banner Section', 'size' => '900×700px', 'ratio' => 'Landscape (~9:7)', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom row — 4 image blocks', 'admin' => 'Main Categories → Bottom 4 Image Blocks', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Optional extra banner', 'admin' => 'Main Categories → Additional banner', 'size' => '1920×400px', 'ratio' => 'Wide strip', 'format' => 'WebP / JPG'],
        ],
        'Subcategory pages' => [
            ['where' => 'Card / thumbnail image', 'admin' => 'Subcategories → Card image', 'size' => '1500×1500px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG'],
            ['where' => 'Top page banner (desktop)', 'admin' => 'Subcategories → Page top banner', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
            ['where' => 'Top page banner (mobile)', 'admin' => 'Subcategories → Page top banner (mobile)', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Legacy category thumbnail (if used)', 'admin' => 'Sub Categories → Thumbnail', 'size' => '400×400px', 'ratio' => '1:1 square', 'format' => 'WebP / JPG / PNG'],
        ],
        'Products' => [
            ['where' => 'Main product image', 'admin' => 'Products → Main image', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Product gallery images', 'admin' => 'Products → Gallery', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Color / variant image', 'admin' => 'Inventory → Variant image', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Color swatch circle', 'admin' => 'Inventory → Color display settings', 'size' => '96×96px', 'ratio' => '1:1 square', 'format' => 'PNG / WebP / JPG'],
            ['where' => 'Shop / listing thumbnail', 'admin' => '(Uses main product image)', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
        ],
        'Account / other' => [
            ['where' => 'User profile avatar', 'admin' => 'My Account', 'size' => '120×120px', 'ratio' => '1:1 square', 'format' => 'JPG / PNG'],
        ],
    ];
@endphp
<div class="image-size-guide">
    <p class="text-muted small mb-3">
        Use these exact pixel sizes so images look sharp on desktop and mobile. Prefer <strong>WebP</strong> or JPG for photos and <strong>PNG</strong> only when you need transparency (logo, flash-sale cutout, swatches).
        Export at <strong>72–144 DPI</strong> for web — pixel dimensions matter more than DPI.
    </p>
    @foreach($imageSizeGuide as $section => $rows)
        <h6 class="mt-3 mb-2 fw-semibold">{{ $section }}</h6>
        <div class="table-responsive mb-2">
            <table class="table table-sm table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Where it appears</th>
                        <th>Admin location</th>
                        <th>Recommended size</th>
                        <th>Aspect ratio</th>
                        <th>Format</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{ $row['where'] }}</td>
                            <td><code class="small">{{ $row['admin'] }}</code></td>
                            <td><strong>{{ $row['size'] }}</strong></td>
                            <td>{{ $row['ratio'] }}</td>
                            <td>{{ $row['format'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
    <p class="small text-muted mb-0 mt-3">
        <strong>Mobile tip:</strong> For banners that support a separate mobile upload, use <strong>750×1000px</strong> (3:4) unless noted otherwise. If no mobile image is set, the desktop image is used automatically.
        This same guide is also available in <strong>Admin → Settings → Content</strong>.
    </p>
</div>
