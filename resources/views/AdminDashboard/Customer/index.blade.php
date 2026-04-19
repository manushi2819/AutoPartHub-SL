@extends('AdminDashboard.index')

@section('title', 'Customers')

@section('content')

<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Customers</h6>
</div>

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
                        <th>Address</th>
                        <th>Total Orders</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $index => $customer)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? ''}}</td>
                        <td>{{ $customer->address ?? '' }}</td>
                        <td>{{ $customer->orders_count ?? 0}}</td>
                        <td>
                            @if($customer->status)
                                <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Active</span>
                            @else
                                <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editCustomerModal{{ $customer->id }}" class="btn btn-sm btn-warning p-1">Update Status</a>
                        </td>
                    </tr>

                    <!-- Update Status Modal -->
                    <div class="modal fade" id="editCustomerModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content radius-16 bg-base">
                                <div class="modal-header py-16 px-24 border-top-0 border-start-0 border-end-0">
                                    <h6 class="modal-title">Update Status: {{ $customer->first_name }} {{ $customer->last_name }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-24">
                                    <form action="{{ route('admin.customers.updateStatus', $customer->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-20">
                                            <label class="form-label">Status</label>
                                            <div class="d-flex gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" value="1" {{ $customer->status ? 'checked' : '' }}>
                                                    <label class="form-check-label">Active</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="status" value="0" {{ !$customer->status ? 'checked' : '' }}>
                                                    <label class="form-check-label">Inactive</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-end gap-3 mt-24">
                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection