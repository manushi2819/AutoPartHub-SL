@extends('Frontend.master')

@section('title', 'About')

@section('content')

    <!-- page-title -->
        <section class="page-title">
            <div class="auto-container">
                <div class="content-box">
                    <div class="border-line"></div>
                    <ul class="bread-crumb">
                        <li><a href="index.html">Home</a></li>
                        <li>About Us</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page-title end -->


        <!-- about-section -->
        <section class="about-section pt_80 pb_80">
            <div class="auto-container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                        <div class="about-content mr_15">
                          <div class="text-box mb_30" >
                                <h2>Your One-Stop Marketplace for Vehicles and Auto Parts</h2>
                                <p style="text-align:justify">AutoPartHub SL offers a wide range of high-quality vehicle parts and accessories, along with a curated selection of cars for sale. With years of experience in the automotive industry, we ensure every product and vehicle meets rigorous quality standards.</p>
                                <p style="text-align:justify">Whether you're upgrading your car, replacing parts, or looking for your next vehicle, our platform provides a reliable and convenient solution for automotive enthusiasts and everyday drivers alike.</p>
                            </div>
                            <div class="inner-box">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                        <div class="single-item">
                                            <div class="image-box">
                                                <figure class="image"><img src="{{ asset('frontend/assets/images/resource/Wheel-1.png') }}" alt=""></figure>
                                            </div>
                                            <h3>08 M+</h3>
                                            <span>Differents Parts</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                        <div class="single-item">
                                            <div class="image-box">
                                                <ul class="clients-list">
                                                    <li><img src="{{ asset('frontend/assets/images/resource/clients-1.png') }}" alt=""></li>
                                                    <li><img src="{{ asset('frontend/assets/images/resource/clients-2.png') }}" alt=""></li>
                                                    <li><img src="{{ asset('frontend/assets/images/resource/clients-3.png') }}" alt=""></li>
                                                </ul>
                                            </div>
                                            <h3>10 M+</h3>
                                            <span>Happy Clients</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                        <div class="about-image ml_15">
                            <figure class="image image-1"><img src="{{ asset('frontend/assets/images/about3.jpg') }}" alt=""></figure>
                            <figure class="image image-2"><img src="{{ asset('frontend/assets/images/about1.jpg') }}" alt="" style="width:420px"></figure>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-section end -->


        <!-- video-section -->
        <section class="video-section centred">
            <div class="bg-layer parallax-bg" data-parallax='{"y": 100}' style="background-image: url(frontend/assets/images/background/video-bg.jpg);"></div>
            <div class="auto-container">
                <div class="video-btn">
                    <a href="https://www.youtube.com/watch?v=nfP5N9Yc72A&amp;t=28s" class="lightbox-image" data-caption="">
                        <i class="fas fa-play"></i>
                        <span class="border-animation border-1"></span>
                        <span class="border-animation border-2"></span>
                        <span class="border-animation border-3"></span>
                    </a>
                </div>
            </div>
        </section>
        <!-- video-section end -->


       <!-- highlights-style-two -->
        <section class="highlights-style-two centred pt_80 pb_45">
            <div class="auto-container">
                <div class="row clearfix">
                    <!-- Fast & Reliable Delivery -->
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-5"></i></div>
                                <h3>Fast & Reliable Delivery</h3>
                                <p>Get your auto parts and vehicle orders delivered quickly and safely, ensuring you never wait long to get back on the road.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Loyalty Rewards -->
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-24"></i></div>
                                <h3>Loyalty Rewards</h3>
                                <p>Earn points on every purchase of car parts or vehicles and redeem them for discounts on future orders.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quality Assurance -->
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-23"></i></div>
                                <h3>Quality Assurance</h3>
                                <p>All vehicles and parts undergo strict quality checks to ensure you receive reliable, durable, and top-performing products.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- highlights-style-two end -->



        <!-- testimonial-section 
        <section class="testimonial-section pb_70">
            <div class="auto-container">
                <div class="sec-title centred mb_30">
                    <h2>Love from Clients</h2>
                </div>
                <div class="three-item-carousel owl-carousel owl-theme dots-style-one owl-nav-none">
                    <div class="testimonial-block-one">
                        <div class="inner-box">
                            <ul class="rating">
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li class="light"><i class="icon-29"></i></li>
                            </ul>
                            <p>“Suspendisse est imperdiet pellentesque nulla vulputate eu pharetra pharetra massa amet ac semper et pellentesque dolor tincidunt sodales”</p>
                            <div class="author-box">
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-1.png" alt=""></figure>
                                <h4>Floyd Miles</h4>
                                <span class="designation">UI Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-block-one">
                        <div class="inner-box">
                            <ul class="rating">
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li><i class="icon-29"></i></li>
                                <li class="light"><i class="icon-29"></i></li>
                            </ul>
                            <p>“Suspendisse est imperdiet pellentesque nulla vulputate eu pharetra pharetra massa amet ac semper et pellentesque dolor tincidunt sodales”</p>
                            <div class="author-box">
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-2.png" alt=""></figure>
                                <h4>Cody Fisher</h4>
                                <span class="designation">UI Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
         testimonial-section end -->


        <!-- instagram-section -->
        <section class="instagram-section">
            <div class="outer-container">
                <div class="instagram-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/ab1.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/ab2.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/ab3.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/ab4.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/about2.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/about1.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-4.png" alt="">Follow us on Facebook</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- instagram-section end -->
 @endsection