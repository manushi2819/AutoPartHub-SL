<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Auction Ended</title>
</head>

<body style="margin:0; padding:0; background:#f5f6fa; font-family: Arial, sans-serif;">

<div style="max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">

    {{-- HEADER --}}
    <div style="background:#111827; padding:20px; color:#fff; text-align:center;">
        <h2 style="margin:0;">🏁 Auction Ended</h2>
    </div>

    {{-- BODY --}}
    <div style="padding:25px;">

        <p style="font-size:14px; color:#555;">
            The auction you participated in has ended. Below are the details:
        </p>

        <div style="background:#f9fafb; padding:15px; border-radius:8px; margin-bottom:15px;">
            <strong>Auction ID:</strong> #{{ $auction->id }}
        </div>

        {{-- ITEM DETAILS --}}
        <h3 style="margin-bottom:10px; color:#111827;">Item Details</h3>

        @php
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

        {{-- FOOTER MESSAGE --}}
        <div style="margin-top:20px; padding:15px; background:#fff7ed; border-left:4px solid #f59e0b; border-radius:6px;">
            <p style="margin:0; font-size:14px;">
                ⏳ The winner will be announced after admin approval.
            </p>
        </div>

        <p style="margin-top:20px; font-size:14px; color:#555;">
            Thank you for participating in our auction system.
        </p>

    </div>

    {{-- FOOTER --}}
    <div style="text-align:center; padding:15px; font-size:12px; color:#999; background:#f3f4f6;">
        © {{ date('Y') }} Auction System. All rights reserved.
    </div>

</div>

</body>
</html>