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
<div class="auction-card ended-card">

    <div class="auction-img">
        <img src="{{ $imageUrl }}" alt="{{ $itemName }}">

        <span class="badge ended-badge">
            ENDED
        </span>
    </div>

    <div class="auction-body">

        <h3 class="auction-title">
            {{ $itemName }}
        </h3>

        <p class="auction-subtitle">
            {{ $itemBrand }}
        </p>

        <div class="ended-info-grid">
            <div class="ended-info-item final-price">
                <span class="info-label">Final Price</span>
                <strong class="info-value">
                    LKR {{ number_format($auction->highestBid?->bid_amount ?? $auction->starting_price, 2) }}
                </strong>
            </div>
            
            <div class="ended-info-item starting-price">
                <span class="info-label">Starting Price</span>
                <span class="info-value">
                    LKR {{ number_format($auction->starting_price, 2) }}
                </span>
            </div>
            
            <div class="ended-info-item ended-date">
                <span class="info-label">Ended On</span>
                <span class="info-value">
                    {{ $auction->end_time->format('d M Y') }}
                    <span class="time-sm">{{ $auction->end_time->format('h:i A') }}</span>
                </span>
            </div>
        </div>

    </div>
</div>