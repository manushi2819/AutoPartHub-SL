@extends('AdminDashboard.index')

@section('title', 'Admin Bank Accounts')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Admin Bank Accounts</h6>

    <a href="#" class="btn btn-primary btn-sm"
       data-bs-toggle="modal"
       data-bs-target="#bankModal">
        <i class="ri-add-line"></i> Add Bank Account
    </a>
</div>

<!-- Add Modal -->
<div class="modal fade" id="bankModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">

            <div class="modal-header">
                <h6 class="modal-title">Add Bank Account</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Bank Name *</label>
                            <input type="text" name="bank_name" class="form-control radius-8" required>
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Branch *</label>
                            <input type="text" name="branch" class="form-control radius-8" required>
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Account Name *</label>
                            <input type="text" name="account_name" class="form-control radius-8" required>
                        </div>

                        <div class="col-md-6 mb-20">
                            <label class="form-label">Account Number *</label>
                            <input type="text" name="account_number" class="form-control radius-8" required>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label">Default Account *</label>

                            <div class="d-flex gap-3">

                                <div class="form-check">
                                    <input class="form-check-input mt-1 me-1" type="radio" name="is_default" value="1" checked>
                                    <label class="form-check-label">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input mt-1 me-1" type="radio" name="is_default" value="0">
                                    <label class="form-check-label">No</label>
                                </div>

                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary btn-sm">Save</button>
                        </div>

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
                        <th>Bank</th>
                        <th>Branch</th>
                        <th>Account Name</th>
                        <th>Account No</th>
                        <th>Default</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($accounts as $index => $account)

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $account->bank_name }}</td>
                            <td>{{ $account->branch }}</td>
                            <td>{{ $account->account_name }}</td>
                            <td>{{ $account->account_number }}</td>
                            <td>
                                @if($account->is_default)
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Default</span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-secondary-focus text-secondary-main">Normal</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <!-- Edit -->
                                    <a href="#"
                                       data-bs-toggle="modal"
                                       data-bs-target="#editBankModal{{ $account->id }}"
                                       class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.bank-accounts.destroy', $account->id) }}" method="POST">
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
                        <div class="modal fade" id="editBankModal{{ $account->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content radius-16 bg-base">

                                    <div class="modal-header">
                                        <h6 class="modal-title">Edit Bank Account</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <form action="{{ route('admin.bank-accounts.update', $account->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="row">

                                                <div class="col-md-6 mb-20">
                                                    <label>Bank Name *</label>
                                                    <input type="text" name="bank_name" class="form-control radius-8"
                                                           value="{{ $account->bank_name }}" required>
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label>Branch *</label>
                                                    <input type="text" name="branch" class="form-control radius-8"
                                                           value="{{ $account->branch }}" required>
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label>Account Name *</label>
                                                    <input type="text" name="account_name" class="form-control radius-8"
                                                           value="{{ $account->account_name }}" required>
                                                </div>

                                                <div class="col-md-6 mb-20">
                                                    <label>Account Number *</label>
                                                    <input type="text" name="account_number" class="form-control radius-8"
                                                           value="{{ $account->account_number }}" required>
                                                </div>

                                                <div class="col-12 mb-20">
                                                    <label class="form-label">Default</label>

                                                    <div class="d-flex gap-3">

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                type="radio"
                                                                name="is_default"
                                                                value="1"
                                                                id="defaultYes{{ $account->id }}"
                                                                {{ $account->is_default == 1 ? 'checked' : '' }}>

                                                            <label class="form-check-label me-1" for="defaultYes{{ $account->id }}">
                                                                Yes
                                                            </label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                type="radio"
                                                                name="is_default"
                                                                value="0"
                                                                id="defaultNo{{ $account->id }}"
                                                                {{ $account->is_default == 0 ? 'checked' : '' }}>

                                                            <label class="form-check-label  me-1" for="defaultNo{{ $account->id }}">
                                                                No
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <button class="btn btn-primary btn-sm">Update</button>
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