@extends('AdminDashboard.index')

@section('title', 'Settle Card Commissions')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Settle Card Commissions — {{ $vendor->shop_name ?? $vendor->name }}</h6>
    <a href="{{ route('admin.vendor-commissions-card.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="iconify" data-icon="mdi:arrow-left"></i> Back
    </a>
</div>

@if($commissions->isEmpty())
    <div class="alert alert-info">No pending card commissions for this vendor.</div>
@else
    <form action="{{ route('admin.vendor-commissions-card.settle', $vendor->id) }}" method="POST">
        @csrf

        <div class="card shadow-sm border-0 mb-3">
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
                    <table class="table table-hover mb-0 align-middle">
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
                    <span class="fw-semibold">Selected Total:</span>
                    <span class="fw-bold fs-5 text-primary" id="selectedTotal">
                        Rs. {{ number_format($commissions->sum('commission_amount'), 2) }}
                    </span>
                </div>

                <div class="mt-3">
                    <label class="form-label fw-semibold">Notes (optional)</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-check-circle me-1"></i> Mark as Settled
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