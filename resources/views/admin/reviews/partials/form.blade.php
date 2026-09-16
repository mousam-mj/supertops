@php
    $review = $review ?? null;
    $selectedProductId = old('product_id', $review->product_id ?? ($preselectedProductId ?? null));
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
        <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
            <option value="">Select product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ (string) $selectedProductId === (string) $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        @error('product_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="guest_name" class="form-label">Reviewer name <span class="text-danger">*</span></label>
        <input type="text"
               class="form-control @error('guest_name') is-invalid @enderror"
               id="guest_name"
               name="guest_name"
               value="{{ old('guest_name', $review->guest_name ?? ($review->reviewer_name ?? '')) }}"
               placeholder="e.g. Priya S."
               required>
        @error('guest_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">Shown publicly on the product page. No customer account or order required.</small>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="guest_email" class="form-label">Reviewer email</label>
        <input type="email"
               class="form-control @error('guest_email') is-invalid @enderror"
               id="guest_email"
               name="guest_email"
               value="{{ old('guest_email', $review->guest_email ?? '') }}"
               placeholder="optional@email.com">
        @error('guest_email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">Optional — not shown on the storefront.</small>
    </div>

    <div class="col-md-6 mb-3">
        <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
        <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
            @for($r = 5; $r >= 1; $r--)
                <option value="{{ $r }}" {{ (int) old('rating', $review->rating ?? 5) === $r ? 'selected' : '' }}>
                    {{ $r }} {{ $r === 1 ? 'star' : 'stars' }}
                </option>
            @endfor
        </select>
        @error('rating')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="comment" class="form-label">Review comment</label>
    <textarea class="form-control @error('comment') is-invalid @enderror"
              id="comment"
              name="comment"
              rows="4"
              placeholder="What did the customer say about this product?">{{ old('comment', $review->comment ?? '') }}</textarea>
    @error('comment')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="reviewed_at" class="form-label">Review date</label>
        <input type="datetime-local"
               class="form-control @error('reviewed_at') is-invalid @enderror"
               id="reviewed_at"
               name="reviewed_at"
               value="{{ old('reviewed_at', isset($review) && $review->created_at ? $review->created_at->format('Y-m-d\TH:i') : '') }}">
        @error('reviewed_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="form-text text-muted">Optional. Controls when the review appears to have been posted.</small>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Visibility</label>
        <input type="hidden" name="is_approved" value="0">
        <div class="form-check form-switch">
            <input class="form-check-input"
                   type="checkbox"
                   id="is_approved"
                   name="is_approved"
                   value="1"
                   {{ old('is_approved', $review->is_approved ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_approved">Published on product page</label>
        </div>
        <small class="form-text text-muted">Turn off to save as draft until you are ready to publish.</small>
    </div>
</div>
