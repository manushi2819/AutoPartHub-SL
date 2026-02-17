@extends('Frontend.master')

@section('title', 'Shop')

@section('content')

      


        <!-- page-title -->
        <section class="page-title">
            <div class="auto-container">
                <div class="content-box">
                    <ul class="bread-crumb">
                        <li><a href="index.html">Home</a></li>
                        <li>Shop</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page-title end -->


        <!-- cta-style-two -->
        <section class="cta-style-two pb_0">
            <div class="auto-container">
                <div class="inner-container">
                    <figure class="image-layer"><img src="frontend/assets/images/resource/cta-1.png" alt=""></figure>
                    <div class="content-box">
                        <span class="text">Engine Oil</span>
                        <h2>Elevate Your Drive Authenticity. Get <span>Original Car Parts</span></h2>
                        <p>Fulfill your automotive fantasies without breaking the bank.</p>
                        <a href="index-4.html" class="theme-btn">Get All Deals <span></span><span></span><span></span><span></span></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- cta-style-two end -->


        <!-- shop-page-section -->
        <section class="shop-page-section shop-style-two pt_60 pb_80">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-12 col-sm-12 sidebar-side">
                        <div class="shop-sidebar">
                            <div class="search-widget sidebar-widget pb_40 mb_40">
                                <div class="widget-title mb_30">
                                    <h3>Select Vehicle</h3>
                                </div>
                                <div class="search-inner">
                                    <form method="post" action="shop.html">
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Select Year">Select Year</option>
                                                   <option value="1">2021</option>
                                                   <option value="2">2022</option>
                                                   <option value="3">2023</option>
                                                   <option value="4">2024</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Select Brand">Select Brand</option>
                                                   <option value="1">Audi</option>
                                                   <option value="2">BMW</option>
                                                   <option value="3">Mercedes Benz</option>
                                                   <option value="4">Tesla Motors</option>
                                                   <option value="5">Volkswagen</option>
                                                   <option value="6">Porsche</option>
                                                   <option value="7">Hyundai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Car Model">Car Model</option>
                                                   <option value="1">2021</option>
                                                   <option value="2">2022</option>
                                                   <option value="3">2023</option>
                                                   <option value="4">2024</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Select Engine">Select Engine</option>
                                                   <option value="1">1000 cc</option>
                                                   <option value="2">1500 cc</option>
                                                   <option value="3">2000 cc</option>
                                                   <option value="4">3000 cc</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Fuel Type">Fuel Type</option>
                                                   <option value="1">Diesel</option>
                                                   <option value="2">Biodiesel</option>
                                                   <option value="3">Gasoline</option>
                                                   <option value="4">Ethanol</option>
                                                   <option value="5">Natural gas</option>
                                                   <option value="6">Octane gasoline</option>
                                                   <option value="7">Lpg</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="select-box">
                                                <select class="wide">
                                                   <option data-display="Engine Type">Engine Type</option>
                                                   <option value="1">Diesel</option>
                                                   <option value="2">Biodiesel</option>
                                                   <option value="3">Gasoline</option>
                                                   <option value="4">Ethanol</option>
                                                   <option value="5">Natural gas</option>
                                                   <option value="6">Octane gasoline</option>
                                                   <option value="7">Lpg</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="message-btn">
                                            <button type="submit" class="theme-btn">Search Part<span></span><span></span><span></span><span></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="category-widget sidebar-widget pb_40 mb_40">
                                <div class="widget-title mb_30">
                                    <h3>Categories</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="accordion-box">
                                        <li class="accordion block active-block">
                                            <div class="acc-btn active"><div class="icon-box"></div>Light & Optics</div>
                                            <div class="acc-content current">
                                                <ul class="category-list clearfix">
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox1">
                                                            <label for="checkbox1">LED Light</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox2">
                                                            <label for="checkbox2">Tail Light</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox3">
                                                            <label for="checkbox3">Halogen Light</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="accordion block">
                                            <div class="acc-btn"><div class="icon-box"></div>Braking System</div>
                                            <div class="acc-content">
                                                <ul class="category-list clearfix">
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox4">
                                                            <label for="checkbox4">ABS Brake</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox5">
                                                            <label for="checkbox5">Hydralic Brake</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox6">
                                                            <label for="checkbox6">Anti- lock Brake</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="accordion block">
                                            <div class="acc-btn"><div class="icon-box"></div>Exhaust System</div>
                                            <div class="acc-content">
                                                <ul class="category-list clearfix">
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox7">
                                                            <label for="checkbox7">Deep Dish Exhaust</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox8">
                                                            <label for="checkbox8">Mesh Pattern Exhaust</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="check-box">
                                                            <input class="check" type="checkbox" id="checkbox9">
                                                            <label for="checkbox9">Split-Spoke Exhaust</label>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="category-list clearfix">
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox10">
                                                <label for="checkbox10">Cooling System</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox11">
                                                <label for="checkbox11">Car Wheels</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox12">
                                                <label for="checkbox12">Exterior Parts</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox13">
                                                <label for="checkbox13">Oil Filters</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox14">
                                                <label for="checkbox14">Wheel Rims</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox15">
                                                <label for="checkbox15">Steel Rim</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox16">
                                                <label for="checkbox16">Piston Rod</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="filter-widget sidebar-widget pb_50 mb_40">
                                <div class="widget-title mb_30">
                                    <h3>Filter by Price</h3>
                                </div>
                                <div class="price-range-slider">
                                    <div id="slider-range" class="range-bar"></div>
                                    <p class="range-value">
                                        <span>Price:</span>
                                        <input type="text" id="amount" readonly>
                                    </p>
                                    <div class="btn-box">
                                        <button type="button" class="clear-btn">Clear</button>
                                        <button type="button" class="theme-btn filter-btn">Apply<span></span><span></span><span></span><span></span></button>
                                    </div>
                                </div>
                            </div>
                           
                           
                            <div class="review-widget sidebar-widget">
                                <div class="widget-title mb_25">
                                    <h3>Reviews</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="category-list clearfix">
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox29">
                                                <label for="checkbox29"><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox30">
                                                <label for="checkbox30"><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29 light"></i></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox31">
                                                <label for="checkbox31"><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29 light"></i><i class="icon-29 light"></i></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox32">
                                                <label for="checkbox32"><i class="icon-29"></i><i class="icon-29"></i><i class="icon-29 light"></i><i class="icon-29 light"></i><i class="icon-29 light"></i></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="check-box">
                                                <input class="check" type="checkbox" id="checkbox33">
                                                <label for="checkbox33"><i class="icon-29"></i><i class="icon-29 light"></i><i class="icon-29 light"></i><i class="icon-29 light"></i><i class="icon-29 light"></i></label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                        <div class="our-shop">
                            <div class="item-shorting">
                                <div class="left-column">
                                    <div class="text"><p>Showing <span>1–30</span> of <span>160</span> results</p></div>
                                </div>
                                
                            </div>
                            <div class="wrapper grid">
                                <div class="shop-grid-content">
                                    <div class="row clearfix">
                                        <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                                            <div class="shop-block-one">
                                                <div class="inner-box">
                                                    <div class="image-box">
                                                        <ul class="option-list-two">
                                                            
                                                            <li><button type="button"><i class="icon-7"></i></button></li>
                                                        </ul>
                                                        <figure class="image"><img src="frontend/assets/images/shop/shop-88.png" alt=""></figure>
                                                    </div>
                                                    <div class="lower-content">
                                                        <span class="text">Interior</span>
                                                        <h4><a href="shop-details.html">Fuel Filter Nitro Engine Parts</a></h4>
                                                        <h5><del>$70.99</del> $66.99</h5>
                                                        <ul class="rating"> 
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><span>(4)</span></li>
                                                        </ul>
                                                        <span class="product-stock"><i class="icon-39"></i>In Stock</span>
                                                        <div class="overlay-content">
                                                            <ul class="feature-list clearfix">
                                                                <li>Fully tested, & Functional</li>
                                                                <li>Up to 200MB/s Speed</li>
                                                                <li>With Bluetooth Full Touch</li>
                                                            </ul>
                                                            <div class="cart-btn">
                                                                <button type="button" class="theme-btn">Add to Cart
                                                                    <span></span><span></span><span></span><span></span></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                                            <div class="shop-block-one">
                                                <div class="inner-box">
                                                    <div class="image-box">
                                                        <div class="discount-product">6% Off</div>
                                                        <ul class="option-list-two">
                                                           
                                                            <li><button type="button"><i class="icon-7"></i></button></li>
                                                        </ul>
                                                        <figure class="image"><img src="frontend/assets/images/shop/shop-89.png" alt=""></figure>
                                                    </div>
                                                    <div class="lower-content">
                                                        <span class="text">Interior</span>
                                                        <h4><a href="shop-details.html">Starting a car with a manual transmission</a></h4>
                                                        <h5><del>$56.99</del> $55.99</h5>
                                                        <ul class="rating"> 
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><span>(5)</span></li>
                                                        </ul>
                                                        <span class="product-stock"><i class="icon-39"></i>In Stock</span>
                                                        <div class="overlay-content">
                                                            <ul class="feature-list clearfix">
                                                                <li>Fully tested, & Functional</li>
                                                                <li>Up to 200MB/s Speed</li>
                                                                <li>With Bluetooth Full Touch</li>
                                                            </ul>
                                                            <div class="cart-btn"><button type="button" class="theme-btn">Add to Cart<span></span><span></span><span></span><span></span></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                                            <div class="shop-block-one">
                                                <div class="inner-box">
                                                    <div class="image-box">
                                                        <div class="discount-product">6% Off</div>
                                                        <ul class="option-list-two">
                                                          
                                                            <li><button type="button"><i class="icon-7"></i></button></li>
                                                        </ul>
                                                        <figure class="image"><img src="frontend/assets/images/shop/shop-90.png" alt=""></figure>
                                                    </div>
                                                    <div class="lower-content">
                                                        <span class="text">Interior</span>
                                                        <h4><a href="shop-details.html">Advance 10w30 full synthetic fuel</a></h4>
                                                        <h5><del>$90.99</del> $85.99</h5>
                                                        <ul class="rating"> 
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><span>(5)</span></li>
                                                        </ul>
                                                        <span class="product-stock"><i class="icon-39"></i>In Stock</span>
                                                        <div class="overlay-content">
                                                            <ul class="feature-list clearfix">
                                                                <li>Fully tested, & Functional</li>
                                                                <li>Up to 200MB/s Speed</li>
                                                                <li>With Bluetooth Full Touch</li>
                                                            </ul>
                                                            <div class="cart-btn"><button type="button" class="theme-btn">Add to Cart<span></span><span></span><span></span><span></span></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                                            <div class="shop-block-one">
                                                <div class="inner-box">
                                                    <div class="image-box">
                                                        <span class="discount-product">6% Off</span>
                                                        <ul class="option-list-two">
                                                          
                                                            <li><button type="button"><i class="icon-7"></i></button></li>
                                                        </ul>
                                                        <figure class="image"><img src="frontend/assets/images/shop/shop-85.png" alt=""></figure>
                                                    </div>
                                                    <div class="lower-content">
                                                        <span class="text">Interior</span>
                                                        <h4><a href="shop-details.html">Steering a car with a manual Wheel</a></h4>
                                                        <h5><del>$92.99</del>$83.99</h5>
                                                        <ul class="rating"> 
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><span>(5)</span></li>
                                                        </ul>
                                                        <span class="product-stock"><i class="icon-39"></i>In Stock</span>
                                                        <div class="overlay-content">
                                                            <ul class="feature-list clearfix">
                                                                <li>Fully tested, & Functional</li>
                                                                <li>Up to 200MB/s Speed</li>
                                                                <li>With Bluetooth Full Touch</li>
                                                            </ul>
                                                            <div class="cart-btn"><button type="button" class="theme-btn">Add to Cart<span></span><span></span><span></span><span></span></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       
                                </div>
                            </div>
                            <div class="pagination-wrapper centred pt_20">
                                <ul class="pagination clearfix">
                                    <li><a href="shop.html"><i class="fal fa-angle-left"></i></a></li>
                                    <li><a href="shop.html" class="current">1</a></li>
                                    <li><a href="shop.html">2</a></li>
                                    <li><a href="shop.html">3</a></li>
                                    <li><a href="shop.html"><i class="fal fa-angle-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-page-section end -->



 

 @endsection