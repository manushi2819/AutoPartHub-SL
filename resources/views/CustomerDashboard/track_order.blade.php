@extends('Frontend.master')

@section('title', 'Order Details - Track Order')

@section('content')

<style>
@media (max-width: 767.98px) {
    .row.g-4 { flex-direction: column; }
    .col-8, .col-4 { width: 100% !important; }
    .table-responsive { overflow-x: auto; }
    .card-body { padding: 0.75rem !important; }
    h6, h4, .fw-semibold { font-size: 1rem !important; }
    .btn.w-100 { width: 100% !important; margin-top: 0.5rem; }
    .px-24.py-4 { padding: 0.25rem 0.5rem !important; font-size: 0.8rem !important; }
    .mt-4.p-3.bg-light.rounded { padding: 0.75rem !important; }
}

.table thead { background-color: #f8f9fa; }

.status-step { transition: all 0.3s ease; }
.status-step:hover .rounded-circle {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.progress { overflow: visible; background-color: #e9ecef; border-radius: 10px; }
.progress-bar { border-radius: 10px; transition: width 1s ease-in-out; }
.border-top { border-color: #dee2e6 !important; opacity: 0.5; }

.bg-success { background-color: #16A34A !important; }
.bg-warning { background-color: #FFA500 !important; }

.mini-tracker .rounded-circle { width: 40px; height: 40px; }
.mini-tracker i { font-size: 1.1rem !important; }

.status-pill {
    font-size: 0.75rem;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 500;
}
.status-pending    { background: #fff3cd; color: #92660d; }
.status-confirmed   { background: #d1ecf1; color: #0c5460; }
.status-in_transit  { background: #cfe2ff; color: #084298; }
.status-delivered   { background: #d1f2dd; color: #0f5132; }
.status-cancelled, .status-failed { background: #f8d7da; color: #842029; }
</style>

<!-- page-title -->
<section class="page-title-two centred">
    <div class="container">
        <div class="content-box">
            <h4>Order Details - {{ $order->order_number }}</h4>
        </div>
    </div>
</section>
<!-- page-title end -->

<div class="container mb-5">
    <div class="row g-4">
        <!-- Left Column: Products -->
        <div class="col-9">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header text-white" style="background-color: #007bff60;">
                    <h6 class="mb-0">Order Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th class="text-end">Subtotal</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->product->name, 30) }}</td>
                                        <td>
                                            @if($item->product && $item->product->images->count())
                                                <img src="{{ asset('uploads/' . $item->product->images->first()->image_url) }}"
                                                    alt="Product Image" width="50" height="50">
                                            @else
                                                <span class="text-muted">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rs. {{ number_format($item->price, 2) }}</td>
                                        <td class="text-end">Rs. {{ number_format($item->subtotal, 2) }}</td>
                                        <td>
                                            <span class="status-pill status-{{ $item->status }}">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#itemStatusModal{{ $item->id }}">
                                                View Status
                                            </button>
                                        </td>
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
                            <span style="color:black !important">Total:</span>
                            <span class="fw-bold fs-6" style="color:black !important">Rs. {{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Customer Info -->
        <div class="col-3">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header text-white" style="background-color: #007bff60;">
                    <h6 class="mb-0">Summary</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="mb-1"><strong>Order ID:</strong> {{ $order->order_number }}</p>
                        <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                        <p class="mb-1"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
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
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

{{-- ===================== --}}
{{-- Per-item status modals --}}
{{-- ===================== --}}
@php
    $statuses = [
        'pending'    => ['label' => 'Pending',    'icon' => 'fa-solid fa-hourglass-start', 'color' => '#04a840'],
        'confirmed'  => ['label' => 'Confirmed',  'icon' => 'fa-solid fa-check',            'color' => '#04a840'],
        'in_transit' => ['label' => 'In Transit', 'icon' => 'fa-solid fa-truck',            'color' => '#04a840'],
        'delivered'  => ['label' => 'Delivered',  'icon' => 'fa-solid fa-gift',             'color' => '#04a840'],
    ];
    $statusKeys = array_keys($statuses);
@endphp

@foreach ($order->items as $item)
    @php
        $currentIndex = array_search($item->status, $statusKeys);
        $currentIndex = $currentIndex === false ? -1 : $currentIndex; // handles 'cancelled'/'failed'
        $progressPercent = $currentIndex >= 0 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0;
    @endphp

    <div class="modal fade" id="itemStatusModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">
                        {{ $item->product->name ?? 'Item #' . $item->id }} — Status
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if(in_array($item->status, ['cancelled', 'failed']))
                        <div class="alert alert-danger mb-0">
                            <i class="fa-solid fa-circle-xmark me-2"></i>
                            This item was {{ $item->status }} and is not being shipped.
                        </div>
                    @else
                        <!-- Status Tracker -->
                        <div class="position-relative mb-4 mini-tracker" style="padding: 20px 0;">
                            <div class="progress" style="height: 4px; position: absolute; top: 40px; left: 0; right: 0; z-index: 1;">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ $progressPercent }}%; background: linear-gradient(90deg, #22C55E, #16A34A);"
                                     aria-valuenow="{{ $progressPercent }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between position-relative" style="z-index: 2;">
                                @foreach($statuses as $key => $status)
                                    @php
                                        $stepIndex = array_search($key, $statusKeys);
                                        $isCompleted = $currentIndex >= 0 && $stepIndex <= $currentIndex;
                                        $isCurrent = $key === $item->status;
                                    @endphp

                                    <div class="text-center" style="flex: 1;">
                                        <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2"
                                             style="background: {{ $isCompleted ? $status['color'] : '#f8f9fa' }};
                                                    border: 3px solid {{ $isCompleted ? $status['color'] : '#dee2e6' }};
                                                    box-shadow: {{ $isCurrent ? '0 0 0 3px rgba(34,197,94,0.2)' : 'none' }};
                                                    transition: all 0.3s ease;">
                                            <i class="{{ $status['icon'] }}" style="color: {{ $isCompleted ? 'white' : '#6c757d' }};"></i>
                                        </div>

                                        <div>
                                            <span class="fw-bold d-block" style="color: {{ $isCompleted ? $status['color'] : '#6c757d' }};">
                                                {{ $status['label'] }}
                                            </span>
                                            @if($isCurrent)
                                                <small class="text-muted">Current</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($item->tracking_no)
                            <p class="mb-3"><strong>Tracking Number:</strong> {{ $item->tracking_no }}</p>
                        @endif

                        <!-- Mark as Delivered: only when item is in_transit -->
                        @if($item->status === 'in_transit')
                            <form method="POST" action="{{ route('customer.orderitem.markDelivered', $item->id) }}" class="border-top pt-3">
                                @csrf
                                @method('PUT')
                                <div class="row g-3 align-items-center">
                                    <div class="col-12 col-md-8">
                                        <p class="mb-0">Click the button below when you have received this item.</p>
                                    </div>
                                    <div class="col-12 col-md-4 text-md-end">
                                        <button type="submit" class="btn theme-btn p-2">
                                            <i class="fa-solid fa-check-circle me-2"></i>Mark as Delivered
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @elseif($item->status === 'delivered')
                            <div class="alert alert-success mb-0">
                                <i class="fa-solid fa-circle-check me-2"></i>
                                This item has been delivered successfully.
                            </div>
                        @else
                            <p class="text-muted mb-0">
                                <i class="fa-solid fa-info-circle me-2"></i>
                                You'll be able to confirm delivery once this item is shipped.
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection