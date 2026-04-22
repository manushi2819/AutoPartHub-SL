@extends('AdminDashboard.index')

@section('title', 'Vehicle Types')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Vehicle Types</h6>
    <div class="d-flex flex-wrap align-items-center gap-3">
        <a href="" class="btn btn-sm btn-primary-600"
           data-bs-toggle="modal" data-bs-target="#vehicleTypeModal">
            <i class="ri-add-line"></i> Create Vehicle Type
        </a>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="vehicleTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">

            <div class="modal-header py-16 px-24 border-0">
                <h6 class="modal-title">Add Vehicle Type</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-24">
                <form action="{{ route('admin.vehicle-types.store') }}" method="POST">
                    @csrf

                    <div class="mb-20">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control radius-8" placeholder="Car, Bike..." required>
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

                </form>
            </div>

        </div>
    </div>
</div>

<!-- Table -->
<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vehicleTypes as $index => $type)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $type->name }}</td>

                            <td>
                               
                                @if($type->status)
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Active</span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Inactive</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <!-- Edit -->
                                
                                     <a href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $type->id }}" 
                                     class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle 
                                     d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.vehicle-types.destroy', $type->id) }}" method="POST" class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="w-32-px h-32-px bg-danger-focus text-danger-main 
                                                rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal"
                                                data-url="{{ route('admin.vehicle-types.destroy', $type->id) }}">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $type->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h6>Edit Vehicle Type</h6>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <form action="{{ route('admin.vehicle-types.update', $type->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="text" name="name"
                                                   value="{{ $type->name }}"
                                                   class="form-control mb-3" required>

                                             <div class="col-12 mb-20">
                                                    <label class="form-label">Status</label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-1 me-1" type="radio" name="status" value="1" 
                                                                {{ (int) $type->status === 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Active</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input mt-1 me-1" type="radio" name="status" value="0" 
                                                                {{ (int) $type->status === 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label">Inactive</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            <button class="btn btn-primary w-100">Update</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection