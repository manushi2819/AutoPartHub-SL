@extends('CustomerDashboard.layout')

@section('account-content')

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

<div class="orders-container">

    <div class="card border-0 shadow-sm rounded-4 mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <img src="{{ asset($image) }}"
                         class="img-fluid rounded-4">
                </div>

                <div class="col-md-8">

                    <h3 class="fw-bold">
                        {{ $title }}
                    </h3>

                    <div class="my-1">

                        <span class="badge bg-primary">
                            {{ ucfirst($auction->current_status) }}
                        </span>

                        <span class="badge bg-dark">
                            {{ ucfirst($auction->item_type) }}
                        </span>

                    </div>

                    <p>
                        <strong>Starting Price:</strong>
                        LKR {{ number_format($auction->starting_price, 2) }}
                    </p>

                    <p>
                        <strong>Your Highest Bid:</strong>
                        LKR {{ number_format($customerHighestBid, 2) }}
                    </p>

                    <p>
                        <strong>Winning Bid:</strong>
                        LKR {{ number_format(optional($auction->highestBid)->bid_amount ?? 0, 2) }}
                    </p>

                    <p>
                        <strong>Winner:</strong>

                        @if($auction->highestBid)
                            {{ optional($auction->highestBid->customer)->first_name }}
                             {{ optional($auction->highestBid->customer)->last_name }}
                        @else
                            No winner yet
                        @endif
                    </p>

                </div>

            </div>

        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 pt-4">
            <h5 class="mb-0">Bid History</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Bidder</th>
                            <th>Bid Amount</th>
                            <th>Bid Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($bids as $bid)

                            <tr
                                @if($bid->customer_id == auth()->guard('customer')->id())
                                    style="background:#fff8e1;"
                                @endif
                            >

                                <td>
                                    {{ $bid->customer->first_name }} {{ $bid->customer->last_name }}

                                    @if($bid->customer_id == auth()->guard('customer')->id())
                                        <span class="badge bg-dark">
                                            You
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <strong>
                                        LKR {{ number_format($bid->bid_amount, 2) }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $bid->created_at->format('d M Y h:i A') }}
                                </td>

                                <td>

                                    @if(optional($auction->highestBid)->id == $bid->id)

                                        <span class="badge bg-success">
                                            Highest Bid
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Outbid
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

             <div class="pagination-wrapper mt-3">
                <ul class="pagination">

                    {{-- Previous --}}
                    @if ($bids->onFirstPage())
                        <li class="disabled"><span>‹</span></li>
                    @else
                        <li>
                            <a href="{{ $bids->previousPageUrl() }}">‹</a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($bids->getUrlRange(1, $bids->lastPage()) as $page => $url)

                        @if ($page == $bids->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif

                    @endforeach

                    {{-- Next --}}
                    @if ($bids->hasMorePages())
                        <li>
                            <a href="{{ $bids->nextPageUrl() }}">›</a>
                        </li>
                    @else
                        <li class="disabled"><span>›</span></li>
                    @endif

                </ul>
            </div>

        </div>

    </div>

</div>

@endsection