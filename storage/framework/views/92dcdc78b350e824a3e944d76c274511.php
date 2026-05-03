<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($product->sku ?? $product->name); ?> — EDX</title>
    <style>
        @page { margin: 28px 36px 32px 36px; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            margin: 0;
        }
        .pdf-header {
            background: #e31e24;
            color: #fff;
            padding: 10px 14px;
            margin: -8px -8px 14px -8px;
        }
        .pdf-header-inner { width: 100%; border-collapse: collapse; }
        .pdf-header-inner td { vertical-align: middle; }
        .pdf-header img { height: 36px; display: block; }
        .pdf-header-title {
            font-size: 13px;
            font-weight: bold;
            text-align: right;
            letter-spacing: 0.04em;
        }
        .pdf-main-title {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 6px 0;
        }
        .pdf-cat {
            display: inline-block;
            background: #16a34a;
            color: #fff;
            padding: 3px 10px;
            font-size: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .pdf-top { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .pdf-top td { vertical-align: top; }
        .pdf-top .img-cell { width: 42%; padding-right: 12px; }
        .pdf-top img.product-img {
            max-width: 100%;
            height: auto;
            border: 1px solid #e5e5e5;
        }
        .pdf-desc { color: #444; line-height: 1.45; }
        .pdf-desc p { margin: 0 0 8px 0; }
        .pdf-desc p:last-child { margin-bottom: 0; }
        .pdf-desc ul, .pdf-desc ol { margin: 0 0 8px 0; padding-left: 1.2em; }
        .section-label {
            background: #e31e24;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            padding: 4px 8px;
            display: inline-block;
            margin: 14px 0 8px 0;
        }
        .spec-grid { width: 100%; border-collapse: collapse; }
        .spec-grid td { width: 50%; vertical-align: top; padding: 0 8px 0 0; }
        .spec-grid td + td { padding: 0 0 0 8px; }
        .spec-title { font-size: 11px; font-weight: bold; margin: 0 0 6px 0; }
        .spec-table { width: 100%; border-collapse: collapse; }
        .spec-table tr { border-bottom: 1px solid #ccc; }
        .spec-table td { padding: 7px 0; font-size: 10px; }
        .spec-table td:last-child { text-align: right; font-weight: bold; }
        .pdf-footer {
            margin-top: 22px;
            background: #0f0f0f;
            color: #fff;
            padding: 14px 16px;
            font-size: 9px;
        }
        .pdf-footer table { width: 100%; border-collapse: collapse; }
        .pdf-footer td { vertical-align: top; padding: 4px 8px; width: 33%; }
        .pdf-footer h4 {
            margin: 0 0 6px 0;
            font-size: 10px;
            color: #fff;
        }
        .pdf-footer ul { margin: 0; padding-left: 14px; }
        .pdf-footer li { margin: 2px 0; }
        .pdf-footer a { color: #ccc; text-decoration: none; }
        .pdf-footer .pdf-brand-logo {
            width: 56px;
            height: auto;
            display: block;
        }
        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 10px;
            padding-top: 8px;
            text-align: center;
            color: #aaa;
            font-size: 8px;
        }
    </style>
</head>
<body>
<?php
    $specs = $product->specifications;
    if (is_string($specs)) {
        $specs = json_decode($specs, true);
    }
    $specs = is_array($specs) ? $specs : [];
?>

<div class="pdf-header">
    <table class="pdf-header-inner">
        <tr>
            <td style="width: 50%;">
                <?php if($pdfLogoSrc !== ''): ?>
                    <img src="<?php echo e($pdfLogoSrc); ?>" alt="EDX">
                <?php else: ?>
                    <span style="font-size: 18px; font-weight: bold;">EDX</span>
                <?php endif; ?>
            </td>
            <td class="pdf-header-title">EDX RULMENTI ROMANIA S.R.L.</td>
        </tr>
    </table>
</div>

<table class="pdf-top">
    <tr>
        <td class="img-cell">
            <?php if($pdfProductImageSrc !== ''): ?>
                <img class="product-img" src="<?php echo e($pdfProductImageSrc); ?>" alt="">
            <?php endif; ?>
        </td>
        <td>
            <div class="pdf-main-title"><?php echo e($product->sku ?? $product->name); ?></div>
            <div class="pdf-cat"><?php echo e($product->category->name ?? 'Deep Groove Ball Bearing'); ?></div>
            <div class="pdf-desc"><?php echo $product->description ?? ''; ?></div>
        </td>
    </tr>
</table>

<div class="section-label">OVERVIEW</div>

<table class="spec-grid">
    <tr>
        <td>
            <div class="spec-title">Boundary dimensions</div>
            <table class="spec-table">
                <tr><td>Bore diameter</td><td><?php echo e($specs['bore_diameter'] ?? '—'); ?></td></tr>
                <tr><td>Outside diameter</td><td><?php echo e($specs['outside_diameter'] ?? '—'); ?></td></tr>
                <tr><td>Width</td><td><?php echo e($specs['width'] ?? '—'); ?></td></tr>
            </table>
        </td>
        <td>
            <div class="spec-title">Performance</div>
            <table class="spec-table">
                <tr><td>Basic dynamic load rating</td><td><?php echo e($specs['dynamic_load_rating'] ?? '—'); ?></td></tr>
                <tr><td>Basic static load rating</td><td><?php echo e($specs['static_load_rating'] ?? '—'); ?></td></tr>
                <tr><td>Limiting speed – Grease</td><td><?php echo e($specs['limiting_speed_grease'] ?? '—'); ?></td></tr>
                <tr><td>Limiting speed – Oil</td><td><?php echo e($specs['limiting_speed_oil'] ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 10px;">
            <div class="spec-title">Properties</div>
            <table class="spec-table">
                <tr><td>Number of rows</td><td><?php echo e($specs['number_of_rows'] ?? '—'); ?></td></tr>
                <tr><td>Bore type</td><td><?php echo e($specs['bore_type'] ?? '—'); ?></td></tr>
                <tr><td>Cage</td><td><?php echo e($specs['cage'] ?? '—'); ?></td></tr>
                <tr><td>Radial internal clearance</td><td><?php echo e($specs['radial_clearance'] ?? '—'); ?></td></tr>
                <tr><td>Tolerance class for dimensions</td><td><?php echo e($specs['tolerance_class'] ?? '—'); ?></td></tr>
            </table>
        </td>
    </tr>
</table>

<div class="pdf-footer">
    <table>
        <tr>
            <td style="vertical-align: top; width: 64px;">
                <?php if($pdfLogoSrc !== ''): ?>
                    <img src="<?php echo e($pdfLogoSrc); ?>" alt="EDX Rulmenți" class="pdf-brand-logo">
                <?php else: ?>
                    <div style="background:#e31e24;color:#fff;width:56px;height:56px;text-align:center;padding:6px 4px;font-weight:bold;line-height:1.1;font-size:14px;">EDX</div>
                <?php endif; ?>
            </td>
            <td>
                <h4>Get in touch</h4>
                <div>Sediu social: Bucuresti Sectorul 4,<br>Bulevardul METALURGIEI, Nc 132, Bloc BIC, Etaj 4, Ap. 42.</div>
                <div style="margin-top: 4px;">+40 723 370 345</div>
                <div>info@edxromania.ro</div>
            </td>
            <td>
                <h4>Products &amp; services</h4>
                <ul>
                    <li>Ball Bearing</li>
                    <li>Spherical Roller Bearing</li>
                    <li>Cylindrical Roller Bearing</li>
                    <li>Taper Roller Bearing</li>
                </ul>
            </td>
        </tr>
    </table>
    <div class="footer-bottom"><?php echo e(date('Y')); ?> © All Rights Reserved by Edx Rulmenti Romania S.R.L.</div>
</div>
</body>
</html>
<?php /**PATH /Users/mousamjain/Documents/GitHub/edx/resources/views/pdf/product-specification.blade.php ENDPATH**/ ?>