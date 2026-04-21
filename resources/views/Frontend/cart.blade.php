@extends('Frontend.master')

@section('title', 'Cart')

@section('content')

<style>

    /* Cart Page Styles */
    .cart-page {
         background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% );
        min-height: 100vh;
    }

    .cart-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
    }

    /* Page Title */
    .cart-title {
        text-align: center;
        margin-bottom: 2.5rem;
        margin-top: 1rem;
    }

    .cart-title h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--primary-black);
        letter-spacing: -0.02em;
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .cart-title h1:after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-red);
    }

    /* Table Styles */
    .cart-table-wrapper {
        background: white;
        border-radius: var(--card-border-radius);
        box-shadow: var(--shadow-sm);
        overflow-x: auto;
        transition: var(--transition-smooth);
        margin-bottom: 2rem;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
    }

    .cart-table thead tr {
         background: #e2e2e2;
        color: black;
    }

    .cart-table th {
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cart-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #eef2f6;
        vertical-align: middle;
        color: #2d3e50;
        font-size: 0.95rem;
    }

    .cart-table tr:last-child td {
        border-bottom: none;
    }

    .cart-table tr:hover {
        background-color: var(--primary-red-light);
        transition: var(--transition-smooth);
    }

    /* Product Cell */
    .product-cell {
        min-width: 280px;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image {
        width: 60px;
        height: 60px;
        background: var(--light-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-smooth);
    }

    .product-info:hover .product-image img {
        transform: scale(1.05);
    }

    .product-name {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-black);
        text-decoration: none;
        transition: color 0.2s;
    }

    .product-name:hover {
        color: var(--primary-red);
    }

    /* Price & Total */
    .price-cell, .total-cell {
        font-weight: 700;
        color: var(--primary-black);
        font-size: 1rem;
    }

   
    /* Remove Button */
    .remove-cart-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: #94a3b8;
        transition: var(--transition-smooth);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
    }

    .remove-cart-btn:hover {
        color: var(--primary-red);
        transform: scale(1.1);
    }

    /* Lower Content - Coupon & Cart Total */
    .lower-content {
        margin-top: 1rem;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .coupon-column {
        flex: 2;
        min-width: 250px;
    }

    .cart-column {
        flex: 1;
        min-width: 300px;
    }

    /* Coupon Box */
    .coupon-box {
        background: white;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border-radius: var(--card-border-radius);
    }

    .form-group {
        display: flex;
        gap: 0.5rem;
    }

    .form-group input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        font-size: 0.9rem;
        transition: var(--transition-smooth);
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-red);
    }

    .form-group button {
        background: var(--primary-black);
        border: none;
        padding: 0 1.5rem;
        cursor: pointer;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-group button:hover {
        background: var(--primary-red);
    }

    .form-group button i {
        color: white;
        font-size: 1.2rem;
    }

    /* Cart Total Box */
    .total-cart {
        background: white;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border-radius: var(--card-border-radius);
    }

    .title-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
    }

    .title-box h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-black);
        margin: 0;
    }

    .title-box h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #2d3e50;
        margin: 0;
    }

    .total-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        margin-top: 0.5rem;
        border-top: 2px solid var(--primary-red);
    }

    .total-box h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-black);
        margin: 0;
    }

    .total-box h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-red);
        margin: 0;
    }

    .btn-box {
        margin-top: 1.5rem;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        background: var(--primary-red);
        color: white;
        text-align: center;
        padding: 0.9rem 1rem;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        transition: var(--transition-smooth);
        border: none;
        cursor: pointer;
    }

    .checkout-btn:hover {
        background: var(--primary-red-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    /* Empty State */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-cart p {
        font-size: 1.2rem;
        color: #64748b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-container {
            padding: 1rem;
        }

        .cart-table th,
        .cart-table td {
            padding: 0.75rem 0.5rem;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .product-image {
            width: 60px;
            height: 60px;
        }

        .row {
            flex-direction: column;
        }

        .coupon-column, .cart-column {
            min-width: auto;
        }
    }
</style>

<div class="cart-page">
    <div class="cart-container">
        <div class="cart-title">
            <h1>Your Cart</h1>
        </div>

        <div class="cart-table-wrapper">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cartItems as $item)
                        <tr id="cart-row-{{ $item->id }}">
                            <td class="product-cell">
                                <div class="product-info">
                                    <div class="product-image">
                                        <img src="{{ asset('uploads/' . ($item->product->images->first()->image_url ?? 'placeholder.png')) }}" 
                                            alt="{{ $item->product->name }}">
                                    </div>
                                    <a href="{{ route('Frontend.parts-details', $item->product->id) }}" class="product-name">
                                        {{ $item->product->name }}
                                    </a>
                                </div>
                            </td>
                            <td class="price-cell">LKR {{ number_format($item->price, 2) }}</td>
                            
                            <td class="qty">
                                <div class="item-quantity">
                                      <input 
                                            type="number"
                                            min="1"
                                            class="quantity-spinner"
                                            value="{{ $item->quantity }}"
                                            data-cart-id="{{ $item->id }}"
                                        >
                                    </div>                                
                            </td>

                            <td class="total-cell item-total" data-cart-id="{{ $item->id }}">
                                LKR {{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                            <td>
                                <button class="remove-cart-btn remove-cart" data-cart-id="{{ $item->id }}">
                                    ✕
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-cart">
                                <p>Your cart is empty.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="lower-content">
            <div class="row">
                <div class="coupon-column">
                   <!-- <div class="coupon-box">
                        <div class="form-group">
                            <input type="text" placeholder="Apply Coupon">
                            <button type="button">
                                <i class="icon-27"></i>
                            </button>
                        </div>
                    </div>-->
                </div>
                <div class="cart-column">
                    <div class="total-cart">
                        @php
                            $subtotal = $cartItems->sum(fn($i) => $i->price * $i->quantity);
                            $discount = 0;
                            $total = $subtotal - $discount;
                        @endphp

                        <div class="title-box">
                            <h4>Subtotal</h4>
                            <h5 id="cart-subtotal">LKR {{ number_format($subtotal, 2) }}</h5>
                        </div>

                        <div class="title-box">
                            <h4>Discount</h4>
                            <h5>(LKR {{ number_format($discount, 2) }})</h5>
                        </div>

                        <div class="total-box">
                            <h4>Total</h4>
                            <h5 id="cart-total">LKR {{ number_format($total, 2) }}</h5>
                        </div>

                        <div class="btn-box">
                            <a href="{{ route('Frontend.checkout') }}" class="checkout-btn">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


 <script>
document.addEventListener("DOMContentLoaded", function () {

    // Update Quantity
   $(document).ready(function () {

    // Initialize TouchSpin
    $("input.quantity-spinner").TouchSpin({
        verticalbuttons: true,
        min: 1
    });

    // Listen to TouchSpin change properly
    $(document).on('change', '.quantity-spinner', function () {

        let cartId = $(this).data('cart-id');
        let quantity = parseInt($(this).val());

        if (quantity < 1 || isNaN(quantity)) {
            quantity = 1;
            $(this).val(1);
        }

        $.ajax({
            url: "{{ route('cart.update') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cart_id: cartId,
                quantity: quantity
            },
            success: function (response) {

                if (response.success) {

                    // Update row total
                    $('.item-total[data-cart-id="' + cartId + '"]')
                        .html("LKR " + parseFloat(response.item_total)
                        .toLocaleString(undefined, {minimumFractionDigits: 2}));

                    recalculateTotals();
                }
            }
        });

    });

    function recalculateTotals() {

        let subtotal = 0;

        $('.item-total').each(function () {
            let amount = $(this).text().replace('LKR', '').replace(/,/g, '');
            subtotal += parseFloat(amount);
        });

        $('#cart-subtotal').text(
            "LKR " + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})
        );

        $('#cart-total').text(
            "LKR " + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2})
        );
    }

});

    // Delete Item
    document.querySelectorAll('.remove-cart').forEach(button => {
        button.addEventListener('click', function () {

            let cartId = this.dataset.cartId;

            fetch("{{ route('cart.delete') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    cart_id: cartId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-row-' + cartId).remove();
                    recalculateTotals();
                }
            });
        });
    });


    // Recalculate totals
    function recalculateTotals() {

        let subtotal = 0;

        document.querySelectorAll('.item-total').forEach(el => {
            let amount = el.innerText.replace('LKR', '').replace(/,/g, '');
            subtotal += parseFloat(amount);
        });

        document.getElementById('cart-subtotal').innerText =
            "LKR " + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});

        document.getElementById('cart-total').innerText =
            "LKR " + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2});
    }

});
</script>

@endsection