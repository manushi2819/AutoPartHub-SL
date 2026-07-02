<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #222; padding: 0px; }
        .header { border-bottom: 2px solid #007bff; padding-bottom: 10px; margin-bottom: 16px; }
        .header h2 { margin: 0 0 4px 0; font-size: 16px; color: #007bff; }
        .header p { margin: 0; color: #666; }
        table.data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 5px 6px; }
        table.data th { background: #f0f0f0; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Payout History</h2>
        <p>Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }} – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}</p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>Paid Date</th>
                <th>Period</th>
                <th>Reference</th>
                <th class="text-end">Amount</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($settlements as $settlement)
                <tr>
                    <td>{{ $settlement->paid_at ? $settlement->paid_at->format('M d, Y') : '-' }}</td>
                    <td>{{ $settlement->period_start->format('M d, Y') }} - {{ $settlement->period_end->format('M d, Y') }}</td>
                    <td>{{ $settlement->transfer_reference ?? '-' }}</td>
                    <td class="text-end">Rs. {{ number_format($settlement->total_amount, 2) }}</td>
                    <td>{{ $settlement->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No payouts in this period.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
