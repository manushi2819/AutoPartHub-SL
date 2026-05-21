<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Auction Winner</title>
</head>

<body style="margin:0; padding:0; background:#f5f6fa; font-family: Arial, sans-serif;">

<div style="max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

    {{-- HEADER --}}
    <div style="background:#16a34a; padding:20px; color:#fff; text-align:center;">
        <h2 style="margin:0;">🎉 Congratulations! You Won</h2>
    </div>

    {{-- BODY --}}
    <div style="padding:25px;">

        <p style="font-size:14px; color:#555;">
            Your bid has been <strong>approved by the admin</strong>. You are the winner of this auction.
        </p>

        {{-- AUCTION ID --}}
        <div style="background:#f9fafb; padding:12px; border-radius:8px; margin-bottom:15px;">
            <strong>Auction ID:</strong> #{{ $winner->auction_id }}
        </div>

        {{-- ITEM DETAILS --}}
        <h3 style="margin-bottom:10px; color:#111827;">Item Details</h3>

        @php
            $auction = $winner->auction;
            $item = $auction->item;
        @endphp

        <div style="background:#f9fafb; padding:15px; border-radius:8px;">

            @if($auction->item_type === 'vehicle' && $item)

                <p><strong>🚗 Type:</strong> Vehicle</p>
                <p><strong>Model:</strong> {{ $item->model ?? '-' }}</p>
                <p><strong>Brand:</strong> {{ $item->brand->name ?? '-' }}</p>
                <p><strong>Year:</strong> {{ $item->year ?? '-' }}</p>

            @elseif($auction->item_type === 'product' && $item)

                <p><strong>🧩 Type:</strong> Spare Part</p>
                <p><strong>Name:</strong> {{ $item->name ?? '-' }}</p>
                <p><strong>Brand:</strong> {{ $item->brand->name ?? '-' }}</p>
                <p><strong>SKU:</strong> {{ $item->sku ?? '-' }}</p>

            @endif

        </div>

        {{-- WINNING PRICE --}}
        <div style="margin-top:15px; background:#ecfdf5; padding:12px; border-radius:8px; border-left:4px solid #16a34a;">
            <strong>Winning Price:</strong>
            <span style="color:#16a34a; font-weight:bold;">
                LKR {{ number_format($winner->winner_price) }}
            </span>
        </div>

        {{-- NEXT STEP --}}
        <div style="margin-top:20px; padding:15px; background:#eff6ff; border-left:4px solid #3b82f6; border-radius:6px;">
            <p style="margin:0; font-size:14px;">
                📦 Our team will contact you soon for payment and delivery processing.
            </p>
        </div>

        <p style="margin-top:20px; font-size:14px; color:#555;">
            Thank you for participating in our auction system.
        </p>

    </div>

    {{-- FOOTER --}}
    <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f3f4f6;">
        © {{ date('Y') }} AutoPartHub SL. All rights reserved.
    </div>

</div>

</body>
</html>