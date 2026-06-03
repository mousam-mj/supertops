@extends('admin.layout')

@section('title', 'Instagram Reels')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-instagram me-2"></i>Instagram Reels</h1>
        <form action="{{ route('admin.instagram-reels.sync') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-arrow-repeat me-1"></i> Sync from {{ config('services.instagram.username', 'perch.life') }}
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="alert alert-info">
        <strong>Auto-sync from Instagram</strong>
        <p class="mb-2 small">
            Reels are pulled from
            <a href="https://www.instagram.com/{{ config('services.instagram.username', 'perch.life') }}/" target="_blank" rel="noopener">
                {{ config('services.instagram.username', 'perch.life') }}
            </a>
            via the Meta Graph API. Add these to <code>.env</code>, then click <strong>Sync</strong> above (or run <code>php artisan instagram:sync-reels</code>):
        </p>
        <pre class="small mb-0 bg-white p-2 rounded border"><code>INSTAGRAM_ACCESS_TOKEN=your_long_lived_token
INSTAGRAM_USERNAME=perch.life
INSTAGRAM_USER_ID=          # optional if token is linked to the account
INSTAGRAM_REELS_LIMIT=10</code></pre>
        <p class="small text-muted mt-2 mb-0">
            Generate the token in
            <a href="https://developers.facebook.com/apps/" target="_blank" rel="noopener">Meta for Developers</a>
            → your app → Instagram Graph API → generate a token with
            <code>instagram_basic</code> and <code>pages_read_engagement</code>.
            The Instagram account must be a Business/Creator account linked to a Facebook Page.
        </p>
    </div>

    <div class="card mb-4">
        <div class="card-header">Add Reel or post link</div>
        <div class="card-body">
            <p class="text-muted small mb-3">
                Full URL from Instagram, e.g. <code>https://www.instagram.com/reel/ABC123xyz/</code> or <code>.../p/ABC123xyz/</code>
            </p>
            <form action="{{ route('admin.instagram-reels.store') }}" method="POST" class="row g-2 align-items-end">
                @csrf
                <div class="col-md-10">
                    <label class="form-label">Instagram URL</label>
                    <input type="url" name="url" class="form-control @error('url') is-invalid @enderror"
                           value="{{ old('url') }}" placeholder="https://www.instagram.com/reel/..." required>
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Slider order (shown on home &amp; category pages)</div>
        <div class="card-body p-0">
            @if($reels->isEmpty())
                <p class="text-muted p-4 mb-0">No links yet — the storefront uses the default image gallery.</p>
            @else
                <form id="instagram-reels-sort-form" action="{{ route('admin.instagram-reels.sort') }}" method="POST" class="d-none">
                    @csrf
                    @method('PUT')
                </form>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:110px">Order</th>
                                <th>URL</th>
                                <th style="width:100px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reels as $reel)
                                <tr>
                                    <td>
                                        <input type="number" form="instagram-reels-sort-form" name="sort[{{ $reel->id }}]" class="form-control form-control-sm"
                                               value="{{ $reel->sort_order }}" min="0" max="99999" required>
                                    </td>
                                    <td>
                                        <a href="{{ $reel->url }}" target="_blank" rel="noopener" class="small text-break">{{ $reel->url }}</a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.instagram-reels.destroy', $reel) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Remove this reel?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 border-top bg-light">
                    <button type="submit" form="instagram-reels-sort-form" class="btn btn-secondary btn-sm">Save order</button>
                    <span class="text-muted small ms-2">Lower numbers appear first in the slider.</span>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
