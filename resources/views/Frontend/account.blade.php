@extends('Frontend.master')

@section('title', 'Account')

@section('content')

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
            <div class="auto-container">
                <div class="inner-container">
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
                                <li class="tab-btn" data-tab="#tab-4">Wishlist</li>
                            </ul>
                        </div>
                        <div class="tabs-content">
                            <div class="tab active-tab" id="tab-1">
                                <div class="personal-info">
                                    <h3>Personal Information</h3>
                                    <p>Manage your personal information, including phone numbers and email adress where you can be contacted</p>
                                    <div class="row clearfix">
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Name</h6>
                                                <span>{{ $customer->first_name}} {{ $customer->last_name}}</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>

                                         <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Email</h6>
                                                <span>{{ $customer->email}} </span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Contact Number</h6>
                                                <span><a href="tel:{{ $customer->phone}}">{{ $customer->phone}}</a></span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab" id="tab-3">
                                <h3>Order History</h3>
                                <div class="history-box">
                                    <div class="single-history">
                                        <!--<div class="product-box">
                                            <figure class="image-box"><img src="frontend/assets/images/resource/history-1.png" alt=""></figure>
                                            <div class="product-info">
                                                <h6>Advance 10w30 full synthetic fuel</h6>
                                                <span>#X469626</span>
                                                <h4>LKR 33.99</h4>
                                            </div>
                                        </div>
                                        <span class="text">Delivered</span>-->
                                        No Orders
                                    </div>
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