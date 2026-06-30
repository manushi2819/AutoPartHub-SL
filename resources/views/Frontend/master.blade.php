<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<title>AutoPartHub - SL</title>

<!-- Fav Icon -->
<link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

<!-- Stylesheets -->
<link href="{{ asset('frontend/assets/css/font-awesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/nice-select.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/aos.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/elpath.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/color.css') }}" id="jssDefault" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/rtl.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/style.css') }}" rel="stylesheet">

<link href="{{ asset('frontend/assets/css/module-css/header.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/page-title.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/banner.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/brand.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/highlights.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/shop.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/contact.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/about.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/video.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/clients.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/instagram.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/shop-sidebar.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/category.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/feature.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/flash-sales.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/cta.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/testimonial.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/footer.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/sign.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/account.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/cart.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/checkout.css') }}" rel="stylesheet">
<link href="{{ asset('frontend/assets/css/module-css/shop-details.css') }}" rel="stylesheet">


<!-- Bootstrap JS bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>

:root {
    --primary-red: #c20d0d;
    --primary-red-dark: #9b0a0a;
    --primary-red-light: #ffebeb;
    --primary-black: #0b0b0b;
    --dark-gray: #1e1e2f;
    --light-gray: #f8fafc;
    --card-border-radius: 0px;
    --shadow-sm: 0 8px 20px rgba(0, 0, 0, 0.04), 0 2px 4px rgba(0, 0, 0, 0.02);
    --shadow-hover: 0 20px 35px rgba(0, 0, 0, 0.1), 0 5px 12px rgba(0, 0, 0, 0.05);
    --transition-smooth: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
}

body {
  font-size:14px !important;
}

/* Flash message container */
#flash-messages {
    position: fixed;
    top: 80px;
    right: 24px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 14px;
    width: 360px;
    max-width: calc(100vw - 48px);
    pointer-events: none;
}

/* Base style for all flash messages */
.flash-message {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    font-weight: 600;
    font-size: 16px;
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    opacity: 1;
    transform: translateX(0) scale(1);
    pointer-events: auto;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

/* Animated border gradient */
.flash-message::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: currentColor;
    opacity: 0.3;
}

/* Fade-out animation */
.flash-message.fade-out {
    opacity: 0;
    transform: translateX(60px) scale(0.95);
    transition: all 0.3s ease;
}

/* Success */
.flash-message.alert-success {
    background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
    color: #2e7d32;
    border-left: 4px solid #4caf50;
    box-shadow: 0 8px 20px rgba(76, 175, 80, 0.2);
}

/* Warning */
.flash-message.alert-warning {
    background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
    color: #f57c00;
    border-left: 4px solid #ff9800;
    box-shadow: 0 8px 20px rgba(255, 152, 0, 0.2);
}

/* Error / Danger */
.flash-message.alert-danger {
    background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
    color: #c62828;
    border-left: 4px solid #f44336;
    box-shadow: 0 8px 20px rgba(244, 67, 54, 0.2);
}

/* Info (optional) */
.flash-message.alert-info {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1565c0;
    border-left: 4px solid #2196f3;
    box-shadow: 0 8px 20px rgba(33, 150, 243, 0.2);
}

/* Icon inside flash */
.flash-message .icon {
    font-size: 22px;
    margin-right: 12px;
    flex-shrink: 0;
    filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.1));
}

/* Close button */
.flash-message .btn-close {
    background: rgba(0, 0, 0, 0.05);
    border: none;
    font-size: 14px;
    cursor: pointer;
    color: inherit;
    padding: 6px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.25s ease;
    margin-left: 12px;
    flex-shrink: 0;
}

.flash-message .btn-close:hover {
    background: rgba(0, 0, 0, 0.15);
    transform: scale(1.1);
}

.flash-message .btn-close:active {
    transform: scale(0.95);
}

/* Content wrapper */
.flash-message .message-content {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Progress bar for auto-dismiss */
.flash-message .progress-bar {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: currentColor;
    border-radius: 0 0 0 16px;
    animation: shrink 5s linear forwards;
    opacity: 0.3;
}

@keyframes shrink {
    from {
        width: 100%;
    }
    to {
        width: 0%;
    }
}

/* Responsive */
@media (max-width: 480px) {
    #flash-messages {
        top: 70px;
        right: 12px;
        left: 12px;
        width: auto;
    }
    
    .flash-message {
        padding: 12px 14px;
        font-size: 13px;
    }
    
    .flash-message .icon {
        font-size: 18px;
        margin-right: 10px;
    }
}

/* Entry animation */
@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(100px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.flash-message {
    animation: slideInRight 0.4s cubic-bezier(0.34, 1.2, 0.64, 1) forwards;
}

/* Stack animation for multiple messages */
.flash-message:not(:last-child) {
    animation: slideInRight 0.4s cubic-bezier(0.34, 1.2, 0.64, 1) backwards;
}

/* Hover effect - pause animation on hover */
.flash-message:hover {
    transform: translateX(-2px);
    transition: transform 0.2s ease;
}

.flash-message:hover .progress-bar {
    animation-play-state: paused;
}

.form-control  {
    display: block;
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    font-size: 14px;
    color: #333;
    box-sizing: border-box;
}

.card1{
  background: #fff;
  border-radius: 5px;
  box-shadow: 0px 24px 50px 0px rgba(0, 0, 0, 0.05);
  padding: 21px 30px 21px 30px;
}

.theme-btn{
  position: relative;
  display: inline-block;
  overflow: hidden;
  vertical-align: middle;
  font-size: 18px;
  line-height: 24px;
  font-weight: 500;
  font-family: var(--text-font);
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 13px 37px;
  z-index: 1;
  background-color: #000000;
  transition: all 500ms ease;
}

.theme-btn:hover{
  color: #fff;
}

.theme-btn span {
  position: absolute;
  width: 25%;
  height: 100%;
  transform: translateY(150%);
  border-radius: 50%;
  left: calc((var(--n) - 1) * 25%);
  transition: 0.5s;
  transition-delay: calc((var(--n) - 1) * 0.1s);
  z-index: -1;
}

.theme-btn:hover span {
  transform: translateY(0) scale(2);
}

.theme-btn span:nth-child(1) {
  --n: 1;
}

.theme-btn span:nth-child(2) {
  --n: 2;
}

.theme-btn span:nth-child(3) {
  --n: 3;
}

.theme-btn span:nth-child(4) {
  --n: 4;
}


a{
    text-decoration: none !important;
}

a:hover{
   color: #e53e3e; !important;
}

/* Pagination Styling */
.pagination-wrapper {
    text-align: center;
    margin-top: 40px;
}

.pagination {
    display: inline-flex;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    display: inline-block;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    color: #333;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.pagination li a:hover {
    background: #e31e24;
    border-color: #e31e24;
    color: #fff;
}

.pagination li.active span {
    background: #e31e24;
    border-color: #e31e24;
    color: #fff;
}

.pagination li.disabled span {
    background: #f5f5f5;
    color: #999;
    cursor: not-allowed;
}

</style>
</head>


<!-- page wrapper -->
<body>

    @include('Frontend.header')

    <div class="boxed_wrapper ltr">
      @yield('content')

        <!--Scroll to top-->
        <div class="scroll-to-top">
            <div>
                <div class="scroll-top-inner">
                    <div class="scroll-bar">
                        <div class="bar-inner"></div>
                    </div>
                    <div class="scroll-bar-text">Go To Top</div>
                </div>
            </div>
        </div>
        <!-- Scroll to top end -->
        
        
        {{-- Notifications --}}
      <div id="flash-messages">
            @if(session('success'))
            <div class="flash-message alert-success">
                <div class="message-content">
                    <iconify-icon icon="bi:patch-check" class="icon"></iconify-icon>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close remove-button" aria-label="Close">&times;</button>
            </div>
            @endif

            @if(session('warning'))
            <div class="flash-message alert-warning">
                <div class="message-content">
                    <iconify-icon icon="mdi:clock-outline" class="icon"></iconify-icon>
                    <div>{{ session('warning') }}</div>
                </div>
                <button type="button" class="btn-close remove-button" aria-label="Close">&times;</button>
            </div>
            @endif

            @if(session('error') || session('danger'))
            <div class="flash-message alert-danger">
                <div class="message-content">
                    <iconify-icon icon="mingcute:delete-2-line" class="icon"></iconify-icon>
                    <div>{{ session('error') ?? session('danger') }}</div>
                </div>
                <button type="button" class="btn-close remove-button" aria-label="Close">&times;</button>
            </div>
            @endif
        </div>

    </div>

    @include('Frontend.footer')

   <!-- jequery plugins -->
<script src="{{ asset('frontend/assets/js/jquery.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wow.js') }}"></script>
<script src="{{ asset('frontend/assets/js/validation.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('frontend/assets/js/appear.js') }}"></script>
<script src="{{ asset('frontend/assets/js/isotope.js') }}"></script>
<script src="{{ asset('frontend/assets/js/parallax-scroll.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/language.js') }}"></script>
<script src="{{ asset('frontend/assets/js/countdown.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('frontend/assets/js/lenis.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/aos.js') }}"></script>

<script src="{{ asset('frontend/assets/js/product-filter.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bxslider.js') }}"></script>




<!-- main-js -->
<script src="{{ asset('frontend/assets/js/script.js') }}"></script>

 <script>
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessages = document.querySelectorAll('#flash-messages .flash-message');

        flashMessages.forEach(msg => {
            // Auto hide after 3 seconds
            setTimeout(() => {
                msg.classList.add('fade-out');
                setTimeout(() => msg.remove(), 500); // remove after fade-out
            }, 2000);

            // Manual close button
            const btn = msg.querySelector('.remove-button');
            if(btn){
                btn.addEventListener('click', () => msg.remove());
            }
        });
    });
</script>

</body><!-- End of .page_wrapper -->
</html>
