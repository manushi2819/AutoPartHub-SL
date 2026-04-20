@extends('Frontend.master')

@section('title', 'Vehicles - AutoPartHub SL')

@section('content')

<style>


    /* Filter Card */
    .filter-card {
        background: #ffffff;
        border: none;
        border-radius: 0px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .filter-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-black);
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control, select.form-control {
        border: 2px solid #e0e0e0;
        border-radius: 0px;
        padding: 10px 12px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .form-control:focus, select.form-control:focus {
        border-color: var(--primary-red);
        box-shadow: 0 0 0 0.2rem rgba(194,13,13,0.1);
        outline: none;
    }

    .btn-dark {
        background: var(--primary-black);
        border: none;
        border-radius: 0px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-dark:hover {
        background: var(--primary-red);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(194,13,13,0.3);
    }

    .btn-light {
        background: #f8f9fa;
        border: 2px solid #e0e0e0;
        border-radius: 0px;
        padding: 10px 24px;
        font-weight: 600;
        color: var(--primary-black);
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        border-color: var(--primary-red);
        background: #ffffff;
        transform: translateY(-2px);
    }

    /* Vehicle Card */
    .vehicle-card {
        background: #ffffff;
        border: none;
        border-radius: 0px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .vehicle-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .vehicle-image {
        position: relative;
        overflow: hidden;
        background: var(--light-gray);
    }

    .vehicle-image img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.05);
    }


    .vehicle-card .card-body {
        padding: 20px;
    }

    .vehicle-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 12px;
    }

    .vehicle-details {
        margin-bottom: 15px;
    }

    .vehicle-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #666;
        margin-bottom: 3px;
    }

    .vehicle-detail-item i {
        color: var(--primary-red);
        width: 18px;
        font-size: 13px;
    }

    .vehicle-price {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-red);
        margin: 15px 0;
    }

    .vehicle-price small {
        font-size: 12px;
        font-weight: normal;
        color: #999;
    }

    .btn-view {
        background: var(--primary-black);
        color: #ffffff;
        border: none;
        border-radius: 0px;
        padding: 10px;
        font-weight: 600;
        width: 100% !important;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: var(--primary-red);
        transform: translateY(-2px);
        color: #ffffff;
    }


    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: #ffffff;
        border-radius: 0px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    }

    .empty-state i {
        font-size: 64px;
        color: var(--primary-red);
        margin-bottom: 20px;
    }

    .empty-state h5 {
        font-size: 24px;
        color: var(--primary-black);
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
    }

    /* Responsive */
    @media (max-width: 768px) {
     
        .vehicle-image img {
            height: 180px;
        }
        
        .vehicle-price {
            font-size: 18px;
        }
        
        .btn-dark, .btn-light {
            padding: 8px 16px;
        }
    }
</style>



<!-- page-title -->
<section class="page-title">
    <div class="auto-container">
        <div class="content-box">
            <ul class="bread-crumb">
                <li><a href="{{ route('Frontend.index') }}">Home</a></li>
                <li>Vehicles</li>
            </ul>
        </div>
    </div>
</section>
<!-- page-title end -->

<section class="pt-4 pb-3">
    <div class="auto-container">
        <div class="filter-card card p-4 mb-4">

            <form method="GET" action="{{ route('Frontend.vehicles') }}">
                <div class="row g-3 align-items-end">

                    {{-- BRAND --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-car"></i> Brand
                        </label>
                        <select name="brand" class="form-control">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->name }}" {{ request('brand') == $brand->name ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MODEL (NOW DROPDOWN) --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-tag"></i> Model
                        </label>
                        <select name="model" class="form-control">
                            <option value="">All Models</option>
                            @foreach($models as $model)
                                <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>
                                    {{ $model }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- YEAR --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt"></i> Year
                        </label>
                        <select name="year" class="form-control">
                            <option value="">All Years</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DISTRICT --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> District
                        </label>
                        <select name="district" class="form-control">
                            <option value="">All Districts</option>
                            @foreach($districts as $district)
                                <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CONDITION --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-info-circle"></i> Condition
                        </label>
                        <select name="condition" class="form-control">
                            <option value="">All Conditions</option>
                            @foreach($conditions as $condition)
                                <option value="{{ $condition }}" {{ request('condition') == $condition ? 'selected' : '' }}>
                                    {{ $condition }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- MIN PRICE --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign"></i> Min Price
                        </label>
                        <input type="number" name="min_price" class="form-control"
                               placeholder="Minimum price"
                               value="{{ request('min_price') }}">
                    </div>

                    {{-- MAX PRICE --}}
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign"></i> Max Price
                        </label>
                        <input type="number" name="max_price" class="form-control"
                               placeholder="Maximum price"
                               value="{{ request('max_price') }}">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button class="btn btn-dark px-4 flex-grow-1">
                                <i class="fas fa-search"></i> Search
                            </button>
                            <a href="{{ route('Frontend.vehicles') }}" class="btn btn-light px-4">
                                <i class="fas fa-undo-alt"></i> Clear
                            </a>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</section>

<!-- VEHICLE LIST -->
<section class="pb-5">
    <div class="auto-container">
        <div class="row g-4">
            @forelse($vehicles as $vehicle)
                @php
                    $image = $vehicle->images->first();
                @endphp

                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="vehicle-card">
                        <div class="vehicle-image">
                            <img src="{{ $image ? asset('uploads/'.$image->image_url) : asset('no-image.png') }}"
                                 alt="{{ $vehicle->brand->name }} {{ $vehicle->model }}">
                        </div>
                        <div class="card-body">
                            <h6 class="vehicle-title">
                                {{ $vehicle->brand->name }} {{ $vehicle->model }}
                            </h6>
                            
                            <div class="vehicle-details">
                                <div class="vehicle-detail-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Year: {{ $vehicle->year ?? 'N/A' }}</span>
                                </div>
                                <div class="vehicle-detail-item">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>Fuel: {{ $vehicle->fuel_type ?? 'N/A' }}</span>
                                </div>
                                @if($vehicle->mileage ?? false)
                                <div class="vehicle-detail-item">
                                    <i class="fas fa-road"></i>
                                    <span>Mileage: {{ number_format($vehicle->mileage) }} km</span>
                                </div>
                                @endif
                                @if($vehicle->transmission ?? false)
                                <div class="vehicle-detail-item">
                                    <i class="fas fa-cogs"></i>
                                    <span>Transmission: {{ $vehicle->transmission }}</span>
                                </div>
                                @endif
                                <div class="vehicle-detail-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Location: {{ $vehicle->district ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div class="vehicle-price">
                                LKR {{ number_format($vehicle->price) }}
                                <small>negotiable</small>
                            </div>

                            <a href="{{ route('Frontend.vehicle.details', $vehicle->id) }}"
                               class="btn-view d-block w-100 text-center">View Details
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-car-side"></i>
                        <h5>No Vehicles Found</h5>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($vehicles->hasPages())
        <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($vehicles->onFirstPage())
                    <li class="disabled"><span><i class="fas fa-chevron-left"></i></span></li>
                @else
                    <li><a href="{{ $vehicles->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($vehicles->getUrlRange(1, $vehicles->lastPage()) as $page => $url)
                    @if ($page == $vehicles->currentPage())
                        <li><a href="{{ $url }}" class="current">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($vehicles->hasMorePages())
                    <li><a href="{{ $vehicles->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                @else
                    <li class="disabled"><span><i class="fas fa-chevron-right"></i></span></li>
                @endif
            </ul>
        </div>
        @endif
    </div>
</section>

@endsection