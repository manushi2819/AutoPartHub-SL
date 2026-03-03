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
</style>

<!-- Page Title -->
<section class="page-title">
    <div class="auto-container">
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
        <section class="shop-details pb_50">
            <div class="auto-container">
               <div class="product-details-content mb_45">
                   <div class="row clearfix">
                        <!-- Images -->
                        <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                            <div class="bxslider">
                                @foreach($product->images as $index => $image)
                                    <div class="slider-content">
                                        <div class="image-inner">
                                            <div class="image-box">
                                                <figure class="image" style="height:450px">
                                                    <a href="{{ asset('uploads/' . $image->image_url) }}" class="lightbox-image" data-fancybox="gallery">
                                                        <img  style="height:100%" src="{{ asset('uploads/' . $image->image_url) }}" alt="{{ $product->name }}">
                                                    </a>
                                                </figure>
                                            </div>
                                            <div class="slider-pager">
                                                <ul class="thumb-box">
                                                    @foreach($product->images as $thumbIndex => $thumb)
                                                        <li>
                                                            <a class="{{ $thumbIndex == 0 ? 'active' : '' }}" data-slide-index="{{ $thumbIndex }}" href="#">
                                                                <figure><img src="{{ asset('uploads/' . $thumb->image_url) }}" alt="{{ $product->name }}"></figure>
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
                        <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                            <div class="content-box ml_20">
                                <span class="upper-text">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                <h2>{{ $product->name }}</h2>
                                <h3>Rs. {{ number_format($product->price, 2) }}</h3>

                                <ul class="rating mb_25">
                                    {{-- Static 5-star example --}}
                                    @for($i = 0; $i < 5; $i++)
                                        <li><i class="icon-41"></i></li>
                                    @endfor
                                    <li><span>(08)</span></li>
                                </ul>

                                <div class="text-box mb_30">
                                    <p>{{ $product->small_description }}</p>
                                </div>

                                <ul class="discription-box mb_30 clearfix">
                                    <li><strong>Brand :</strong> {{ $product->brand }}</li>
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
                                    <ul class="clearfix">
                                        <li class="item-quantity">
                                            <input class="quantity-spinner" type="text" value="1" name="quantity">
                                        </li>
                                        <li class="cart-btn">
                                            <button type="button" class="theme-btn">Add To Cart<span></span><span></span><span></span><span></span></button>
                                        </li>
                                        <li class="like-btn">
                                            <button><i class="icon-7"></i></button>
                                        </li>
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
                                        <h3>Write Your Rating</h3>
                                        
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


            <div class="related-product">
                <h2>You may also like these</h2>
                <div class="inner-content clearfix">
                    @foreach($relatedProducts as $related)
                        <div class="shop-block-one">
                            <div class="inner-box d-flex flex-column">
                                <div class="image-box">
                                    <ul class="option-list">
                                        <li>
                                            <a href="{{ asset('uploads/' . ($related->images->first()->image_url ?? 'placeholder.png')) }}" 
                                            class="lightbox-image" data-fancybox="gallery">
                                            <i class="icon-12"></i>
                                            </a>
                                        </li>
                                   
                                        <li>
                                            <button type="button"><i class="icon-7"></i></button>
                                        </li>
                                    </ul>
                                   <figure class="image" style="height:200px; overflow:hidden;">
                                    <img src="{{ asset('uploads/' . ($related->images->first()->image_url ?? 'placeholder.png')) }}" 
                                        alt="{{ $related->name }}" 
                                        style="width:100%; height:100%; object-fit: cover;">
                                </figure>
                                </div>
                                <div class="lower-content mt-auto">
                                    <h4 class="product-name">
                                        <a href="{{ route('Frontend.parts-details', $related->id) }}">
                                            {{ $related->name }}
                                        </a>
                                    </h4>
                                    <h5>Rs. {{ $related->price }}</h5>
                                    <ul class="rating">
                                        @for($i=0; $i<5; $i++)
                                            <li><i class="icon-41"></i></li>
                                        @endfor
                                        <li><span>(5)</span></li>
                                    </ul>
                                    <span class="product-stock">
                                        <i class="icon-39"></i>{{ $related->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            </div>
        </section>
        <!-- shop-details end -->


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
@endsection