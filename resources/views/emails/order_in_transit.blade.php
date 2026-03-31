<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order In Transit</title>
</head>
<body>
    <h3>Hello {{ $order->first_name }},</h3>
    <p>Your order <strong>#{{ $order->order_number }}</strong> has been handed over to the courier.</p>

    @if($order->tracking_no)
        <p>
            <strong>Tracking Number:</strong> {{ $order->tracking_no }} <br>

            You can track your order here: <br>
            <a href="https://koombiyodelivery.lk/Track/track_id" target="_blank">
                Track Your Order
            </a>
        </p>
    @endif

    <p>
        @if($order->payment_method === 'cod')
            Please prepare Rs. {{ number_format($order->total, 2) }} for Cash on Delivery. The courier will contact you to collect the payment.
        @else
            Your payment has already been received. The courier will contact you regarding delivery.
        @endif
    </p>

    <p>Thank you for shopping with us!</p>
</body>
</html>