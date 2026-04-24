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
    
/* Mobile responsiveness */
@media (max-width: 768px) {
    .cta-style-two .inner-container {
        height: 120px !important;
    
}

@media (max-width: 480px) {
    .cta-style-two .inner-container 
    {
        height: 150px !important;
    }
}
}



/* Products Grid */
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin: 30px 0;
}

.product-card {
    background: #fff;
    border-radius: 0px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-link {
    text-decoration: none;
    display: block;
    color: inherit;
}

.product-image-wrapper {
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f5f5f5;
    padding: 10px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-info {
    padding: 15px;
}

.product-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin: 0 0 0px 0;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 40px;
}

.product-price {
    font-size: 18px;
    font-weight: 700;
    color: #e31e24;
    margin: 0 0 5px 0;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 3px;
    margin-bottom: 12px;
}

.star {
    font-size: 14px;
    color: #ddd;
}

.star.filled {
    color: #ffc107;
}

.rating-count {
    font-size: 12px;
    color: #666;
    margin-left: 5px;
}

.stock-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
}

.stock-badge.in-stock {
    background: #e8f5e9;
    color: #2e7d32;
}

.stock-badge.out-of-stock {
    background: #ffebee;
    color: #c62828;
}


/* Item Shorting */
.item-shorting {
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.left-column .text p {
    margin: 0;
    font-size: 14px;
    color: #666;
}

.left-column .text span {
    font-weight: 600;
    color: #333;
}

/* Responsive */
@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .product-image-wrapper {
        height: 180px;
    }
    
    .product-title {
        font-size: 14px;
        height: 38px;
    }
    
    .product-price {
        font-size: 16px;
    }
    
    .product-info {
        padding: 12px;
    }
    
    .pagination li a,
    .pagination li span {
        min-width: 35px;
        height: 35px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .product-image-wrapper {
        height: 150px;
    }
    
    .product-title {
        font-size: 13px;
        height: 34px;
    }
    
    .product-price {
        font-size: 14px;
    }
    
    .star {
        font-size: 11px;
    }
    
    .rating-count {
        font-size: 10px;
    }
    
    .stock-badge {
        font-size: 10px;
        padding: 3px 8px;
    }
    
    .item-shorting {
        padding: 10px 15px;
    }
    
    .left-column .text p {
        font-size: 12px;
    }
}
</style>


        <!-- page-title -->
        <section class="page-title">
            <div class="auto-container">
                <div class="content-box">
                    <ul class="bread-crumb">
                        <li><a href="{{ route('Frontend.index') }}">Home</a></li>
                        <li>Shop</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- page-title end -->


    <!-- cta-style-two -->
    <section class="cta-style-two pb_0">
        <div class="auto-container">
            <div class="inner-container" style="width: 100%; height: 310px; overflow: hidden; position: relative;">
                <img src="frontend/assets/images/banner1.png" alt="Banner Image" 
                    style="width: 100%; height: 100%; object-fit: cover; display: block; position: absolute; top: 0; left: 0;">
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
                                    <h4>Select Vehicle</h4>
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

                                        {{-- SEARCH BUTTON --}}
                               
                                        <div class="btn-box" style="display:flex; gap:12px; margin-top:15px;">

                                            <button type="submit"  class="theme-btn"
                                                style="
                                                    flex:1;
                                                    padding:10px 18px;
                                                    background:linear-gradient(135deg, #000000, #000000);
                                                    border:none;
                                                    border-radius:6px;
                                                    color:#fff;
                                                    font-weight:600;
                                                    font-size:14px;
                                                    cursor:pointer;
                                                    transition:all 0.3s ease;
                                                    box-shadow:0 4px 10px rgba(0,0,0,0.15);
                                                "
                                            >
                                                Search Part
                                            </button>

                                            <a href="{{ route('Frontend.shop') }}" 
                                                style="
                                                    flex:1;
                                                    text-align:center;
                                                    padding:10px 18px;
                                                    background:#f5f5f5;
                                                    border:1px solid #ddd;
                                                    border-radius:6px;
                                                    color:#333;
                                                    font-weight:600;
                                                    font-size:14px;
                                                    text-decoration:none;
                                                    transition:all 0.3s ease;
                                                "
                                            >
                                                Clear
                                            </a>

                                        </div>
                                    </form>
                                </div>
                            </div>

                   <form method="GET" action="{{ route('Frontend.shop') }}">
                        {{-- =========================
                            Categories
                        ========================== --}}
                        <div class="category-widget sidebar-widget pb_40 mb_40">
                            <div class="widget-title mb_30">
                                <h4>Categories</h4>
                            </div>
                            <div class="widget-content">
                                <ul class="accordion-box">
                                    @foreach($categories as $category)
                                        <li class="accordion block">

                                            {{-- Parent Row --}}
                                            <div class="parent-row d-flex align-items-center justify-content-between">

                                                {{-- Checkbox --}}
                                                <div class="check-box">
                                                    <input type="checkbox"
                                                        name="category[]"
                                                        value="{{ $category->id }}"
                                                        id="cat-{{ $category->id }}"
                                                        {{ in_array($category->id, request()->input('category', [])) ? 'checked' : '' }}>
                                                    <label for="cat-{{ $category->id }}">
                                                        <strong>{{ $category->name }}</strong>
                                                    </label>
                                                </div>

                                                {{-- Toggle Button --}}
                                                @if($category->children->count())
                                                    <span class="acc-toggle" style="cursor:pointer;">+</span>
                                                @endif

                                            </div>

                                            {{-- Children --}}
                                            @if($category->children->count())
                                                <div class="acc-content" style="display:none;">
                                                    <ul class="category-list clearfix">
                                                        @foreach($category->children as $child)
                                                            <li>
                                                                <div class="check-box">
                                                                    <input type="checkbox"
                                                                        name="category[]"
                                                                        value="{{ $child->id }}"
                                                                        id="cat-{{ $child->id }}"
                                                                        {{ in_array($child->id, request()->input('category', [])) ? 'checked' : '' }}>
                                                                    <label for="cat-{{ $child->id }}">
                                                                        {{ $child->name }}
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                        </li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- =========================
                            Price Filter
                        ========================== --}}
                        <div class="filter-widget sidebar-widget  mb_40">
                            <div class="widget-title mb_30">
                                <h4>Filter by Price</h4>
                            </div>

                            <div class="price-range-slider">
                                <div id="slider-range" class="range-bar"></div>

                                <p class="range-value">
                                    <span>Price:</span>
                                    <input type="text" id="amount" readonly
                                        value="{{ request('min_price') ?? 0 }} - {{ request('max_price') ?? 100000 }}">
                                </p>

                                <input type="hidden" name="min_price" id="min_price"
                                    value="{{ request('min_price') ?? 0 }}">

                                <input type="hidden" name="max_price" id="max_price"
                                    value="{{ request('max_price') ?? 100000 }}">
                            </div>
                        </div>

    
                        <div class="btn-box" style="display:flex; gap:12px; margin-top:15px;">

                            <button type="submit"  class="theme-btn"
                                style="
                                    flex:1;
                                    padding:10px 18px;
                                    background:linear-gradient(135deg, #000000, #000000);
                                    border:none;
                                    border-radius:6px;
                                    color:#fff;
                                    font-weight:600;
                                    font-size:14px;
                                    cursor:pointer;
                                    transition:all 0.3s ease;
                                    box-shadow:0 4px 10px rgba(0,0,0,0.15);
                                "
                            >
                                Apply Filters
                            </button>

                            <a href="{{ route('Frontend.shop') }}" 
                                style="
                                    flex:1;
                                    text-align:center;
                                    padding:10px 18px;
                                    background:#f5f5f5;
                                    border:1px solid #ddd;
                                    border-radius:6px;
                                    color:#333;
                                    font-weight:600;
                                    font-size:14px;
                                    text-decoration:none;
                                    transition:all 0.3s ease;
                                "
                            >
                                Clear
                            </a>

                        </div>

                    </form>
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
        
        <div class="products-grid">
            @foreach($products as $product)
            <div class="product-card">
                <a href="{{ route('Frontend.parts-details', ['id' => $product->id]) }}" class="product-link">
                    <div class="product-image-wrapper">
                        @php
                            $mainImage = $product->images->where('is_main', 1)->first();
                        @endphp
                        <img src="{{ $mainImage ? asset('uploads/' . $mainImage->image_url) : asset('no-image.png') }}" 
                             alt="{{ $product->name }}"
                             class="product-image">
                    </div>
                    
                    <div class="product-info">
                        <h4 class="product-title">{{ $product->name }}</h4>
                        <h5 class="product-price">LKR {{ number_format($product->price, 2) }}</h5>
                        
                        <div class="product-rating">
                            @php
                                $avg = round($product->averageRating());
                                $total = $product->reviewsCount();
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star {{ $i <= $avg ? 'filled' : '' }}">★</span>
                            @endfor
                            <span class="rating-count">({{ $total }})</span>
                        </div>
                        
                        @if($product->stock_quantity > 0)
                            <span class="stock-badge in-stock">✓ In Stock</span>
                        @else
                            <span class="stock-badge out-of-stock">✗ Out of Stock</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($products->onFirstPage())
                    <li class="disabled"><span>‹</span></li>
                @else
                    <li><a href="{{ $products->previousPageUrl() }}">‹</a></li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if ($page == $products->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($products->hasMorePages())
                    <li><a href="{{ $products->nextPageUrl() }}">›</a></li>
                @else
                    <li class="disabled"><span>›</span></li>
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
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).on("click", ".acc-toggle", function(e){
    e.stopPropagation();
    $(this).closest("li").children(".acc-content").slideToggle();
});
</script>
 @endsection