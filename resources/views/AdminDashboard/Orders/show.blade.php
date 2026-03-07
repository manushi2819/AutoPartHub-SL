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
                                <th>Image</th>
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
                                    <td>
                                        @if($item->product && $item->product->images->count())
                                            <img src="{{ asset('uploads/' . $item->product->images->first()->image_url) }}" 
                                                alt="Product Image" width="60" height="60">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
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
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1"><strong>Order ID:</strong> {{ $order->order_number }}</p>
                    <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                    <p class="mb-0"><strong>Order Total:</strong> Rs. {{ number_format($order->total, 2) }}</p>
                    <p class="mb-0"><strong>Payment Status:</strong> 
                        <span class="badge {{ $order->payment_status == 'paid' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                    <p class="mb-0"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                </div>

                <hr class="mt-3 mb-3">

                <div class="mb-3">
                    <h6 class="fw-semibold" style="font-size: 18px !important;">Shipping Address</h6>
                    <p class="mb-1">{{ $order->first_name }} {{ $order->last_name }}</p>
                    <p class="mb-1">{{ $order->address }}</p>
                    <p class="mb-1">{{ $order->city }}, {{ $order->zip }}, {{ $order->country }}</p>
                    <p class="mb-0"><strong>Contact:</strong> {{ $order->phone }}</p>
                </div>

           
               
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="card shadow-sm border-0 mb-3">
    <div class="card-header bg-light text-white">
        <h6 class="mb-0">Order Status</h6>
    </div>
    <div class="card-body">
        <!-- Modern Status Tracker -->
        <div class="position-relative mb-3" style="padding: 20px 0;">
           @php
            $statuses = [
                'pending' => ['label' => 'Pending', 'icon' => 'fa-solid fa-hourglass-start', 'color' => '#22C55E'],
                'confirmed' => ['label' => 'Confirmed', 'icon' => 'fa-solid fa-check', 'color' => '#22C55E'],
                'in_transit' => ['label' => 'In Transit', 'icon' => 'fa-solid fa-truck', 'color' => '#22C55E'],
                'delivered' => ['label' => 'Delivered', 'icon' => 'fa-solid fa-gift', 'color' => '#22C55E'],
            ];

            $currentStatus = $order->status;
            $statusKeys = array_keys($statuses);
            $currentIndex = array_search($currentStatus, $statusKeys);
            $progressPercent = ($currentIndex / (count($statusKeys) - 1)) * 100;
            @endphp

            <!-- Progress Bar Background -->
            <div class="progress" style="height: 4px; position: absolute; top: 45px; left: 0; right: 0; z-index: 1;">
                <div class="progress-bar" role="progressbar" 
                     style="width: {{ ($currentIndex / (count($statusKeys) - 1)) * 100 }}%; background: linear-gradient(90deg, #22C55E, #16A34A);"
                     aria-valuenow="{{ ($currentIndex / (count($statusKeys) - 1)) * 100 }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>

            <!-- Status Steps -->
            <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                @foreach($statuses as $key => $status)
                    @php
                        $isCompleted = array_search($key, $statusKeys) <= $currentIndex;
                        $isCurrent = $key === $currentStatus;
                    @endphp
                    
                    <div class="text-center" style="flex: 1;">
                        <!-- Status Icon -->
                       <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                            style="width: 50px; height: 50px; 
                                    background: {{ $isCompleted ? $status['color'] : '#f8f9fa' }};
                                    border: 3px solid {{ $isCompleted ? $status['color'] : '#dee2e6' }};
                                    box-shadow: {{ $isCurrent ? '0 0 0 3px rgba(' . implode(',', sscanf($status['color'], '#%02x%02x%02x')) . ',0.2)' : 'none' }};
                                    transition: all 0.3s ease;">
                            <i class="{{ $status['icon'] }}" style="font-size: 1.5rem; color: {{ $isCompleted ? 'white' : '#6c757d' }};"></i>
                        </div>
                        
                        <!-- Status Label -->
                        <div>
                            <span class="fw-bold d-block" 
                                  style="color: {{ $isCompleted ? $status['color'] : '#6c757d' }};">
                                {{ $status['label'] }}
                            </span>
                            @if($isCurrent)
                                <small class="text-muted">Current</small>
                            @endif
                        </div>
                        
                        <!-- Date (if available) -->
                        @if($isCompleted && isset($order->{$key . '_at'}))
                            <small class="text-muted d-block mt-1">
                                {{ \Carbon\Carbon::parse($order->{$key . '_at'})->format('M d, H:i') }}
                            </small>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

                <!-- Update Status Form -->
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-5">
                    <label class="form-label fw-semibold">Update Order Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="in_transit" {{ $order->status === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="col-5">
                    <label class="form-label fw-semibold">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </div>

            
        </form>
    </div>
</div>

<!-- Add this CSS to your stylesheet or in a style tag -->
<style>
.status-step {
    transition: all 0.3s ease;
}

.status-step:hover .rounded-circle {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.progress {
    overflow: visible;
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
    transition: width 1s ease-in-out;
}

.form-select-lg {
    padding: 0.75rem 1rem;
    font-size: 1rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.form-select-lg:hover {
    background-color: #e9ecef !important;
}

.btn-lg {
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-weight: 500;
}

.border-top {
    border-color: #dee2e6 !important;
    opacity: 0.5;
}
</style>


@endsection