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


        <!-- account-section -->
        <section class="account-section pb_80">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="tabs-box">
                        <div class="account-info">
                            <div class="upper-box centred mb_40">
                                <figure class="image-box"><img src="frontend/assets/images/resource/account-1.png" alt=""></figure>
                                <h4>Ridoy Rock</h4>
                                <a href="mailto:rodiyrock11@gmail.com">rodiyrock11@gmail.com</a>
                            </div>
                            <ul class="tab-btns tab-buttons clearfix">
                                <li class="tab-btn active-btn" data-tab="#tab-1">Personal Information</li>
                                <li class="tab-btn" data-tab="#tab-2">Billing and Payments</li>
                                <li class="tab-btn" data-tab="#tab-3">Oder History</li>
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
                                                <span>Ridoy Rock</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Date of Birth</h6>
                                                <span>02 July 2000</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Country Region</h6>
                                                <span>02 July 2000</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Number</h6>
                                                <span>1213456789</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Language</h6>
                                                <span>English ( UK ) - English</span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-sm-12 single-column">
                                            <div class="single-item">
                                                <h6>Contact at</h6>
                                                <span><a href="mailto:rodiyrock11@gmail.com">rodiyrock11@gmail.com</a></span>
                                                <button type="button">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab" id="tab-2">
                                <h3>Billing and Payments</h3>
                                <div class="payment-option">
                                    <div class="bank-payment">
                                        <div class="check-box mb_12">
                                            <input class="check" type="radio" id="checkbox3" name="same" checked="">
                                            <label for="checkbox3">Direct Bank Transfer</label>
                                        </div>
                                        <p>Make your payment directly into our bank account. Please use your Order ID as payment reference.</p>
                                    </div>
                                    <ul class="other-payment">
                                        <li>
                                            <div class="check-box mb_12">
                                                <input class="check" type="radio" id="checkbox4" name="same">
                                                <label for="checkbox4">Cash on Delivery</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box mb_12">
                                                <input class="check" type="radio" id="checkbox5" name="same">
                                                <label for="checkbox5">Credit/Debit Cards or Paypal</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab" id="tab-3">
                                <h3>Oder History</h3>
                                <div class="history-box">
                                    <div class="single-history">
                                        <div class="product-box">
                                            <figure class="image-box"><img src="frontend/assets/images/resource/history-1.png" alt=""></figure>
                                            <div class="product-info">
                                                <h6>Advance 10w30 full synthetic fuel</h6>
                                                <span>#X469626</span>
                                                <h4>$33.99</h4>
                                            </div>
                                        </div>
                                        <span class="text">Delivered</span>
                                    </div>
                                    <div class="single-history">
                                        <div class="product-box">
                                            <figure class="image-box"><img src="frontend/assets/images/resource/history-2.png" alt=""></figure>
                                            <div class="product-info">
                                                <h6>High-Performance Brake Kit for Your Car</h6>
                                                <span>#X469625</span>
                                                <h4>$45.99</h4>
                                            </div>
                                        </div>
                                        <span class="text">Delivered</span>
                                    </div>
                                    <div class="single-history">
                                        <div class="product-box">
                                            <figure class="image-box"><img src="frontend/assets/images/resource/history-3.png" alt=""></figure>
                                            <div class="product-info">
                                                <h6>Car Remote Key for Xhorse XKTO10EN</h6>
                                                <span>#X469629</span>
                                                <h4>$66.99</h4>
                                            </div>
                                        </div>
                                        <span class="text">Delivered</span>
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