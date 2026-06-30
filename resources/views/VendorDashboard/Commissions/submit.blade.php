@extends('VendorDashboard.index')

@section('title', 'COD Commission Settlement')

@section('content')
<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-submitted { background: #cfe2ff; color: #084298; }
.status-paid { background: #d1f2dd; color: #0f5132; }
.status-rejected { background: #f8d7da; color: #842029; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6>Admin Commissions — COD Orders</h6>
</div>

{{-- TABS --}}
<ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.commissions.index', ['tab' => 'pending']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'pending' ? 'active' : '' }}">
            Pending Settlement
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a href="{{ route('vendor.commissions.index', ['tab' => 'history']) }}"
            class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ $tab == 'history' ? 'active' : '' }}">
            Submission History
        </a>
    </li>
</ul>

@if($tab == 'pending')
    @if($commissions->isEmpty())
        <div class="alert alert-info" style="font-size:15px !important">You have no pending COD commissions to settle right now.</div>
    @else
        <form action="{{ route('vendor.commissions.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card basic-data-table shadow-sm border-0 mb-3">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff1f;">
                    <h6 class="mb-0" style="font-size:17px !important">
                        Your Pending Commissions
                        <small class="d-block fw-normal mt-1" style="font-size: 0.8rem;">
                            Period: {{ \Carbon\Carbon::parse($periodStart)->format('M d, Y') }} – {{ \Carbon\Carbon::parse($periodEnd)->format('M d, Y') }}
                        </small>
                    </h6>
                    <div class="form-check form-switch text-white">
                        <input class="form-check-input" type="checkbox" id="selectAll" checked>
                        <label class="form-check-label" for="selectAll">Select All</label>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-danger" style="font-size:12px">** Select the commissions you are paying to admin, then attach your bank transfer slip below.</p>

                    <div class="table-responsive">
                         <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                            <thead class="table-light">
                                <tr>
                                    <th width="40"></th>
                                    <th>Order #</th>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th class="text-end">Commission Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissions as $commission)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input commission-checkbox"
                                                   name="commission_ids[]" value="{{ $commission->id }}"
                                                   data-amount="{{ $commission->commission_amount }}" checked>
                                        </td>
                                        <td>{{ $commission->order->order_number ?? '—' }}</td>
                                        <td>{{ $commission->product->name ?? 'N/A' }}</td>
                                        <td>{{ $commission->created_at->format('M d, Y') }}</td>
                                        <td class="text-end">Rs. {{ number_format($commission->commission_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 p-3 bg-light rounded d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Selected Total to Pay:</span>
                        <span class="fw-bold fs-5 text-primary" id="selectedTotal">
                            Rs. {{ number_format($commissions->sum('commission_amount'), 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header text-white" style="background-color: #007bff1f;">
                    <h6 class="mb-0" style="font-size:17px !important">Payment Proof</h6>
                </div>
                <div class="card-body">
                       <h6 class="mb-3" style="font-size:15px !important">
                            <i class="fa-solid fa-building-columns me-2"></i>
                            Admin Bank Details
                        </h6>
                        @php
                            $defaultBank = \App\Models\AdminBankAccount::where('is_default', 1)->first();
                        @endphp

                        <div class="row">

                            <div class="col-md-6 mb-1">
                                <strong>Bank Name :</strong>
                                <span>{{ $defaultBank->bank_name ?? '-' }}</span>
                            </div>

                            <div class="col-md-6 mb-1">
                                <strong>Branch Name :</strong>
                                <span>{{ $defaultBank->branch ?? '-' }}</span>
                            </div>

                            <div class="col-md-6 mb-1">
                                <strong>Account Name :</strong>
                                <span>{{ $defaultBank->account_name ?? '-' }}</span>
                            </div>

                            <div class="col-md-6 mb-0">
                                <strong>Account Number :</strong>
                                <span class="fw-bold">
                                    {{ $defaultBank->account_number ?? '-' }}
                                </span>
                            </div>

                        </div>

                    <hr class="mt-3 mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Transfer Reference (optional)</label>
                            <input type="text" name="transfer_reference" class="form-control" placeholder="Bank ref / transaction ID">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Slip <span class="text-danger">*</span></label>
                            <input type="file" name="payment_slip" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-paper-plane me-1"></i> Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif
@else
    <div class="card basic-data-table shadow-sm border-0 mb-3">

        <div class="card-body">
                <div class="table-responsive">
                     <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                        <thead class="table-light">
                            <tr>
                                <th>Period</th>
                                <th class="text-end">Amount</th>
                                <th>Status</th>
                                <th>Submitted On</th>
                                <th>Slip</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $settlement)
                                <tr>
                                    <td>{{ $settlement->period_start->format('M d') }} – {{ $settlement->period_end->format('M d, Y') }}</td>
                                    <td class="text-end fw-bold">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                                    <td>
                                        <span class="status-pill status-{{ $settlement->status }}">
                                            {{ ucfirst($settlement->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $settlement->submitted_at?->format('M d, Y') }}</td>
                                    <td>  @if($settlement->payment_slip)
                                            <a href="{{ asset($settlement->payment_slip) }}" target="_blank" class="text-primary">
                                                <i class="fa-solid fa-receipt me-1"></i> View Payment Slip
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($settlement->status === 'rejected')
                                            <span class="text-danger small">{{ $settlement->rejection_reason }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.commission-checkbox');
    const selectAll = document.getElementById('selectAll');
    const totalEl = document.getElementById('selectedTotal');

    if (!checkboxes.length) return;

    function recalcTotal() {
        let total = 0;
        checkboxes.forEach(cb => { if (cb.checked) total += parseFloat(cb.dataset.amount); });
        totalEl.textContent = 'Rs. ' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    checkboxes.forEach(cb => cb.addEventListener('change', function () {
        recalcTotal();
        selectAll.checked = Array.from(checkboxes).every(c => c.checked);
    }));

    selectAll.addEventListener('change', function () {
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        recalcTotal();
    });

    recalcTotal();
});
</script>
@endsection