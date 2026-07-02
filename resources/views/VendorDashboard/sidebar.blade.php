
<aside class="sidebar">


    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>

    @php
        $vendor = null;

        if (session()->has('vendor_id')) {
            $vendor = \App\Models\Vendor::find(session('vendor_id'));
        }
    @endphp

    <div>
        <a href="{{ route('vendor.dashboard') }}" class="sidebar-logo">

            {{-- VENDOR LOGO --}}
            @if($vendor && $vendor->logo)
                <img src="{{ asset($vendor->logo) }}"
                    alt="Vendor Logo"
                    class="light-logo"
                    style="width:auto">

                <img src="{{ asset($vendor->logo) }}"
                    alt="Vendor Logo"
                    class="dark-logo"
                    style="width:auto">

            @else

            @endif

        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('vendor.dashboard') }}">
                <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                <span>Dashboard</span>
                </a>
    
            </li>
            <li class="sidebar-menu-group-title">Application</li>

           
            <li>
                <a href="{{ route('vendor.products.index') }}">
                <iconify-icon icon="mdi:package-variant-closed" class="menu-icon"></iconify-icon>
                    <span>Spare Parts</span>
                </a>
    
            </li>

            <li>
                <a href="{{ route('vendor.orders.index') }}">
                <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
                    <span>Orders</span>
                </a>
    
            </li>


    
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:wallet-plus-outline" class="menu-icon"></iconify-icon>
                <span>My Payments</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('vendor.earnings.index') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> My Earnings (Card)</a>
                    </li>
                     <li>
                        <a href="{{ route('vendor.earnings.cod.index') }}">
                            <i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> My Earnings (COD)</a>
                    </li>
                     <li>
                        <a href="{{ route('vendor.commissions-card.index') }}">
                            <i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i>Commissions (Card)</a>
                    </li>
                      <li>
                        <a href="{{ route('vendor.commissions.index') }}">
                            <i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Commissions (COD)</a>
                    </li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                <span>Reports</span> 
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('vendor.reports.earnings') }}">
                            <i class="ri-circle-fill circle-icon text-success-600 w-auto"></i> Earnings Report</a>
                    </li>
                     <li>
                        <a href="{{ route('vendor.reports.commission') }}">
                            <i class="ri-circle-fill circle-icon text-warning-600 w-auto"></i>Commission Report</a>
                    </li>
                      <li>
                        <a href="{{ route('vendor.reports.sales-summary') }}">
                            <i class="ri-circle-fill circle-icon text-danger-600 w-auto"></i> Sales Report</a>
                    </li>
                    <li>
                        <a href="{{ route('vendor.reports.settlement-report') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Payout History</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('vendor.reviews.index') }}">
                <iconify-icon icon="mdi:star-outline" class="menu-icon"></iconify-icon>
                    <span>Reviews</span>
                </a>
    
            </li>


        </ul>



    </div>
    </aside>