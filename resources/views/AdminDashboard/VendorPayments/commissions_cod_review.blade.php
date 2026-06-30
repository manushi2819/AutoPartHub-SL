@extends('AdminDashboard.index')

@section('title', 'Review Commission Settlement')

@section('content')
<style>
.status-pill { font-size: 0.8rem; padding: 5px 14px; border-radius: 20px; font-weight: 500; }
.status-submitted { background: #cfe2ff; color: #084298; }
.status-paid { background: #d1f2dd; color: #0f5132; }
.status-rejected { background: #f8d7da; color: #842029; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Settlement #{{ $settlement->id }} — {{ $settlement->vendor->shop_name ?? $settlement->vendor->name }}</h6>
    <a href="{{ route('admin.vendor-commissions-cod.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<div class="row g-4">
    <div class="col-8">
        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Items Claimed in This Settlement</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                     <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Product</th>
                                <th>Date</th>
                                <th class="text-end">Commission Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settlement->commissions as $commission)
                                <tr>
                                    <td>{{ $commission->order->order_number ?? '—' }}</td>
                                    <td>{{ $commission->product->name ?? 'N/A' }}</td>
                                    <td>{{ $commission->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($commission->commission_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if($settlement->status === 'rejected')
            <div class="alert alert-danger">
                <strong>Rejected on {{ $settlement->reviewed_at->format('M d, Y H:i') }}</strong><br>
                Reason: {{ $settlement->rejection_reason }}
            </div>
        @endif
    </div>

    <div class="col-4">
        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Summary</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Status:</strong>
                    <span class="status-pill status-{{ $settlement->status }}">{{ ucfirst($settlement->status) }}</span>
                </p>
                <p class="mb-1"><strong>Period:</strong> {{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</p>
                <p class="mb-1"><strong>Submitted On:</strong> {{ $settlement->submitted_at->format('M d, Y H:i') }}</p>
                <p class="mb-1"><strong>Reference:</strong> {{ $settlement->transfer_reference ?? '—' }}</p>
                <p class="mb-3 fw-bold fs-5 text-primary">Rs. {{ number_format($settlement->total_amount, 2) }}</p>

                @if($settlement->payment_slip)
                    <a href="{{ asset($settlement->payment_slip) }}" target="_blank" class="btn btn-outline-primary btn-sm w-100 mb-3">
                        <i class="fa-solid fa-receipt me-1"></i> View Payment Slip
                    </a>
                @endif

                @if($settlement->status === 'submitted')
                    <form action="{{ route('admin.vendor-commissions-cod.approve', $settlement->id) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa-solid fa-check me-1"></i> Approve
                        </button>
                    </form>

                    <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                        <i class="fa-solid fa-xmark me-1"></i> Reject
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.vendor-commissions-cod.reject', $settlement->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title">Reject Settlement</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-semibold">Reason for Rejection <span class="text-danger">*</span></label>
                    <textarea name="rejection_reason" class="form-control" rows="3" required
                              placeholder="e.g. Slip amount doesn't match claimed total"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Confirm Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endsection