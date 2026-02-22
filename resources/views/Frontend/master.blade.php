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

<!-- Bootstrap JS bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* Flash message container */
#flash-messages {
    position: fixed;
    top: 60px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 12px;
    width: 320px; /* adjust width as needed */
}

/* Base style for all flash messages */
.flash-message {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-weight: 500;
    font-size: 14px;
    transition: all 0.5s ease;
    opacity: 1;
    transform: translateX(0);
}

/* Fade-out animation */
.flash-message.fade-out {
    opacity: 0;
    transform: translateX(50px);
}

/* Success */
.flash-message.alert-success {
    background-color: #e6f9f0;
    color: #2f855a;
    border-left: 5px solid #2f855a;
}

/* Warning */
.flash-message.alert-warning {
    background-color: #fff7e6;
    color: #d69e2e;
    border-left: 5px solid #d69e2e;
}

/* Error / Danger */
.flash-message.alert-danger {
    background-color: #ffe6e6;
    color: #e53e3e;
    border-left: 5px solid #e53e3e;
}

/* Icon inside flash */
.flash-message .icon {
    font-size: 20px;
    margin-right: 10px;
    flex-shrink: 0;
}

/* Close button */
.flash-message .btn-close {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: inherit;
    padding: 0;
}

/* Content wrapper */
.flash-message .message-content {
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
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
