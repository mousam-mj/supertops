@extends('admin.layout')

@section('title', 'Add Review')
@section('page-title', 'Add Product Review')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add review (no order required)</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">Create a review that appears on the product page. Use this for testimonials, imported reviews, or feedback collected offline.</p>

                <form action="{{ route('admin.reviews.store') }}" method="POST">
                    @csrf
                    @include('admin.reviews.partials.form', ['preselectedProductId' => $preselectedProductId ?? null])

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Save Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
