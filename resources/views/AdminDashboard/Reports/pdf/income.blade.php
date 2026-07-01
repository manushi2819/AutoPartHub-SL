<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #222; }
        h2 { margin-bottom: 2px; }
        .subtitle { color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        .text-end { text-align: right; }
        .summary-table td { border: none; padding: 4px 8px; }
        .summary-label { color: #666; }
        .total-row { font-weight: bold; background: #f8f9fa; }
        .section-title { margin-top: 20px; margin-bottom: 8px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Income Report</h2>
    <p class="subtitle">
        Period: {{ $period_start ? $period_start->format('M d, Y') : 'All Time' }}
        – {{ $period_end ? $period_end->format('M d, Y') : 'Present' }}
        | Generated: {{ now()->format('M d, Y H:i') }}
    </p>

    <table class="summary-table">
        <tr><td class="summary-label">Orders Income</td><td class="text-end">Rs. {{ number_format($own_store_earnings, 2) }}</td></tr>
        <tr><td class="summary-label">Total Commission Earned</td><td class="text-end">Rs. {{ number_format($total_commission, 2) }}</td></tr>
        <tr class="total-row"><td>Total Income</td><td class="text-end">Rs. {{ number_format($total_income, 2) }}</td></tr>
    </table>


    <div class="section-title">Income Transactions</div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Order No</th>
                <th>Vendor</th>
                <th class="text-end">Vendor Earning</th>
                <th class="text-end">Commission Income</th>
                <th class="text-end">Total Income</th>
            </tr>
        </thead>

        <tbody>

            @forelse($income_details as $item)

                <tr>

                    <td>{{ $item->created_at->format('Y-m-d') }}</td>

                    <td>{{ $item->order->order_number ?? '-' }}</td>

                    <td>
                        @if($item->vendor_id == 1)
                            Admin Store
                        @else
                            {{ $item->vendor->shop_name
                                ?? $item->vendor->owner_name
                                ?? 'Vendor #' . $item->vendor_id }}
                        @endif
                    </td>

                    <td class="text-end">
                        Rs. {{ number_format($item->vendor_earning_amount, 2) }}
                    </td>

                    <td class="text-end">
                        Rs. {{ number_format($item->vendor_commission_amount, 2) }}
                    </td>

                    <td class="text-end">
                        Rs.
                        {{ number_format(
                            $item->vendor_id == 1
                                ? $item->vendor_earning_amount
                                : $item->vendor_commission_amount,
                            2
                        ) }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" style="text-align:center;">
                        No income records found for this period.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
</body>
</html>