  <style>
.user-dropdown {
    position: relative;
    display: inline-block;
}

.user-toggle {
    cursor: pointer;
}

.user-initials-circle {
    width: 35px;
    height: 35px;
    background: linear-gradient(95deg, #ff0000, #000000); 
    color: #fff;
    border: 1px solid white;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.user-menu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 6px;
    list-style: none;
    margin: 5px 0 0 0;
    padding: 0;
    min-width: 150px;
    z-index: 100;
     color: black !important;
}

.user-menu li {
    padding: 8px 12px;
     color: black !important;
    font-size:15px !important;
}

.user-menu li:hover {
    background-color: #f0f0f0;
}

.logout-btn {
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
    color: black !important;
    font-size:15px !important;
}

/* Show dropdown on hover */
.user-dropdown:hover .user-menu {
    display: block;
}

</style>

  <!-- main header -->
        <header class="main-header header-style-five dark-header">
            <!-- header-top -->
            <div class="header-top">
                <div class="large-container">
                    <div class="top-inner">
                        <ul class="info-list">
                            <li><i class="icon-2"></i>Open Hours: <span>Mon - Sat 8am - 6pm</span></li>
                            <li><i class="icon-4"></i>Call: <span>+94 71 631 6143</span></li>
                            <li><i class="icon-47"></i>Location: <span>Ridigama, Kurunegala</span></li>
                        </ul>
                        <div class="right-column">
                            <div class="text mr_30">
                                <i class="icon-5"></i>
                                <p>Fast and Free Shipping all over Sri Lanka</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-upper -->
            <div class="header-upper">
                <div class="large-container">
                    <div class="upper-inner">
                        <figure class="logo-box"  style="height:70px">
                            <a href="{{ route('Frontend.index') }}"><img src="{{ asset('logo4.png') }}" alt=""  style="height:100%"></a></figure>
                        <div class="search-area">
                            @php
                                $parentCategories = \App\Models\Category::whereNull('parent_id')
                                                    ->where('status', 1)
                                                    ->orderBy('name')
                                                    ->get();
                            @endphp

                            <div class="category-box">
                                <div class="select-box">
                                    <form method="GET" action="{{ route('Frontend.shop') }}">
                                        <select class="wide" name="category[]">
                                            <option value="">Select Category</option>
                                            @foreach($parentCategories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, (array) request()->input('category')) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="search-box">
                                    <div class="form-group">
                                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search Products">
                                        <button type="submit"><i class="icon-9"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @php
                            $customer = Auth::guard('customer')->user();
                            $sessionId = session()->getId();

                            if ($customer) {
                                $cartCount = \App\Models\Cart::where('customer_id', $customer->id)
                                                ->sum('quantity');
                            } else {
                                $cartCount = \App\Models\Cart::where('session_id', $sessionId)
                                                ->sum('quantity');
                            }
                        @endphp
                        <ul class="option-list">
                            <li><a href="{{ route('Frontend.wishlist') }}"><i class="icon-7"></i></a></li>
                            <li><a href="{{ route('Frontend.cart') }}"><i class="icon-6"></i><span>{{ $cartCount }}</span></a></li>
                          
                             @if(Auth::guard('customer')->check())
                                @php
                                    $customer = Auth::guard('customer')->user();
                                    // Use first_name and last_name for initials
                                    $initials = strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1));
                                @endphp

                                <li class="nav-item user-dropdown">
                                    <!-- Toggle -->
                                    <div class="user-toggle">
                                        <span class="user-initials-circle">{{ $initials }}</span>
                                    </div>

                                    <!-- Dropdown menu -->
                                    <ul class="user-menu">
                                        <li><a href="{{ route('customer.dashboard') }}" style=" color: black !important;
                                        font-size:15px !important;">Dashboard</a></li>
                                        <li>
                                            <form method="POST" action="{{ route('Frontend.logout') }}">
                                                @csrf
                                                <button type="submit" class="logout-btn">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('Frontend.login') }}"><i class="icon-25"></i></a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
            <!-- header-lower -->
            <div class="header-lower">
                <div class="large-container">
                    <div class="outer-box">
                        @php
                            $categories = \App\Models\Category::whereNull('parent_id')
                                            ->where('status', 1)
                                            ->with(['children.children'])
                                            ->get();
                        @endphp

                        <div class="category-box">
                            <span class="text"><i class="fas fa-bars"></i>All Categories</span>
                            <ul class="category-list clearfix">

                                @foreach($categories as $category)
                                    <li class="{{ $category->children->count() ? 'category-dropdown' : '' }}">
                                        
                                        <a href="{{ route('Frontend.shop', ['category[]' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>

                                        @if($category->children->count())
                                        <div class="list-inner">
                                            <div class="inner-box clearfix">

                                                @foreach($category->children as $child)
                                                    <div class="single-column">
                                                        <p>
                                                            <a href="{{ route('Frontend.shop', ['category[]' => $child->id]) }}"
                                                            style="color:black">
                                                                {{ $child->name }}
                                                            </a>
                                                        </p>

                                                        @if($child->children->count())
                                                        <ul>
                                                            @foreach($child->children as $subChild)
                                                                <li>
                                                                    <a href="{{ route('Frontend.shop', ['category[]' => $subChild->id]) }}">
                                                                        {{ $subChild->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        @endif

                                                    </div>
                                                @endforeach

                                            </div>

                                            <!-- Keep Your Shop Block -->
                                            <div class="shop-block">
                                                <span class="title">Only for this month</span>
                                                <h2><a href="#">Special Offer</a></h2>
                                                <h4>Best Deals Available</h4>
                                                <a href="#" class="link">Shop now</a>
                                                <figure class="image">
                                                    <img src="{{ asset('assets/images/shop/shop-1.png') }}" alt="">
                                                </figure>
                                            </div>

                                        </div>
                                        @endif

                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="menu-area">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler">
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                                <i class="icon-bar"></i>
                            </div>
                            <nav class="main-menu navbar-expand-md navbar-light clearfix">
                               <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li class="{{ request()->routeIs('Frontend.index') ? 'current' : '' }}">
                                            <a href="{{ route('Frontend.index') }}">Home</a>
                                        </li> 

                                        <li class="{{ request()->routeIs('Frontend.shop') ? 'current' : '' }}">
                                            <a href="{{ route('Frontend.shop') }}">Shop</a>
                                        </li> 

                                        <li class="{{ request()->routeIs('Frontend.about') ? 'current' : '' }}">
                                            <a href="{{ route('Frontend.about') }}">About</a>
                                        </li> 

                                        <li class="{{ request()->routeIs('Frontend.contact') ? 'current' : '' }}">
                                            <a href="{{ route('Frontend.contact') }}">Contact</a>
                                        </li> 
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="support-box">
                                <div class="icon-box"><i class="icon-3"></i></div>
                                <a href="tel:+94 71 631 6143">+94 71 631 6143</a>
                                <span>Call out Hotline 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--sticky Header-->
            <div class="sticky-header">
                <div class="large-container">
                    <div class="outer-box">
                        <div class="category-box">
                            <span class="text"><i class="fas fa-bars"></i>All Categories</span>
                            <ul class="category-list clearfix">
                               
                                <li class="category-dropdown">
                                    <a href="#">Engine Oil</a>
                                    <div class="list-inner">
                                        <div class="inner-box clearfix">
                                            <div class="single-column">
                                                <p>Designed Engine Oil</p>
                                                <ul>
                                                    <li><a href="shop-details.html">Deep Dish Oil</a></li>
                                                    <li><a href="shop-details.html">Mesh Pattern Oil</a></li>
                                                    <li><a href="shop-details.html">Split-Spoke Oil</a></li>
                                                    <li><a href="shop-details.html">Five-Spoke Oil</a></li>
                                                    <li><a href="shop-details.html">Blade Design Oil</a></li>
                                                </ul>
                                            </div>
                                            <div class="single-column">
                                                <p>Luxury Engine Oil</p>
                                                <ul>
                                                    <li><a href="shop-details.html">Multi-Spoke Oil</a></li>
                                                    <li><a href="shop-details.html">Monoblock Oil</a></li>
                                                    <li><a href="shop-details.html">Directional Oil</a></li>
                                                    <li><a href="shop-details.html">Honeycomb Oil</a></li>
                                                    <li><a href="shop-details.html">Twisted Spoke Oil</a></li>
                                                </ul>
                                            </div>
                                            <div class="single-column">
                                                <p>Exclusive Engine Oil</p>
                                                <ul>
                                                    <li><a href="shop-details.html">Retro Steel Oil</a></li>
                                                    <li><a href="shop-details.html">Thin-Spoke Oil</a></li>
                                                    <li><a href="shop-details.html">Diamond-Cut Oil</a></li>
                                                    <li><a href="shop-details.html">Cross-Spoke Oil</a></li>
                                                    <li><a href="shop-details.html">Star-Shaped Oil</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="shop-block">
                                            <span class="title">Only for this month</span>
                                            <h2><a href="shop-details.html">Buy the Tires</a></h2>
                                            <h4>From $99.99</h4>
                                            <a href="shop-details.html" class="link">Shop now</a>
                                            <figure class="image"><img src="assets/images/shop/shop-1.png" alt=""></figure>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="shop-details.html">Clutch & Gears</a></li>
                            </ul>
                        </div>
                        <div class="menu-area">
                            <nav class="main-menu clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </nav>
                        </div>
                        <div class="menu-right-content">
                            <div class="support-box">
                                <div class="icon-box"><i class="icon-3"></i></div>
                                <a href="tel:+94 71 631 6143">+94 71 631 6143</a>
                                <span>Call out Hotline 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- main-header end -->


        <!-- Mobile Menu  -->
        <div class="mobile-menu">
            <div class="menu-backdrop"></div>
            <div class="close-btn"><i class="fas fa-times"></i></div>
            
            <nav class="menu-box">
                <div class="nav-logo"><a href="{{ route('Frontend.index') }}"><img src="assets/images/logo.png" alt="" title=""></a></div>
                <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                <div class="contact-info">
                    <h4>Contact Info</h4>
                    <ul>
                        <li>Chicago 12, Melborne City, USA</li>
                        <li><a href="tel:+94 71 631 6143">+94 71 631 6143</a></li>
                        <li><a href="mailto:info@example.com">info@example.com</a></li>
                    </ul>
                </div>
                <div class="social-links">
                    <ul class="clearfix">
                        <li><a href="{{ route('Frontend.index') }}"><span class="fab fa-twitter"></span></a></li>
                        <li><a href="{{ route('Frontend.index') }}"><span class="fab fa-facebook-square"></span></a></li>
                        <li><a href="{{ route('Frontend.index') }}"><span class="fab fa-pinterest-p"></span></a></li>
                        <li><a href="{{ route('Frontend.index') }}"><span class="fab fa-instagram"></span></a></li>
                        <li><a href="{{ route('Frontend.index') }}"><span class="fab fa-youtube"></span></a></li>
                    </ul>
                </div>
            </nav>
        </div><!-- End Mobile Menu -->