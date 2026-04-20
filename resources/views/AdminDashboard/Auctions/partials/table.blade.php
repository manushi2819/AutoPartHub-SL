<table class="table basic-border-table mb-0" id="dataTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Item Type</th>
            <th>Item</th>
            <th>Start</th>
            <th>End</th>
            <th>Starting Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($auctions as $auction)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ ucfirst($auction->item_type) }}</td>

           <td>
                @if ($auction->item_type === 'vehicle' && $auction->item)
                    {{ optional($auction->item->brand)->name ?? '' }}
                    {{ $auction->item->model ?? '' }}
                    ({{ $auction->item->year ?? '' }})
                @elseif ($auction->item_type === 'product' && $auction->item)
                    {{ $auction->item->brand ?? '' }} {{ $auction->item->name ?? '' }}
                @else
                    N/A
                @endif
            </td>

            <td>{{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y, g:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y, g:i A') }}</td>
            <td>Rs. {{ $auction->starting_price }}</td>

            <td>
                @php
                    $statusClasses = [
                        'upcoming' => 'bg-info-focus text-info-main',
                        'active'   => 'bg-success-focus text-success-main',
                        'ended'    => 'bg-danger-focus text-danger-main',
                    ];
                    $class = $statusClasses[$auction->status] ?? 'bg-secondary text-dark';
                @endphp

                <span class="px-24 py-4 rounded-pill fw-medium text-sm {{ $class }}">
                    {{ ucfirst($auction->status) }}
                </span>
            </td>

            <td>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.auctions.edit', $auction->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </a>

                    <form action="{{ route('admin.auctions.destroy', $auction->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main 
                        rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal"
                               >
                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                    </form>
                </div>
              
            </td>
        </tr>
        @endforeach
    </tbody>
</table>