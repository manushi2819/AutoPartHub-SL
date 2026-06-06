@extends('CustomerDashboard.layout')

@section('account-content')

<div class="orders-container">

    <h4 class="mb-4">My Auction Participation</h4>

    @forelse($auctions as $auction)

      @php

        if($auction->item_type == 'vehicle') {

            $item = $auction->vehicle;

            $image = $item && $item->images->count()
                ? '/uploads/' . $item->images->first()->image_url
                : '/no-image.png';

            $title = $item
                ? ($item->brand->name . ' ' . $item->model)
                : 'Unknown Vehicle';

        } else {

            $item = $auction->product;

            $image = $item && $item->images->count()
                ? '/uploads/' . $item->images->first()->image_url
                : '/no-image.png';

            $title = $item
                ? \Illuminate\Support\Str::limit($item->name, 60)
                : 'Unknown Product';
        }

        $winner = optional($auction->highestBid)->customer;

        $myHighestBid = $auction->bids()
            ->where('customer_id', auth()->guard('customer')->id())
            ->max('bid_amount');

        @endphp

        <div class="card shadow-sm border-0 mb-4 rounded-4">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-2">
                        <img
                            src="{{ asset($image) }}"
                            class="img-fluid"
                            style="height:100px;width:100%;object-fit:cover;"
                        >
                    </div>

                    <div class="col-md-8">

                        <h5 class="fw-bold mb-2">
                            {{ $title }}
                        </h5>

                        <div class="mb-0">

                            <span class="badge bg-dark">
                                {{ ucfirst($auction->item_type) }}
                            </span>

                            <span class="badge bg-primary">
                                {{ ucfirst($auction->current_status) }}
                            </span>

                        </div>

                        <p class="mb-0">
                            <strong>My Highest Bid:</strong>
                            LKR {{ number_format($myHighestBid, 2) }}
                        </p>

                        <p class="mb-0">
                            <strong>Winning Bid:</strong>
                            LKR {{ number_format(optional($auction->highestBid)->bid_amount ?? 0, 2) }}
                        </p>

                        <p class="mb-0">
                            <strong>Winner:</strong>

                            @if($winner)
                                {{ $winner->first_name }} {{ $winner->last_name }}
                            @else
                                No winner yet
                            @endif
                        </p>

                    </div>

                    <div class="col-md-2 text-md-end">

                        @if($auction->highestBid && $auction->highestBid->customer_id == auth()->guard('customer')->id())

                            <div class="badge bg-success p-2 mb-3">
                                You Won
                            </div>

                        @elseif($auction->current_status == 'ended')

                        @else

                            <div class="badge bg-warning text-dark p-2 mb-3">
                                Auction Running
                            </div>

                        @endif

                        <br>

                        <a href="{{ route('customer.auction.bids.show', $auction->id) }}"
                           class="btn btn-dark rounded-pill px-2" style="font-size:13px">

                            View Auction
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @empty
        <div class="empty-state text-center py-5">
            <div style="font-size:60px;">🔨</div>
            <h5 class="mt-3">
                No Auction Participation Yet
            </h5>
            <p class="text-muted">
                You haven't participated in any auctions.
            </p>
        </div>

    @endforelse

    <div class="pagination-wrapper mt-4">
        <ul class="pagination">

            {{-- Previous --}}
            @if ($auctions->onFirstPage())
                <li class="disabled"><span>‹</span></li>
            @else
                <li>
                    <a href="{{ $auctions->previousPageUrl() }}">‹</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($auctions->getUrlRange(1, $auctions->lastPage()) as $page => $url)

                @if ($page == $auctions->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li>
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif

            @endforeach

            {{-- Next --}}
            @if ($auctions->hasMorePages())
                <li>
                    <a href="{{ $auctions->nextPageUrl() }}">›</a>
                </li>
            @else
                <li class="disabled"><span>›</span></li>
            @endif

        </ul>
    </div>
</div>

@endsection