{{-- frontend/partials/active_auction_card.blade.php --}}
@php
    $currentStatus = $auction->getCurrentStatusAttribute();
    $item = $auction->item;
    $highestBid = $auction->highestBid;
    $currentBid = $highestBid ? $highestBid->bid_amount : $auction->starting_price;
    $imageUrl = null;
    $itemName = '';
    $itemBrand = '';

  if ($auction->item_type === 'vehicle' && $item) {

    $mainImage = optional($item->images)->where('is_main', 1)->first();

    $imageUrl = ($mainImage && $mainImage->image_url)
        ? asset('uploads/' . $mainImage->image_url)
        : asset('no-image.png');

    $itemName = $item->model ?? 'Vehicle';

    $itemBrand = ($item->brand->name ?? 'Generic') . ' ' .
                 ($item->year ?? '');

} elseif ($auction->item_type === 'product' && $item) {

    $mainImage = optional($item->images)->where('is_main', 1)->first();

    $imageUrl = ($mainImage && $mainImage->image_url)
        ? asset('uploads/' . $mainImage->image_url)
        : asset('no-image.png');

    $itemName = $item->name ?? 'Product';

    $itemBrand = ($item->brand ?? 'Genuine Part') ;
}
@endphp

<div class="active-auction-card">
    <div class="auction-img">
        <img src="{{ $imageUrl }}" alt="{{ $itemName }}">
        <div class="image-badges">

             <span class="">

            </span>
           <span class="item-type-tag countdown-badge countdown-timer"
                data-end-time="{{ $auction->end_time->toIso8601String() }}">
                ⏳ Loading...
            </span>
            
        </div>
    </div>
    <div class="auction-content">
        <h3 class="item-title">{{ $itemName }} - {{ $itemBrand }}</h3>

        <div class="bid-info">
            <div class="current-bid">
                <span class="current-bid-label">Current Bid</span>
                <span class="current-bid-amount">LKR {{ number_format($currentBid, 2) }}</span>
            </div>
            <div class="starting-bid">
                <span>Starting: LKR {{ number_format($auction->starting_price, 2) }}</span>
                <span>Increment: LKR {{ number_format($auction->bid_increment, 2) }}</span>
            </div>
        </div>
        <a href="{{ route('Frontend.auction.details', $auction->id) }}" class="btn-bid">
            Place Bid <i class="fas fa-gavel"></i>
        </a>
    </div>
</div>