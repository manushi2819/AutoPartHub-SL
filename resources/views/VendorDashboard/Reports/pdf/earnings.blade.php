<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; margin: 0; padding: 0px; }
        .header { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { margin: 0 0 4px 0; font-size: 18px; color: #007bff; }
        .header p { margin: 0; color: #666; font-size: 11px; }
        .summary-box { width: 100%; margin-bottom: 16px; }
        .summary-box td { padding: 5px 5px; }
        .summary-label { color: #666; width: 40%; }
        .summary-value { font-weight: bold; text-align: right; }
        .highlight { background: #f0f6ff; border-left: 3px solid #007bff; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 5px 7px; }
        table.data th { background: #f0f0f0; font-size: 10px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .status-paid { color: #0f5132; }
        .status-pending { color: #92660d; }
        .totals-row { background: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Earnings Report</h2>
        <p>
            Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }}
            – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Generated: {{ now()->format('M d, Y H:i') }}
        </p>
    </div>

    <table class="summary-box">
        <tr><td class="summary-label">Total Earned</td><td class="summary-value">Rs. {{ number_format($total_earned, 2) }}</td></tr>
        <tr><td class="summary-label">Transferred to You</td><td class="summary-value status-paid">Rs. {{ number_format($total_paid, 2) }}</td></tr>
        <tr><td class="summary-label">Pending</td><td class="summary-value status-pending">Rs. {{ number_format($total_pending, 2) }}</td></tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Product</th>
                <th>Date</th>
                <th>Payment</th>
                <th class="text-end">Subtotal</th>
                <th class="text-end">Commission</th>
                <th class="text-end">Net Earning</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($earnings as $earning)
                <tr>
                    <td>{{ $earning->order->order_number ?? '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($earning->product->name ?? 'N/A', 35) }}</td>
                    <td>{{ $earning->created_at->format('M d, Y') }}</td>
                    <td>{{ $earning->order->payment_method ?? '—' }}</td>
                    <td class="text-end">Rs. {{ number_format($earning->orderItem->subtotal ?? 0, 2) }}</td>
                    <td class="text-end">Rs. {{ number_format($earning->orderItem->vendor_commission_amount ?? 0, 2) }}</td>
                    <td class="text-end">Rs. {{ number_format($earning->earning_amount, 2) }}</td>
                    <td class="text-center {{ 'status-' . $earning->status }}">{{ ucfirst($earning->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="7">No earnings in this period.</td></tr>
            @endforelse
            @if($earnings->isNotEmpty())
                <tr class="totals-row">
                    <td colspan="6" class="text-end">Total</td>
                    <td class="text-end">Rs. {{ number_format($total_earned, 2) }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>


</body>
</html>