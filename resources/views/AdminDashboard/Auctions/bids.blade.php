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

    <select name="auction_id" class="form-control" onchange="this.form.submit()">
        <option value="">-- All {{ ucfirst($status) }} Auctions --</option>

        @foreach($allAuctions as $a)

            <option value="{{ $a->id }}"
                {{ $auctionId == $a->id ? 'selected' : '' }}>

                Auction #{{ $a->id }} -

                @if($a->item_type === 'vehicle')
                    {{ $a->vehicle->model ?? '' }}
                @else
                    {{ $a->product->name ?? '' }}
                @endif

            </option>

        @endforeach
    </select>
</form>


<div id="auction-container">



@foreach($auctions as $auction)

<div class="card mb-3 shadow-sm auction-box" data-id="{{ $auction->id }}">

    <div class="card-header d-flex justify-content-between">
        <strong>
            Auction #{{ $auction->id }}
        </strong>

      <span class="badge text-sm fw-semibold rounded-pill bg-primary-600 px-20 py-9 radius-4 text-white">
                {{ $auction->bids->count() }} Bids
            </span>
    </div>

    <div class="card-body">

        {{-- ITEM --}}
        <p class="mb-1">
            <strong>Item:</strong>
            @if($auction->item_type === 'vehicle')
                {{ $auction->vehicle->model ?? '' }}
                ({{ $auction->vehicle->year ?? '' }})
            @else
                {{ \Illuminate\Support\Str::limit($auction->product->name ?? '', 60) }}
            @endif
        </p>

    {{-- HIGHEST BID + TOTAL BIDS --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            @if($auction->highestBid)
                <strong>Highest Bid:</strong>
                <span class="text-danger fw-bold">
                    LKR {{ number_format($auction->highestBid->bid_amount) }}
                </span>
            @else
                <strong>Starting Price:</strong>
                <span class="fw-bold">
                    LKR {{ number_format($auction->starting_price) }}
                </span>
            @endif
        </div>
    </div>

        <hr>

  
      {{-- BID LIST --}}
        <div style="max-height: 420px; overflow-y:auto;">

            @forelse($auction->bids()->with('customer')->latest()->take(15)->get() as $bid)

                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">

                    {{-- LEFT SIDE --}}
                    <div>

                        {{-- LINE 1 --}}
                        <div class="fw-semibold text-dark" style="font-size: 14px;">
                            👤 {{ $bid->customer->first_name ?? 'Guest' }}
                            {{ $bid->customer->last_name ?? '' }}
                            <span class="text-muted" style="font-size: 12px;">
                                ({{ $bid->customer->phone ?? 'N/A' }})
                            </span>
                        </div>

                        {{-- LINE 2 --}}
                        <small class="text-muted" style="font-size: 12px;">
                            🕒 {{ \Carbon\Carbon::parse($bid->bid_time)->format('d M h:i A') }}
                            • {{ $bid->customer->email ?? 'N/A' }}
                        </small>

                    </div>

                    {{-- RIGHT SIDE --}}
                    <div class="text-end">

                        <span class="badge text-sm fw-semibold rounded-pill bg-success-600 px-18 py-9 radius-4 text-white">
                            LKR {{ number_format($bid->bid_amount) }}
                        </span>

                    </div>

                </div>

            @empty
                <div class="text-center py-3 text-muted">
                    <i class="fas fa-inbox"></i> No bids
                </div>
            @endforelse

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