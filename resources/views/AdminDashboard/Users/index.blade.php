@extends('AdminDashboard.index')

@section('title', 'Admin Users')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Admin Users</h6>

    <a href="#" class="btn btn-primary btn-sm"
       data-bs-toggle="modal"
       data-bs-target="#userModal">
        <i class="ri-add-line"></i> Create User
    </a>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">

            <div class="modal-header">
                <h6 class="modal-title">Add Admin User</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Name <i class="text-danger">*</i></label>
                            <input type="text"
                                   name="name"
                                   class="form-control radius-8"
                                   required>
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Email <i class="text-danger">*</i></label>
                            <input type="email"
                                   name="email"
                                   class="form-control radius-8"
                                   required>
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control radius-8">
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Password <i class="text-danger">*</i></label>
                            <input type="password"
                                   name="password"
                                   class="form-control radius-8"
                                   required>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label">Status <i class="text-danger">*</i></label>

                            <div class="d-flex gap-3">

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           value="1"
                                           checked>

                                    <label class="form-check-label">
                                        Active
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           value="0">

                                    <label class="form-check-label">
                                        Inactive
                                    </label>
                                </div>

                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-sm">
                                Save User
                            </button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="card basic-data-table">
    <div class="card-body">

        <div class="table-responsive">

            <table class="table basic-border-table mb-0" id="dataTable">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($users as $index => $user)

                        <tr>

                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if($user->status)
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
                                        Active
                                    </span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td>

                                <div class="d-flex gap-2">

                                    <!-- Edit -->
                                    <a href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#editUserModal{{ $user->id }}"
                                       class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">

                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle border-0 d-inline-flex align-items-center justify-content-center">

                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                                <div class="modal-content radius-16 bg-base">

                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit User</h6>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <form action="{{ route('admin.users.update', $user->id) }}"
                                              method="POST">

                                            @csrf
                                            @method('PUT')

                                            <div class="row">

                                                <div class="col-md-6 mb-20">
                                                    <label class="form-label">Name <i class="text-danger">*</i></label>

                                                    <input type="text"
                                                           name="name"
                                                           class="form-control radius-8"
                                                           value="{{ $user->name }}"
                                                           required>
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label class="form-label">Email <i class="text-danger">*</i></label>

                                                    <input type="email"
                                                           name="email"
                                                           class="form-control radius-8"
                                                           value="{{ $user->email }}"
                                                           required>
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label class="form-label">Phone</label>

                                                    <input type="text"
                                                           name="phone"
                                                           class="form-control radius-8"
                                                           value="{{ $user->phone }}">
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label class="form-label">Password <i class="text-danger">*</i></label>

                                                    <input type="password"
                                                           name="password"
                                                           class="form-control radius-8"
                                                           placeholder="Leave blank to keep current password">
                                                </div>

                                                <div class="col-12 mb-20">

                                                    <label class="form-label">Status <i class="text-danger">*</i></label>

                                                    <div class="d-flex gap-3">

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="radio"
                                                                   name="status"
                                                                   value="1"
                                                                   {{ $user->status == 1 ? 'checked' : '' }}>

                                                            <label class="form-check-label">
                                                                Active
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="radio"
                                                                   name="status"
                                                                   value="0"
                                                                   {{ $user->status == 0 ? 'checked' : '' }}>

                                                            <label class="form-check-label">
                                                                Inactive
                                                            </label>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="text-center">
                                                    <button class="btn btn-primary btn-sm">
                                                        Update User
                                                    </button>
                                                </div>

                                            </div>

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