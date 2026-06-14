@php
    use App\Support\AboutPageContent;

    $html = trim((string) ($content ?? ''));
    if ($html === '') {
        $html = AboutPageContent::defaultHtml();
    }

    $allowed = '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><div><span><img><table><thead><tbody><tr><td><th><hr><blockquote><pre><code><section><article><header><footer><figure><figcaption><i>';
    $parts = explode(AboutPageContent::BENEFIT_MARKER, $html, 2);
    $before = strip_tags($parts[0] ?? '', $allowed);
    $after = isset($parts[1]) ? strip_tags($parts[1], $allowed) : '';
@endphp
{!! $before !!}
<div class="benefit-block md:pt-20 pt-10">
    <div class="container">
        @include('partials.benefit-items')
    </div>
</div>
{!! $after !!}
