@extends('AdminDashboard.index')

@section('title', 'Orders')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Orders</h6>
</div>

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
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
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
                            <td>
                                @if($order->status === 'pending')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-warning-focus text-warning-main">Pending</span>
                                @elseif($order->status === 'completed')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Completed</span>
                                @elseif($order->status === 'canceled')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Canceled</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                            <td>
                                @if($order->payment_status === 'pending')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-warning-focus text-warning-main">Pending</span>
                                @elseif($order->payment_status === 'paid')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Paid</span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">Failed</span>
                                @endif
                            </td>
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