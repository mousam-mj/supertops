@extends('admin.layout')

@section('title', 'Edit Review')
@section('page-title', 'Edit Product Review')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">Edit review</h5>
                @if($review->product)
                    <a href="{{ route('product.show', $review->product->slug) }}#form-review" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-box-arrow-up-right me-1"></i>View on product
                    </a>
                @endif
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.reviews.partials.form')

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
