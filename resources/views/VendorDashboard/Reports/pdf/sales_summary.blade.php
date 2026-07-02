<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #222; padding: 0px; }
        .header { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { margin: 0 0 4px 0; font-size: 16px; color: #007bff; }
        .header p { margin: 0; color: #666; }
        table.summary { width: 60%; margin-bottom: 16px; }
        table.summary td { padding: 4px 8px; }
        .summary-label { color: #666; }
        .summary-value { font-weight: bold; text-align: right; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 5px 6px; }
        table.data th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .section-title { font-weight: bold; margin: 16px 0 6px 0; font-size: 11px; border-bottom: 1px solid #eee; padding-bottom: 3px; }
        .earn { color: #1a7a3c; }
        .comm { color: #b3791d; }
        .totals-row { background: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>My Sales Summary</h2>
        <p>
            Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }}
            – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Generated: {{ now()->format('M d, Y H:i') }}
        </p>
    </div>

    <table class="summary">
        <tr><td class="summary-label">Total Orders</td><td class="summary-value">{{ number_format($total_orders) }}</td></tr>
        <tr><td class="summary-label">Total Revenue</td><td class="summary-value">Rs. {{ number_format($total_revenue, 2) }}</td></tr>
        <tr><td class="summary-label">Commission Paid</td><td class="summary-value comm">Rs. {{ number_format($total_commission, 2) }}</td></tr>
        <tr><td class="summary-label">Net Earnings</td><td class="summary-value earn">Rs. {{ number_format($total_earnings, 2) }}</td></tr>
        <tr><td class="summary-label">Card Sales Earning</td><td class="summary-value">Rs. {{ number_format($card_earning, 2) }}</td></tr>
        <tr><td class="summary-label">COD Sales Earning</td><td class="summary-value">Rs. {{ number_format($cod_revenue, 2) }}</td></tr>
    </table>

    <div class="section-title">Order Details</div>
    <table class="data">
        <thead>
            <tr>
                <th>Date</th>
                <th>Order #</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Address</th>
                <th>Product</th>
                <th class="text-end">Qty</th>
                <th>Payment Method</th>
                <th class="text-end">Revenue</th>
                <th class="text-end">Commission</th>
                <th class="text-end">Net Earning</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order_details as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}</td>
                    <td>{{ $row['order_number'] ?? '—' }}</td>
                    <td>{{ $row['customer_name'] ?? '-' }}</td>
                    <td>{{ $row['customer_contact'] ?? '-' }}</td>
                    <td>{{ $row['customer_address'] ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($row['product'], 40) }}</td>
                    <td class="text-end">{{ $row['quantity'] }}</td>
                    <td>{{ ucfirst($row['payment_method'] ?? '-') }}</td>
                    <td class="text-end">Rs. {{ number_format($row['revenue'], 2) }}</td>
                    <td class="text-end comm">Rs. {{ number_format($row['commission'], 2) }}</td>
                    <td class="text-end earn">Rs. {{ number_format($row['earning'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No order details in this period.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>