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

<h2>Vendors Report</h2>

<p class="subtitle">
    Period:
    {{ $start ? $start->format('M d, Y') : 'All Time' }}
    -
    {{ $end ? $end->format('M d, Y') : 'Present' }}
    | Generated: {{ now()->format('M d, Y H:i') }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Vendor</th>
            <th>Vendor contact</th>
            <th>Vendor Address</th>
            <th>Owner</th>
            <th class="text-end">Total Orders</th>
            <th class="text-end">Total Sales</th>
        </tr>
    </thead>

    <tbody>

        @forelse($vendors as $index => $vendor)

            <tr>

                <td>{{ $index + 1 }}</td>

                <td>
                    {{ $vendor->vendor->shop_name ?? ''}}
                </td>
                <td>
                    {{ $vendor->vendor->email ?? '-' }} - {{ $vendor->vendor->phone ?? '-' }}
                </td>
                <td>
                    {{ $vendor->vendor->address ?? '-' }}, {{ $vendor->vendor->district ?? '-' }}
                </td>
                <td>
                    {{ $vendor->vendor->owner_name ?? '-' }}
                </td>

                <td class="text-end">
                    {{ number_format($vendor->total_orders) }}
                </td>

                <td class="text-end">
                    Rs. {{ number_format($vendor->total_sales, 2) }}
                </td>

            </tr>

        @empty

            <tr>
                <td colspan="4" style="text-align:center;">
                    No vendor sales found for this period.
                </td>
            </tr>

        @endforelse

    </tbody>
</table>

</body>
</html>