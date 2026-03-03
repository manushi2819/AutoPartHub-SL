@extends('Frontend.master')

@section('title','Order Successful')

@section('content')
<style>
    .order-success-section {
        padding: 60px 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .success-container {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-header {
        background: linear-gradient(135deg, #66ea6f 0%, #4ea24b 100%);
        color: white !important;
        padding: 20px 30px;
        text-align: center;
    }

    .success-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 30px;
        border: 3px solid white;
    }

    .success-header h1 {
        font-size: 32px;
        margin-bottom: 10px;
        font-weight: 700;
        color: white !important;
    }

    .order-number {
        font-size: 18px;
        opacity: 0.9;
        background: rgba(255,255,255,0.1);
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        margin-top: 15px;
    }

    .payment-note {
        background: #f8f9fa;
        padding: 20px;
        margin: 20px;
        border-radius: 10px;
        border-left: 4px solid #28a745;
        font-size: 16px;
        color: #555;
    }

    .payment-note.cod {
        border-left-color: #ffc107;
        background: #fff9e6;
    }

    .order-summary {
        padding: 30px;
        border-bottom: 1px solid #eee;
    }

    .order-summary h3 {
        font-size: 22px;
        margin-bottom: 25px;
        color: #333;
        font-weight: 600;
        position: relative;
        padding-bottom: 10px;
    }

    .order-summary h3:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #ea6666 0%, #cc1010 100%);
    }

    .order-items {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .order-items li {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #eee;
        font-size: 16px;
        color: #555;
    }

    .order-items li:last-child {
        border-bottom: none;
    }

    .item-name {
        flex: 2;
    }

    .item-quantity {
        flex: 1;
        text-align: center;
        color: #888;
    }

    .item-price {
        flex: 1;
        text-align: right;
        font-weight: 600;
        color: #333;
    }

    .total-amount {
        background: #f8f9fa;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 20px;
        font-weight: 700;
        border-bottom: 1px solid #eee;
    }

    .total-amount span:last-child {
        color: #a40000;
        font-size: 24px;
    }

    .action-buttons {
        padding: 30px;
        text-align: center;
    }

    .theme-btn {
        display: inline-block;
        padding: 15px 40px;
        background: linear-gradient(135deg, #ea6666 0%, #cd1313 100%);
        color: white;
        text-decoration: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(234, 102, 102, 0.4);
    }

    .theme-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(234, 102, 102, 0.6);
        color: white;
        text-decoration: none;
    }

    .additional-info {
        padding: 0 30px 30px;
        text-align: center;
        color: #888;
        font-size: 14px;
    }

    .additional-info p {
        margin-bottom: 5px;
    }

    .info-icon {
        margin-right: 5px;
        color: #667eea;
    }

    @media (max-width: 768px) {
        .success-container {
            margin: 20px;
        }
        
        .success-header h1 {
            font-size: 24px;
        }
        
        .order-number {
            font-size: 14px;
        }
        
        .total-amount {
            flex-direction: column;
            gap: 10px;
        }
        
        .action-buttons .theme-btn {
            display: block;
            margin: 10px 0;
        }
        
    }
</style>

<section class="order-success-section">
    <div class="auto-container">
        <div class="success-container">
            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">
                    ✓
                </div>
                <h1>Order Placed Successfully!</h1>
                <div class="order-number">
                    Order #{{ $order->order_number }}
                </div>
            </div>

            <!-- Payment Note -->
            <div class="payment-note {{ $order->payment_method == 'cod' ? 'cod' : '' }}">
                @if($order->payment_method == 'cod')
                    <strong>💰 Cash on Delivery</strong><br>
                    Please keep <strong>Rs. {{ number_format($order->total, 2) }}</strong> ready for delivery.
                    Additional courier fee may apply.
                @else
                    <strong>✅ Payment Successful</strong><br>
                    Your payment has been confirmed. Thank you for your purchase!
                @endif
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                <ul class="order-items">
                    @foreach($order->items as $item)
                    <li>
                        <span class="item-name">{{ $item->product->name ?? 'Product' }}</span>
                        <span class="">x{{ $item->quantity }}</span>
                        <span class="item-price">Rs. {{ number_format($item->subtotal,2) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Total Amount -->
            <div class="total-amount">
                <span>Total Amount:</span>
                <span>Rs. {{ number_format($order->total,2) }}</span>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('Frontend.index') }}" class="theme-btn">
                    🛍️ Continue Shopping
                </a>

            </div>

            <!-- Additional Info -->
            <div class="additional-info">
                <p>
                    <span class="info-icon">📧</span> 
                    A confirmation email has been sent to your registered email address.
                </p>
                <p>
                    <span class="info-icon">⏰</span> 
                    You will receive updates about your order status via SMS/Email.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection