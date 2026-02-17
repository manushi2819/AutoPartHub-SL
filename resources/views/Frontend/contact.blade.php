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
                                <p>0233 Brisbane Cir. Shiloh, Australia 81063</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 info-column">
                        <div class="info-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-48"></i></div>
                                <h4>Email Address</h4>
                                <p><a href="mailto:contact@example.com">contact@example.com</a><br /><a href="mailto:support@example.com">support@example.com</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 info-column">
                        <div class="info-block-one">
                            <div class="inner-box">
                                <div class="icon-box"><i class="icon-49"></i></div>
                                <h4>Phone Number</h4>
                                <p>Emergency Cases <br /><a href="tel:2085440142">+(208) 544 -0142</a> (24/7)</p>
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
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55945.16225505631!2d-73.90847969206546!3d40.66490264739892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1601263396347!5m2!1sen!2sbd" width="100%" height="500" frameborder="0" style="border:0; width: 100%" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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
                <div class="form-inner">
                    <form method="post" action="sendemail.php" id="contact-form">
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                <input type="text" name="username" placeholder="Name" required>
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