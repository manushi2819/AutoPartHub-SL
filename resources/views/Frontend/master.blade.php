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


</body><!-- End of .page_wrapper -->
</html>
