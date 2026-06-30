@extends('AdminDashboard.index')

@section('title', 'Settle Vendor Earnings')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Settle Earnings — {{ $vendor->shop_name ?? $vendor->name }}</h6>
    <a href="{{ route('admin.vendor-earnings.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

@if($earnings->isEmpty())
    <div class="alert alert-info">This vendor has no pending earnings right now.</div>
@else
    <form action="{{ route('admin.vendor-earnings.settle', $vendor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card basic-data-table shadow-sm border-0 mb-3">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">
                    Pending Earnings
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
                                <th class="text-end">Earning Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earnings as $earning)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input earning-checkbox"
                                               name="earning_ids[]" value="{{ $earning->id }}"
                                               data-amount="{{ $earning->earning_amount }}" checked>
                                    </td>
                                    <td>{{ $earning->order->order_number ?? '—' }}</td>
                                    <td>{{ $earning->product->name ?? 'N/A' }}</td>
                                    <td>{{ $earning->created_at->format('M d, Y') }}</td>
                                    <td class="text-end">Rs. {{ number_format($earning->earning_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 p-3 bg-light rounded d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Selected Total:</span>
                    <span class="fw-bold fs-5 text-primary" id="selectedTotal">
                        Rs. {{ number_format($earnings->sum('earning_amount'), 2) }}
                    </span>
                </div>
            </div>
        </div>



        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background-color: #007bff1f;">
                <h6 class="mb-0" style="font-size:17px !important">Transfer Details</h6>
            </div>

                <div class="card-body">
                    <h6 class="mb-3" style="font-size:17px !important">
                            <i class="fa-solid fa-building-columns me-2"></i>
                            Vendor Bank Details
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <strong>Bank Name : {{ $vendor->bank_name }}</strong>
                            </div>

                            <div class="col-md-6 mb-1">
                                <strong>Branch Name : {{ $vendor->branch_name }}</strong>
                            </div>

                            <div class="col-md-6 mb-1">
                                <strong>Account Name : {{ $vendor->account_name }}</strong>
                            </div>

                            <div class="col-md-6 mb-0">
                                <strong>Account Number</strong>:
                                <span class="fw-bold">{{ $vendor->account_number }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Transfer Reference (optional)</label>
                            <input type="text" name="transfer_reference" class="form-control" placeholder="Bank ref / transaction ID">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Slip <span class="text-danger">*</span></label>
                            <input type="file" name="payment_slip" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes (optional)</label>
                            <textarea name="notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-check-circle me-1"></i> Confirm Settlement
                        </button>
                    </div>
                </div>
           
        </div>
    </form>
@endif

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.earning-checkbox');
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