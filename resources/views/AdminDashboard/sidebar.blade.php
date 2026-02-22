
<aside class="sidebar">


    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <img src="{{ asset('logo3.png') }}" alt="DSA logo" class="light-logo" style="width:130px">
        <img src="{{ asset('logo4.png') }}" alt="DSA logo" class="dark-logo" style="width:130px">
        <img src="{{ asset('icon.png') }}" alt="DSA logo" class="logo-icon">
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
                <a href="{{ route('admin.products.index') }}">
                <iconify-icon icon="mdi:package-variant-closed" class="menu-icon"></iconify-icon>
                    <span>Products</span>
                </a>
    
            </li>

            <li>
                <a href="{{ route('admin.contact') }}">
                <iconify-icon icon="mdi:email-outline" class="menu-icon"></iconify-icon>
                    <span>Contact messages</span>
                </a>
    
            </li>



        </ul>



    </div>
    </aside>