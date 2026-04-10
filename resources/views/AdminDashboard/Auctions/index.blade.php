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

            <ul class="nav focus-tab nav-pills mb-16" id="pills-tab-two" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 active" 
                    id="pills-focus-home-tab" data-bs-toggle="pill" data-bs-target="#active" type="button" role="tab" 
                    aria-controls="pills-focus-home" aria-selected="true">Active</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10" 
                    id="pills-focus-details-tab" data-bs-toggle="pill" data-bs-target="#upcoming" type="button" role="tab" 
                    aria-controls="pills-focus-details" aria-selected="false">Upcoming</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10" 
                    id="pills-focus-settings-tab" data-bs-toggle="pill" data-bs-target="#ended" type="button" role="tab" 
                    aria-controls="pills-focus-settings" aria-selected="false">Ended</button>
                </li>
            </ul>


            <div class="tab-content">

                {{-- ACTIVE --}}
                <div class="tab-pane fade show active" id="active">
                    @include('AdminDashboard.Auctions.partials.table', ['auctions' => $active])
                </div>

                {{-- UPCOMING --}}
                <div class="tab-pane fade" id="upcoming">
                    @include('AdminDashboard.Auctions.partials.table', ['auctions' => $upcoming])
                </div>

                {{-- ENDED --}}
                <div class="tab-pane fade" id="ended">
                    @include('AdminDashboard.Auctions.partials.table', ['auctions' => $ended])
                </div>

            </div>
        </table>
        </div>
    </div>
</div>

@endsection