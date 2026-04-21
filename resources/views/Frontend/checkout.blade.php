@extends('Frontend.master')

@section('title', 'Checkout')

@section('content')

<style>
     /* Page Title */
    .cart-title {
        text-align: center;
    }

    .cart-title h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--primary-black);
        letter-spacing: -0.02em;
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .cart-title h1:after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-red);
    }
</style>

<!-- page-title -->
<section class="page-title-two centred">
    <div class="auto-container">
        <div class="content-box cart-title">
            <h1>Checkout</h1>
        </div>
    </div>
</section>
<!-- page-title end -->

<!-- checkout-section -->
<section class="checkout-section pb_80">
    <div class="auto-container">
        <div class="row clearfix">

            <!-- Billing Details -->
            <div class="col-lg-7 col-md-12 col-sm-12 billing-column">
                
                <div class="billing-content order-info">
                    <h3>Billing Details</h3>
                    <div class="form-inner">
                        <form method="POST" action="{{ route('Frontend.checkout.process') }}">
                            @csrf
                            <div class="row clearfix">

                                <!-- First Name -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="fname" value="{{ $customer->first_name ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="lname" value="{{ $customer->last_name ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Email Address<span>*</span></label>
                                        <input type="email" name="email" value="{{ $customer->email ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Phone Number<span>*</span></label>
                                        <input type="text" name="phone" value="{{ $customer->phone ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-lg-12 col-md-12 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Country<span>*</span></label>
                                        <input type="hidden" name="country" value="Sri Lanka">
                                        <input type="text" class="form-control" value="Sri Lanka" readonly>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-lg-12 col-md-12 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Address<span>*</span></label>
                                        <input type="text" name="address" value="{{ $customer->address ?? '' }}" required>
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Town / City<span>*</span></label>
                                        <input type="text" name="city" required>
                                    </div>
                                </div>

                                <!-- ZIP -->
                                <div class="col-lg-6 col-md-6 col-sm-12 field-column">
                                    <div class="form-group">
                                        <label>Postcode / ZIP<span>*</span></label>
                                        <input type="text" name="zip" required>
                                    </div>
                                </div>

                            </div>

                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-5 col-md-12 col-sm-12 order-column ">
                <div class="order-box order-info">
                    <h3>Order Summary</h3>
                    <div class="">

                        <div class="title-box">
                            <span class="text">Product</span>
                            <span class="text">Total</span>
                        </div>

                        <div class="order-product">
                            @foreach($cartItems as $item)
                                <div class="single-item">
                                    <div class="product-box">
                                        <figure class="image-box" style="width: 60px; height: 60px;">
                                            <img src="{{ asset('uploads/' . ($item->product->images->first()->image_url ?? 
                                            'assets/images/shop/checkout-1.png')) }}" alt="" style="object-fit: cover;">
                                        </figure>
                                        <h6>{{ $item->product->name ?? 'Product Name' }} 
                                            <span>x {{ $item->quantity }}</span>
                                        </h6>
                                    </div>
                                    <h6 style="color: black">
                                        Rs. {{ number_format($item->quantity * $item->price, 2) }}</h6>
                                </div>
                            @endforeach
                        </div>

                        <ul class="cost-box">
                            <li>
                                <h4><span>Subtotal</span></h4>
                                <h6 style="color: black">Rs. {{ number_format($subtotal, 2) }}</h6>
                            </li>
                            <li>
                                <h4><span>Discount</span></h4>
                                <h6 style="color: black"><span>Rs. 0</span></h6>
                            </li>
                        </ul>

                        <div class="total-box">
                            <h4><span>Total</span></h4>
                            <h5 style="color: #1fad0f">Rs. {{ number_format($total, 2) }}</h5>
                        </div>

                        <!-- Payment Options -->
                        <div class="payment-option">
                            <ul class="other-payment">
                                <li>
                                    <div class="check-box mb_12">
                                        <input class="check" type="radio" id="cod" name="payment_method" value="cod" checked>
                                        <label for="cod">Cash on Delivery</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="check-box mb_12">
                                        <input class="check" type="radio" id="card" name="payment_method" value="card">
                                        <label for="card">Credit/Debit Cards</label>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="btn-box pt_30">
                            <button type="submit" class="theme-btn">
                                Place the Order
                                <span></span><span></span><span></span><span></span>
                            </button>
                        </div>

                    </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- checkout-section end -->

@endsection