@extends('AdminDashboard.master')
@section('title', 'Products')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Products</h6>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
        Add Product
    </a>
</div>


<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Main Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach($products as $product)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>
                             <span class="px-24 py-4 rounded-pill fw-medium text-sm
                                {{ $product->status
                                    ? 'bg-success-focus text-success-main'
                                    : 'bg-danger-focus text-danger-main' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            @if($product->images->count())
                                <img src="{{ asset('uploads/' . $product->images->first()->image_url) }}" 
                                     alt="Product Image" width="50" height="50">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>
                     
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                            onclick="return confirm('Are you sure you want to delete this product?');">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </button>
                                </form>
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
