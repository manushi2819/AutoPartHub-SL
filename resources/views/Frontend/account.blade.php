@extends('Frontend.master')

@section('title', 'Account')

@section('content')

<style>
 
</style>

        <!-- page-title -->
        <section class="page-title-two centred">
            <div class="auto-container">
                <div class="content-box">
                    <h1>My Account</h1>
                </div>
            </div>
        </section>
        <!-- page-title end -->

            @php
                $customer = Auth::guard('customer')->user();
            @endphp
        <!-- account-section -->
        <section class="account-section pb_80">
            <div class="auto-container ">
                <div class="inner-container card1">
                    <div class="tabs-box">
                        <div class="account-info">
                            <div class="upper-box centred mb_40">
                                <figure class="image-box"><img src="{{ asset('frontend/assets/images/resource/account.jpg') }}" 
                                style="width:150px" alt=""></figure>
                                <h4>{{ $customer->first_name}} {{ $customer->last_name}}</h4>
                                <a href="mailto:{{ $customer->email}}">{{ $customer->email}}</a>
                            </div>
                            <ul class="tab-btns tab-buttons clearfix">
                                <li class="tab-btn active-btn" data-tab="#tab-1">Personal Information</li>
                                <li class="tab-btn" data-tab="#tab-3">Order History</li>
                                <!--<li class="tab-btn" data-tab="#tab-4">Wishlist</li>-->
                            </ul>
                        </div>
                        <div class="tabs-content">
                            <div class="tab active-tab" id="tab-1">
                            <section class="contact-section">
                                <div class="auto-container">
                                    <div class="sec-title mb_10">
                                        <h3>Personal Information</h3>
                                        <p>Manage your personal information, including phone numbers, email, and address where you can be contacted</p>
                                    </div>
                                    <div class="form-inner">
                                         <form method="POST" action="{{ route('customer.profile.update') }}" id="contact-form">
                                            @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="text" name="first_name" value="{{ $customer->first_name }}" placeholder="First Name" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="text" name="last_name" value="{{ $customer->last_name }}" placeholder="Last Name" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="email" name="email" value="{{ $customer->email }}" placeholder="E-mail" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="text" name="phone" value="{{ $customer->phone }}" placeholder="Phone">
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                    <textarea name="address" placeholder="Address" rows="0">{{ $customer->address }}</textarea>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                                    <button type="submit" class="theme-btn" name="submit-form">
                                                        Update Profile
                                                        <span></span><span></span><span></span><span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
   
                           <section class="contact-section mt-5">
                                <div class="auto-container">
                                    <div class="sec-title mb_10">
                                        <h3>Update Password</h3>
                                        <p>Change your account password securely</p>
                                    </div>
                                    <div class="form-inner">
                                        <form method="POST" action="{{ route('customer.profile.password') }}" id="password-form">
                                            @csrf
                                            <div class="row clearfix">

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="password" name="current_password" placeholder="Current Password" class="form-control" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="password" name="password" placeholder="New Password" class="form-control" required>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                    <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="form-control" required>
                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                                    <button type="submit" class="theme-btn" name="submit-form">
                                                        Update Password
                                                        <span></span><span></span><span></span><span></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </section>
                            </div>
                            
                          <div class="tab" id="tab-3">
                            <h3>Order History</h3>
                            <div class="history-box" style="max-height:800px; overflow-y:auto;">
                                @forelse($orders as $order)
                                    <div class="single-history" style="width:100%; border:1px solid #ddd; padding:10px; margin-bottom:10px; border-radius:5px;">
                                        
                                        <div class="order-info" style="display:flex; justify-content:space-between; align-items:center;">
                                            <div>
                                                <h6>Order #{{ $order->order_number }}</h6>
                                                <p><strong>Placed on:</strong> {{ $order->created_at->format('d M, Y') }}</p>
                                                <p><strong>Status:</strong> 
                                                    @if($order->status == 'pending')
                                                        <span style="color:orange;">Pending</span>
                                                    @elseif($order->status == 'completed')
                                                        <span style="color:green;">Completed</span>
                                                    @elseif($order->status == 'canceled')
                                                        <span style="color:red;">Canceled</span>
                                                    @endif
                                                </p>
                                                <p><strong>Total:</strong> Rs. {{ number_format($order->total,2) }}</p>
                                            </div>
                                            <div class="ms-5">
                                                <a href="{{ route('customer.order.track', $order->id) }}" 
                                                class="theme-btn" style="padding:5px 10px; font-size:14px;">Track Order
                                             <span></span><span></span><span></span><span></span></a>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="order-items" style="text-align:right;">
                                            @foreach($order->items as $item)
                                                <p>{{ $item->product->name ?? 'Product' }} x {{ $item->quantity }} - Rs. {{ number_format($item->subtotal,2) }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <div class="single-history">No Orders</div>
                                @endforelse
                            </div>
                        </div>
                            <div class="tab" id="tab-4">
                                <h3>Wishlist</h3>
                                <p>No Wishlist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- account-section end -->

 @endsection