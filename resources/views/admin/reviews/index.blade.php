@extends('admin.layout')

@section('title', 'Review Manage')
@section('page-title', 'Review Manage')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-1 fw-bold" style="color: #2d3748;">Product Reviews</h4>
                <p class="text-muted mb-0">Manage customer reviews or add reviews manually — no order required.</p>
            </div>
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add Review
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                @if($reviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Reviewer</th>
                                    <th>Source</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Comment</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                    <tr>
                                        <td>
                                            @if($review->product)
                                                <a href="{{ route('product.show', $review->product->slug) }}" target="_blank">{{ $review->product->name }}</a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->reviewer_name }}</td>
                                        <td>
                                            @if($review->user_id)
                                                <span class="badge bg-info">Customer</span>
                                            @else
                                                <span class="badge bg-secondary">Manual</span>
                                            @endif
                                        </td>
                                        <td>
                                            @for($s = 1; $s <= 5; $s++)
                                                <i class="bi bi-star{{ $s <= $review->rating ? '-fill text-warning' : '' }}"></i>
                                            @endfor
                                            ({{ $review->rating }})
                                        </td>
                                        <td>
                                            @if($review->is_approved)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Draft</span>
                                            @endif
                                        </td>
                                        <td class="text-break" style="max-width: 280px;">{{ Str::limit($review->comment, 80) ?: '—' }}</td>
                                        <td>{{ $review->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if($review->product)
                                                <a href="{{ route('product.show', $review->product->slug) }}#form-review" target="_blank" class="btn btn-sm btn-outline-secondary me-1" title="View on product">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.reviews.destroy', $review) }}?from=admin" method="post" class="d-inline" onsubmit="return confirm('Delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>No product reviews yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
