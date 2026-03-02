@extends('Frontend.master')

@section('title', 'Cart')

@section('content')

      <!-- page-title -->
        <section class="page-title-two centred">
            <div class="auto-container">
                <div class="content-box">
                    <h1>Your Cart</h1>
                </div>
            </div>
        </section>
        <!-- page-title end -->


        <!-- cart section -->
        <section class="cart-section pb_80">
            <div class="auto-container">
                <div class="table-outer mb_30">
                    <table class="cart-table">
                        <thead class="cart-header">
                            <tr>
                                <th>product</th>

                                <th>price</th>
                                <th>quantity</th>
                                <th>total</th>
                                <th>&nbsp;</th>
                            </tr>    
                        </thead>
                       <tbody>
                        @forelse($cartItems as $item)
                            <tr id="cart-row-{{ $item->id }}">
                                <td class="product-column">
                                    <div class="product-box">
                                        <figure class="image-box">
                                            <img src="{{ asset('uploads/' . ($item->product->images->first()->image_url ?? 'placeholder.png')) }}" 
                                                alt="{{ $item->product->name }}">
                                        </figure>
                                        <h6><a href="{{ route('Frontend.parts-details', $item->product->id) }}">
                                            {{ $item->product->name }}
                                        </a></h6>    
                                    </div>
                                </td>

                                <td>LKR {{ number_format($item->price, 2) }}</td>
                                
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

                                <td class="item-total" data-cart-id="{{ $item->id }}">
                                    LKR {{ number_format($item->price * $item->quantity, 2) }}
                                </td>

                                <td>
                                    <button class="cancel-btn remove-cart" data-cart-id="{{ $item->id }}">
                                        <i class="icon-38"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Your cart is empty.</td>
                            </tr>
                        @endforelse
                    </tbody> 
                    </table>
                </div>
                <div class="lower-content">
                    <div class="row clearfix">
                        <div class="col-lg-8 col-md-12 col-sm-12 coupon-column">
                            <div class="coupon-box">
                                <div class="form-group">
                                    <input type="text" name="" placeholder="Apply Coupon">
                                    <button type="button"><i class="icon-27"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12 cart-column">
                            <div class="total-cart">
                                @php
                                    $subtotal = $cartItems->sum(fn($i) => $i->price * $i->quantity);
                                    $discount = 0; // calculate if needed
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
                                    <a href="{{ route('Frontend.checkout') }}" class="theme-btn" type="button">Proceed to Checkout<span></span><span></span><span></span><span></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart section end -->


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