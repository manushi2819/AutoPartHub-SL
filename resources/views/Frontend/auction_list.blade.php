@extends('Frontend.master')

@section('title', 'Auction List')

@section('content')
    <style>

        :root {
            --primary-red: #c20d0d;
            --primary-red-dark: #9b0a0a;
            --primary-red-light: #ffebeb;
            --primary-black: #0b0b0b;
            --dark-gray: #1e1e2f;
            --light-gray: #f8fafc;
            --card-border-radius: 0px;
            --shadow-sm: 0 8px 20px rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.02);
            --shadow-hover: 0 20px 35px rgba(0, 0, 0, 0.1), 0 5px 12px rgba(0, 0, 0, 0.05);
            --transition-smooth: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* ========== TABS STYLING ========== */
        .auction-tabs {
            background: white;
            border-radius: 60px;
            padding: 6px;
            display: inline-flex;
            margin-bottom: 0;
            box-shadow: var(--shadow-sm);
            border: 1px solid #eef2f6;
        }

        .tab-btn {
            padding: 12px 32px;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 50px;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.25s ease;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #5a687a;
        }

        .tab-btn i {
            font-size: 1.1rem;
        }

        .tab-btn.active {
            background: #e3e3e3;
            color: black;
            box-shadow: 0 4px 12px rgba(214, 214, 214, 0.3);
        }

        .tab-btn:not(.active):hover {
            background: #f0f2f5;
            color: var(--primary-black);
        }

        .tab-pane {
            display: none;
            animation: fadeIn 0.4s ease-out;
        }

        .tab-pane.active-pane {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Top bar wrapper - tabs and sidebar aligned on same row */
        .top-bar-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 35px;
        }

        /* main wrapper grid - now sidebar starts at same level as content */
        .auction-main-wrapper {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 32px;
            margin: 0 0 60px;
        }

        @media (max-width: 1100px) {
            .auction-main-wrapper {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .sidebar {
                position: static;
                margin-top: 0;
            }
            .top-bar-wrapper {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* ========== CARD GRID: 3 COLUMNS ========== */
        .auctions-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 28px;
        }

        @media (max-width: 992px) {
            .auctions-grid {
                grid-template-columns: repeat(1, 1fr);
                gap: 24px;
            }
        }

        @media (max-width: 640px) {
            .auctions-grid {
                grid-template-columns: 1fr;
            }
        }

            /* ---------- HORIZONTAL AUCTION CARD ---------- */
        .active-auction-card {
            background: #ffffff;
            border-radius: var(--card-border-radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: row;
            height: auto;
            min-height: 220px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            position: relative;
            animation: riseUp 0.5s ease-out backwards;
            border-color: rgba(194, 13, 13, 0.2);
        }

        .active-auction-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(194, 13, 13, 0.2);
        }

        @keyframes riseUp {
            0% {
                opacity: 0;
                transform: translateY(25px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* staggered delays */
        .auctions-grid .active-auction-card:nth-child(1) { animation-delay: 0.03s; }
        .auctions-grid .active-auction-card:nth-child(2) { animation-delay: 0.07s; }
        .auctions-grid .active-auction-card:nth-child(3) { animation-delay: 0.11s; }
        .auctions-grid .active-auction-card:nth-child(4) { animation-delay: 0.15s; }
        .auctions-grid .active-auction-card:nth-child(5) { animation-delay: 0.19s; }
        .auctions-grid .active-auction-card:nth-child(6) { animation-delay: 0.23s; }

        /* image container - fixed width on left */
        .auction-img {
            padding: 10px;
            width: 350px;
            min-width: 300px;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            background: linear-gradient(135deg, #eef2f6 0%, #e2e8f0 100%);
            position: relative;
        }

        .auction-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .active-auction-card:hover .auction-img img {
            transform: scale(1.05);
        }

        /* floating badges on image */
        .image-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            right: 12px;
            display: flex;
            justify-content: space-between;
            z-index: 2;
        }

        .item-type-tag {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            color: white;
            padding: 6px 14px;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            border: 1px solid rgba(255,255,255,0.15);
        }

        /* countdown badge on image */
        .countdown-badge {
            background: linear-gradient(135deg, #c20d0d 0%, #8b0000 100%);
            color: white;
            padding: 5px 10px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* content area - takes remaining space */
        .auction-content {
            padding: 16px 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .item-title {
            font-size: 1.5rem;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 8px;
            color: #0a0c10;
            letter-spacing: -0.3px;
        }

        /* modern bid info card - sleek */
        .bid-info {
            background: linear-gradient(115deg, #fafcff 0%, #f5f8fe 100%);
            border-radius: 18px;
            padding: 12px 16px;
            margin: 8px 0 12px;
            border: 1px solid #eef2fa;
            transition: all 0.2s;
        }

        .current-bid {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .current-bid-label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #71777f;
            letter-spacing: 0.5px;
        }

        .current-bid-amount {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--primary-red);
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .starting-bid {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #71777f;
            border-top: 1px solid #e6edf4;
            padding-top: 8px;
            margin-top: 4px;
        }

        /* place bid button */
        .btn-bid {
            background: var(--primary-black);
            color: white;
            padding: 10px 0;
            border-radius: 50px;
            font-weight: 700;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s ease;
            margin-top: auto;
            border: none;
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(194, 13, 13, 0.2);
        }

        .btn-bid:hover {
            background: var(--primary-red);
            transform: scale(0.98);
            color: white;
            box-shadow: 0 6px 14px rgba(194, 13, 13, 0.3);
        }

        /* Responsive: Stack vertically on mobile */
        @media (max-width: 768px) {
            .active-auction-card {
                flex-direction: column;
            }
            
            .auction-img {
                width: 100%;
                min-width: auto;
                aspect-ratio: 16 / 9;
            }
            
            .auction-content {
                padding: 16px;
            }
            
            .current-bid-amount {
                font-size: 1.3rem;
            }
        }

        /* For tablets - slightly smaller image */
        @media (min-width: 769px) and (max-width: 1024px) {
            .auction-img {
                width: 180px;
                min-width: 180px;
            }
            
            .item-title {
                font-size: 1rem;
            }
            
            .current-bid-amount {
                font-size: 1.1rem;
            }
        }
       
        /* sidebar styles - elegant widget */
        .sidebar {
            position: sticky;
            top: 30px;
            height: fit-content;
        }
        .sidebar-widget {
            background: #f0f0f0;
            border-radius: 0px;
            padding: 24px 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #edf2f7;
             animation: riseUp 0.5s ease-out backwards;
        }
        .widget-titlenew {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid var(--primary-red);
            padding-left: 16px;
            color: #0f172a;
        }

       .upcoming-card {
            display: flex;
            gap: 14px;
            padding: 10px 10px;
            border-bottom: 1px solid #eef2f8;
            transition: all 0.2s;
            background: white;
            margin-bottom: 12px;
            position: relative;
            border-radius: 15px;
        }
        .upcoming-card:hover {
            background: #fafcff;
            margin: 0 -6px;
            padding: 12px 6px;
            border-radius: 15px;
        }
        .upcoming-img {
            width: 75px;
            height: 75px;
            border-radius: 15px;
            overflow: hidden;
            background: #eef2f9;
            flex-shrink: 0;
        }
        .upcoming-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .upcoming-info {
            flex: 1;
        }
        .upcoming-info h6 {
            font-weight: 800;
            font-size: 0.9rem;
            margin-bottom: 4px;
             margin-right: 50px;
            padding-right: 80px !important; /* Space for the start time badge */
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .upcoming-start {
            font-size: 0.7rem;
            background: #f9f1f1;
            display: inline-block;
            padding: 3px 10px;
            border-radius: 30px;
            color: var(--primary-red);
            font-weight: 600;
            position: absolute;
            top: 12px;
            right: 12px;
        }
        .empty-state {
            text-align: center;
            background: white;
            border-radius: 0px;
            padding: 48px 20px;
            box-shadow: var(--shadow-sm);
            grid-column: 1/-1;
        }
        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
        }

        @media (max-width: 640px) {
            .current-bid-amount {
                font-size: 1.4rem;
            }
            .tab-btn {
                padding: 8px 20px;
                font-size: 0.85rem;
            }
            .item-title {
                font-size: 1.1rem;
            }
        }

        /* badge animations */
        @keyframes softPulse {
            0% { opacity: 0.9; }
            100% { opacity: 1; }
        }
        .status-badge {
            animation: softPulse 1.2s ease-in-out infinite;
        }
    </style>



    <div class="auto-container mb-5 mt-5">
        <!-- TOP BAR: Tabs + Sidebar info aligned (sidebar starts at same level) -->
        <div class="top-bar-wrapper">
            <div class="auction-tabs">
                <button class="tab-btn active" data-tab="vehicles">
                    <i class="fas fa-car"></i> Vehicle Auctions
                </button>
                <button class="tab-btn" data-tab="parts">
                    <i class="fas fa-microchip"></i> Parts Auctions
                </button>
            </div>
        </div>

        <div class="auction-main-wrapper">
            <!-- LEFT COLUMN: TAB CONTENT -->
            <div>
                <!-- VEHICLES TAB PANE -->
                <div id="vehicles-pane" class="tab-pane active-pane">
                
                    <div class="auctions-grid">
                        @forelse($activeVehicles as $auction)
                            @include('Frontend.partials.active_auction_card', ['auction' => $auction])
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-car-side"></i>
                                <h5>No Active Vehicle Auctions</h5>
                                <p>Check back soon for live vehicle auctions!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- PARTS TAB PANE -->
                <div id="parts-pane" class="tab-pane">
                   
                    <div class="auctions-grid">
                        @forelse($activeParts as $auction)
                            @include('Frontend.partials.active_auction_card', ['auction' => $auction])
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-microchip"></i>
                                <h5>No Active Parts Auctions</h5>
                                <p>Check back soon for live parts auctions!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDEBAR: Upcoming Auctions (now aligned with tabs from top) -->
            <div class="sidebar">

                 <div class="mb-5">
                        <img src="{{ asset('frontend/assets/images/auction1.png') }}" 
                        alt="Banner" style="width: 100%; height: auto; display: block;">
                    </div>
             

                <div class="sidebar-widget">
                    <h4 class="widget-titlenew"><i class="fas fa-calendar-week me-2"></i> Upcoming Auctions</h4>
                    @php
                        $allUpcoming = $upcomingVehicles->concat($upcomingParts)->sortBy('start_time');
                    @endphp
                    @forelse($allUpcoming as $auction)
                        @php
                            $item = $auction->item;
                            $imageUrl = null;
                            if ($auction->item_type === 'vehicle' && $item) {
                                $firstImage = $item->images->first();
                                $imageUrl = $firstImage ? asset('uploads/' . $firstImage->image_url) : asset('no-image.png');
                            } elseif ($auction->item_type === 'product' && $item) {
                                $mainImage = $item->images->where('is_main', 1)->first();
                                $imageUrl = $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png');
                            }
                            $itemName = $item->name ?? $item->model ?? 'Auction Item';
                            $itemBrand = $item->brand->name ?? '';
                        @endphp
                        <div class="upcoming-card">
                            <div class="upcoming-img">
                                <img src="{{ $imageUrl }}" alt="{{ $itemName }}">
                            </div>
                            <div class="upcoming-info">
                                <h6>{{ $itemName }} {{ $itemBrand }}</h6>
                                <p style="font-size: 0.7rem; color:#5b6e8c;">
                                    @if($auction->item_type == 'vehicle') 🚗 Vehicle @else 🔧 Part @endif
                                </p>
                               <div class="upcoming-start">
                                    <i class="far fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($auction->start_time)->format('M d, h:i A') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-2x mb-2" style="color: #cbd5e0;"></i>
                            <p class="mb-0">No upcoming auctions scheduled</p>
                            <small>Stay tuned</small>
                        </div>
                    @endforelse
                  
                </div>

            </div>
            
              
            
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const vehiclesPane = document.getElementById('vehicles-pane');
            const partsPane = document.getElementById('parts-pane');

            function activateTab(tabId) {
                if (vehiclesPane) vehiclesPane.classList.remove('active-pane');
                if (partsPane) partsPane.classList.remove('active-pane');
                
                const activePane = document.getElementById(tabId + '-pane');
                if (activePane) activePane.classList.add('active-pane');
                
                tabBtns.forEach(btn => {
                    const btnTab = btn.getAttribute('data-tab');
                    if (btnTab === tabId) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }

            tabBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const tabId = this.getAttribute('data-tab');
                    if (tabId === 'vehicles') {
                        activateTab('vehicles');
                    } else if (tabId === 'parts') {
                        activateTab('parts');
                    }
                });
            });
        });

        // Advanced countdown timer
        function updateCountdowns() {
            document.querySelectorAll('.countdown-timer[data-end-time]').forEach(element => {
                const endTimeAttr = element.getAttribute('data-end-time');
                if (!endTimeAttr) return;
                const endTime = new Date(endTimeAttr).getTime();
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    element.innerHTML = '<i class="fas fa-hourglass-end"></i> Auction Ended';
                    element.style.background = "#8b0000";
                    element.style.color = "white";
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                let timeString = '';
                if (days > 0) timeString += `${days}d `;
                timeString += `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                element.innerHTML = `<i class="fas fa-hourglass-half"></i> ${timeString}`;
            });
        }

        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    </script>
@endsection