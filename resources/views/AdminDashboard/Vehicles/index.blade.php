@extends('AdminDashboard.master')
@section('title', 'Vehicles')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Vehicles</h6>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-sm">
       Add Vehicle
    </a>
</div>

<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Year</th>
                    <th>Price (LKR)</th>
                    <th>Mileage (km)</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Main Image</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @php $counter = 1; @endphp

                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $counter++ }}</td>

                        {{-- Brand --}}
                        <td>{{ $vehicle->brand->name ?? 'N/A' }}</td>

                        {{-- Model --}}
                        <td>{{ $vehicle->model }}</td>

                        {{-- Year --}}
                        <td>{{ $vehicle->year }}</td>

                        {{-- Price --}}
                        <td>{{ number_format($vehicle->price, 2) }}</td>

                        {{-- Mileage --}}
                        <td>{{ $vehicle->mileage ?? 'N/A' }}</td>

                        {{-- Location --}}
                        <td>
                            {{ $vehicle->city ?? '' }}
                            @if($vehicle->city && $vehicle->district) ,
                            @endif
                            {{ $vehicle->district ?? '' }}
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="px-24 py-4 rounded-pill fw-medium text-sm
                                {{ $vehicle->status
                                    ? 'bg-success-focus text-success-main'
                                    : 'bg-danger-focus text-danger-main' }}">
                                {{ $vehicle->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        {{-- Main Image --}}
                        <td>
                            @if($vehicle->mainImage)
                                <img src="{{ asset('uploads/' . $vehicle->mainImage->image_url) }}"
                                     width="50" height="50" class="rounded">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-2">

                                {{-- Edit --}}
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}"
                                   class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>

                                {{-- Delete --}}
                      
                                  <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal" 
                                        data-url="{{ route('admin.vehicles.destroy', $vehicle->id) }}">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </button>

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