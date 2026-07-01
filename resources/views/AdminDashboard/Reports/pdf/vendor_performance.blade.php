<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #222; margin:0px;padding:0px }
        h2 { margin-bottom: 2px; }
        .subtitle { color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px 6px; text-align: left; }
        th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .positive { color: #1a7a3c; }
        .pending { color: #b3791d; }
    </style>
</head>
<body>
    <h2>Vendor Performance / Settlement Report</h2>
    <p class="subtitle">
        Period: {{ $start->format('M d, Y') }} – {{ $end->format('M d, Y') }}
        | Generated: {{ now()->format('M d, Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Vendor</th>
                <th class="text-end">Orders</th>
                <th class="text-end">Total Sales</th>
                <th class="text-end">Commission Generated</th>
                <th class="text-end">Earnings Paid</th>
                <th class="text-end">Earnings Pending</th>
                <th class="text-end">Commission Collected</th>
                <th class="text-end">Commission Pending</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendors as $row)
                <tr>
                    <td>{{ $row->vendor->shop_name ?? $row->vendor->name ?? 'Vendor #' . $row->vendor->id }}</td>
                    <td class="text-end">{{ $row->order_count }}</td>
                    <td class="text-end">Rs. {{ number_format($row->total_sales, 2) }}</td>
                    <td class="text-end">Rs. {{ number_format($row->total_commission_generated, 2) }}</td>
                    <td class="text-end positive">Rs. {{ number_format($row->earnings_paid, 2) }}</td>
                    <td class="text-end pending">Rs. {{ number_format($row->earnings_pending, 2) }}</td>
                    <td class="text-end positive">Rs. {{ number_format($row->commission_paid, 2) }}</td>
                    <td class="text-end pending">Rs. {{ number_format($row->commission_pending, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No vendor activity in this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>