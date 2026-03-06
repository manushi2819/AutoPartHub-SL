@extends('AdminDashboard.index')

@section('title', 'Brands')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Brands</h6>
    <div class="d-flex flex-wrap align-items-center gap-3">
        <a href="" class="btn btn-sm btn-primary-600" data-bs-toggle="modal" data-bs-target="#brandModal">
            <i class="ri-add-line"></i> Create Brand
        </a>
    </div>
</div>

<!-- Add Brand Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">
            <div class="modal-header py-16 px-24 border-top-0 border-start-0 border-end-0">
                <h5 class="modal-title">Add New Brand</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-24">
                <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-20">
                            <label class="form-label">Brand Name</label>
                            <input type="text" name="name" class="form-control radius-8" placeholder="Enter Brand Name" required>
                        </div>

                        <div class="col-6 mb-20">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control radius-8">
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label">Status</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input mt-1 me-1" type="radio" name="status" value="1" checked>
                                    <label class="form-check-label">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input mt-1 me-1" type="radio" name="status" value="0">
                                    <label class="form-check-label">Inactive</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-24">
                            <button type="reset" class="btn btn-outline-danger">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Brand Modal -->

<!-- Brands Table -->
<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($brands as $index => $brand)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $brand->name }}</td>
                            <td>
                                @if($brand->image)
                                    <img src="{{ asset('uploads/' . $brand->image) }}" style="width:40px; height:40px; object-fit:cover; border-radius:4px;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                           <td>
                                @if($brand->status)
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Active</span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#editBrandModal{{ $brand->id }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                                onclick="return confirm('Are you sure you want to delete this brand?');">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    </form>
                                </div>
                                 
                            </td>
                        </tr>

                        <!-- Edit Brand Modal -->
                        <div class="modal fade" id="editBrandModal{{ $brand->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content radius-16 bg-base">
                                    <div class="modal-header py-16 px-24 border-top-0 border-start-0 border-end-0">
                                        <h5 class="modal-title">Edit Brand</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-24">
                                        <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col-12 mb-20">
                                                    <label class="form-label">Brand Name</label>
                                                    <input type="text" name="name" class="form-control radius-8" value="{{ $brand->name }}" required>
                                                </div>

                                                <div class="col-12 mb-20">
                                                    <label class="form-label">Image</label>
                                                    <input type="file" name="image" class="form-control radius-8">
                                                </div>

                                                <div class="col-12 mb-20">
                                                    <label class="form-label">Status</label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-1 me-1" type="radio" name="status" value="1" 
                                                                {{ (int) $brand->status === 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-1 me-1" type="radio" name="status" value="0" 
                                                                {{ (int) $brand->status === 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center gap-3 mt-24">
                                                    <button type="reset" class="btn btn-outline-danger">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Brand Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection