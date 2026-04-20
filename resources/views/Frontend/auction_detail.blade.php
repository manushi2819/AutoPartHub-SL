@extends('Frontend.master')

@section('title', 'Auction Details')

@section('content')
<style>

    body {
    background: linear-gradient(135deg, #f0f0f0 0%, #e5e5e5 100%);
    }


    /* Smooth transitions */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        box-shadow: var(--box-shadow);
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--box-shadow-hover);
    }

    /* Card headers */
    .card-header {
        background: linear-gradient(135deg, var(--primary-black) 0%, #1a1a1a 100%);
        color: white;
        font-weight: 600;
        border: none;
        padding: 0.6rem 1.25rem;
        letter-spacing: -0.3px;
    }

    /* Main image hover effect */
    .main-image {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border: 1px solid #eaeaea;
    }

    .main-image:hover {
        transform: scale(1.02);
    }

    /* Thumbnail images */
    .thumbnail-img {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 2px solid transparent;
        opacity: 0.7;
    }

    .thumbnail-img:hover {
        transform: scale(1.05);
        opacity: 1;
        border-color: var(--primary-red);
        box-shadow: 0 4px 12px rgba(194, 13, 13, 0.2);
    }


    .timer-boxes {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .timer-box {
        flex: 1;
        min-width: 70px;
        background: linear-gradient(135deg, var(--primary-black) 0%, #1a1a1a 100%);
        border-radius: 12px;
        padding: 1rem 0.5rem;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .timer-box::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .timer-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(194, 13, 13, 0.3);
    }

    .timer-box:hover::before {
        left: 100%;
    }

    .timer-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: white;
        letter-spacing: 2px;
        line-height: 1;
        margin-bottom: 0.5rem;
        text-shadow: 0 0 10px rgba(194, 13, 13, 0.5);
    }

    .timer-label {
        font-size: 0.7rem;
        font-weight: 600;
        color: rgba(255,255,255,0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Animation for timer values when changing */
    @keyframes timerPop {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); color: var(--primary-red); }
        100% { transform: scale(1); }
    }

    .timer-value-updated {
        animation: timerPop 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .timer-box {
            min-width: 55px;
            padding: 0.75rem 0.25rem;
        }
        .timer-value {
            font-size: 1.2rem;
        }
        .timer-label {
            font-size: 0.6rem;
        }
        .timer-boxes {
            gap: 8px;
        }
    }



    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.9; }
    }

    /* Current price styling */
    .current-price {
        background: linear-gradient(135deg, var(--primary-red-light) 0%, #fff5f5 100%);
        border-radius: 12px;
        padding: 1rem;
        position: relative;
        overflow: hidden;
    }

    .current-price::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .current-price:hover::before {
        left: 100%;
    }

    .price-amount {
        font-size: 2.0rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        animation: slideIn 0.5s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Bid form styling */
    .bid-input {
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        transition: all 0.2s ease;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .bid-input:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 3px rgba(194, 13, 13, 0.1);
        outline: none;
    }

    .btn-bid {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
        border: none;
        border-radius: 10px;
        padding: 0.7rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-bid:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(194, 13, 13, 0.3);
    }

    .btn-bid:active {
        transform: translateY(0);
    }

    /* Bid history items */
    .bid-item {
        transition: all 0.2s ease;
        animation: fadeInUp 0.3s ease;
    }

    .bid-item:hover {
        background: var(--primary-gray);
        transform: translateX(5px);
        padding-left: 0.75rem !important;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Badge styling */
    .badge-custom {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
        color: white;
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .info-badge {
        background: #f3f4f6;
        color: var(--primary-black);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .info-badge:hover {
        background: #e5e7eb;
        transform: scale(1.02);
    }

    /* Item details styling */
   .detail-row {
        display: flex;
        align-items: center;
        gap: 10px; /* space between label & value */
        padding: 10px 20px;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s ease;
    }

    .detail-row:hover {
        background: var(--primary-gray);
    }

    .detail-label {
        font-weight: 700;
        color: var(--primary-black);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 120px; /* keeps alignment nice */
    }

    .detail-value {
        color: #4b5563;
        font-weight: 500;
    }



    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Bid increment pill */
    .increment-pill {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        display: inline-block;
        font-weight: 600;
        font-size: 0.85rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #countdown {
            font-size: 1.25rem;
        }
        
        .price-amount {
            font-size: 1.75rem;
        }
        
        .btn-bid {
            font-size: 1rem;
        }
    }

    /* Loading skeleton animation */
    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-red);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary-red-dark);
    }

    /* Badge for new bids */
    .new-badge {
        background: #159b17;
        color: white;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        margin-left: 0.5rem;
        animation: blink 1s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Winner crown icon */
    .winner-crown {
        color: #fbbf24;
        font-size: 0.7rem;
        margin-right: 0.25rem;
    }
</style>


    <!-- page-title -->
        <section class="page-title">
            <div class="auto-container">
                <div class="content-box">
                    <div class="border-line"></div>
                    <ul class="bread-crumb">
                        <li><a href="{{ route('Frontend.index') }}">Home</a></li>
                        <li>Auction</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page-title end -->


<div class="auto-container py-4">
    <div class="row">

        {{-- LEFT SIDE --}}
        <div class="col-lg-8">

            {{-- MAIN IMAGE --}}
            <div class="card mb-4">
                <div class="card-body text-center p-4">

                    @php
                        if ($auction->item_type === 'vehicle') {
                            $item = $auction->vehicle;
                        } else {
                            $item = $auction->product;
                        }

                        $images = $item->images ?? collect();
                        $mainImage = $images->first();
                    @endphp

                    {{-- MAIN IMAGE --}}
                    <img 
                        src="{{ $mainImage 
                                ? asset('uploads/' . $mainImage->image_url) 
                                : asset('uploads/default.jpg') 
                            }}" 
                        class="img-fluid rounded main-image mb-0" 
                        style="max-height:420px; width:100%; object-fit:contain;"
                    >

                    <div class="d-flex mt-1 gap-2 justify-content-center flex-wrap">
                        @foreach($images as $img)
                            <img src="{{ asset('uploads/' . $img->image_url) }}" 
                                width="110" 
                                height="110"
                                class="rounded thumbnail-img"
                                style="object-fit:cover;">
                        @endforeach
                    </div>

                </div>
            </div>

            {{-- ITEM DETAILS --}}
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-info-circle me-2"></i>Item Details
                    <span class="badge-custom ms-2">{{ strtoupper($auction->item_type) }}</span>
                </div>
                <div class="card-body p-0">

                    @if($auction->item_type == 'vehicle')

                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="detail-row">
                                    <div class="detail-label">Brand</div>
                                    <div class="detail-value">{{ $item->brand->name ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Model</div>
                                    <div class="detail-value">{{ $item->model }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Year</div>
                                    <div class="detail-value">{{ $item->year }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Condition</div>
                                    <div class="detail-value">
                                        {{ ucfirst($item->condition) }}
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Fuel Type</div>
                                    <div class="detail-value">{{ $item->fuel_type }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Transmission</div>
                                    <div class="detail-value">{{ $item->transmission }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-row">
                                    <div class="detail-label">Engine CC</div>
                                    <div class="detail-value">{{ $item->engine_cc }} CC</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Mileage</div>
                                    <div class="detail-value">{{ number_format($item->mileage) }} km</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Body Type</div>
                                    <div class="detail-value">{{ $item->body_type }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Color</div>
                                    <div class="detail-value">{{ $item->color }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Location</div>
                                    <div class="detail-value">{{ $item->city }}, {{ $item->district }}</div>
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="row g-0">
                            <div class="col-md-6">
                                <div class="detail-row">
                                    <div class="detail-label">Name</div>
                                    <div class="detail-value">{{ $item->name }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Brand</div>
                                    <div class="detail-value">{{ $item->brand ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">SKU</div>
                                    <div class="detail-value">{{ $item->sku }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Category</div>
                                    <div class="detail-value">{{ $item->category->name ?? '' }}</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                @if($item->compatibility)
                                    <div class="detail-row">
                                        <div class="detail-label">Compatible Brand</div>
                                        <div class="detail-value">{{ $item->compatibility->brand }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Model</div>
                                        <div class="detail-value">{{ $item->compatibility->model }}</div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-label">Year Range</div>
                                        <div class="detail-value">{{ $item->compatibility->year_from }} - {{ $item->compatibility->year_to }}</div>
                                    </div>
                                @else
                                    <div class="detail-row">
                                        <div class="detail-value text-muted">No compatibility info available</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    @endif

                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="fas fa-file-alt me-2"></i>Description
                </div>
                <div class="card-body">
                    <div class="description-content" style="line-height: 1.6;">
                        {!! $item->description ?? '<span class="text-muted">No description available</span>' !!}
                    </div>
                </div>
            </div>

        </div>


        {{-- RIGHT SIDE --}}
        <div class="col-lg-4">

            {{-- BID BOX --}}
            <div class="card mb-4">
                <div class="card-body p-4">


                    {{-- TIMER --}}
                    <div class="mb-4">
                        <div class="text-muted mb-3" style="font-size: 0.85rem; font-weight: 600; text-align: center;">
                            <i class="fas fa-hourglass-half me-1"></i>AUCTION ENDS IN
                        </div>
                        <div class="timer-boxes" id="countdown">
                            <div class="timer-box">
                                <div class="timer-value" id="timer-days">00</div>
                                <div class="timer-label">Days</div>
                            </div>
                            <div class="timer-box">
                                <div class="timer-value" id="timer-hours">00</div>
                                <div class="timer-label">Hrs</div>
                            </div>
                            <div class="timer-box">
                                <div class="timer-value" id="timer-minutes">00</div>
                                <div class="timer-label">Mins</div>
                            </div>
                            <div class="timer-box">
                                <div class="timer-value" id="timer-seconds">00</div>
                                <div class="timer-label">Secs</div>
                            </div>
                        </div>
                    </div>

                    {{-- CURRENT PRICE --}}
                    <div class="current-price mb-4">
                        <div class="text-center">
                            <div class="text-muted mb-2" style="font-size: 0.85rem; font-weight: 600;">
                                <i class="fas fa-gavel me-1"></i>CURRENT HIGHEST BID
                            </div>

                            @php
                                $highestBid = $auction->highestBid;
                            @endphp

                            <div class="price-amount mb-2">
                                LKR {{ number_format($highestBid->bid_amount ?? $auction->starting_price) }}
                            </div>

                            {{-- CUSTOMER NAME (ONLY IF BID EXISTS) --}}
                            @if($highestBid)
                                <div class="text-muted" style="font-size: 0.85rem;">
                                    <i class="fas fa-user-circle"></i>
                                    Bidder #{{ $highestBid->customer_id }}
                                    @if($loop->first ?? false)
                                        <span class="new-badge">Leading</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- STARTING PRICE & BID INCREMENT --}}
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <div class="info-badge text-center">
                                <small class="text-muted d-block">Starting Price</small>
                                <strong class="text-dark">LKR {{ number_format($auction->starting_price) }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-badge text-center">
                                <small class="text-muted d-block">Bid Increment</small>
                                <strong class="text-dark">LKR {{ number_format($auction->bid_increment) }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- BID FORM --}}
                    <form action="{{ route('auction.bid') }}" method="POST">
                        @csrf
                        <input type="hidden" name="auction_id" value="{{ $auction->id }}">

                        @php
                            $nextBid = ($highestBid->bid_amount ?? $auction->starting_price) + $auction->bid_increment;
                        @endphp

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">
                                <i class="fas fa-hand-holding-usd me-1"></i>Your Bid Amount (LKR)
                            </label>
                            <input type="number" name="bid_amount" class="form-control bid-input"
                                value="{{ $nextBid }}"
                                min="{{ $nextBid }}"
                                required>
                            <small class="text-muted mt-1 d-block">
                                Minimum bid: LKR {{ number_format($nextBid) }}
                            </small>
                        </div>

                        @if(Auth::guard('customer')->check())
                            <button class="btn btn-bid w-100 text-white">
                                <i class="fas fa-gavel me-2"></i>Place Bid
                            </button>
                        @else
                            <button type="button" class="btn btn-bid w-100 text-white" onclick="showLoginWarning()">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Place Bid
                            </button>

                            {{-- WARNING MESSAGE --}}
                            <div id="loginWarning" class="flash-message alert-warning mt-3 d-none">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Please login first to place a bid.
                            </div>
                        @endif
                    </form>

                </div>
            </div>

            {{-- BID HISTORY --}}
            <div class="card">
                <div class="card-header fw-bold">
                    <i class="fas fa-history me-2"></i>Bid History
                    <span class="badge-custom ms-2">{{ $auction->bids()->count() }} bids</span>
                </div>
                <div class="card-body p-0" >
                    @php $bidCount = 0; @endphp
                    @foreach($auction->bids()->latest()->take(8)->get() as $bid)
                        @php $bidCount++; @endphp
                        <div class="bid-item d-flex justify-content-between align-items-center" style="padding: 10px 20px;">
                            <div>
                                <div class="fw-bold">
                                    <i class="fas fa-user-circle text-secondary me-1"></i>
                                    Bidder #{{ $bid->customer_id }}
                                    @if($loop->first)
                                        <span class="new-badge">
                                            <i class="fas fa-crown winner-crown"></i>Highest
                                        </span>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($bid->bid_time)->diffForHumans() }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-danger">
                                    LKR {{ number_format($bid->bid_amount) }}
                                </span>
                                @if($bidCount == 1 && $auction->bids()->count() > 0)
                                    <div><small class="text-success">Leading bid</small></div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if($auction->bids()->count() == 0)
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            No bids yet. Be the first to bid!
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    let endTime = new Date("{{ $auction->end_time }}").getTime();
    let previousValues = { days: null, hours: null, minutes: null, seconds: null };

    function updateTimerDisplay(days, hours, minutes, seconds) {
        // Add animation class when values change
        if (previousValues.days !== days) {
            document.getElementById('timer-days').classList.add('timer-value-updated');
            setTimeout(() => document.getElementById('timer-days').classList.remove('timer-value-updated'), 300);
        }
        if (previousValues.hours !== hours) {
            document.getElementById('timer-hours').classList.add('timer-value-updated');
            setTimeout(() => document.getElementById('timer-hours').classList.remove('timer-value-updated'), 300);
        }
        if (previousValues.minutes !== minutes) {
            document.getElementById('timer-minutes').classList.add('timer-value-updated');
            setTimeout(() => document.getElementById('timer-minutes').classList.remove('timer-value-updated'), 300);
        }
        if (previousValues.seconds !== seconds) {
            document.getElementById('timer-seconds').classList.add('timer-value-updated');
            setTimeout(() => document.getElementById('timer-seconds').classList.remove('timer-value-updated'), 300);
        }

        document.getElementById('timer-days').innerHTML = String(days).padStart(2, '0');
        document.getElementById('timer-hours').innerHTML = String(hours).padStart(2, '0');
        document.getElementById('timer-minutes').innerHTML = String(minutes).padStart(2, '0');
        document.getElementById('timer-seconds').innerHTML = String(seconds).padStart(2, '0');

        previousValues = { days, hours, minutes, seconds };
    }

    let x = setInterval(function () {
        let now = new Date().getTime();
        let distance = endTime - now;

        if (distance < 0) {
            clearInterval(x);
            document.querySelector('.timer-boxes').innerHTML = `
                <div style="width:100%; text-align:center; padding:1rem;">
                    <div style="font-size:1.5rem; font-weight:700; color:var(--primary-red);">🎉 AUCTION ENDED 🎉</div>
                </div>
            `;
            return;
        }

        let days = Math.floor(distance / (1000 * 60 * 60 * 24));
        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        updateTimerDisplay(days, hours, minutes, seconds);
    }, 1000);
</script>

<script>
    function showLoginWarning() {
        let warning = document.getElementById('loginWarning');
        warning.classList.remove('d-none');

        // auto hide after 3 seconds (optional)
        setTimeout(() => {
            warning.classList.add('d-none');
        }, 3000);
    }

    // Thumbnail click to change main image
    document.querySelectorAll('.thumbnail-img').forEach(thumb => {
        thumb.addEventListener('click', function() {
            const mainImg = document.querySelector('.main-image');
            if (mainImg) {
                const tempSrc = mainImg.src;
                mainImg.src = this.src;
                this.src = tempSrc;
            }
        });
    });
</script>
@endsection