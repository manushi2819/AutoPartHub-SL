@extends('AdminDashboard.master')

@section('title','Auction Winners')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Auction Winners</h6>
</div>

<div class="card basic-data-table">
<div class="card-body">

<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <select name="auction_id" class="form-control">
            <option value="">All Auctions</option>

            @foreach($allAuctions as $auction)
                <option value="{{ $auction->id }}"
                    {{ $auctionId == $auction->id ? 'selected' : '' }}>
                    Auction #{{ $auction->id }}
                     @if($auction->item_type === 'vehicle')
                        {{ $auction->vehicle->model ?? 'Vehicle' }}
                    @else
                        {{ $auction->product->name ?? 'Product' }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <select name="customer_id" class="form-control">
            <option value="">All Customers</option>

            @foreach($allCustomers as $customer)
                <option value="{{ $customer->id }}"
                    {{ $customerId == $customer->id ? 'selected' : '' }}>

                    {{ $customer->first_name }}
                    {{ $customer->last_name }}

                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary btn-sm w-100">
            Filter
        </button>
    </div>

</form>

<div class="table-responsive mt-3">
 <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>

<thead>
<tr>
    <th>ID</th>
    <th>Item Type</th>
    <th>Item</th>
    <th>Winner</th>
    <th>Winning Bid</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>

@foreach($winners as $winner)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>{{ ucfirst($auction->item_type) }}</td>

     <td> #{{ $winner->auction_id }}
        @if ($winner->auction->item_type === 'vehicle' && $winner->auction->item)

            {{ optional($winner->auction->item->brand)->name ?? '' }}
            {{ $winner->auction->item->model ?? '' }}
            ({{ $winner->auction->item->year ?? '' }})

        @elseif ($winner->auction->item_type === 'product' && $winner->auction->item)

            {{ optional($winner->auction->item->brand)->name ?? '' }}
            {{ \Illuminate\Support\Str::limit($winner->auction->item->name, 50) }}

        @else
            N/A
        @endif
    </td>

    <td>
        {{ $winner->winner->first_name ?? '' }}
        {{ $winner->winner->last_name ?? '' }}
    </td>

    <td>
        <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
            LKR {{ number_format($winner->winner_price) }}
        </span>
    </td>

    <td>
        @if($winner->status == 'approved')
            <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
                Approved
            </span>
        @elseif($winner->status == 'rejected')
            <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-danger-focus text-danger-main">
                Rejected
            </span>

        @else
            <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-warning-focus text-warning-main">
                Pending
            </span>
        @endif
    </td>

    <td>

        {{-- VIEW BIDS --}}
        <button class="btn btn-info btn-sm p-1" style="font-size: 12px;"
            data-bs-toggle="modal"
            data-bs-target="#bidModal{{ $winner->id }}">
            View Bids
        </button>

        @if($winner->status != 'approved')

            {{-- APPROVE --}}
            <form action="{{ route('admin.auction.winners.approve',$winner->id) }}"
                method="POST"
                class="d-inline">

                @csrf

                <button class="btn btn-success btn-sm p-1" style="font-size: 12px;"">
                    Approve
                </button>

            </form>

            {{-- REJECT BUTTON --}}
            <button class="btn btn-danger btn-sm p-1" style="font-size: 12px;""
                data-bs-toggle="modal"
                data-bs-target="#rejectModal{{ $winner->id }}">
                Reject
            </button>

        @endif

    </td>
</tr>

{{-- MODAL --}}
<div class="modal fade" id="bidModal{{ $winner->id }}">

<div class="modal-dialog ">
<div class="modal-content">

<div class="modal-header">
    <h6>All Bids</h6>
</div>

<div class="modal-body">

@foreach($winner->auction->bids
    ->where('customer_id', $winner->winner_id)
    ->sortByDesc('bid_amount') as $bid)

<div class="border rounded p-1 mb-1">

    <div class="d-flex justify-content-between">

        <div>
            <strong>
                {{ $bid->customer->first_name ?? '' }}
                {{ $bid->customer->last_name ?? '' }}
            </strong>

            <br>

            <small>
                {{ $bid->customer->email ?? '' }}
            </small>
        </div>

        <div class="text-end">

            <div class="fw-bold">
                LKR {{ number_format($bid->bid_amount) }}
            </div>

            @if($bid->is_winner)

                <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
                    WINNING BID
                </span>

            @endif

        </div>

    </div>

</div>

@endforeach

</div>

</div>
</div>
</div>




{{-- REJECT MODAL --}}
<div class="modal fade" id="rejectModal{{ $winner->id }}">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.auction.winners.reject', $winner->id) }}"
                  method="POST">

                @csrf

                <div class="modal-header">
                    <h6 class="modal-title">
                        Reject Winner
                    </h6>
                </div>

                <div class="modal-body">

                    <label class="form-label">
                        Rejection Reason
                    </label>

                    <textarea name="rejection_reason"
                              class="form-control"
                              rows="4"
                              required></textarea>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button class="btn btn-danger btn-sm">
                        Reject Winner
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

@endforeach



</tbody>
</table>

</div>
</div>
</div>


@endsection