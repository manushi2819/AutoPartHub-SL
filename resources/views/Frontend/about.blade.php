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
                            <div class="text-box mb_30">
                                <h2>We are a retail business in automotive parts and accessories</h2>
                                <p>Garaze Auto Parts, with a rich legacy spanning 12 years, stands as a venerable online destination for automotive enthusiasts seeking a diverse range of high-quality vehicle components.</p>
                                <p>All components featured in their inventory undergo rigorous quality checks to meet or exceed industry standards, instilling confidence in customers regarding the reliability of their purchases.</p>
                            </div>
                            <div class="inner-box">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                        <div class="single-item">
                                            <div class="image-box">
                                                <figure class="image"><img src="frontend/assets/images/resource/Wheel-1.png" alt=""></figure>
                                            </div>
                                            <h3>08 M+</h3>
                                            <span>Differents Parts</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 single-column">
                                        <div class="single-item">
                                            <div class="image-box">
                                                <ul class="clients-list">
                                                    <li><img src="frontend/assets/images/resource/clients-1.png" alt=""></li>
                                                    <li><img src="frontend/assets/images/resource/clients-2.png" alt=""></li>
                                                    <li><img src="frontend/assets/images/resource/clients-3.png" alt=""></li>
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
                            <figure class="image image-1"><img src="frontend/assets/images/resource/about-1.jpg" alt=""></figure>
                            <figure class="image image-2"><img src="frontend/assets/images/resource/about-2.jpg" alt=""></figure>
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


        <!-- clients-section -->
        <section class="clients-section">
            <div class="outer-container">
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-1.png" alt=""></a></div>
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-2.png" alt=""></a></div>
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-3.png" alt=""></a></div>
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-4.png" alt=""></a></div>
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-5.png" alt=""></a></div>
                <div class="clients-logo"><a href="about.html"><img src="frontend/assets/images/brands/clients-3.png" alt=""></a></div>
            </div>
        </section>
        <!-- clients-section end -->


        <!-- highlights-style-two -->
        <section class="highlights-style-two centred pt_80 pb_45">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-22"></i></div>
                                <h3>Free Shipping</h3>
                                <p>Include information about free shipping in your email campaigns to keep existing customers informed and attract new ones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-24"></i></div>
                                <h3>Earn Points</h3>
                                <p>Include information about free shipping in your email campaigns to keep existing customers informed and attract new ones.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 highlights-block">
                        <div class="highlights-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-23"></i></div>
                                <h3>Money Back Guarantee</h3>
                                <p>Include information about free shipping in your email campaigns to keep existing customers informed and attract new ones.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- highlights-style-two end -->


        <!-- feature-section -->
        <section class="feature-section about-page pb_40">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <span class="text hot">Hot Sale</span>
                                <h2><a href="shop-details.html">Premium oils</a></h2>
                                <h4 class="discount">Up to 35% Off</h4>
                                <div class="btn-box"><a href="shop-details.html" class="theme-btn">Shop now <span></span><span></span><span></span><span></span></a></div>
                                <figure class="image"><img src="frontend/assets/images/resource/feature-11.png" alt=""></figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 feature-block">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <span class="hot-product">Stock Clear</span>
                                <h2><a href="shop-details.html">Cheap Brakes</a></h2>
                                <h4>From $23.99</h4>
                                <div class="btn-box"><a href="shop-details.html" class="theme-btn">Shop now <span></span><span></span><span></span><span></span></a></div>
                                <figure class="image"><img src="frontend/assets/images/resource/feature-12.png" alt=""></figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- feature-section end -->


        <!-- testimonial-section -->
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
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-3.png" alt=""></figure>
                                <h4>Courtney Henry</h4>
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
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-3.png" alt=""></figure>
                                <h4>Courtney Henry</h4>
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
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-3.png" alt=""></figure>
                                <h4>Courtney Henry</h4>
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
                                <figure class="author-thumb"><img src="frontend/assets/images/resource/testimonial-3.png" alt=""></figure>
                                <h4>Courtney Henry</h4>
                                <span class="designation">UI Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- testimonial-section end -->


        <!-- instagram-section -->
        <section class="instagram-section">
            <div class="outer-container">
                <div class="instagram-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-1.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-2.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-3.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-4.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-5.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                    <div class="instagram-block-one">
                        <div class="inner-box">
                            <figure class="image-box"><img src="frontend/assets/images/resource/instagram-6.jpg" alt=""></figure>
                            <div class="text-box">
                                <a href="index-3.html"><img src="frontend/assets/images/icons/icon-1.png" alt="">Follow us on Instagram</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- instagram-section end -->
 @endsection