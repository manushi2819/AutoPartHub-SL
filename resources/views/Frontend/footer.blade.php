
        <!-- main-footer -->
        <footer class="main-footer">
            <div class="auto-container">
                <div class="widget-section" style="padding: 70px 0px 20px 0px;">
                    <div class="row clearfix">
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget logo-widget" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="700">
                                <figure class="footer-logo"><a href="{{ route('Frontend.index') }}"><img src="{{ asset('logo.png') }}" 
                                style="width:230px" alt=""></a></figure>
                                <p>Your trusted automotive marketplace for vehicles and spare parts, featuring direct sales and auction integration for a smarter buying experience.</p>
                               
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="800">
                                <div class="widget-title">
                                    <h4>Quick Links</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        <li><a href="{{ route('Frontend.index') }}">Home</a></li>
                                        <li><a href="{{ route('Frontend.about') }}">About Us</a></li>
                                        <li><a href="{{ route('Frontend.shop') }}">Spare Parts</a></li>
                                        <li><a href="">Vehicles</a></li>
                                        <li><a href="">Auction</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                      
                           @php
                            $parentCategories = \App\Models\Category::whereNull('parent_id')
                                                ->where('status', 1)
                                                ->orderBy('name')
                                                ->take(5)
                                                ->get();
                            @endphp
                        <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                                <div class="widget-title">
                                    <h4>Categories</h4>
                                </div>
                                <div class="widget-content">
                                    <ul class="links-list clearfix">
                                        @foreach($parentCategories as $category)
                                        <li><a href="{{ route('Frontend.shop', ['category[]' => $category->id]) }}">{{ $category->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                                <div class="widget-title">
                                    <h4>Help Center</h4>
                                </div>
                              <div class="widget-content">
                                    <ul class="links-list clearfix">
                                         <li><a href="{{ route('frontend.vendor') }}">Become a Vendor</a></li>

                                        @auth('customer')
                                            <li><a href="{{ route('customer.orders') }}">Your Orders</a></li>
                                            <li><a href="{{ route('customer.profile') }}">Your Account</a></li>
                                            <li><a href="{{ route('customer.orders') }}">Track Order</a></li>
                                        @else
                                            <li><a href="javascript:void(0)" onclick="showLoginToast()">Your Orders</a></li>
                                            <li><a href="javascript:void(0)" onclick="showLoginToast()">Your Account</a></li>
                                            <li><a href="javascript:void(0)" onclick="showLoginToast()">Track Order</a></li>
                                        @endauth

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget contact-widget" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1100">
                                <div class="widget-title">
                                    <h4>Contact Info</h4>
                                </div>
                                <div class="widget-content">
                                    <p>Location: Ridigama, Kurunegala</p>
                                    <ul class="info mb_25 clearfix">
                                        <li><a href="mailto:kasthurid1234@gmail.com">kasthurid1234@gmail.com</a></li>
                                        <li><a href="tel:+94716316143">+94 71 631 6143</a></li>
                                    </ul>
                                    <ul class="social-links">
                                        <!-- Existing icons -->
                                        <li><a href="https://facebook.com/yourprofile3" target="_blank"><i class="fab fa-facebook"></i></a></li>
                                        <li><a href="https://wa.me/+94716316143" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                        <li><a href="https://instagram.com/yourprofile" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="bottom-inner">
                        <div class="copyright"><p>Copyright &copy; 2026 <a href="{{ route('Frontend.index') }}">AutoPartHub-SL
                        </a>. All Rights Reserved</p></div>
                        <ul class="footer-card clearfix">
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-1.png" alt=""></a></li>
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-2.png" alt=""></a></li>
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-3.png" alt=""></a></li>
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-4.png" alt=""></a></li>
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-5.png" alt=""></a></li>
                            <li><a href="{{ route('Frontend.index') }}"><img src="assets/images/resource/footer-card-6.png" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- main-footer end -->
<div id="loginToast" class="toast-message">
    Please login to access your account
</div>

<style>
.toast-message{
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #ff4d4f;
    color: white;
    padding: 12px 18px;
    border-radius: 6px;
    display: none;
    z-index: 9999;
    font-size: 14px;
}

/* Mobile View - 2 columns for footer widgets */
@media (max-width: 768px) {
    .main-footer .widget-section .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    
    .main-footer .widget-section .row [class*="col-"] {
        width: 50%;
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
        margin-bottom: 30px;
    }
    
    /* Optional: Adjust logo width for mobile */
    .footer-widget.logo-widget figure img {
        width: 180px !important;
    }
    
    /* Optional: Reduce text size for better readability */
    .footer-widget p {
        font-size: 13px;
    }
    
    .footer-widget .widget-title h4 {
        font-size: 16px;
    }
    
    .footer-widget .links-list li a {
        font-size: 13px;
    }
}

</style>

<script>
function showLoginToast() {
    let toast = document.getElementById("loginToast");
    toast.style.display = "block";

    setTimeout(() => {
        toast.style.display = "none";
    }, 3000);
}
</script>