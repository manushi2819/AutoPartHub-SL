
<aside class="sidebar">


    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <img src="{{ asset('logo1.png') }}" alt="DSA logo" class="light-logo" style="width:150px">
        <img src="{{ asset('logo.png') }}" alt="DSA logo" class="dark-logo" style="width:150px">
        <img src="{{ asset('icon.png') }}" alt="DSA logo" class="logo-icon" style="width:50px">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                <span>Dashboard</span>
                </a>
    
            </li>
            <li class="sidebar-menu-group-title">Application</li>


             <li>
                <a href="{{ route('admin.categories.index') }}">
                <iconify-icon icon="mdi:view-grid-outline" class="menu-icon"></iconify-icon>
                    <span>Categories</span>
                </a>
    
            </li>

             <li>
                <a href="{{ route('admin.brands.index') }}">
                <iconify-icon icon="mdi:tag-outline" class="menu-icon"></iconify-icon>
                    <span>Brands</span>
                </a>
    
            </li>

            <li>
                <a href="{{ route('admin.vehicle-types.index') }}">
               <iconify-icon icon="mdi:car-outline" class="menu-icon"></iconify-icon>
                    <span>Vehicle Types</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.products.index') }}">
                <iconify-icon icon="mdi:package-variant-closed" class="menu-icon"></iconify-icon>
                    <span>Spare Parts</span>
                </a>
    
            </li>

             <!--<li>
                <a href="{{ route('admin.vehicles.index') }}">
                <iconify-icon icon="mdi:car-multiple" class="menu-icon"></iconify-icon>
                    <span>Vehicles</span>
                </a>
            </li>-->


            <li>
                <a href="{{ route('admin.orders.index') }}">
                <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
                    <span>Orders</span>
                </a>
    
            </li>


            <!-- <li class="dropdown">
                <a href="javascript:void(0)">
                   <iconify-icon icon="mdi:gavel" class="menu-icon"></iconify-icon>
                <span>Auction Module</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.auctions.index') }}"><i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> All Auctions</a>
                    </li>
                </ul>
            </li>-->

            <!-- <li>
                <a href="{{ route('admin.reviews.index') }}">
                <iconify-icon icon="mdi:star-outline" class="menu-icon"></iconify-icon>
                    <span>Reviews</span>
                </a>
    
            </li>-->

            
            <!-- <li>
                <a href="{{ route('admin.customers.index') }}">
                    <iconify-icon icon="mdi:account-outline" class="menu-icon"></iconify-icon>
                    <span>Customers</span>
                </a>
            </li>-->

            <!--<li>
                <a href="{{ route('admin.contact') }}">
                <iconify-icon icon="mdi:email-outline" class="menu-icon"></iconify-icon>
                    <span>Contact messages</span>
                </a>
            </li>-->



        </ul>



    </div>
    </aside>