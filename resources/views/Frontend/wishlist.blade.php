@extends('Frontend.master')

@section('title', 'Wishlist')

@section('content')

      <!-- page-title -->
        <section class="page-title-two centred">
            <div class="auto-container">
                <div class="content-box">
                    <h1>Your Wishlist</h1>
                </div>
            </div>
        </section>
        <!-- page-title end -->


<!-- wishlist section -->
<section class="cart-section pb_80">
    <div class="auto-container">

        <div class="table-outer mb_30">
            <table class="cart-table">
                <thead class="cart-header">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Add to Cart</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($wishlistItems as $item)
                        <tr>
                            <td class="product-column">
                                <div class="product-box">
                                    <figure class="image-box">
                                        <img src="{{ asset('uploads/' . ($item->product->images->first()->image_url ?? 'placeholder.png')) }}"
                                             alt="{{ $item->product->name }}"
                                             style="width:80px; height:80px; object-fit:cover;">
                                    </figure>

                                    <h6 class="wishlist-product-name">
                                        <a href="{{ route('Frontend.parts-details', $item->product->id) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h6>
                                </div>
                            </td>

                            <td>
                                LKR {{ number_format($item->product->price, 2) }}
                            </td>

                            <td>
                                @if($item->product->stock_quantity > 0)
                                    <span class="text-success">In Stock</span>
                                @else
                                    <span class="text-danger">Out of Stock</span>
                                @endif
                            </td>

                            <td>
                                @if($item->product->stock_quantity > 0)
                                    <button class="theme-btn cart-btn"
                                            data-product-id="{{ $item->product->id }}">
                                        Add To Cart
                                        <span></span><span></span><span></span><span></span>
                                    </button>
                                @else
                                    <button class="theme-btn" disabled>Unavailable</button>
                                @endif
                            </td>

                            <td>
                                <button class="cancel-btn remove-wishlist"
                                        data-id="{{ $item->id }}">
                                    <i class="icon-38"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Your wishlist is empty.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {

    function showFlash(type, message) {

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
            <button type="button" class="btn-close remove-button">&times;</button>
        `;

        container.appendChild(div);

        div.querySelector('.remove-button').addEventListener('click', function() {
            div.remove();
        });

        setTimeout(() => div.remove(), 3000);
    }


    // ✅ WISHLIST ADD TO CART
    document.querySelectorAll('.cart-btn').forEach(btn => {

        btn.addEventListener('click', function() {

            const productId = this.dataset.productId;

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Something went wrong');
                }
                return response.json();
            })
            .then(data => {
                showFlash('success', data.message || 'Product added to cart!');
            })
            .catch(error => {
                showFlash('danger', 'Failed to add product.');
                console.error(error);
            });

        });

    });

});
</script>


 @endsection