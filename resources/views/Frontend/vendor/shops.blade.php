@extends('Frontend.master')

@section('title','Our Shops')

@section('content')

<section class="shops-section py-5">

    <div class="container">

        <div class="text-center mb-5">
            <span class="section-tag">Verified Vendors</span>
            <h2 class="fw-bold mt-2">Our Partner Shops</h2>
            <p class="text-muted">
                Browse trusted vendors selling quality auto parts across Sri Lanka.
            </p>
        </div>

        <div class="search-box1 mb-4">
            <i class="fa fa-search"></i>
            <input type="text" id="shopSearch" placeholder="Search shops by name, address or email...">
        </div>

        <div class="row" id="shopsGrid">

            @forelse($vendors as $vendor)

                <div class="col-lg-4 col-md-6 mb-4 shop-card-item" data-search="{{ strtolower($vendor->shop_name . ' ' . ($vendor->address ?? '') . ' ' . ($vendor->email ?? '')) }}">

                    <div class="shop-card h-100">

                        <div class="shop-top">

                            <div class="shop-logo">
                                @if($vendor->logo)
                                    <img src="{{ asset($vendor->logo) }}" alt="{{ $vendor->shop_name }}">
                                @else
                                    <div class="shop-logo-fallback" aria-label="{{ $vendor->shop_name }}">
                                        {{ strtoupper(substr($vendor->shop_name ?? 'S', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="shop-heading">
                               
                                <h4>{{ $vendor->shop_name }}</h4>

                                <span class="products-badge">
                                    {{ $vendor->products_count }} Products
                                </span>
                            </div>

                        </div>


                        <div class="shop-divider"></div>
                        <ul class="shop-info">

                            <li>
                                <i class="fa fa-map-marker-alt"></i>
                                <div>
                                    <span class="info-value">Address : {{ $vendor->address }}, {{ $vendor->district }}</span>
                                </div>
                            </li>

                            <li>
                                <i class="fa fa-phone"></i>
                                <div>
                                    <span class="info-value">Contact : {{ $vendor->phone }}</span>
                                </div>
                            </li>

                            <li>
                                <i class="fa fa-envelope"></i>
                                <div>
                                    <span class="info-value">Email : {{ $vendor->email }}</span>
                                </div>
                            </li>

                        </ul>

                        <a href="{{ route('Frontend.shop', ['vendor_slug' => $vendor->slug]) }}"
                           class="btn-visit w-100">
                            Visit Store
                            <i class="fa fa-arrow-right ms-2"></i>
                        </a>

                    </div>

                </div>

            @empty

                <div class="col-12">

                    <div class="alert alert-info text-center">
                        No vendor stores available yet.
                    </div>

                </div>

            @endforelse

        </div>

        <div id="noShopsFound" class="alert alert-info text-center mt-3" style="display:none;">
            No shops match your search.
        </div>

    </div>


</section>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('shopSearch');
        const shopItems = Array.from(document.querySelectorAll('.shop-card-item'));
        const emptyState = document.getElementById('noShopsFound');

        if (!searchInput || shopItems.length === 0) return;

        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            let visibleCount = 0;

            shopItems.forEach(function (item) {
                const text = item.getAttribute('data-search') || '';
                const match = text.includes(query);
                item.style.display = match ? '' : 'none';
                if (match) visibleCount++;
            });

            if (emptyState) {
                emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
            }
        });
    });
</script>

<style>

.search-box1 input::placeholder{
    color: #999;
}

:root {
    --primary-red: #c20d0d;
    --primary-red-dark: #8b0b0b;
    --primary-black: #111111;
    --primary-gray: #6b7280;
    --light-gray: #f5f7fb;
    --surface: #ffffff;
    --card-radius: 28px;
    --shadow-soft: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
    --shadow-sm: 0 8px 22px rgba(0, 0, 0, 0.04);
    --transition: all 0.25s ease;
}

.shops-section{
    background: var(--light-gray);
}

.section-tag{
    display:inline-block;
    background: rgba(34, 194, 13, 0.08);
    color: #0c8208;
    font-weight:600;
    font-size:.75rem;
    letter-spacing:1.5px;
    text-transform:uppercase;
    padding:6px 16px;
    border-radius:50px;
}

/* Search box */
.search-box1{
    max-width: 640px;
    margin: 0 auto 30px;
    position: relative;
}

.search-box1 i{
    position: absolute;
    left: 25px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-red);
}

.search-box1 input{
    width: 100%;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 999px;
    padding: 14px 18px 14px 46px;
    background: var(--surface);
    box-shadow: var(--shadow-sm);
    outline: none;
    transition: var(--transition);
}

.search-box1 input:focus{
    border-color: rgba(194,13,13,0.3);
    box-shadow: 0 0 0 4px rgba(194,13,13,0.12);
}

/* Card */
.shop-card{
    background: var(--surface);
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
    padding: 26px 26px 24px;
    display:flex;
    flex-direction:column;
}

.shop-logo-fallback{
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #eaeaea, #8c8c8c);
    color: #fff;
    font-size: 1.8rem;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

.shop-card:hover{
    transform: translateY(-6px);
    box-shadow: var(--shadow-soft);
}

/* Top row: logo + heading */
.shop-top{
    display:flex;
    align-items:flex-start;
    gap:16px;
    margin-bottom:18px;
}

.shop-logo{
    width:72px;
    height:72px;
    border-radius:16px;
    overflow:hidden;
    flex-shrink:0;
    background: var(--primary-black);
}

.shop-logo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.shop-heading{
    flex:1;
    min-width:0;
}

.since-text{
    margin:0;
    font-size:.8rem;
    color: var(--primary-gray);
}

.shop-heading h4{
    margin:2px 0 8px;
    font-weight:700;
    color: var(--primary-black);
}

.products-badge{
    display:inline-block;
    background: rgba(194,13,13,0.08);
    color: var(--primary-red-dark);
    font-size:.78rem;
    font-weight:600;
    padding:4px 12px;
    border-radius:50px;
}


.shop-divider{
    border-top:1px solid rgba(0,0,0,.06);
    margin-bottom:18px;
}

/* Info list */
.shop-info{
    list-style:none;
    padding:0;
    margin:0 0 22px;
    flex:1;
}

.shop-info li{
    display:flex;
    align-items:flex-start;
    gap:12px;
    margin-bottom:5px;
}

.shop-info li:last-child{
    margin-bottom:0;
}

.shop-info i{
    width:18px;
    margin-top:3px;
    color: var(--primary-red);
    font-size:.95rem;
}

.info-label{
    display:block;
    font-size:.78rem;
    color: var(--primary-gray);
    margin-bottom:2px;
}

.info-value{
    display:block;
    font-size:.9rem;
    color: var(--primary-black);
    word-break:break-word;
}

/* CTA button */
.btn-visit{
    display:flex;
    align-items:center;
    justify-content:center;
    background: var(--primary-black);
    color:#fff;
    font-weight:600;
    padding:8px 0;
    border-radius:50px;
    text-decoration:none;
    transition: var(--transition);
}

.btn-visit:hover{
    background: var(--primary-red);
    color:#fff;
}

</style>

@endsection