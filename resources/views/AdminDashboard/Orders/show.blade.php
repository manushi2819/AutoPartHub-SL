@extends('AdminDashboard.index')

@section('title', 'Order Details')

@section('content')


<style>
/* Mobile responsiveness for order details */
@media (max-width: 767.98px) {
    /* Stack columns vertically */
    .row.g-4 {
        flex-direction: column;
    }

    .col-8, .col-4 {
        width: 100% !important;
    }

    /* Make tables horizontally scrollable */
    .table-responsive {
        overflow-x: auto;
    }

    /* Reduce padding for mobile cards */
    .card-body {
        padding: 0.75rem !important;
    }

    /* Adjust text size */
    h6, h4, .fw-semibold {
        font-size: 1rem !important;
    }

    /* Buttons full width and spacing */
    .btn.w-100 {
        width: 100% !important;
        margin-top: 0.5rem;
    }

    /* Summary badges smaller */
    .px-24.py-4 {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.8rem !important;
    }

    /* Totals box adjustments */
    .mt-4.p-3.bg-light.rounded {
        padding: 0.75rem !important;
    }
}

/* Optional: make table headers sticky on mobile for better usability */
.table thead {
    background-color: #f8f9fa;
}
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Order Details - {{ $order->order_number }}</h6>
     <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: Products -->
    <div class="col-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0">Order Items</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rs. {{ number_format($item->price, 2) }}</td>
                                    <td class="text-end">Rs. {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span class="fw-bold">Rs. {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Discount:</span>
                        <span class="fw-bold">Rs. {{ number_format($order->discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2 mt-3">
                        <span>Total:</span>
                        <span class="fw-bold fs-6 text-primary">Rs. {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Summary & Customer Info -->
    <div class="col-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #48ff0060;">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1"><strong>Order ID:</strong> {{ $order->order_number }}</p>
                    <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                    <p class="mb-0"><strong>Order Total:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                </div>

                <hr class="mt-3 mb-3">

                <div class="mb-3">
                    <h6 class="fw-semibold" style="font-size: 18px !important;">Shipping Address</h6>
                    <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                    <p class="mb-1">{{ $order->address }}</p>
                    <p class="mb-1">{{ $order->city }}, {{ $order->zip }}, {{ $order->country }}</p>
                    <p class="mb-0"><strong>Contact:</strong> {{ $order->phone }}</p>
                </div>

                <hr class="mt-3 mb-3">

                <div class="mb-3">
                    <h6 class="fw-semibold" style="font-size: 18px !important;">Payment Method</h6>
                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-info-focus text-info-main">{{ strtoupper($order->payment_method) }}</span>
                </div>

                <a href="{{ route('admin.orders.track', $order->id) }}" class="btn btn-primary w-100 fw-semibold shadow">
                    <i class="iconify" data-icon="mdi:truck-fast"></i> Track Order
                </a>
            </div>
        </div>
    </div>
</div>

@endsection