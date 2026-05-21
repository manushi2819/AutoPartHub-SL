@extends('AdminDashboard.master')

@section('title','Auction Bids')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Auction Bids - {{ ucfirst($status) }}</h6>
</div>

<div class="d-flex gap-2 mb-3">

    <a href="?status=active"
       class="btn btn-sm {{ $status=='active' ? 'btn-success' : 'btn-outline-success' }}">
        Active
    </a>

    <a href="?status=ended"
       class="btn btn-sm {{ $status=='ended' ? 'btn-danger' : 'btn-outline-danger' }}">
        Ended
    </a>

</div>


{{-- Auction Selector --}}
<form method="GET" class="mb-3">

    <input type="hidden" name="status" value="{{ $status }}">

    <div class="d-flex gap-2 align-items-center">

        <select name="auction_id"
                class="form-select"
                onchange="this.form.submit()"
                style="max-width: 400px;">

            <option value="">
                -- All {{ ucfirst($status) }} Auctions --
            </option>

            @foreach($allAuctions as $a)

                <option value="{{ $a->id }}"
                    {{ (int)$auctionId === $a->id ? 'selected' : '' }}>

                    #{{ $a->id }} -

                    @if($a->item_type === 'vehicle')
                        {{ $a->vehicle->model ?? 'Vehicle' }}
                    @else
                        {{ $a->product->name ?? 'Product' }}
                    @endif

                </option>

            @endforeach

        </select>

    </div>

</form>

<div id="auction-container">

@foreach($auctions as $auction)

<div class="card basic-data-table auction-box mb-3 p-1" data-id="{{ $auction->id }}">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <div>

            <h6 class="mb-1 ">
                Auction #{{ $auction->id }}
            </h6>

            <small class="text-muted">

                @if($auction->item_type === 'vehicle')

                    Vehicle :
                    {{ $auction->vehicle->brand->name ?? '' }}
                    {{ $auction->vehicle->model ?? '' }}
                    ({{ $auction->vehicle->year ?? '' }})

                @else

                    Product :
                    {{ \Illuminate\Support\Str::limit($auction->product->name ?? '', 60) }}

                @endif

            </small>

        </div>

        <div class="text-end">

            {{-- TOTAL BIDS --}}
            <div class="mb-1">

                <span class="badge text-sm fw-semibold rounded-pill bg-primary-600 px-20 py-9 radius-4 text-white">
                    {{ $auction->bids->count() }} Bids
                </span>

            </div>

            {{-- PRICE --}}
            <div>

                @if($auction->highestBid)

                    <span class="fw-bold text-success me-3">
                        Highest:
                        LKR {{ number_format($auction->highestBid->bid_amount) }}
                    </span>
                @endif
                    <span class="fw-bold text-dark">
                        Starting:
                        LKR {{ number_format($auction->starting_price) }}
                    </span>

                

            </div>

        </div>

    </div>

    {{-- BODY --}}
    <div class="card-body">

        <div class="table-responsive">

            <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Bid Time</th>
                        <th>Bid Amount</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                @foreach($auction->bids()->with('customer')->latest()->get() as $bid)

                    <tr>

                        {{-- NUMBER --}}
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        {{-- CUSTOMER --}}
                        <td>

                            <div class="fw-semibold">

                                {{ $bid->customer->first_name ?? 'Guest' }}
                                {{ $bid->customer->last_name ?? '' }}

                            </div>

                        </td>

                        {{-- CONTACT --}}
                        <td>

                            <small class="d-block">
                                📞 {{ $bid->customer->phone ?? 'N/A' }} <br>
                                 ✉ {{ $bid->customer->email ?? 'N/A' }}
                            </small>

                        </td>

                        {{-- TIME --}}
                        <td>

                            <small class="d-block">
                                {{ \Carbon\Carbon::parse($bid->bid_time)->format('d M Y') }}
                                 {{ \Carbon\Carbon::parse($bid->bid_time)->format('h:i A') }}
                            </small>

                        </td>

                        {{-- BID AMOUNT --}}
                        <td>

                            <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">
                                LKR {{ number_format($bid->bid_amount) }}
                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td>

                            @if($loop->first)

                                <span class="badge text-sm fw-semibold rounded-pill bg-primary-600 px-20 py-9 radius-4 text-white">
                                    Highest
                                </span>

                            @endif

                            @if($bid->is_winner)

                                <span class="badge text-sm fw-semibold rounded-pill bg-warning px-20 py-9 radius-4 text-dark">
                                    Winner
                                </span>

                            @endif

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endforeach

</div>


<script>
let lastCounts = {};

function checkNewBids() {

    document.querySelectorAll('.auction-box').forEach(box => {

        let id = box.dataset.id;

        fetch(`/admin/auction/${id}/bid-count`)
            .then(res => res.json())
            .then(data => {

                if (!lastCounts[id]) {
                    lastCounts[id] = data.count;
                    return;
                }

                if (data.count > lastCounts[id]) {

                    // small notification
                    const toast = document.createElement('div');
                    toast.innerHTML = `
                        <div style="
                            position: fixed;
                            top: 20px;
                            right: 20px;
                            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
                            color: #2e7d32;
                            border-left: 4px solid #4caf50;
                            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.2);
                            padding: 12px 18px;
                            border-radius: 8px;
                            z-index: 9999;
                            font-weight: 600;
                            ">
                            🔔 New bid received!
                        </div>
                    `;
                    document.body.appendChild(toast);

                    setTimeout(() => location.reload(), 1500);
                }

                lastCounts[id] = data.count;
            });

    });
}

setInterval(checkNewBids, 7000);
</script>

@endsection