<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order In Transit</title>
</head>
<body>
    <h3>Hello {{ $order->first_name }},</h3>
    <p>The following item(s) from your order <strong>#{{ $order->order_number }}</strong> have been handed over to the courier.</p>

    <table cellpadding="6" cellspacing="0" border="1" style="border-collapse: collapse; width: 70%; margin: 16px 0;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th align="left">Product</th>
                <th align="center">Qty</th>
                <th align="right">Price</th>
                <th align="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td align="center">{{ $item->quantity }}</td>
                    <td align="right">Rs. {{ number_format($item->price, 2) }}</td>
                    <td align="right">Rs. {{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $trackingNo = $items->first(fn ($i) => $i->tracking_no)?->tracking_no;
    @endphp

    @if($trackingNo)
        <p>
            <strong>Tracking Number:</strong> {{ $trackingNo }} <br>

            You can track your order here: <br>
            <a href="https://koombiyodelivery.lk/Track/track_id" target="_blank">
                Track Your Order
            </a>
        </p>
    @endif

    <p>
        @if($order->payment_method === 'cod')
            Please prepare Rs. {{ number_format($items->sum('subtotal'), 2) }} for Cash on Delivery for the item(s) above. The courier will contact you to collect the payment.
        @else
            Your payment has already been received. The courier will contact you regarding delivery.
        @endif
    </p>

    <p>Thank you for shopping with us!</p>
</body>
</html>