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
            <ul class="nav nav-tabs mb-3">
                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#active">Active</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#upcoming">Upcoming</a></li>
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#ended">Ended</a></li>
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