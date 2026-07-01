<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 6px; }
        th { background: #f0f0f0; }
        .text-end { text-align: right; }
    </style>
</head>
<body>

<h3>COD Commission Report</h3>

<p>
    Period:
    {{ $period_start?->format('Y-m-d') ?? 'All' }}
    -
    {{ $period_end?->format('Y-m-d') ?? 'Now' }}
</p>

@if($status)
<p>Status: {{ ucfirst($status) }}</p>
@endif

<table>
    <thead>
        <tr>
            <th>Vendor</th>
            <th>Vendor contact</th>
            <th class="text-end">Status</th>
            <th class="text-end">Items</th>
            <th class="text-end">Commission</th>
        </tr>
    </thead>

    <tbody>

        @forelse($data as $row)

            <tr>
                <td>
                    {{ $row->vendor->shop_name ?? '-'}}
                </td>
                <td>
                    {{ $row->vendor->email ?? '-' }} - {{ $row->vendor->phone ?? '-' }}
                </td>

                <td class="text-end">{{ ucfirst($row->status) }}</td>

                <td class="text-end">{{ $row->item_count }}</td>

                <td class="text-end">
                    Rs. {{ number_format($row->total,2) }}
                </td>
            </tr>

        @empty
            <tr>
                <td colspan="4" style="text-align:center;">
                    No records found
                </td>
            </tr>
        @endforelse

    </tbody>
</table>

</body>
</html>