<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isAdmin ? 'New Order Received' : 'Order Confirmation' }}</title>
    <style>
        /* Reset styles */
        body, table, td, p, a {
            margin: 0;
            padding: 0;
            border: 0;
            font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
        }
        
        body {
            background-color: #f4f4f7;
            color: #333333;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Main container */
        .email-wrapper {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        /* Header section */
        .email-header {
            background: linear-gradient(135deg, #f6f6f6 0%, #b6b6b6 100%);
            padding: 40px 30px;
            text-align: center;
        }
        

        
        .email-header h2 {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        
        .order-badge {
            background: rgba(255,255,255,0.15);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            display: inline-block;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(5px);
            margin-top: 10px;
        }
        
        /* Content section */
        .email-content {
            padding: 40px 30px;
        }
        
        /* Greeting */
        .greeting {
            font-size: 18px;
            margin-bottom: 25px;
            color: #333;
        }
        
        .greeting strong {
            color: #d30808;
        }
        
        /* Customer info cards */
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            padding: 10px 15px;
            background: #f8fafc;
            font-weight: 600;
            color: #555;
            width: 120px;
            border-radius: 8px 0 0 8px;
            font-size: 14px;
        }
        
        .info-value {
            display: table-cell;
            padding: 10px 15px;
            background: #f8fafc;
            color: #333;
            border-radius: 0 8px 8px 0;
            font-size: 14px;
            text-align: left;
        }
        
        /* Order summary table */
        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        
        .order-table th {
            background: #f8fafc;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #555;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #eef2f6;
        }
        
        .order-table td {
            padding: 15px;
            border-bottom: 1px solid #eef2f6;
            color: #666;
        }
        
        .order-table tr:last-child td {
            border-bottom: none;
        }
        
        .product-name {
            font-weight: 600;
            color: #333;
        }
        
        
        /* Totals section */
        .totals-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #dde3e9;
        }
        
        .total-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 18px;
            color: #333;
            padding-top: 15px;
            margin-top: 5px;
        }
        
        .total-label {
            color: #666;
        }
        
        
        /* Payment note */
        .payment-note {
            background: {{ $order->payment_method == 'cod' ? '#fff9e6' : '#e8f5e9' }};
            border-left: 4px solid {{ $order->payment_method == 'cod' ? '#ffc107' : '#28a745' }};
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            font-size: 15px;
        }
        
        .payment-note strong {
            display: block;
            margin-bottom: 8px;
            color: {{ $order->payment_method == 'cod' ? '#856404' : '#1e7e34' }};
        }
        
        
        /* Footer */
        .email-footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #eef2f6;
        }
        

        .copyright {
            color: #999;
            font-size: 13px;
            margin-top: 15px;
        }
        
    </style>
</head>
<body style="background-color: #f4f4f7; padding: 30px 15px;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f7; padding: 30px 15px;">
        <tr>
            <td align="center">
                <!-- Main Email Container -->
                <div class="email-wrapper">
                    <!-- Header -->
                    <div class="email-header">
                      
                        <h2 style="color: #000000;">{{ $isAdmin ? 'New Order Received!' : 'Thank You for Your Order!' }}</h2>
                        <div class="order-badge" style="color: #000000;">
                            Order #{{ $order->order_number }}
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="email-content">
                        <!-- Greeting -->
                        <div class="greeting">
                            @if($isAdmin)
                                <strong>New order alert!</strong> A customer has placed an order.
                            @else
                                <strong>Hi {{ $order->first_name }},</strong> your order has been placed.
                            @endif
                        </div>
                        
                        <!-- Customer Information -->
                        <h3 style="margin-bottom: 15px; color: #333; font-size: 18px;">📋 Customer Details</h3>
                        <div class="info-grid">
                            <div class="info-row">
                                <span class="info-label">Name:</span>
                                <span class="info-value" style="text-align: left;">{{ $order->first_name }} {{ $order->last_name }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email:</span>
                                <span class="info-value" style="text-align: left;">{{ $order->email }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone:</span>
                                <span class="info-value" style="text-align: left;">{{ $order->phone }}</span>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <h3 style="margin: 30px 0 15px; color: #333; font-size: 18px;">🛍️ Order Details</h3>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th style="text-align: right;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <span class="product-name">{{ $item->product->name ?? 'Product' }}</span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td align="right">Rs. {{ number_format($item->subtotal,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                       <!-- Totals -->
                    <div class="totals-section" style=" margin-top: 20px;">
                        <div class="total-row" style="display: flex; justify-content: space-between">
                            <span class="total-label" style="font-weight: bold;">Subtotal:</span>
                            <span class="total-value" style="text-align: right; font-weight: bold;">Rs. {{ number_format($order->subtotal,2) }}</span>
                        </div>
                        <div class="total-row" style="display: flex; justify-content: space-between;">
                            <span class="total-label" style="font-weight: bold;">Discount:</span>
                            <span class="total-value" style="text-align: right; font-weight: bold;">- Rs. {{ number_format($order->discount,2) }}</span>
                        </div>
                        <div class="total-row" style="display: flex; justify-content: space-between; border-top: 1px solid #ccc; padding-top: 8px; font-size: 1.1em;">
                            <span class="total-label" style="font-weight: bold;">Total Amount:</span>
                            <span class="total-value" style="text-align: right; font-weight: bold; color: #1fad0f;">Rs. {{ number_format($order->total,2) }}</span>
                        </div>
                    </div>
                        
                        <!-- Payment Information -->
                        @if(!$isAdmin)
                        <div class="payment-note">
                            <strong>
                                @if($order->payment_method == 'cod')
                                    💰 Cash on Delivery
                                @else
                                    ✅ Payment Completed
                                @endif
                            </strong>
                            @if($order->payment_method == 'cod')
                                Please keep <strong>Rs. {{ number_format($order->total,2) }}</strong> ready for delivery. Our courier partner will collect the payment when delivering your order.
                            @else
                                Your payment has been successfully processed. Thank you for your purchase!
                            @endif
                        </div>
                        @endif
                        
                    </div>
                    
                    <!-- Footer -->
                    <div class="email-footer">
                        <div class="copyright">
                            © {{ date('Y') }} AutoPartHub SL. All rights reserved.<br>
                            This is an automated message, please do not reply to this email.
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>