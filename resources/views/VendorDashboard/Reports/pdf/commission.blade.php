<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; padding: 0px; }
        .header { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { margin: 0 0 4px 0; font-size: 18px; color: #007bff; }
        .header p { margin: 0; color: #666; }
        table.summary { width: 100%; margin-bottom: 16px; }
        table.summary td { padding: 4px 8px; }
        .summary-label { color: #666; width: 45%; }
        .summary-value { font-weight: bold; text-align: right; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 10px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 5px 6px; }
        table.data th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .section-title { font-weight: bold; margin: 16px 0 6px 0; font-size: 12px; border-bottom: 1px solid #eee; padding-bottom: 4px; }
        .aging-cell { text-align: center; border: 1px solid #ddd; padding: 8px; }
        .warn { color: #c0392b; font-weight: bold; }
        .note { color: #888; font-size: 10px; margin-bottom: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>My Commission Report</h2>
        <p>
            Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }}
            – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            Generated: {{ now()->format('M d, Y H:i') }}
        </p>
    </div>

    <table class="summary">
        <tr><td class="summary-label">Card Commission (retained by admin)</td><td class="summary-value">Rs. {{ number_format($card_total, 2) }}</td></tr>
        <tr><td class="summary-label">COD Commission Due to Admin</td><td class="summary-value warn">Rs. {{ number_format($cod_pending, 2) }}</td></tr>
        <tr><td class="summary-label">COD Commission Settled</td><td class="summary-value">Rs. {{ number_format($cod_paid, 2) }}</td></tr>
    </table>

  
    <div class="section-title">Commission Transactions</div>
    <table class="data">
        <thead>
            <tr>
                <th>Date</th>
                <th>Order #</th>
                <th>Product</th>
                <th>Payment Method</th>
                <th class="text-end">Commission</th>
                <th>Status</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($report_rows as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row['date'])->format('M d, Y') }}</td>
                    <td>{{ $row['order_number'] ?? '—' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($row['product'] ?? '-', 35) }}</td>
                    <td>{{ $row['payment_method'] }}</td>
                    <td class="text-end">Rs. {{ number_format($row['amount'], 2) }}</td>
                    <td>{{ $row['status'] }}</td>
                    <td>{{ $row['remarks'] ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8">No commission transactions in this period.</td></tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>