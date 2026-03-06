<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order In Transit</title>
</head>
<body>
    <h3>Hello {{ $order->first_name }},</h3>
    <p>Your order <strong>#{{ $order->order_number }}</strong> has been handed over to the courier.</p>

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