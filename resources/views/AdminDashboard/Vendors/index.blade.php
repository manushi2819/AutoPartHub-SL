@extends('AdminDashboard.master')
@section('title', 'Vendors')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Vendors</h6>
</div>

<div class="card basic-data-table">
<div class="card-body">

<div class="table-responsive">

{{-- TABS --}}
<ul class="nav nav-pills mb-3">

  {{-- TABS --}}
    <ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.vendors.index', ['status' => 'Pending']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status','Pending')=='Pending' ? 'active' : '' }}">
                Pending
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.vendors.index', ['status' => 'Approved']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status')=='Approved' ? 'active' : '' }}">
                Approved
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.vendors.index', ['status' => 'Rejected']) }}"
                class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status')=='Rejected' ? 'active' : '' }}">
                Rejected
            </a>
        </li>
    </ul>

    </ul>
{{-- TABLE --}}
  <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>

<thead>
<tr>
    <th>#</th>
    <th>Shop</th>
    <th>Owner</th>
    <th>Email</th>
    <th>Phone</th>
    <th>NIC</th>
    <th>Address</th>
    <th>District</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($vendors as $vendor)
<tr>
    <td>{{ $loop->iteration }}</td>

    <td>{{ $vendor->shop_name }}</td>
    <td>{{ $vendor->owner_name }}</td>
    <td>{{ $vendor->email }}</td>
    <td>{{ $vendor->phone }}</td>
    <td>{{ $vendor->nic }}</td>
    <td>{{ $vendor->address }}</td>
    <td>{{ $vendor->district }}</td>

    <td>
        <span class="px-24 py-4 rounded-pill fw-medium text-sm 
            @if($vendor->status == 'Approved') bg-success-focus text-success-main
            @elseif($vendor->status == 'Rejected') bg-danger-focus text-danger-main
            @else bg-warning-focus text-warning-main @endif">
            {{ $vendor->status }}
        </span>
    </td>

    <td>

        <button class="btn btn-sm btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#statusModal{{ $vendor->id }}">
            Update Status
        </button>

        <a href="{{ route('admin.vendors.show', $vendor->id) }}" 
            class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" 
            title="View vendor">
            <iconify-icon icon="lucide:eye"></iconify-icon>
        </a>

    </td>
</tr>

<!-- STATUS MODAL -->
<div class="modal fade" id="statusModal{{ $vendor->id }}">
<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
    <h6>Update Vendor Status</h6>
</div>

<form method="POST"
      action="{{ route('admin.vendors.status', $vendor->id) }}">
    @csrf

    <div class="modal-body">

        <select name="status" class="form-control">
            <option value="Pending" {{ $vendor->status=='Pending'?'selected':'' }}>Pending</option>
            <option value="Approved" {{ $vendor->status=='Approved'?'selected':'' }}>Approved</option>
            <option value="Rejected" {{ $vendor->status=='Rejected'?'selected':'' }}>Rejected</option>
            <option value="Suspended" {{ $vendor->status=='Suspended'?'selected':'' }}>Suspended</option>
        </select>

    </div>

    <div class="modal-footer">
        <button class="btn btn-success btn-sm">Update</button>
    </div>

</form>

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