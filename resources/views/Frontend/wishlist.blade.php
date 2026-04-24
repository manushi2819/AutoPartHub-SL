@extends('Frontend.master')

@section('title', 'Wishlist')

@section('content')

<style>


    /* Wishlist Page Specific Styles */
    .wishlist-page {
   
        min-height: 100vh;
    }

    .wishlist-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
    }

    /* Page Title */
    .wishlist-title {
        text-align: center;
        margin-bottom: 2.5rem;
        margin-top: 1rem;
    }

    .wishlist-title h1 {
        font-size: 1.9rem;
        font-weight: 700;
        color: var(--primary-black);
        margin: 0;
        position: relative;
        display: inline-block;
    }

    .wishlist-title h1:after {
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
    .wishlist-table-wrapper {
        background: white;
        border-radius: var(--card-border-radius);
        box-shadow: var(--shadow-sm);
        overflow-x: auto;
        transition: var(--transition-smooth);
    }

    .wishlist-table {
        width: 100%;
        border-collapse: collapse;
    }

    .wishlist-table thead tr {
        background: #e2e2e2;
        color: black;
    }

    .wishlist-table th {
        padding: 1.25rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .wishlist-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #eef2f6;
        vertical-align: middle;
        color: #2d3e50;
        font-size: 0.95rem;
    }

    .wishlist-table tr:last-child td {
        border-bottom: none;
    }

    .wishlist-table tr:hover {
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

    /* Price */
    .price-cell {
        font-weight: 700;
        color: var(--primary-black);
        font-size: 1.05rem;
    }

    /* Stock Status */
    .stock-in {
        color: #2b7e3a;
        font-weight: 600;
        font-size: 0.85rem;
        background: #e8f5e9;
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
    }

    .stock-out {
        color: #b91c1c;
        font-weight: 600;
        font-size: 0.85rem;
        background: #fee2e2;
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
    }

    /* Buttons */
   /* Buttons */
.add-to-cart-btn {
    background: var(--primary-red);
    color: white;
    border: none;
    border-radius: 4px;
    width: 40px;
    height: 40px;
    padding: 0;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    transition: var(--transition-smooth);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.add-to-cart-btn .cart-icon {
    width: 18px;
    height: 18px;
    stroke: white;
    stroke-width: 2;
    fill: none;
}

.add-to-cart-btn:hover {
    background: var(--primary-red-dark);
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

.add-to-cart-btn:hover .cart-icon {
    stroke: white;
}

.add-to-cart-btn:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}
    .remove-btn {
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

    .remove-btn:hover {
        color: var(--primary-red);
        transform: scale(1.1);
    }

    /* Empty State */
    .empty-wishlist {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-wishlist p {
        font-size: 1.0rem;
        color: #64748b;
        margin-bottom: 1.0rem;
    }

   
    /* Responsive */
    @media (max-width: 768px) {
        .wishlist-container {
            padding: 1rem;
        }

        .wishlist-table th,
        .wishlist-table td {
            padding: 0.75rem 0.5rem;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .product-image {
            width: 40px;
            height: 40px;
        }

        .add-to-cart-btn {
            padding: 0.3rem 0.7rem;
            font-size: 0.5rem;
        }

        .wishlist-title h1 {
            font-size: 1.0rem;
        }
    }
</style>

<div class="wishlist-page">
    <div class="wishlist-container">
        <div class="wishlist-title">
            <h1>Your Wishlist</h1>
        </div>

        <div class="wishlist-table-wrapper">
            <table class="wishlist-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Add to Cart</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlistItems as $item)
                        <tr>
                            <td class="product-cell">
                                <div class="product-info">
                                    <div class="product-image">
                                        <img src="{{ asset('uploads/' . ($item->product->images->first()->image_url ?? 'placeholder.png')) }}"
                                             alt="{{ $item->product->name }}">
                                    </div>
                                    <a href="{{ route('Frontend.parts-details', $item->product->id) }}"
                                       class="product-name">
                                        {{ $item->product->name }}
                                    </a>
                                </div>
                            </td>
                            <td class="price-cell">
                                LKR {{ number_format($item->product->price, 2) }}
                            </td>
                            <td>
                                @if($item->product->stock_quantity > 0)
                                    <span class="stock-in">In Stock</span>
                                @else
                                    <span class="stock-out">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                @if($item->product->stock_quantity > 0)
                                    <button class="add-to-cart-btn"
                                            data-product-id="{{ $item->product->id }}">
                                        <svg class="cart-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                    </button>
                                @else
                                    <button class="add-to-cart-btn" disabled>
                                        <svg class="cart-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="9" cy="21" r="1"></circle>
                                            <circle cx="20" cy="21" r="1"></circle>
                                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                        </svg>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <button class="remove-btn remove-wishlist"
                                        data-id="{{ $item->id }}">
                                    ✕
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-wishlist">
                                <p>Your wishlist is empty.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // -------------------------
    // Remove Wishlist
    // -------------------------
    document.querySelectorAll('.remove-wishlist').forEach(button => {
        button.addEventListener('click', function () {
            let wishlistId = this.getAttribute('data-id');
            let row = this.closest('tr');

            fetch("{{ route('wishlist.remove') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    wishlist_id: wishlistId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    row.remove();
                    showFlash('success', data.message);
                } else {
                    showFlash('error', data.message);
                }
            })
            .catch(() => {
                showFlash('error', 'Something went wrong');
            });
        });
    });

    // -------------------------
    // Add to Cart
    // -------------------------
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function () {
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
            .then(response => response.json())
            .then(data => {
                showFlash('success', data.message || 'Product added to cart!');
            })
            .catch(() => {
                showFlash('error', 'Failed to add product.');
            });
        });
    });

});
</script>


@endsection