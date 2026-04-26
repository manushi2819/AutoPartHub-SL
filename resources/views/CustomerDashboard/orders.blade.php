@extends('CustomerDashboard.layout')

@section('account-content')

<style>
    .orders-container {
        max-width: 100%;
    }
    
    .orders-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .orders-header h4 {
        margin: 0;
        color: #333;
        font-weight: 600;
    }
    
    .order-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.12);
    }
    
    .order-header {
        background: #f8f9fa;
        padding: 7px 20px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .order-title {
        display: flex;
        align-items: baseline;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .order-number {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }
    
    .order-date {
        font-size: 13px;
        color: #6c757d;
    }
    
    .order-total {
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
        margin: 0;
    }
    
    .order-body {
        padding: 5px 20px;
    }
    
    .order-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0px;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .order-status {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-confirmed {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .status-in_transit {
        background: #d4edda;
        color: #155724;
    }
    
    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }
    
    .track-btn {
        display: inline-block;
        padding: 5px 15px;
        background: linear-gradient(135deg, #486CEA 0%, #486CEA 100%);
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .track-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }
    
    .order-items {
        padding-top: 5px;
    }
    
    .items-title {
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f8f9fa;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
    
    .item-name {
        color: #495057;
        font-size: 14px;
    }
    
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    
    .empty-icon {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }
    
    .empty-state p {
        color: #6c757d;
        font-size: 16px;
        margin-bottom: 20px;
    }
    
    .shop-now-btn {
        display: inline-block;
        padding: 10px 30px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-decoration: none;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .shop-now-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }
    
    @media (max-width: 768px) {
        .order-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .order-title {
            width: 100%;
        }
        
        .order-total {
            width: 100%;
        }
        
        .order-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }


/* "Table" container */
.items-table {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Each row */
.item-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
}

/* Columns */
.item-col.image {
    width: 60px;
}

.item-col.image img {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #eee;
}

.no-img {
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    background: #f5f5f5;
    border-radius: 8px;
    color: #888;
}

.item-col.name {
    flex: 1;
}

.product-name {
    font-size: 14px;
    font-weight: 500;
    color: #333;
}

.item-col.price {
    width: 120px;
    text-align: right;
    font-size: 14px;
    color: #555;
}

.item-col.qty {
    width: 60px;
    text-align: right;
    font-weight: 600;
    color: #777;
}
</style>

<div class="orders-container">
    <h4 class="mb-3">Order History</h4>

    @forelse($orders as $order)
    <div class="order-card">
        <div class="order-header">
            <div class="order-title">
                <h5 class="order-number">Order #{{ $order->order_number }}</h5>
                <span class="order-date">{{ $order->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <div class="order-total">
                Rs {{ number_format($order->total,2) }}
            </div>
            <div class="order-info">
                <div>
                    <span class="order-status status-{{ $order->status }}">
                        @if($order->status == 'pending') ⏳ Pending
                        @elseif($order->status == 'confirmed') ✅ Confirmed
                        @elseif($order->status == 'in_transit') 🚚 In Transit
                        @elseif($order->status == 'cancelled') ❌ Cancelled
                        @endif
                    </span>
                </div>
                <a href="{{ route('customer.order.track', $order->id) }}" class="track-btn">
                     Track Order
                </a>
            </div>
        </div>
        
        <div class="order-body">
            
            @if($order->items->count() > 0)
            <div class="order-items">

                <div class="items-title">📦 Order Items</div>

                <div class="items-table">

                    @foreach($order->items as $item)
                    <div class="item-row">

                        <!-- Product Image -->
                        <div class="item-col image">
                            @if($item->product && $item->product->images->count())
                                <img src="{{ asset('uploads/' . $item->product->images->first()->image_url) }}" 
                                    alt="Product Image">
                            @else
                                <div class="no-img">No Image</div>
                            @endif
                        </div>

                        <!-- Product Name -->
                        <div class="item-col name">
                            <div class="product-name">
                                {{ $item->product->name ?? 'Product' }}
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="item-col price">
                            Rs {{ number_format($item->price ?? 0, 2) }}
                        </div>

                        <!-- Quantity -->
                        <div class="item-col qty">
                            x{{ $item->quantity }}
                        </div>

                    </div>
                    @endforeach

                </div>

            </div>
            @endif
        </div>
    </div>

    @empty
    <div class="empty-state">
        <div class="empty-icon">🛒</div>
        <p>You haven't placed any orders yet.</p>
        <a href="{{ url('/shop') }}" class="shop-now-btn">Start Shopping</a>
    </div>
    @endforelse


     <div class="pagination-wrapper mt-4">
        <ul class="pagination">

            {{-- Previous --}}
            @if ($orders->onFirstPage())
                <li class="disabled"><span>‹</span></li>
            @else
                <li>
                    <a href="{{ $orders->previousPageUrl() }}">‹</a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)

                @if ($page == $orders->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li>
                        <a href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif

            @endforeach

            {{-- Next --}}
            @if ($orders->hasMorePages())
                <li>
                    <a href="{{ $orders->nextPageUrl() }}">›</a>
                </li>
            @else
                <li class="disabled"><span>›</span></li>
            @endif

        </ul>
    </div>
</div>

@endsection