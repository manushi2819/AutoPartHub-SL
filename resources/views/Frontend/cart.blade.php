@extends('Frontend.master')

@section('title', 'Cart')

@section('content')

      <!-- page-title -->
        <section class="page-title-two centred">
            <div class="auto-container">
                <div class="content-box">
                    <h1>Your Cart</h1>
                </div>
            </div>
        </section>
        <!-- page-title end -->


        <!-- cart section -->
        <section class="cart-section pb_80">
            <div class="auto-container">
                <div class="table-outer mb_30">
                    <table class="cart-table">
                        <thead class="cart-header">
                            <tr>
                                <th>product</th>
                                <th>color</th>
                                <th>size</th>
                                <th>price</th>
                                <th>quantity</th>
                                <th>total</th>
                                <th>&nbsp;</th>
                            </tr>    
                        </thead>
                        <tbody>
                            <tr>
                                <td class="product-column">
                                    <div class="product-box">
                                        <figure class="image-box"><img src="assets/images/shop/cart-1.png" alt=""></figure>
                                        <h6><a href="shop-details.html">Car LED Strip LED Headlight</a></h6>    
                                    </div>
                                </td>
                                <td><span class="color black"></span></td>
                                <td>Medium</td>
                                <td>$133</td>
                                <td class="qty">
                                    <div class="item-quantity">
                                        <input class="quantity-spinner" type="text" value="2" name="quantity">
                                    </div>
                                </td>
                                <td>$266</td>
                                <td><button class="cancel-btn"><i class="icon-38"></i></button></td>
                            </tr>
                           
                        </tbody>    
                    </table>
                </div>
                <div class="lower-content">
                    <div class="row clearfix">
                        <div class="col-lg-8 col-md-12 col-sm-12 coupon-column">
                            <div class="coupon-box">
                                <div class="form-group">
                                    <input type="text" name="" placeholder="Apply Coupon">
                                    <button type="button"><i class="icon-27"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 cart-column">
                            <div class="total-cart">
                                <div class="title-box">
                                    <h4>Subtotal</h4>
                                    <h5>LKR 770.00</h5>
                                </div>

                                <div class="title-box">
                                    <h4>Discount</h4>
                                    <h5>(LKR 50.00)</h5>
                                </div>
                               
                               
                                <div class="total-box">
                                    <h4>Total</h4>
                                    <h5>LKR 720.00</h5>
                                </div>
                                <div class="btn-box">
                                    <a href="{{ route('Frontend.checkout') }}" class="theme-btn" type="button">Proceed to Checkout<span></span><span></span><span></span><span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart section end -->


   
 @endsection