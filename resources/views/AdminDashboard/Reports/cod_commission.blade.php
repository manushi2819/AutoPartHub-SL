@extends('AdminDashboard.index')

@section('title', 'COD Commission Report')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>COD Commission Report</h6>

    <a href="{{ route('admin.reports.cod-commission.pdf', request()->query()) }}"
       class="btn btn-danger btn-sm">
        <i class="fa-solid fa-file-pdf me-1"></i> Download PDF
    </a>
</div>

<!-- FILTER -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">

        <form method="GET" class="row g-3 align-items-end">

            <div class="col-md-3">
                <label>From</label>
                <input type="date" name="start_date" class="form-control"
                       value="{{ $period_start?->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label>To</label>
                <input type="date" name="end_date" class="form-control"
                       value="{{ $period_end?->format('Y-m-d') }}">
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <option value="pending" {{ $status=='pending'?'selected':'' }}>Pending</option>
                    <option value="paid" {{ $status=='paid'?'selected':'' }}>Paid</option>
                </select>
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary btn-sm">Filter</button>
                <a href="{{ route('admin.reports.cod-commission') }}"
                   class="btn btn-secondary btn-sm">Reset</a>
            </div>

        </form>

    </div>
</div>

<!-- TABLE -->
<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Vendor contact</th>
                        <th>Status</th>
                        <th class="text-end">Items</th>
                        <th class="text-end">Total Commission</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $row)
                        <tr>
                            <td>
                                {{ $row->vendor->shop_name ?? '-'}}
                            </td>
                            <td>
                                {{ $row->vendor->email ?? '-' }} - {{ $row->vendor->phone ?? '-' }}
                            </td>
                            <td>
                                @if($row->status == 'paid')
                                    Paid
                                @else
                                   Pending
                                @endif
                            </td>

                            <td class="text-end">{{ $row->item_count }}</td>
                            <td class="text-end fw-bold">
                                Rs. {{ number_format($row->total,2) }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
</div>

@endsection