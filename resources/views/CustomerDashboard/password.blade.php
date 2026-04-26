@extends('CustomerDashboard.layout')

@section('account-content')

<h4 class="mb-3">Update Password</h4>

<form method="POST" action="{{ route('customer.profile.password') }}">
    @csrf

    <div class="row">

        <!-- Current Password -->
        <div class="col-md-6 mb-3">
            <input type="password" 
                   name="current_password" 
                   placeholder="Current Password" 
                   class="form-control @error('current_password') is-invalid @enderror" 
                   required>

            @error('current_password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- New Password -->
        <div class="col-md-6 mb-3">
            <input type="password" 
                   name="password" 
                   placeholder="New Password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   required>

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="col-md-6 mb-3">
            <input type="password" 
                   name="password_confirmation" 
                   placeholder="Confirm Password" 
                   class="form-control" 
                   required>
        </div>

        <div class="col-md-12">
            <button type="submit" class="theme-btn p-2" style="font-size:13px">
                Update Password
            </button>
        </div>

    </div>
</form>

@endsection