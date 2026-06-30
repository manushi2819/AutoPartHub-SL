@extends('AdminDashboard.index')

@section('title', 'Settlement Details')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Settlement #{{ $settlement->id }} — {{ $settlement->vendor->shop_name ?? $settlement->vendor->name }}</h6>
    <a href="{{ route('admin.vendor-earnings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<div class="row g-4">
    <div class="col-8">
        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Items Covered</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Order date</th>
                                <th>Product</th>
                                <th class="text-end">Earning Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlement->earnings as $earning)
                                <tr>
                                    <td>{{ $earning->order->order_number ?? '—' }}</td>
                                    <td>{{ $earning->order->created_at->format('M d, Y H:i A') ?? '—' }}</td>
                                    <td>{{ $earning->product->name ?? 'N/A' }}</td>
                                    <td class="text-end">Rs. {{ number_format($earning->earning_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Summary</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Period:</strong> {{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</p>
                <p class="mb-1"><strong>Paid On:</strong> {{ $settlement->paid_at->format('M d, Y H:i') }}</p>
                <p class="mb-1">
                    <strong>Paid By:</strong>
                    @if($settlement->paid_by == 0)
                        Super Admin
                    @else
                        {{ \App\Models\AdminUser::find($settlement->paid_by)?->name ?? 'Unknown' }}
                    @endif
                </p>
                <p class="mb-1"><strong>Reference:</strong> {{ $settlement->transfer_reference ?? '—' }}</p>
                <p class="mb-3 fw-bold fs-5 text-success">Rs. {{ number_format($settlement->total_amount, 2) }}</p>

                @if($settlement->notes)
                    <p class="mb-3"><strong>Notes:</strong><br>{{ $settlement->notes }}</p>
                @endif

                @if($settlement->payment_slip)
                    <a href="{{ asset($settlement->payment_slip) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fa-solid fa-receipt me-1"></i> View Payment Slip
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection