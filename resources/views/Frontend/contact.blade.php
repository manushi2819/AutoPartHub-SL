@extends('Frontend.master')

@section('title', 'Contact')

@section('content')

      
  <!-- contact-info-section -->
        <section class="contact-info-section pt_70 pb_50">
            <div class="auto-container">
                <div class="sec-title centred mb_50">
                    <h2>Contact Information</h2>
                </div>
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6 col-sm-12 info-column">
                        <div class="info-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-47"></i></div>
                                <h4>Our Location</h4>
                                <p>Ridigama, Kurunegala</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 info-column">
                        <div class="info-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-48"></i></div>
                                <h4>Email Address</h4>
                                <p><a href="mailto:kasthurid1234@gmail.com">kasthurid1234@gmail.com</a><br />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 info-column">
                        <div class="info-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-49"></i></div>
                                <h4>Phone Number</h4>
                                <p><a href="tel:+94716316143">+94 71 631 6143</a> (24/7)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact-info-section end -->


        <!-- google-map-section -->
        <section class="google-map-section">
            <div class="auto-container">
                <div class="map-inner">
                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31642.29862528431!2d80.44858726963813!3d7.543611671503454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3484e3ad44717%3A0x793fda3969064d5!2sRidigama!5e0!3m2!1sen!2slk!4v1771779413276!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
        <!-- google-map-section end -->


        <!-- contact-section -->
        <section class="contact-section pt_70 pb_80">
            <div class="auto-container">
                <div class="sec-title centred mb_50">
                    <h2>Send a Message</h2>
                </div>
                <div class="form-inner card1">
                    <form method="post"  action="{{ route('contact.submit') }}" id="contact-form">
                         @csrf 
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="name" placeholder="Name" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="email" name="email" placeholder="E-mail" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="phone" placeholder="Phone" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="subject" placeholder="Subject" required>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <textarea name="message" placeholder="Type message"></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn centred">
                                <button type="submit" class="theme-btn" name="submit-form">Send Message<span></span><span></span><span></span><span></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- contact-section end -->

 @endsection