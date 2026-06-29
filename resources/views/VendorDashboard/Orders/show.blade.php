@extends('VendorDashboard.index')

@section('title', 'Order Details')

@section('content')

<style>
@media (max-width: 767.98px) {
    .row.g-4 { flex-direction: column; }
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
.border-top { border-color: #dee2e6 !important; }

.mini-tracker .rounded-circle { width: 36px; height: 36px; }
.mini-tracker i { font-size: 1rem !important; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Order Details - {{ $order->order_number }}</h6>
    <a href="{{ route('vendor.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<!-- Order Items: full width -->
<div class="row g-4">
    <div class="col-9">
        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0" style="font-size:18px !important">Your Items in This Order</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th class="text-end">Subtotal</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Tracking No</th>
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
                                        @php
                                            $statusColors = [
                                                'pending'    => 'bg-warning-focus text-warning-main',
                                                'confirmed'  => 'bg-info-focus text-info-main',
                                                'in_transit' => 'bg-info-focus text-info-main',
                                                'delivered'  => 'bg-success-focus text-success-main',
                                                'cancelled'  => 'bg-danger-focus text-danger-main',
                                            ];
                                        @endphp
                                        <span class="px-24 py-4 rounded-pill fw-medium text-sm {{ $statusColors[$item->status] ?? 'bg-light text-dark' }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="px-24 py-4 rounded-pill fw-medium text-sm
                                            {{ $item->payment_status == 'paid' ? 'bg-success-focus text-success-main' : 'bg-warning-focus text-warning-main' }}">
                                            {{ ucfirst($item->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->tracking_no ?? '—' }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#updateItemModal{{ $item->id }}">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-light rounded">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Your Items Subtotal:</span>
                        <span class="fw-bold">Rs. {{ number_format($order->items->sum('subtotal'), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff60;">
                <h6 class="mb-0" style="font-size:18px !important">Summary</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <p class="mb-1"><strong>Order ID:</strong> {{ $order->order_number }}</p>
                        <p class="mb-1"><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
                        <p class="mb-3"><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>

                        <h6 class="fw-semibold" style="font-size: 18px !important;">Shipping Address</h6>
                        <p class="mb-0">{{ $order->first_name }} {{ $order->last_name }}</p>
                        <p class="mb-0">{{ $order->address }}</p>
                        <p class="mb-1">{{ $order->city }}, {{ $order->zip }}, {{ $order->country }}</p>
                        <p class="mb-0"><strong>Contact:</strong> {{ $order->phone }} / {{ $order->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

{{-- ===================== --}}
{{-- Per-item update modals --}}
{{-- ===================== --}}
@php
    $statuses = [
        'pending'    => ['label' => 'Pending',    'icon' => 'fa-solid fa-hourglass-start', 'color' => '#22C55E'],
        'confirmed'  => ['label' => 'Confirmed',  'icon' => 'fa-solid fa-check',            'color' => '#22C55E'],
        'in_transit' => ['label' => 'In Transit', 'icon' => 'fa-solid fa-truck',            'color' => '#22C55E'],
        'delivered'  => ['label' => 'Delivered',  'icon' => 'fa-solid fa-gift',             'color' => '#22C55E'],
    ];
    $statusKeys = array_keys($statuses);
@endphp

@foreach ($order->items as $item)
    @php
        $currentIndex = array_search($item->status, $statusKeys);
        $currentIndex = $currentIndex === false ? -1 : $currentIndex;
        $progressPercent = $currentIndex >= 0 ? ($currentIndex / (count($statusKeys) - 1)) * 100 : 0;
    @endphp

    <div class="modal fade" id="updateItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">
                        Update — {{ $item->product->name ?? 'Item #' . $item->id }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="position-relative mb-4 mini-tracker" style="padding: 10px 0;">
                        <div class="progress" style="height: 4px; position: absolute; top: 28px; left: 0; right: 0; z-index: 1;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $progressPercent }}%; background: linear-gradient(90deg, #22C55E, #16A34A);">
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
                                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-1"
                                         style="background: {{ $isCompleted ? $status['color'] : '#f8f9fa' }};
                                                border: 2px solid {{ $isCompleted ? $status['color'] : '#dee2e6' }};
                                                box-shadow: {{ $isCurrent ? '0 0 0 3px rgba(34,197,94,0.2)' : 'none' }};">
                                        <i class="{{ $status['icon'] }}" style="color: {{ $isCompleted ? 'white' : '#6c757d' }};"></i>
                                    </div>
                                    <small class="d-block fw-semibold" style="color: {{ $isCompleted ? $status['color'] : '#6c757d' }};">
                                        {{ $status['label'] }}
                                    </small>
                                </div>
                            @endforeach
                        </div>

                        @if($item->status === 'cancelled')
                            <div class="text-center mt-2">
                                <span class="badge bg-danger">Cancelled</span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('vendor.orderitems.updateStatus', $item->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3">
                            <div class="col-4">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $item->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="in_transit" {{ $item->status === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                    <option value="delivered" {{ $item->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $item->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label fw-semibold">Payment Status</label>
                                <select name="payment_status" class="form-select">
                                    <option value="pending" {{ $item->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $item->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="form-label fw-semibold">Tracking Number</label>
                                <input type="text" name="tracking_no" class="form-control"
                                       value="{{ $item->tracking_no ?? '' }}" placeholder="Enter tracking number">
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection