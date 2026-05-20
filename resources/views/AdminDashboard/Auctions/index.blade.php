@extends('AdminDashboard.master')
@section('title', 'Auctions')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Auctions</h6>

    <a href="{{ route('admin.auctions.create') }}" class="btn btn-primary btn-sm">
        Add Auction
    </a>
</div>

<div class="card basic-data-table">
    <div class="card-body">

        <div class="table-responsive">

            {{-- TABS --}}
            <ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.auctions.index', ['status' => 'active']) }}"
                       class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status','active')=='active' ? 'active' : '' }}">
                        Active
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.auctions.index', ['status' => 'upcoming']) }}"
                       class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status')=='upcoming' ? 'active' : '' }}">
                        Upcoming
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="{{ route('admin.auctions.index', ['status' => 'ended']) }}"
                       class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 {{ request('status')=='ended' ? 'active' : '' }}">
                        Ended
                    </a>
                </li>
            </ul>

            {{-- TABLE --}}
             <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Type</th>
                        <th>Item</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Starting Price</th>
                        <th>is Active </th>
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

                                    {{ optional($auction->item->brand)->name ?? '' }}
                                    {{ \Illuminate\Support\Str::limit($auction->item->name, 50) }}

                                @else
                                    N/A
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($auction->start_time)->format('d M Y, g:i A') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($auction->end_time)->format('d M Y, g:i A') }}
                            </td>

                            <td>Rs. {{ $auction->starting_price }}</td>

                            <td>
                                <span class="px-24 py-4 rounded-pill fw-medium text-sm {{ $auction->is_active == '1' ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }}">
                                    {{ ucfirst($auction->is_active == '1' ? 'Active' : 'Inactive') }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('admin.auctions.edit', $auction->id) }}"
                                       class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <form action="{{ route('admin.auctions.destroy', $auction->id) }}"
                                          method="POST"
                                          class="m-0 p-0">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal"
                                                data-url="{{ route('admin.auctions.destroy', $auction->id) }}">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                 
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>
</div>



@endsection