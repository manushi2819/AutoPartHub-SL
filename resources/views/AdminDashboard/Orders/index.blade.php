@extends('AdminDashboard.index')

@section('title', 'Orders')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Orders</h6>
</div>

<form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 mb-3">

    <div class="col-md-3">
        <input type="text" name="order_number" class="form-control"
               placeholder="Order Number"
               value="{{ request('order_number') }}">
    </div>

    <div class="col-md-3">
        <input type="text" name="customer_name" class="form-control"
               placeholder="Customer Name"
               value="{{ request('customer_name') }}">
    </div>

    <div class="col-md-2">
        <select name="payment_method" class="form-select">
            <option value="">Payment Method</option>
            <option value="cod" {{ request('payment_method')=='cod' ? 'selected' : '' }}>COD</option>
            <option value="card" {{ request('payment_method')=='card' ? 'selected' : '' }}>Card</option>
        </select>
    </div>

    <div class="col-md-2">
        <select name="payment_status" class="form-select">
            <option value="">Payment Status</option>
            <option value="pending" {{ request('payment_status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="paid" {{ request('payment_status')=='paid' ? 'selected' : '' }}>Paid</option>
            <option value="failed" {{ request('payment_status')=='failed' ? 'selected' : '' }}>Failed</option>
        </select>
    </div>

    <div class="col-md-2 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100 btn-sm">Filter</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm w-100">Reset</a>
    </div>

</form>

<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Order Number</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>Rs. {{ number_format($order->total, 2) }}</td>
                            
                            <td>{{ ucfirst($order->payment_method) }}</td>
                           
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" 
                                   class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center" 
                                   title="View Order">
                                   <iconify-icon icon="lucide:eye"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection