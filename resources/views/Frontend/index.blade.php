@extends('Frontend.master')

@section('title', 'Home')

@section('content')


<style>

.content-one .inner-box h2,
.content-one .inner-box h3 {
    margin-bottom: 38px; 
}

/* Banner container */
.content-block .banner {
    width: 1000px!important;
    height: 490px !important;
    background-size: cover !important;   
    background-position: center center !important;
    background-repeat: no-repeat !important;
}

/* Tablet */
@media (max-width: 768px) {
    .content-block .banner {
        height: 200px !important;
    }
}

/* Mobile */
@media (max-width: 480px) {
    .content-block .banner {
        height: 150px !important;
    }
}

/* Mobile Responsiveness for Banner Slider */

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
  
  /* Fix carousel container height */
  #bannerSlider {
    height: 180px !important;
    overflow: hidden;
  }
  
  /* Make banner images cover area properly on mobile */
  #bannerSlider .carousel-inner,
  #bannerSlider .carousel-item {
    height: 180px !important;
  }
  
  /* Ensure background images scale correctly */
  #bannerSlider .banner {
    background-size: cover !important;
    background-position: center center !important;
    background-repeat: no-repeat !important;
    height: 180px !important;
    width: 100% !important;
  }

}

/* Small devices (phones, 768px and down) */
@media only screen and (max-width: 768px) {
  #bannerSlider .banner {
    background-size: contain !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
  }
}

/* Extra small devices (phones, 576px and down) */
@media only screen and (max-width: 576px) {
  #bannerSlider .banner {
    background-size: contain !important;
    background-repeat: no-repeat !important;
    background-position: center center !important;
  }
}/* Mobile Responsive - Banner Image Size Only */

@media only screen and (max-width: 768px) {
  #bannerSlider .banner {
    background-size: cover !important;
    background-position: center center !important;
  }
}

.nice-select .list {
    max-height: 300px !important;
    overflow-y: auto !important;
}
</style>

      
        <!-- banner-style-two -->
        <section class="banner-style-two home-5 pt_20 pb_10 p_relative">
            <div class="pattern-layer" style="background-image: url(frontend/assets/images/shape/shape-6.png);"></div>
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-9 col-md-12 col-sm-12 content-block">
                        <div id="bannerSlider" 
                            class="carousel slide" 
                            data-bs-ride="carousel" 
                            data-bs-interval="3000">

                            <!-- Indicators -->
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#bannerSlider" data-bs-slide-to="2"></button>
                            </div>

                            <!-- Slides -->
                            <div class="carousel-inner">

                                <div class="carousel-item active">
                                    <div class="content-one content-box banner"
                                        style="background-image: url('{{ asset('frontend/assets/images/banner2.png') }}'); ">
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="content-one content-box banner"
                                        style="background-image: url('{{ asset('frontend/assets/images/banner3.png') }}');">
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="content-one content-box banner"
                                        style="background-image: url('{{ asset('frontend/assets/images/banner10.png') }}'); ">
                                    </div>
                                </div>

                            </div>

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#bannerSlider" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>

                            <button class="carousel-control-next" type="button" data-bs-target="#bannerSlider" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 search-column">
                        <div class="search-inner">
                            <form method="GET" action="{{ route('Frontend.shop') }}">
                                @csrf

                                {{-- YEAR --}}
                                <div class="form-group">
                                    <div class="select-box">
                                        <select name="year" class="wide">
                                            <option value="">Select Year</option>
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- BRAND --}}
                                <div class="form-group">
                                    <div class="select-box">
                                        <select name="brand" class="wide">
                                            <option value="">Select Brand</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->name }}" {{ request('brand') == $brand->name ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- MODEL --}}
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        name="model" 
                                        value="{{ request('model') }}" 
                                        placeholder="Type Model (e.g. Corolla, Civic)"
                                        style="
                                            width:100%;
                                            padding:12px 18px;
                                            border-radius:6px;
                                            font-size:14px;
                                            background: #ffffff;
                                        "
                                    >
                                </div>

                                {{-- ENGINE CC --}}
                                <div class="form-group">
                                    <div class="select-box">
                                        <select name="engine_cc" class="wide">
                                            <option value="">Select Engine</option>
                                            @foreach($engines as $engine)
                                                <option value="{{ $engine }}" {{ request('engine_cc') == $engine ? 'selected' : '' }}>
                                                    {{ $engine }} cc
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- FUEL TYPE --}}
                                <div class="form-group">
                                    <div class="select-box">
                                        <select name="fuel_type" class="wide">
                                            <option value="">Fuel Type</option>
                                            @foreach($fuelTypes as $fuel)
                                                <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>
                                                    {{ $fuel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- ENGINE TYPE --}}
                                <div class="form-group">
                                    <div class="select-box">
                                        <select name="engine_type" class="wide">
                                            <option value="">Engine Type</option>
                                            @foreach($engineTypes as $type)
                                                <option value="{{ $type }}" {{ request('engine_type') == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="message-btn">
                                    <button type="submit" class="theme-btn">Search Part<span></span><span></span><span></span><span></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner-style-two end -->


        <!-- highlights-section -->
        <section class="highlights-section home-5 alternat-2">
            <div class="auto-container">
                <div class="inner-container">
                    <div class="shape" style="background-image: url(frontend/assets/images/shape/shape-15.png);"></div>
                    <div class="single-item">
                        <div class="icon-box"><i class="icon-30"></i></div>
                        <h5>Same day Product Delivery</h5>
                    </div>
                    <div class="single-item">
                        <div class="icon-box"><i class="icon-14"></i></div>
                        <h5>100% Customer Satisfaction</h5>
                    </div>
                    <div class="single-item">
                        <div class="icon-box"><i class="icon-15"></i></div>
                        <h5>Help and access is our mission</h5>
                    </div>
                    <div class="single-item">
                        <div class="icon-box"><i class="icon-16"></i></div>
                        <h5>100% quality Car Accessories</h5>
                    </div>
                    <div class="single-item">
                        <div class="icon-box"><i class="icon-17"></i></div>
                        <h5>24/7 Support for Clients</h5>
                    </div>
                </div>
            </div>
        </section>
        <!-- highlights-section end -->


        

        <!-- category-section -->
        <section class="category-section pt_60 pb_80">
            <div class="auto-container">
                <div class="sec-title mb_30">
                    <h4>Popular Categories</h4>
                </div>
                <div class="category-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
                    @foreach($parentCategories as $category)
                    <div class="category-block-one">
                        <div class="inner-box">
                            <figure class="image-box" style="width: 120px; height: 120px; overflow: hidden;">
                                <img src="{{ asset($category->image ?? 'assets/images/about2.jpg') }}" alt="{{ $category->name }}"
                                style=" width: 100%;height: 100%;object-fit: cover; ">
                            </figure>
                            <h4 style="font-size:16px; line-height:20px">
                                <a href="{{ route('Frontend.shop', ['category[]' => $category->id]) }}">
                                    {{ $category->name }}
                                </a>
                            </h4>
                            <span class="text">
                                {{ $category->product_count }} items
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- category-section end -->


        <!-- brand-section -->
        <section class="brand-section pt_0 pb_80">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url(frontend/assets/images/shape/shape-2.png);"></div>
                <div class="pattern-2" style="background-image: url(frontend/assets/images/shape/shape-3.png);"></div>
            </div>
            <div class="auto-container">
                <div class="sec-title mb_30">
                    <h4>Shop by Brands</h4>
                </div>
                <div class="inner-container">
                    <div class="row clearfix">
                        @foreach($brands->take(12) as $brand)
                         <div class="col-lg-2 col-md-4 col-sm-12 brand-block">
                            <div class="brand-block-one">
                                <div class="inner-box text-center">
                                <a href="{{ route('Frontend.shop', ['brand' => $brand->name]) }}">
                                    <figure class="image">
                                        <img src="{{ asset($brand->image ? 'uploads/' . $brand->image : 'assets/images/brands/brands-1.png') }}" 
                                            alt="{{ $brand->name }}"
                                            style="width: 100%; height: 50px; object-fit: contain;">
                                    </figure>
                                    <span>{{ $brand->name }}</span>
                                </a>
                            </div>
                            </div>
                        </div>
                        @endforeach
                                            
                    </div>
                </div>
            </div>
        </section>
        <!-- brand-section end -->


        <!-- shop-style-two -->
        <section class="shop-style-two pt_80 pb_70 mb-5">
        <div class="bg-layer" style="background-image: url('{{ asset('frontend/assets/images/index7.jpg') }}');"></div>
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url('{{ asset('frontend/assets/images/shape/shape-4.png') }}');"></div>
                <div class="pattern-2" style="background-image: url('{{ asset('frontend/assets/images/shape/shape-5.png') }}');"></div>
            </div>
            <div class="auto-container">
                <div class="sortable-masonry">
                    <div class="title-box mb_30">
                        <div class="sec-title">
                            <h2 >Latest Products</h2>
                        </div>
                        <ul class="filter-tabs filter-btns clearfix" >
                            <li class="active filter" data-role="button" data-filter=".all">All</li>
                            @foreach($filterCategories as $cat)
                                <li class="filter" data-role="button" data-filter=".cat-{{ $cat->id }}">
                                    {{ $cat->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="inner-container">
                        <div class="items-container row clearfix">

                            @foreach($latestProducts as $product)
                            <div class="col-lg-3 col-md-6 col-sm-12 masonry-item small-column all cat-{{ $product->parent_category_id }}">
                                <div class="shop-block-two">
                                    <div class="inner-box">
                                        <div class="image-box">
                                            @if($product->created_at >= now()->subWeeks(1))
                                                <span class="discount-product">New</span>
                                            @endif

                                             @php
                                                $mainImage = $product->images->where('is_main', 1)->first();
                                            @endphp
                                            <figure class="image" style="height: 120px; width: 120px; overflow: hidden;">
                                                <img src="{{ $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png') }}" alt="{{ $product->name }}"
                                                    style="height: 100%; width: 100%; object-fit: cover;">
                                            </figure>

                                        </div>

                                        <div class="content-box">
                                            <h6>
                                                <a href="#" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                    {{ $product->name }}
                                                </a>
                                            </h6>
                                            <ul class="rating mb_25">
                                                    @php
                                                        $avg = round($product->averageRating()); // Round to nearest whole number
                                                        $total = $product->reviewsCount();
                                                    @endphp

                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li>
                                                            <i class="icon-41" style="color: {{ $i <= $avg ? '#FFD700' : '#ccc' }}"></i>
                                                        </li>
                                                    @endfor
                                                    <li><span>({{ $total }})</span></li>
                                            </ul>
                                            <h5 style="font-size:15px">LKR {{ number_format($product->price,2) }}</h5>

                                            <div class="cart-btn">
                                                <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}" 
                                                style="color: #000000; font-size: 15px;" type="button">
                                                    Add to Cart<i class="icon-27 ms-1" style="color: #000000; font-size: 10px;"></i>
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-style-two end -->

       <!-- feature-section  -->
<section class="feature-section pb_70">
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="700">
                    <div class="inner-box">
                        <span class="text">Featured Product</span>
                        <h2><a href="shop-details.html">Buy the Tires</a></h2>
                        <h4>From LKR 19,999</h4>
                        <div class="btn-box"><a href="shop-details.html" class="theme-btn">Shop now <span></span><span></span><span></span><span></span></a></div>
                        <figure class="image"><img src="frontend/assets/images/banner-img-2.png" alt="Tires"></figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="800">
                    <div class="inner-box">
                        <span class="text">Featured Product</span>
                        <h2><a href="shop-details.html">Premium Oils</a></h2>
                        <h4>From LKR 4,500</h4>
                        <div class="btn-box"><a href="shop-details.html" class="theme-btn">Shop now <span></span><span></span><span></span><span></span></a></div>
                        <figure class="image"><img src="frontend/assets/images/banner-img-5.png" alt="Premium Oils"></figure>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 feature-block">
                <div class="feature-block-one" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="900">
                    <div class="inner-box">
                        <span class="text">Featured Product</span>
                        <h2><a href="shop-details.html">Brake Pads</a></h2>
                        <h4>From LKR 1,999</h4>
                        <div class="btn-box"><a href="shop-details.html" class="theme-btn">Shop now <span></span><span></span><span></span><span></span></a></div>
                        <figure class="image"><img src="frontend/assets/images/banner-img-3.png" alt="Brake Pads"></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




     

<!-- Featured Vehicles Section -->
<section class="featured-vehicles mb-5">
    <div class="auto-container">
        <div class="sec-title mb_30">
             <h4>Featured Vehicles</h4>
            <p>Discover our collection of premium vehicles</p>
        </div>

        <div class="vehicles-grid">
            @forelse($featuredVehicles as $vehicle)
                <div class="vehicle-card">
                       @php
                            $image = $vehicle->images->first();
                        @endphp
                    <div class="vehicle-image">
                       <img src="{{ $image ? asset('uploads/'.$image->image_url) : asset('no-image.png') }}"
                        alt="{{ $vehicle->brand->name }} {{ $vehicle->model }}">
                        <div class="vehicle-badge {{ $vehicle->condition }}">
                            {{ ucfirst($vehicle->condition) }}
                        </div>
                        @if($vehicle->status)
                            <div class="status-badge available">Available</div>
                        @else
                            <div class="status-badge sold">Sold</div>
                        @endif
                    </div>
                    
                    <div class="vehicle-details">
                        <h3 class="vehicle-title">
                            {{ $vehicle->brand->name }} {{ $vehicle->model }}
                            <span class="vehicle-year">({{ $vehicle->year }})</span>
                        </h3>
                        
                        <div class="vehicle-price">
                            LKR {{ number_format($vehicle->price, 0) }}
                        </div>
                        
                        <div class="vehicle-specs">
                           c

                            @if(!empty($vehicle->fuel_type))
                                <div class="spec-item">
                                    <i class="fas fa-gas-pump"></i>
                                    <span>{{ $vehicle->fuel_type }}</span>
                                </div>
                            @endif

                            @if(!empty($vehicle->transmission))
                                <div class="spec-item">
                                    <i class="fas fa-cogs"></i>
                                    <span>{{ $vehicle->transmission }}</span>
                                </div>
                            @endif

                            @if(!empty($vehicle->body_type))
                                <div class="spec-item">
                                    <i class="fas fa-car"></i>
                                    <span>{{ $vehicle->body_type }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="vehicle-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $vehicle->city }}, {{ $vehicle->district }}</span>
                        </div>
                        
                        <a href="{{ route('Frontend.vehicle.details', $vehicle->id) }}" class="btn-view-details">
                            View Details
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="no-vehicles">
                    <p>No vehicles available at the moment.</p>
                </div>
            @endforelse
        </div>
        
        <div class="view-all-container">
            <a href="{{ route('Frontend.vehicles') }}" class="btn-view-all">
                View All Vehicles
                <i class="fas fa-long-arrow-alt-right"></i>
            </a>
        </div>
    </div>
</section>
<style>
/* Featured Vehicles Section */
.featured-vehicles {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #ededed 100%);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-header h2 {
    font-size: 2.5rem;
    color: #000000;
    margin-bottom: 10px;
    font-weight: 700;
    position: relative;
    display: inline-block;
}

.section-header h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #db3434, #a00e0e);
    border-radius: 2px;
}

.section-header p {
    font-size: 1.1rem;
    color: #7f8c8d;
    margin-top: 15px;
}

.vehicles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.vehicle-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    position: relative;
}

.vehicle-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.vehicle-image {
    position: relative;
    overflow: hidden;
    height: 250px;
}

.vehicle-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.vehicle-card:hover .vehicle-image img {
    transform: scale(1.1);
}

.vehicle-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 0px 8px;
    border-radius: 20px;
    font-size: 0.6rem;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
}

.vehicle-badge.new {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}

.vehicle-badge.used {
    background: linear-gradient(135deg, #f39c12, #e67e22);
}

.status-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    padding: 0px 8px;
    border-radius: 20px;
    font-size: 0.6rem;
    font-weight: 600;
    text-transform: uppercase;
    color: white;
}

.status-badge.available {
    background: #13bb2a;
}

.status-badge.sold {
    background: #e74c3c;
}

.vehicle-details {
    padding: 20px;
}

.vehicle-title {
    font-size: 1.2rem;
    color: #2c3e50;
    margin-bottom: 10px;
    font-weight: 600;
}

.vehicle-year {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: normal;
}

.vehicle-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #bb1313;
    margin-bottom: 5px;
}

.vehicle-price::before {
    content: '';
    font-size: 1rem;
    font-weight: normal;
}

.vehicle-specs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 0px;
    padding: 5px 0;
    border-top: 1px solid #ecf0f1;
    border-bottom: 1px solid #ecf0f1;
}

.spec-item {
    display: flex;
    margin-bottom:0px;
    align-items: center;
    gap: 8px;
    font-size: 0.85rem;
    color: #7f8c8d;
}

.spec-item i {
    color: #bb1313;
    width: 16px;
}

.vehicle-location {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 0.85rem;
    color: #95a5a6;
}

.vehicle-location i {
    color: #bb1313;
}

.btn-view-details {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    padding: 8px;
    background: #000000;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    gap: 10px;
}

.btn-view-details:hover {
    background: linear-gradient(135deg, #b92929, #db3434);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    color:white;
}

.btn-view-details i {
    transition: transform 0.3s ease;
}

.btn-view-details:hover i {
    transform: translateX(5px);
}

.view-all-container {
    text-align: center;
    margin-top: 20px;
}

.btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 30px;
    background: transparent;
    color: #b92929;
    text-decoration: none;
    border: 2px solid #b92929;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-all:hover {
    background: #b92929;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(219, 52, 52, 0.3);
}

.btn-view-all i {
    transition: transform 0.3s ease;
}

.btn-view-all:hover i {
    transform: translateX(5px);
}

.no-vehicles {
    text-align: center;
    padding: 60px;
    background: white;
    border-radius: 15px;
    color: #7f8c8d;
}

/* Responsive Design */
@media (max-width: 768px) {
    .vehicles-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
    
    .vehicle-price {
        font-size: 1.5rem;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .vehicles-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>


<!-- Recently Viewed Parts -->
@if(auth('customer')->check() && $recentlyViewedProducts->count() > 0)
<!-- shop-style-two -->
<section class="shop-style-two pb_100">
    <div class="auto-container">
        <div class="sec-title mb_35">
            <h4>Recently Viewed Parts</h4>
        </div>
        <div class="four-item-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
            @foreach($recentlyViewedProducts as $product)
                <div class="shop-block-one">
                    <div class="inner-box p-4">
                        <div class="image-box">
                            <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}">
                                @php
                                    $mainImage = $product->images->where('is_main', 1)->first();
                                @endphp

                                <figure class="image" style="max-width: 300px;">
                                    <img src="{{ $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png') }}"
                                         alt="{{ $product->name }}"
                                         style="height:200px; object-fit:cover;">
                                </figure>
                            </a>
                        </div>

                        <div class="lower-content">
                            <span class="text">
                                {{ $product->category->name ?? 'Parts' }}
                            </span>
                            <h4 style="font-size:17px">
                                <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}">
                                    {{ Str::limit($product->name, 45) }}
                                </a>
                            </h4>
                            <h5>
                                Rs. {{ number_format($product->price, 2) }}
                            </h5>
                            <span class="product-stock">
                                <i class="icon-39"></i>
                                In Stock
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- shop-style-two end -->
@endif



<!-- Recommended For You -->
@if(auth('customer')->check() && $recommendedProducts->count() > 0)

<!-- shop-section -->
<section class="shop-section pb_100">
    <div class="auto-container">
        <div class="inner-container">
            <div class="ads-box">
                <span class="text">Recommended For You</span>
                <h4 style="color: #000;">Personalized Parts</h4>

                <figure class="image">
                    <img src="{{ asset('frontend/assets/images/shop/shop.png') }}" alt="">
                </figure>
            </div>
            <div class="content-box">
                <div class="shop-carousel owl-carousel owl-theme owl-dots-none nav-style-one">
                    @foreach($recommendedProducts as $product)
                        <div class="shop-block-one">
                            <div class="inner-box">
                                <div class="image-box">
                                    <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}">
                                        @php
                                            $mainImage = $product->images->where('is_main', 1)->first();
                                        @endphp

                                        <figure class="image">
                                            <img src="{{ $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png') }}"
                                                 alt="{{ $product->name }}"
                                                 style="height:200px; object-fit:cover;">
                                        </figure>
                                    </a>
                                </div>

                                <div class="lower-content">
                                    <span class="text">
                                        {{ $product->category->name ?? 'Parts' }}
                                    </span>
                                    <h4 style="font-size:17px">
                                        <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}">
                                            {{ Str::limit($product->name, 30) }}
                                        </a>
                                    </h4>
                                    <h5>
                                        Rs. {{ number_format($product->price, 2) }}
                                    </h5>
                                    <span class="product-stock">
                                        <i class="icon-39"></i>
                                        In Stock
                                    </span>
                                    <div class="cart-btn">
                                        <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}"
                                           class="theme-btn p-2" style="font-size: 14px;">
                                            View Product
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- shop-section end -->

@endif

<!-- cta-style-two -->
<div class="auto-container mb-5">
<img src="{{ asset('frontend/assets/images/banner8.png') }}" alt="Banner" style="width: 100%; height: auto; display: block;">
</div>

<!-- cta-style-two end -->



 @endsection