@extends('Frontend.master')

@section('title', 'Home')

@section('content')


<style>

.content-one .inner-box h2,
.content-one .inner-box h3 {
    margin-bottom: 38px; 
}


</style>

      
        <!-- banner-style-two -->
        <section class="banner-style-two home-5 pt_30 pb_10 p_relative">
            <div class="pattern-layer" style="background-image: url(frontend/assets/images/shape/shape-6.png);"></div>
            <div class="large-container">
                <div class="row clearfix">
                    <div class="col-lg-9 col-md-12 col-sm-12 content-block">
                        <div class="content-one content-box">
                            <div class="bg-layer" style="background-image: url({{ asset('frontend/assets/images/banner/banner-img-4.png') }});"></div>
                            <div class="inner-box">
                                <span class="popular-product">The Best Place for Auto Parts</span>
                                <h2>Premium Parts for Every Vehicle</h2>
                                <h3 style="font-size:16px; color: #5a5a5a">Join our live auctions for exclusive deals on <br>vintage and performance parts.</span></h3>
                                <a href="{{ route('Frontend.shop') }}" class="theme-btn mt-0">SHOP NOW<span></span><span></span><span></span><span></span></a>
                            </div>
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
                                    <div class="select-box">
                                        <select name="model" class="wide">
                                            <option value="">Select Model</option>
                                            @foreach($models as $model)
                                                <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>
                                                    {{ $model }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
            <div class="large-container">
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
                    <h2>Popular Categories</h2>
                </div>
                <div class="category-carousel owl-carousel owl-theme owl-dots-none owl-nav-none">
                    @foreach($parentCategories as $category)
                    <div class="category-block-one">
                        <div class="inner-box">
                            <figure class="image-box" style="width: 160px; height: 160px; overflow: hidden;">
                                <img src="{{ asset($category->image ?? 'assets/images/about2.jpg') }}" alt="{{ $category->name }}"
                                style=" width: 100%;height: 100%;object-fit: cover; ">
                            </figure>
                            <h4>
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
                    <h2>Shop by Brands</h2>
                </div>
                <div class="inner-container">
                    <div class="row clearfix">
                        @foreach($brands as $brand)
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
        <div class="bg-layer" style="background-image: url('{{ asset('frontend/assets/images/index4.jpg') }}');"></div>
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
                                                <a href="#">
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
                                            <h5>LKR {{ number_format($product->price,2) }}</h5>

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

       <!-- feature-section -->
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
<!-- feature-section end -->

 @endsection