<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #222; padding: 0px; }
        .header { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { margin: 0 0 4px 0; font-size: 16px; color: #007bff; }
        .header p { margin: 0; color: #666; }
        table.summary { width: 100%; margin-bottom: 16px; }
        table.summary td { padding: 4px 8px; }
        .summary-label { color: #666; width: 40%; }
        .summary-value { font-weight: bold; text-align: right; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 5px 6px; }
        table.data th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .section-title { font-weight: bold; margin: 16px 0 6px 0; font-size: 11px; border-bottom: 1px solid #eee; padding-bottom: 3px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Sales & Earnings Report</h2>
        <p>Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }} – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}</p>
    </div>

    <table class="summary">
        <tr><td class="summary-label">Total Orders</td><td class="summary-value">{{ number_format($total_orders) }}</td></tr>
        <tr><td class="summary-label">Total Revenue</td><td class="summary-value">Rs. {{ number_format($total_revenue, 2) }}</td></tr>
        <tr><td class="summary-label">Commission</td><td class="summary-value">Rs. {{ number_format($total_commission, 2) }}</td></tr>
        <tr><td class="summary-label">Net Earnings</td><td class="summary-value">Rs. {{ number_format($total_earnings, 2) }}</td></tr>
        <tr><td class="summary-label">Transferred to You</td><td class="summary-value">Rs. {{ number_format($total_paid, 2) }}</td></tr>
        <tr><td class="summary-label">Pending</td><td class="summary-value">Rs. {{ number_format($total_pending, 2) }}</td></tr>
    </table>

    <div class="section-title">Order Details</div>
    <table class="data">
        <thead>
            <tr>
                <th>Date</th>
                <th>Order #</th>
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
                    <td>{{ \Illuminate\Support\Str::limit($row['product'], 40) }}</td>
                    <td class="text-end">{{ $row['quantity'] }}</td>
                    <td>{{ ucfirst($row['payment_method'] ?? '-') }}</td>
                    <td class="text-end">Rs. {{ number_format($row['revenue'], 2) }}</td>
                    <td class="text-end">Rs. {{ number_format($row['commission'], 2) }}</td>
                    <td class="text-end">Rs. {{ number_format($row['earning'], 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No order details in this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
