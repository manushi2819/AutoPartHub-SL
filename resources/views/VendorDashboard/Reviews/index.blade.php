@extends('VendorDashboard.index')

@section('title', 'Reviews')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Reviews</h6>

</div>


<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
                <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Images</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   <tbody>
                        @foreach ($reviews as $index => $review)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->email }}</td>
                            <td>{{ $review->product->name ?? 'N/A' }}</td>
                            <td>{{ $review->rating }}</td>
                            <td>
                                @if($review->images->count())
                                    <div class="d-flex gap-1 flex-wrap">
                                        @foreach($review->images as $image)
                                            <img src="{{ asset('uploads/' . $image->image) }}" 
                                                alt="Review Image" 
                                                style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                        @endforeach
                                    </div>
                                @else
                                    <span>No Images</span>
                                @endif
                            </td>
                            <td>
                                @if($review->status === 'approved')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Approved</span>
                                @elseif($review->status === 'rejected')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Rejected</span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-warning-focus text-warning-main">Pending</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Approve button -->
                                    @if($review->status !== 'approved')
                                    <form action="{{ route('vendor.reviews.approve', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Approve">
                                            <iconify-icon icon="mingcute:check-line"></iconify-icon>
                                        </button>
                                    </form>
                                    @endif

                                    <!-- Reject button -->
                                    @if($review->status !== 'rejected')
                                    <form action="{{ route('vendor.reviews.reject', $review->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" title="Reject">
                                            <iconify-icon icon="mingcute:close-line"></iconify-icon>
                                        </button>
                                    </form>
                                    @endif

                                    <!-- Delete button -->
                                    <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal" 
                                            data-url="{{ route('vendor.reviews.destroy', $review->id) }}" title="Delete">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                   
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
