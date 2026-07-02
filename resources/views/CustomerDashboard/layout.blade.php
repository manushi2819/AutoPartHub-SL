@extends('Frontend.master')

@section('title', 'My Account')

@section('content')

<style>
    /* Customer Dashboard Main Styles */

/* Layout Structure */
.account-section {
    padding: 0 0 60px 0;
    background: #f8f9fa;
    min-height: 100vh;
}


/* Sidebar Styles */
.account-info {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.upper-box {
    background: linear-gradient(135deg, #BFDCFF 0%, #486CEA 100%);
    padding: 30px 20px;
    margin-bottom: 20px;
}

.upper-box img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}

.upper-box h5 {
    color: white;
    font-size: 18px;
    font-weight: 600;
    margin: 10px 0 5px;
}

.upper-box small {
    color: rgba(255,255,255,0.9);
    font-size: 13px;
}

.account-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.account-info ul li {
    border-bottom: 1px solid #eef2f6;
}

.account-info ul li:last-child {
    border-bottom: none;
}

.account-info ul li a {
    display: block;
    padding: 15px 25px;
    color: #4a5568;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.account-info ul li a:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: linear-gradient(135deg, #BFDCFF 0%, #486CEA 100%);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.account-info ul li a:hover,
.account-info ul li a.active {
    background: #f8f9fa;
    color: #486CEA;
    padding-left: 35px;
}

.account-info ul li a:hover:before,
.account-info ul li a.active:before {
    transform: scaleY(1);
}


/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

form input,
form textarea,
form select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #ffffff;
}

form input:focus,
form textarea:focus,
form select:focus {
    outline: none;
    border-color: #BFDCFF;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

form textarea {
    min-height: 100px;
    resize: vertical;
}


/* Responsive Styles */
@media (max-width: 768px) {
    .account-section {
        padding: 30px 0;
    }
    
    .upper-box {
        padding: 20px;
    }
    
    .upper-box img {
        width: 80px;
        height: 80px;
    }
    
    [col-md-9] > div {
        padding: 20px;
        margin-top: 20px;
    }
    
    [col-md-9] h3 {
        font-size: 20px;
    }
    
    .theme-btn,
    form button[type="submit"] {
        width: 100%;
        text-align: center;
    }
    
    .account-info ul li a:hover,
    .account-info ul li a.active {
        padding-left: 25px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

[col-md-9] > div {
    animation: fadeIn 0.5s ease;
}


</style>



@php
    $customer = Auth::guard('customer')->user();
@endphp

 <section class="account-section">
    <section class="page-title-two centred">
    <div class="container">
        <div class="content-box">
            <h3>My Account</h3>
        </div>
    </div>
    </section>
        <div class="auto-container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="account-info newinfo">
                        <div class="upper-box centred mb_40">
                            <img src="{{ asset('frontend/assets/images/resource/account.jpg') }}" width="120" alt="Profile">
                            <h5>{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                            <small>{{ $customer->email }}</small>
                        </div>
                        
                        <ul>
                            <li>
                                <a href="{{ route('customer.profile') }}"
                                   class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                                   Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.orders') }}"
                                   class="{{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                                   Orders
                                </a>
                            </li>
                            <!-- <li>
                                <a href="{{ route('customer.auctionbids') }}"
                                   class="{{ request()->routeIs('customer.auctionbids') ? 'active' : '' }}">
                                   Auction Bids
                                </a>
                            </li>-->
                            <li>
                                <a href="{{ route('customer.password') }}"
                                   class="{{ request()->routeIs('customer.password') ? 'active' : '' }}">
                                   Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="col-md-9 account-info p-4">
                    @yield('account-content')
                </div>
            </div>
        </div>
    </section>


    <!--
@if($recommendedProducts->count())
<div class="recommended-section">
    <div class="auto-container">
        <div class="section-header text-center mb-5">
            <span class="section-badge">Personalized Picks</span>
            <h2 class="section-title">Recommended Parts For You</h2>
              <p class="section-subtitle text-muted">
                Based on your vehicle searches and browsing activity
            </p>
            <div class="section-divider">
                <i class="fas fa-cog"></i>
            </div>
          
        </div>

        <div class="row g-4">
            @foreach($recommendedProducts as $product)
                @php
                    $mainImage = $product->images->where('is_main', 1)->first();
                @endphp

                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-card">
                       
                        <div class="product-image-wrapper">
                            <a href="{{ route('Frontend.parts-details', $product->id) }}" class="product-link">
                                <img src="{{ $mainImage ? asset('uploads/'.$mainImage->image_url) : asset('no-image.png') }}" 
                                     class="product-image" 
                                     alt="{{ $product->name }}">
                            </a>
                        </div>

                       
                        <div class="product-content">
                            <h3 class="product-title">
                                <a href="{{ route('Frontend.parts-details', $product->id) }}">
                                    {{ \Illuminate\Support\Str::limit($product->name, 50) }}
                                </a>
                            </h3>
                            
                            <div class="product-meta">
                                <div class="product-price">
                                    <span class="price-currency">Rs.</span>
                                    <span class="price-amount">{{ number_format($product->price, 2) }}</span>
                                </div>
                                @if(isset($product->old_price))
                                    <div class="product-old-price">
                                        Rs. {{ number_format($product->old_price, 2) }}
                                    </div>
                                @endif
                            </div>

                            @php
                                $rating = $product->reviews_avg_rating ?? 0;
                                $count = $product->reviews_count ?? 0;
                            @endphp
                            <div class="product-rating mb-2">
                                {{-- Stars --}}
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($rating >= $i)
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif ($rating >= $i - 0.5)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                {{-- Count --}}
                                <span class="rating-count text-muted">
                                    ({{ $count }})
                                </span>
                            </div>

                            <a href="{{ route('Frontend.parts-details', $product->id) }}" 
                               class="btn-view-product">
                                <span>View Product</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@else
<div class="recommended-section">
    <div class="auto-container">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-search"></i>
            </div>
            <h3 class="empty-state-title">No Recommendations Yet</h3>
            <p class="empty-state-message">
                Browse some products and vehicles to receive personalized recommendations.
            </p>
            <a href="{{ route('Frontend.shop') }}" class="btn-explore">
                Start Exploring
            </a>
        </div>
    </div>
</div>
@endif-->




<style>
/* ========== RECOMMENDED SECTION STYLES ========== */
.recommended-section {
    padding: 20px 0 60px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Section Header */
.section-header {
    margin-bottom: 3rem;
}

.section-badge {
    display: inline-block;
    padding: 5px 15px;
    background: linear-gradient(135deg, #9ac0ee 0%, #486CEA 100%);
    color: white;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 25px;
    margin-bottom: 15px;
}

.section-title {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.section-divider {
    position: relative;
    width: 90px;
    height: 2px;
    background: linear-gradient(135deg, #9ac0ee 0%, #486CEA 100%);
    margin: 10px auto;
}

.section-divider i {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 0 10px;
    color: #667eea;
    font-size: 14px;
}

.section-subtitle {
    font-size: 15px;
    color: #6c757d;
}

/* Product Card */
.product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    height: 100%;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

/* Product Image Wrapper */
.product-image-wrapper {
    position: relative;
    overflow: hidden;
    background: #f5f5f5;
}

.product-image {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}


/* Product Content */
.product-content {
    padding: 20px;
}

.product-title {
    font-size: 15px;
    font-weight: 600;
    line-height: 1.4;
    margin-bottom: 12px;
    min-height: 42px;
}

.product-title a {
    color: #1a1a2e;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-title a:hover {
    color: #667eea;
}

.product-meta {
    margin-bottom: 0px;
    display: flex;
    align-items: baseline;
    gap: 10px;
    flex-wrap: wrap;
}

.product-price {
    display: inline-flex;
    align-items: baseline;
    gap: 3px;
}

.price-currency {
    font-size: 13px;
    font-weight: 600;
    color: #dc3545;
}

.price-amount {
    font-size: 20px;
    font-weight: 700;
    color: #dc3545;
}

.product-old-price {
    font-size: 13px;
    color: #999;
    text-decoration: line-through;
}

.product-rating {
    font-size: 12px;
    margin-bottom: 15px;
}

.rating-count {
    color: #6c757d;
    margin-left: 5px;
}

/* View Product Button */
.btn-view-product {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px;
    background:  #000000;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
}

.btn-view-product:hover {
    background: var(--primary-red);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(213, 213, 213, 0.3);
}

.btn-view-product i {
    transition: transform 0.3s ease;
}

.btn-view-product:hover i {
    transform: translateX(5px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.empty-state-icon {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state-title {
    font-size: 24px;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.empty-state-message {
    color: #6c757d;
    margin-bottom: 25px;
}

.btn-explore {
    display: inline-block;
    padding: 12px 30px;
    background:  #000000;
    color: white;
    text-decoration: none;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-explore:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(213, 213, 213, 0.3);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .recommended-section {
        padding: 40px 0;
    }
    
    .section-title {
        font-size: 24px;
    }
    
    .product-content {
        padding: 15px;
    }
    
    .price-amount {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .product-image {
        height: 180px;
    }
    
    .product-title {
        font-size: 13px;
    }
}
</style>


@endsection