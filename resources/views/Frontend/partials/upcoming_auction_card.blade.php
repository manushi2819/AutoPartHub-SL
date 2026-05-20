@php
    $currentStatus = $auction->getCurrentStatusAttribute();
    $item = $auction->item;
    $highestBid = $auction->highestBid;
    $currentBid = $highestBid ? $highestBid->bid_amount : $auction->starting_price;

    $imageUrl = null;
    $itemName = '';
    $itemBrand = '';

    use Illuminate\Support\Str;

    if ($auction->item_type === 'vehicle' && $item) {

        $mainImage = optional($item->images)->where('is_main', 1)->first();

        $imageUrl = ($mainImage && $mainImage->image_url)
            ? asset('uploads/' . $mainImage->image_url)
            : asset('no-image.png');

        $itemName = $item->model ?? 'Vehicle';

        $itemBrand = ($item->brand->name ?? 'Generic') . ' ' . ($item->year ?? '');

    } elseif ($auction->item_type === 'product' && $item) {

        $mainImage = optional($item->images)->where('is_main', 1)->first();

        $imageUrl = ($mainImage && $mainImage->image_url)
            ? asset('uploads/' . $mainImage->image_url)
            : asset('no-image.png');

        // ✅ FIX: shorten long product name
        $itemName = Str::limit($item->name ?? 'Product', 40);

        // ✅ FIX: correct brand name (avoid JSON object)
        $itemBrand = $item->brand->name ?? 'Genuine Part';
    }
@endphp
<div class="auction-card upcoming-card">

    <div class="auction-img">
        <img src="{{ $imageUrl }}" alt="{{ $itemName }}">

        <span class="badge upcoming-badge">
            UPCOMING
        </span>
    </div>

    <div class="auction-body">

        <h3 class="auction-title">
            {{ $itemName }}
        </h3>

        <p class="auction-subtitle">
            {{ $itemBrand }}
        </p>
       <div class="bid-info-wrap">
            <div class="bid-info-upcoming">
                <div class="bid-meta">
                    <div class="meta-item">
                        <i class="fas fa-flag-checkered"></i>
                        <span>Starting:</span>
                        <strong>LKR {{ number_format($auction->starting_price, 2) }}</strong>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="meta-item">
                        <i class="fas fa-chart-line"></i>
                        <span>Increment:</span>
                        <strong>LKR {{ number_format($auction->bid_increment, 2) }}</strong>
                    </div>
                </div>
            </div>

            <div class="auction-time-upcoming">
                <div class="time-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="time-details">
                   
                    <strong class="time-value">
                        {{ $auction->start_time->format('d M Y') }}
                        <span class="time-separator">•</span>
                        {{ $auction->start_time->format('h:i A') }}
                    </strong>
                </div>
            </div>
        </div>

    </div>
</div>