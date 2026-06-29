
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


            <li>
                <a href="{{ route('vendor.reviews.index') }}">
                <iconify-icon icon="mdi:star-outline" class="menu-icon"></iconify-icon>
                    <span>Reviews</span>
                </a>
    
            </li>



        </ul>



    </div>
    </aside>