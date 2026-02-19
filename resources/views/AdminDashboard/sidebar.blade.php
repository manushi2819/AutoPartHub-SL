
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


            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:sitemap-outline" class="menu-icon"></iconify-icon>
                    <span>Branches & Departments</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="">
                            <i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Branches
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> Departments
                        </a>
                    </li>
                </ul>
            </li>




        </ul>



    </div>
    </aside>