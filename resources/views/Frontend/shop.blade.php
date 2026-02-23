@extends('Frontend.master')

@section('title', 'Shop')

@section('content')

<style>
    .product-name {
        display: -webkit-box;
        -webkit-line-clamp: 2; 
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.5em; /* ensures even short names occupy 2 lines height */
        line-height: 1.2em; /* adjust based on your font size */
    }

</style> 


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
                    <figure class="image-layer"><img src="frontend/assets/images/cta-1.png" alt=""></figure>
                    <div class="content-box">
                        <span class="text"></span>
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

                            {{-- =========================
                                Vehicle Search Filter
                            ========================== --}}
                            <div class="search-widget sidebar-widget pb_40 mb_40">
                                <div class="widget-title mb_30">
                                    <h3>Select Vehicle</h3>
                                </div>
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
                                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                                            {{ $brand }}
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

                                        {{-- SEARCH BUTTON --}}
                                        <div class="message-btn">
                                            <button type="submit" class="theme-btn">
                                                Search Part
                                                <span></span><span></span><span></span><span></span>
                                            </button>
                                        </div>
                                        <div class="btn-box">
                                            <a href="{{ route('Frontend.shop') }}" class="clear-btn">Clear</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                    <div class="category-widget sidebar-widget pb_40 mb_40">
                        <div class="widget-title mb_30">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content">
                            <form method="GET" action="{{ route('Frontend.shop') }}">
                                <ul class="accordion-box">
                                    @foreach($categories as $category)
                                        @php
                                            $childSelected = $category->children->pluck('id')->intersect(request('category', []))->count() > 0;
                                            $parentSelected = in_array($category->id, request('category', [])) || $childSelected;
                                        @endphp

                                        <li class="accordion block">

                                            {{-- Parent Category Name --}}
                                            <div class="acc-btn">{{ $category->name }}</div>

                                            {{-- Child Categories --}}
                                            @if($category->children->count())
                                                <div class="acc-content" style="{{ $childSelected ? 'display:block;' : 'display:none;' }}">
                                                    <ul class="category-list clearfix">
                                                        @foreach($category->children as $child)
                                                            <li>
                                                                <div class="check-box">
                                                                    <input type="checkbox" name="category[]"
                                                                        value="{{ $child->id }}"
                                                                        id="cat-{{ $child->id }}"
                                                                        {{ in_array($child->id, request('category', [])) ? 'checked' : '' }}>
                                                                    <label for="cat-{{ $child->id }}">{{ $child->name }}</label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                        </li>
                                    @endforeach
                                </ul>

                                <div class="btn-box mt-3">
                                    <button type="submit" class="theme-btn filter-btn">
                                        Filter Categories
                                        <span></span><span></span><span></span><span></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                    $(document).ready(function(){
                        // Accordion toggle on click
                        $(".acc-btn").click(function(){
                            $(this).next(".acc-content").slideToggle();
                        });
                    });
                    </script>
           
                            {{-- =========================
                                Price Filter
                            ========================== --}}
                            <div class="filter-widget sidebar-widget pb_50 mb_40">
                                <div class="widget-title mb_30">
                                    <h3>Filter by Price</h3>
                                </div>
                            <form method="GET" action="{{ route('Frontend.shop') }}">
                                    <div class="price-range-slider">
                                        <div id="slider-range" class="range-bar"></div>
                                        <p class="range-value">
                                            <span>Price:</span>
                                            <input type="text" id="amount" readonly
                                                value="{{ request('min_price') ?? 0 }} - {{ request('max_price') ?? 100000 }}">
                                        </p>

                                        {{-- Hidden inputs for controller --}}
                                        <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') ?? 0 }}">
                                        <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') ?? 100000 }}">

                                        <div class="btn-box">
                                            <button type="submit" class="theme-btn filter-btn">Apply<span></span><span></span><span></span><span></span></button>
                                            <a href="{{ route('Frontend.shop') }}" class="clear-btn">Clear</a>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>




                    <div class="col-lg-9 col-md-12 col-sm-12 content-side">
                        <div class="our-shop">
                           <div class="item-shorting">
                                <div class="left-column">
                                    <div class="text">
                                        <p>
                                            Showing 
                                            <span>{{ $products->firstItem() ?? 0 }}</span>–<span>{{ $products->lastItem() ?? 0 }}</span> 
                                            of <span>{{ $products->total() ?? 0 }}</span> results
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="wrapper grid">
                                <div class="shop-grid-content">
                                    <div class="row clearfix">
                                        @foreach($products as $product)
                                        <div class="col-lg-3 col-md-6 col-sm-12 shop-block">
                                            <div class="shop-block-one">
                                                <div class="inner-box">
                                                   <div class="image-box" style="height: 200px; overflow: hidden;">
                                                        @php
                                                            $mainImage = $product->images->where('is_main', 1)->first();
                                                        @endphp

                                                        <figure class="image" style="height: 100%; margin: 0;">
                                                            <img src="{{ $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png') }}"
                                                                style="height: 100%; width: 100%; object-fit: cover;">
                                                        </figure>
                                                    </div>

                                                    <div class="lower-content">
                                                        <h4 class="product-name">{{ $product->name }}</h4>
                                                        <h5>LKR {{ number_format($product->price, 2) }}</h5>
                                                        <ul class="rating"> 
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><i class="icon-41"></i></li>
                                                            <li><span>(5)</span></li>
                                                        </ul>

                                                        @if($product->stock_quantity > 0)
                                                             <span class="product-stock"><i class="icon-39"></i>
                                                                In Stock
                                                            </span>
                                                        @else
                                                            <span class="product-stock text-danger"><i class="icon-39"></i>
                                                                Out of Stock
                                                            </span>
                                                        @endif
                                                        <div class="overlay-content">
                                                            <ul class="feature-list clearfix">
                                                                <li>{{ \Illuminate\Support\Str::limit($product->description, 80) }}</li>
                                                            </ul>
                                                            <div class="cart-btn"><button type="button" class="theme-btn">Add to Cart<span></span><span></span><span></span><span></span></button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                </div>
                            </div>
                           <div class="pagination-wrapper centred pt_20">
                                <ul class="pagination clearfix">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="disabled"><span><i class="fal fa-angle-left"></i></span></li>
                                    @else
                                        <li><a href="{{ $products->previousPageUrl() }}"><i class="fal fa-angle-left"></i></a></li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li><a href="{{ $url }}" class="current">{{ $page }}</a></li>
                                        @else
                                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li><a href="{{ $products->nextPageUrl() }}"><i class="fal fa-angle-right"></i></a></li>
                                    @else
                                        <li class="disabled"><span><i class="fal fa-angle-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-page-section end -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    var min = 0;
    var max = 100000;

    $("#slider-range").slider({
        range: true,
        min: min,
        max: max,
        values: [min, max],
        slide: function (event, ui) {
            $("#amount").val("LKR " + ui.values[0].toLocaleString() +
                " - LKR " + ui.values[1].toLocaleString());

            // Update hidden inputs
            $("#min_price").val(ui.values[0]);
            $("#max_price").val(ui.values[1]);
        }
    });

    // Set initial value display
    $("#amount").val(
        "LKR " + $("#slider-range").slider("values", 0).toLocaleString() +
        " - LKR " + $("#slider-range").slider("values", 1).toLocaleString()
    );

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));
});
</script>
 

 @endsection