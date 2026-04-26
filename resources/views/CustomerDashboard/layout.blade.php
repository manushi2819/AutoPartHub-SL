@extends('Frontend.master')

@section('title', 'My Account')

@section('content')

<style>
    /* Customer Dashboard Main Styles */

/* Layout Structure */
.account-section {
    padding: 0 0 60px 0;
    background: #f8f9fa;
    min-height: 100vh;
}


/* Sidebar Styles */
.account-info {
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.upper-box {
    background: linear-gradient(135deg, #BFDCFF 0%, #486CEA 100%);
    padding: 30px 20px;
    margin-bottom: 20px;
}

.upper-box img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 15px;
}

.upper-box h5 {
    color: white;
    font-size: 18px;
    font-weight: 600;
    margin: 10px 0 5px;
}

.upper-box small {
    color: rgba(255,255,255,0.9);
    font-size: 13px;
}

.account-info ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.account-info ul li {
    border-bottom: 1px solid #eef2f6;
}

.account-info ul li:last-child {
    border-bottom: none;
}

.account-info ul li a {
    display: block;
    padding: 15px 25px;
    color: #4a5568;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.account-info ul li a:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: linear-gradient(135deg, #BFDCFF 0%, #486CEA 100%);
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.account-info ul li a:hover,
.account-info ul li a.active {
    background: #f8f9fa;
    color: #486CEA;
    padding-left: 35px;
}

.account-info ul li a:hover:before,
.account-info ul li a.active:before {
    transform: scaleY(1);
}


/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

form input,
form textarea,
form select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #ffffff;
}

form input:focus,
form textarea:focus,
form select:focus {
    outline: none;
    border-color: #BFDCFF;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

form textarea {
    min-height: 100px;
    resize: vertical;
}


/* Responsive Styles */
@media (max-width: 768px) {
    .account-section {
        padding: 30px 0;
    }
    
    .upper-box {
        padding: 20px;
    }
    
    .upper-box img {
        width: 80px;
        height: 80px;
    }
    
    [col-md-9] > div {
        padding: 20px;
        margin-top: 20px;
    }
    
    [col-md-9] h3 {
        font-size: 20px;
    }
    
    .theme-btn,
    form button[type="submit"] {
        width: 100%;
        text-align: center;
    }
    
    .account-info ul li a:hover,
    .account-info ul li a.active {
        padding-left: 25px;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

[col-md-9] > div {
    animation: fadeIn 0.5s ease;
}


</style>



@php
    $customer = Auth::guard('customer')->user();
@endphp

 <section class="account-section">
    <section class="page-title-two centred">
    <div class="container">
        <div class="content-box">
            <h3>My Account</h3>
        </div>
    </div>
</section>
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="account-info">
                        <div class="upper-box centred mb_40">
                            <img src="{{ asset('frontend/assets/images/resource/account.jpg') }}" width="120" alt="Profile">
                            <h5>{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                            <small>{{ $customer->email }}</small>
                        </div>
                        
                        <ul>
                            <li>
                                <a href="{{ route('customer.profile') }}"
                                   class="{{ request()->routeIs('customer.profile') ? 'active' : '' }}">
                                   Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.orders') }}"
                                   class="{{ request()->routeIs('customer.orders') ? 'active' : '' }}">
                                   Orders
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.password') }}"
                                   class="{{ request()->routeIs('customer.password') ? 'active' : '' }}">
                                   Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="col-md-9 account-info p-4">
                    @yield('account-content')
                </div>
            </div>
        </div>
    </section>

@endsection