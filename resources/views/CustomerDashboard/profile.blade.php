@extends('CustomerDashboard.layout')

@section('account-content')

<h4 class="mb-3">Personal Information</h4>

<form method="POST" action="{{ route('customer.profile.update') }}">
    @csrf

    <div class="row">

        <div class="col-md-6 mb-3">
            <input type="text" 
                   name="first_name" 
                   value="{{ $customer->first_name }}" 
                   placeholder="First Name" 
                   class="form-control" 
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <input type="text" 
                   name="last_name" 
                   value="{{ $customer->last_name }}" 
                   placeholder="Last Name" 
                   class="form-control" 
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <input type="email" 
                   name="email" 
                   value="{{ $customer->email }}" 
                   placeholder="Email" 
                   class="form-control" 
                   required>
        </div>

        <div class="col-md-6 mb-3">
            <input type="text" 
                   name="phone" 
                   value="{{ $customer->phone }}" 
                   placeholder="Phone" 
                   class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <textarea name="address" 
                      placeholder="Address" 
                      class="form-control" 
                      rows="3">{{ $customer->address }}</textarea>
        </div>

        <div class="col-md-12">
            <button type="submit" class="theme-btn p-2" style="font-size:13px">
                Update Profile
            </button>
        </div>

    </div>
</form>
@endsection