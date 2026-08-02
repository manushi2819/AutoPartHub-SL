@extends('AdminDashboard.index')

@section('title', 'Settle Manually — Suspended Vendor')

@section('content')

<style>
.status-pill { font-size: 0.75rem; padding: 4px 10px; border-radius: 20px; font-weight: 500; }
.status-rejected { background: #f8d7da; color: #842029; }
</style>

<div class="d-flex justify-content-between mb-3">
    <h6 class="mb-0">
        Manual Settlement — {{ $vendor->shop_name ?? $vendor->name }}
        <span class="status-pill status-rejected ms-2">Suspended</span>
    </h6>
    <a href="{{ route('admin.vendor-commissions-cod.index', ['tab' => 'pending']) }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

<div class="alert alert-warning" style="font-size:14px !important">
    <i class="fa-solid fa-triangle-exclamation me-1"></i>
    This vendor is suspended and paid you directly (bank transfer/cash) since they cannot access the system.
    Confirm the commissions being settled and attach proof of payment received. This will reactivate their account.
</div>

@if($commissions->isEmpty())
    <div class="alert alert-info">This vendor has no pending COD commissions right now.</div>
@else
    <form action="{{ route('admin.vendor-commissions-cod.settle-manual.store', $vendor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">
                    Pending Commissions
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
                                    <td>{{ $commission->orderItem->product->name ?? 'N/A' }}</td>
                                    <td>{{ $commission->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($commission->commission_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-light rounded d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Selected Total:</span>
                    <span class="fw-bold fs-5 text-primary" id="selectedTotal">
                        Rs. {{ number_format($commissions->sum('commission_amount'), 2) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Payment Received Details</h6>
            </div>

            <div class="card-body">
                <h6 class="mb-3" style="font-size:15px !important">
                    <i class="fa-solid fa-user me-2"></i>
                    Vendor Contact
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-1">
                        <strong>Vendor:</strong> {{ $vendor->shop_name ?? $vendor->name }}
                    </div>
                    <div class="col-md-6 mb-1">
                        <strong>Phone:</strong> {{ $vendor->phone ?? '-' }}
                    </div>
                    <div class="col-md-6 mb-0">
                        <strong>Email:</strong> {{ $vendor->email ?? '-' }}
                    </div>
                </div>

                <hr class="mb-3 mt-3">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Transfer Reference (optional)</label>
                        <input type="text" name="transfer_reference" class="form-control" placeholder="Bank ref / transaction ID">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Payment Proof <span class="text-danger">*</span></label>
                        <input type="file" name="payment_slip" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        <small class="text-muted">Upload the slip/receipt the vendor sent you directly.</small>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="e.g. Paid via cash on Aug 2, confirmed by phone call"></textarea>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-check-circle me-1"></i> Confirm Settlement & Reactivate Vendor
                    </button>
                </div>
            </div>
        </div>
    </form>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.commission-checkbox');
    const selectAll = document.getElementById('selectAll');
    const totalEl = document.getElementById('selectedTotal');

    function recalcTotal() {
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) total += parseFloat(cb.dataset.amount);
        });
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