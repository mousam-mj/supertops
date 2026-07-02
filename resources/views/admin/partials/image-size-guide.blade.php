@php
    $imageSizeGuide = [
        'General' => [
            ['where' => 'Site logo (header)', 'admin' => 'Settings → General', 'size' => '280×80px', 'ratio' => 'Flexible (wide)', 'format' => 'PNG (transparent)'],
            ['where' => 'About Us hero background', 'admin' => 'Settings → Content → About Us', 'size' => '1920×700px', 'ratio' => 'Wide banner', 'format' => 'WebP / JPG'],
            ['where' => 'About Us section images (2 blocks)', 'admin' => 'Settings → Content → About Us', 'size' => '900×1100px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
        ],
        'Homepage' => [
            ['where' => 'Hero slider (each slide)', 'admin' => 'Hero Banners', 'size' => '1920×820px', 'ratio' => 'Full-width hero', 'format' => 'WebP / JPG'],
            ['where' => 'Category cards (Drinkware / Barware)', 'admin' => 'Main Categories → Category Image', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Best Sellers wide banner', 'admin' => 'Settings → Content', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
            ['where' => 'Discover collection — left image', 'admin' => 'Settings → Content', 'size' => '900×1100px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Discover collection — right image', 'admin' => 'Settings → Content', 'size' => '900×1100px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Flash sale — product image', 'admin' => 'Settings → Content', 'size' => '800×800px', 'ratio' => '1:1 square', 'format' => 'PNG (transparent bg)'],
            ['where' => 'Flash sale — background', 'admin' => 'Settings → Content', 'size' => '1920×700px', 'ratio' => 'Wide banner', 'format' => 'WebP / JPG'],
        ],
        'Category pages (Drinkware / Barware)' => [
            ['where' => 'Top hero banner', 'admin' => 'Main Categories → Hero Image', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
            ['where' => 'Subcategory grid cards', 'admin' => 'Subcategories → Card image', 'size' => '750×1000px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Promo blocks (small banners)', 'admin' => 'Main Categories → Promo banners', 'size' => '600×750px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom sale banner — background', 'admin' => 'Main Categories → Bottom Banner Section', 'size' => '1920×700px', 'ratio' => 'Wide banner', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom sale banner — product image', 'admin' => 'Main Categories → Bottom Banner Section', 'size' => '900×700px', 'ratio' => 'Landscape', 'format' => 'WebP / JPG'],
            ['where' => 'Bottom row — 4 image blocks', 'admin' => 'Main Categories → Bottom 4 Image Blocks', 'size' => '600×750px', 'ratio' => '4:5 portrait', 'format' => 'WebP / JPG'],
        ],
        'Subcategory pages' => [
            ['where' => 'Top page banner', 'admin' => 'Subcategories → Page top banner', 'size' => '1920×600px', 'ratio' => '16:5 wide', 'format' => 'WebP / JPG'],
        ],
        'Products' => [
            ['where' => 'Main product image', 'admin' => 'Products → Main image', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Product gallery images', 'admin' => 'Products → Gallery', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
            ['where' => 'Color / variant image', 'admin' => 'Inventory → Variant image', 'size' => '1200×1600px', 'ratio' => '3:4 portrait', 'format' => 'WebP / JPG'],
        ],
        'Instagram' => [
            ['where' => 'Reels / posts in homepage slider', 'admin' => 'Instagram Reels (URL sync)', 'size' => '1080×1920px', 'ratio' => '9:16 vertical', 'format' => 'Synced from Instagram'],
        ],
    ];
@endphp
<div class="image-size-guide">
    <p class="text-muted small mb-3">
        Use these sizes so images look sharp on desktop and mobile. Prefer <strong>WebP</strong> or JPG for photos and <strong>PNG</strong> only when you need transparency (logo, flash-sale product cutout).
        Export at <strong>72–144 DPI</strong> for web — exact pixel dimensions matter more than DPI.
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
        <strong>Tip:</strong> Upload separate mobile images (750×1000px portrait recommended) for banners that appear on phones. If no mobile image is set, the desktop image is used automatically.
    </p>
</div>
