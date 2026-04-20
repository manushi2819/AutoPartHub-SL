@extends('Frontend.master')

@section('title', 'Part Details')

@section('content')


<style>
.product-name {
    height: 3rem; 
    line-height: 1.5rem; 
    overflow: hidden; 
}

.product-name a {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
}


/* Product Name */
h2 {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 12px 0;
    line-height: 1.3;
    letter-spacing: -0.3px;
}

/* Product Price */
h3 {
    font-size: 28px;
    font-weight: 800;
    color: #e67e22;
    margin: 0 0 15px 0;
    display: inline-block;
    position: relative;
}

/* Rating Container */
.rating {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 0;
    margin: 0 0 20px 0;
    list-style: none;
}

.rating li {
    display: inline-flex;
    align-items: center;
}

.rating li i {
    font-size: 18px;
    transition: transform 0.2s ease;
}

.rating li:last-child {
    margin-left: 8px;
}

.rating li:last-child span {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.rating li i:hover {
    transform: scale(1.1);
}

.btn-success{
    background-color: #25D366;
    border-color: #25D366;
}

/* Description Box / Product Details */
.discription-box {
    list-style: none;
    padding: 0;
    margin: 0 0 20px 0;
    background: #ffffff;
    border-radius: 0px;
    overflow: hidden;
    border: 1px solid #eee;
}

.discription-box li {
    display: flex;
    align-items: baseline;
    padding: 5px 15px;
    font-size: 14px;
    color: #555;
    border-bottom: 1px solid #f0f0f0;
    transition: background 0.2s ease;
}

.discription-box li:last-child {
    border-bottom: none;
}

.discription-box li:hover {
    background: #fafafa;
}

.discription-box li strong {
    min-width: 100px;
    font-weight: 600;
    color: #1a1a2e;
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.discription-box li i {
    margin-right: 6px;
    font-size: 14px;
}

/* Stock Status Specific */
.product-stock strong {
    color: #1a1a2e;
}

.product-stock i {
    color: #27ae60;
}

.product-stock:has(i) {
    color: #27ae60;
    font-weight: 500;
}

/* Out of Stock Styling */
.discription-box li:has(> strong + :contains('Out of Stock')) {
    color: #e74c3c;
}

/* If Out of Stock text appears without icon */
.product-stock:not(:has(i)) {
    color: #e74c3c;
    font-weight: 500;
}

/* Responsive Adjustments */
@media (max-width: 768px) {

    h2 {
        font-size: 24px;
    }
    
    h3 {
        font-size: 24px;
    }
    
    
    .discription-box li {
        flex-direction: column;
        padding: 12px 16px;
    }
    
    .discription-box li strong {
        min-width: auto;
        margin-bottom: 5px;
    }
}

/* Hover Effects */
h3:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

.rating li i {
    cursor: default;
}

/* Animation for Stock Status */
.product-stock i {
    animation: pulse 1.5s ease infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

/* Main Image Styling */
.main-image {
    border: 2px solid #eee;
    border-radius: 0px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.main-image img {
    width: 100% !important;
    object-fit: cover !important;
    border-radius: 0px;
}

.main-image:hover {
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    transform: scale(1.01);
}

/* Thumbnail Styling */
.thumb-box {
    display: flex;
    align-items: center;
    flex-wrap: wrap; /* allow wrapping if many images */
    padding: 0;
    margin: 0;
    list-style: none;
}
.thumb-box li {
    margin: 5px;
}

.thumb-item {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80px;
    height: 70px;
    border: 2px solid transparent;
    overflow: hidden;
}
.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* or use 'contain' if you want full image visible */
}

/* Active Thumbnail */
.thumb-item.active {
    border: 2px solid #ff4d00;
    box-shadow: 0 4px 10px rgba(255, 77, 0, 0.4);
}

/* Hover Effect */
.thumb-item:hover {
    border: 2px solid #ffa500;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    transform: scale(1.05);
}
</style>

<!-- Page Title -->
<section class="page-title">
    <div class="container">
        <div class="content-box">
            <ul class="bread-crumb">
                <li><a href="{{ route('Frontend.index') }}">Home</a></li>
                <li>Shop</li>
                <li>{{ $product->name }}</li>
            </ul>
        </div>
    </div>
</section>


        <!-- shop-details -->
        <section class="shop-details mb-0 mt-3">
            <div class="container">

               <div class="product-details-content mb_0">
                   <div class="row clearfix">
                    <!-- Images -->
                        <div class="col-lg-7 col-md-12 col-sm-12 image-column">
                            <div class="bxslider">
                                @foreach($product->images as $index => $image)
                                    <div class="slider-content">
                                        <div class="image-inner">
                                           <div class="image-box">
                                                <figure class="image main-image"
                                                    style="height:450px !important;
                                                      background:#fff !important;
                                                       ">

                                                    <a href="{{ asset('uploads/' . $image->image_url) }}"
                                                    class="lightbox-image"
                                                    data-fancybox="gallery"
                                                    style="width:100% !important;
                                                            height:100% !important;
                                                            display:flex !important;
                                                            align-items:center !important;
                                                            justify-content:center !important;">

                                                        <img
                                                            src="{{ asset('uploads/' . $image->image_url) }}"
                                                            alt="{{ $product->name }}"
                                                            style="width:100% !important;
                                                                height:100% !important;
                                                                object-fit:contain !important;
                                                                display:block !important;
                                                                padding:15px">
                                                    </a>

                                                </figure>
                                            </div>
                                            <div class="slider-pager">
                                                <ul class="thumb-box">
                                                    @foreach($product->images as $thumbIndex => $thumb)
                                                       <li>
                                                            <a class="{{ $thumbIndex == 0 ? 'active' : '' }} thumb-item" data-slide-index="{{ $thumbIndex }}" href="#">
                                                                <figure>
                                                                    <img src="{{ asset('uploads/' . $thumb->image_url) }}" alt="{{ $product->name }}">
                                                                </figure>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>



                        <!-- Product Info -->
                        <div class="col-lg-5 col-md-12 col-sm-12 content-column">
                            <div class="content-box ml_20">
                                <h2 style="font-size: 34px;">{{ $product->name }}</h2>
                                <h3 style="font-size: 24px; ">LKR {{ number_format($product->price, 2) }}</h3>

                                <ul class="rating">
                                    @php
                                        $avg = round($product->averageRating());
                                        $total = $product->reviewsCount();
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        <li>
                                            <i class="icon-41" style="color: {{ $i <= $avg ? '#FFD700' : '#ccc' }}"></i>
                                        </li>
                                    @endfor
                                    <li><span>({{ $total }})</span></li>
                                </ul>

                                <div class="text-box mb-1">
                                    <p>{{ $product->small_description }}</p>
                                </div>

                                <ul class="discription-box">
                                    <li><strong>Brand :</strong> {{ $product->brand->name }}</li>
                                    <li><strong>Product SKU :</strong> {{ $product->sku }}</li>
                                    <li><strong>Category :</strong> {{ $product->category->name ?? '-' }}</li>
                                    <li class="product-stock"><strong>Availability :</strong>
                                        @if($product->stock_quantity > 0)
                                            <i class="icon-39"></i> In Stock
                                        @else
                                            Out of Stock
                                        @endif
                                    </li>
                                </ul>



                             <div class="addto-cart-box mb_40">
                                <ul class="clearfix" style="display:flex; flex-wrap:wrap; gap:10px;">
                                    <li class="item-quantity" style="flex:1 1 100%;">
                                        <input class="quantity-spinner form-control" type="text" value="1" name="quantity" id="product_qty">
                                    </li>

                                    <li class="cart-btn" style="flex:1 1 100%;">
                                        <button type="button" class="theme-btn w-100" style="padding:12px; font-size:16px;">
                                            Add To Cart
                                            <span></span><span></span><span></span><span></span>
                                        </button>
                                    </li>

                                    <li style="flex:1 1 100%;">
                                        <button type="button" class="theme-btn w-100 mt-2" id="buy-now-btn" style="background:#1fad0f; padding:12px; font-size:16px;">
                                            Buy Now
                                            <span></span><span></span><span></span><span></span>
                                        </button>
                                    </li>

                                    <li class="like-btn mt-2">
                                        <button><i class="icon-7"></i></button>
                                    </li>

                                  <h6 class="mb-3 mt-3"><i class="fas fa-share-alt"></i> Share This Product</h6>

                                    @php
                                        $productLink = route('Frontend.parts-details', $product->id);
                                        $encodedLink = urlencode($productLink);
                                        $whatsappMessage = urlencode("Check out this product: $productLink");
                                    @endphp

                                    <div class="d-flex gap-2 mt-2">
                                        <!-- WhatsApp Share -->
                                        <a href="https://wa.me/?text={{ $whatsappMessage }}" 
                                        target="_blank"
                                        class="share-btn whatsapp-btn btn btn-success"
                                        style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>

                                        <!-- Facebook Share -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedLink }}" 
                                        target="_blank"
                                        class="share-btn facebook-btn btn btn-primary"
                                        style="width:40px; height:40px; display:flex; align-items:center; justify-content:center; border-radius:50%;">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </div>
                                </ul>
                            </div>

                           

                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="product-discription mb_70 card1">
                    <div class="tabs-box">
                        <div class="tab-btn-box">
                            <ul class="tab-btns tab-buttons clearfix">
                                <li class="tab-btn active-btn" data-tab="#tab-1">Description</li>
                                <li class="tab-btn" data-tab="#tab-3">Compatibility</li>
                                <li class="tab-btn" data-tab="#tab-2">Reviews</li>
                            </ul>
                        </div>
                        <div class="tabs-content">
                            <!-- Description Tab -->
                            <div class="tab active-tab" id="tab-1">
                                <div class="discription-content list-style-one pt_35">
                                        {!! $product->description !!}
                                </div>
                            </div>

                           <!-- Reviews Tab -->
                            <div class="tab" id="tab-2">
                                <div class="review-content pt_40">

                                    {{-- Existing Reviews --}}
                                    @forelse($product->reviews as $review)
                                        <div class="single-review" style="margin-bottom:20px; border-bottom:1px solid #ddd; padding-bottom:15px;">
                                            <div class="upper-box">
                                                <div class="info-box" style="display:flex; align-items:center;">
                                                    <figure class="image" style="margin-right:10px;">
                                                        <img src="{{ asset('user1.png') }}" alt="" style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
                                                    </figure>
                                                    <div class="inner">
                                                        <h4>{{ $review->name }}</h4>
                                                        <span class="date">{{ $review->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Rating Stars --}}
                                            <ul class="rating" style="list-style:none; padding:0; display:flex;">
                                                @for($i=1; $i<=5; $i++)
                                                    <li>
                                                        <i class="icon-41" style="color:{{ $i <= $review->rating ? '#FFD700' : '#ccc' }}"></i>
                                                    </li>
                                                @endfor
                                            </ul>

                                            <p>{{ $review->message }}</p>

                                            {{-- Review Images --}}
                                            @if($review->images->count())
                                                <ul class="image-list" style="display:flex; gap:5px; flex-wrap:wrap;">
                                                    @foreach($review->images as $img)
                                                        <li><img src="{{ asset('uploads/'.$img->image) }}" alt="" style="width:80px; height:80px; object-fit:cover; border-radius:5px;"></li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="single-review">No Reviews Yet</div>
                                    @endforelse

                                    {{-- Customer Review Form --}}
                                    <div class="customer-review" style="margin-top:30px;">
                                        <h3 style="font-size: 20px; ">Write Your Rating</h3>
                                        
                                        <div class="rating-box mb_25">
                                            <p>Your Rating <span>*</span></p>
                                            <div class="rating-inner" id="star-rating">
                                                {{-- Use JS to capture selected rating --}}
                                                <ul class="rating-list" style="display:flex; gap:3px;">
                                                    @for($i=1; $i<=5; $i++)
                                                        <li>
                                                            <button type="button" class="star-btn" data-value="{{ $i }}">
                                                                <i class="icon-41"></i>
                                                            </button>
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-inner">
                                            <form method="POST" action="{{ route('product.review.store', $product->id) }}" enctype="multipart/form-data">
                                                @csrf

                                                <div class="form-group">
                                                    <label>Write Your Review <span>*</span></label>
                                                    <textarea name="message" required></textarea>
                                                </div>

                                                <div class="form-group upload-field">
                                                    <label>Add Photos</label>
                                                    <input name="files[]" type="file" multiple>
                                                </div>

                                                <div class="row">
                                                    <div class="form-group col-6">
                                                        <label>Your Name <span>*</span></label>
                                                        <input type="text" name="name" required>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label>Email Address <span>*</span></label>
                                                        <input type="email" name="email" required>
                                                    </div>
                                                </div>

                                                {{-- Hidden input for rating --}}
                                                <input type="hidden" name="rating" id="rating-value" value="5">

                                                <div class="message-btn">
                                                    <button type="submit" class="theme-btn">Submit Review<span></span><span></span><span></span><span></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                         
                            <!-- Compatibility Tab -->
                            <div class="tab" id="tab-3">
                                <div class="specification-content pt_40">
                                    @if($product->compatibility)
                                        <ul class="specification-list clean">
                                            <li><strong>Brand:</strong> {{ $product->compatibility->brand }}</li>
                                            <li><strong>Model:</strong> {{ $product->compatibility->model }}</li>
                                            <li><strong>Year From:</strong> {{ $product->compatibility->year_from }}</li>
                                            <li><strong>Year To:</strong> {{ $product->compatibility->year_to }}</li>
                                            <li><strong>Engine Type:</strong> {{ $product->compatibility->engine_type }}</li>
                                            <li><strong>Engine CC:</strong> {{ $product->compatibility->engine_cc }}</li>
                                            <li><strong>Fuel Type:</strong> {{ $product->compatibility->fuel_type }}</li>
                                            <li><strong>Transmission:</strong> {{ $product->compatibility->transmission }}</li>
                                        </ul>
                                    @else
                                        <p>No compatibility information available for this product.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="container">
            <div class="related-product">
                <h2>You may also like these</h2>
                <div class="inner-content clearfix">
                    @foreach($relatedProducts as $related)
                        <div class="shop-block-one">
                            <div class="inner-box d-flex flex-column" >
                                <div class="image-box" style="height: 180px !important;">
                                    <ul class="option-list">
                                        <li>
                                            <a href="{{ asset('uploads/' . ($related->images->first()->image_url ?? 'placeholder.png')) }}" 
                                            class="lightbox-image" data-fancybox="gallery">
                                            <i class="icon-12"></i>
                                            </a>
                                        </li>
                                   
                                    </ul>
                                   <figure class="image" style="height:200px; overflow:hidden;">
                                    <img src="{{ asset('uploads/' . ($related->images->first()->image_url ?? 'placeholder.png')) }}" 
                                        alt="{{ $related->name }}" 
                                        style="width:100%; height:100%; object-fit: cover;">
                                </figure>
                                </div>
                                <div class="lower-content">
                                    <h4 class="product-name">
                                        <a href="{{ route('Frontend.parts-details', $related->id) }}">
                                            {{ $related->name }}
                                        </a>
                                    </h4>
                                    <h5>LKR {{ $related->price }}</h5>
                                        <ul class="rating">
                                            @for($i=0; $i<5; $i++)
                                                <li><i class="icon-41"></i></li>
                                            @endfor
                                            <li><span>(5)</span></li>
                                        </ul>
                               
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>

        </section>
        <!-- shop-details end -->

<style>

/* Shop block card */
.shop-block-one {
    float: left;
    width: 25%;
    padding: 0 12px !important;
    margin-bottom: 0px !important;
}

/* Responsive breakpoints */
@media (max-width: 992px) {
    .shop-block-one {
        width: 33.333%;
    }
}

@media (max-width: 768px) {
    .shop-block-one {
        width: 50%;
    }
}

@media (max-width: 576px) {
    .shop-block-one {
        width: 100%;
    }
}

.inner-box {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    height: 100%;
}

.inner-box:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

/* Flex column utilities */
.d-flex {
    display: flex;
}

.flex-column {
    flex-direction: column;
}

.mt-auto {
    margin-top: auto;
}

/* Image box */
.image-box {
    position: relative;
    background-color: #f5f5f5 !important;
    overflow: hidden;
}

.image-box .image {
    margin: 0;
    padding: 0;
    overflow: hidden;
}

.image-box .image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.inner-box:hover .image-box .image img {
    transform: scale(1.05);
}



/* Lower content */
.lower-content {
    padding: 5px;
    background: #fff;
}

.product-name {
    margin: 0 0 0px 0 !important;
    font-size: 16px !important;
    font-weight: 600;
    line-height: 1.4;
}

.product-name a {
    color: #222;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-name a:hover {
    color: #e74c3c;
}

.lower-content h5 {
    margin: 0 0 10px 0 !important;
    font-size: 18px;
    font-weight: 700;
    color: #e74c3c;
}

/* Rating stars */
.rating {
    margin: 0 0 12px 0;
    padding: 0;
    list-style: none;
    display: flex;
    align-items: center;
    gap: 3px;
}

.rating li {
    display: inline-block;
}

.rating li i {
    color: #f5b81b;
    font-style: normal;
    font-size: 13px;
}

.rating li:last-child i {
    color: #999;
    font-size: 13px;
}

.rating li span {
    color: #777;
    font-size: 12px;
    margin-left: 0px !important;
}


/* Ensure icons look decent without font */
i[class^="icon-"] {
    font-style: normal;
    font-size: 14px;
}

/* Lightbox link cursor */
.lightbox-image {
    cursor: pointer;
}

/* Button focus removal */
.option-list li button:focus {
    outline: none;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {

    function showFlash(type, message) {
        // Create a flash message element
        const container = document.getElementById('flash-messages');
        const div = document.createElement('div');
        div.className = `flash-message alert-${type}`;
        div.innerHTML = `
            <div class="message-content">
                <iconify-icon icon="${
                    type === 'success' ? 'bi:patch-check' :
                    type === 'warning' ? 'mdi:clock-outline' :
                    'mingcute:delete-2-line'
                }" class="icon"></iconify-icon>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close remove-button" aria-label="Close">&times;</button>
        `;

        container.appendChild(div);

        // Remove on close click
        div.querySelector('.remove-button').addEventListener('click', function() {
            div.remove();
        });

        // Auto remove after 3 seconds
        setTimeout(() => {
            div.remove();
        }, 3000);
    }

    // Add to Cart
    document.querySelectorAll('.cart-btn button').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = {{ $product->id }};
            const quantity = document.querySelector('input[name="quantity"]').value || 1;

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity }),
            })
            .then(res => res.json())
            .then(data => showFlash('success', data.message));
        });
    });

    // Add to Wishlist
    document.querySelectorAll('.like-btn button').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = {{ $product->id }};

            fetch("{{ route('wishlist.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId }),
            })
            .then(res => res.json())
            .then(data => showFlash('success', data.message));
        });
    });

});
</script>


<script>
document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let value = this.dataset.value;
        document.getElementById('rating-value').value = value;

        // Highlight stars
        document.querySelectorAll('.star-btn i').forEach((star, index) => {
            if(index < value) {
                star.style.color = '#FFD700';
            } else {
                star.style.color = '#ccc';
            }
        });
    });
});
</script>

<script>
    const buyNowBtn = document.getElementById('buy-now-btn');
    const qtyInput = document.getElementById('product_qty');
    const productId = "{{ $product->id }}"; // blade variable

    buyNowBtn.addEventListener('click', function() {
        const qty = qtyInput.value || 1; // default 1 if empty
        // Redirect to the buy-now route with product ID and quantity in URL
        window.location.href = `{{ url('/buy-now') }}/${productId}/${qty}`;
    });
</script>
@endsection