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
            <form method="post" action="{{ route('contact.submit') }}" id="contact-form">
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

<style>
  

    .contact-section {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }


    .contact-section .auto-container {
        position: relative;
        z-index: 1;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .contact-section .sec-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .contact-section .sec-title h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
        position: relative;
        display: inline-block;
    }

    .contact-section .sec-title h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--primary-red);
    }

    .contact-section .form-inner {
        background: white;
        padding: 48px 40px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .contact-section .form-inner:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .contact-section .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .contact-section input,
    .contact-section textarea {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid #e0e0e0;
        background: white;
        font-size: 15px;
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        color: var(--primary-black);
        font-family: inherit;
    }

    .contact-section input:focus,
    .contact-section textarea:focus {
        outline: none;
        border-color: var(--primary-red);
        background: var(--primary-red-light);
        transform: translateY(-2px);
    }

    .contact-section input::placeholder,
    .contact-section textarea::placeholder {
        color: #aaa;
        font-weight: 400;
    }

    .contact-section textarea {
        min-height: 150px;
        resize: vertical;
        line-height: 1.6;
    }

    .contact-section .theme-btn {
        width: auto;
        min-width: 200px;
        padding: 16px 32px;
        background: var(--primary-red);
        color: white;
        border: none;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }


    /* Animation for form fields */
    .contact-section .form-group {
        opacity: 0;
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .contact-section .form-group:nth-child(1) { animation-delay: 0.05s; }
    .contact-section .form-group:nth-child(2) { animation-delay: 0.1s; }
    .contact-section .form-group:nth-child(3) { animation-delay: 0.15s; }
    .contact-section .form-group:nth-child(4) { animation-delay: 0.2s; }
    .contact-section .form-group:nth-child(5) { animation-delay: 0.25s; }
    .contact-section .form-group:nth-child(6) { animation-delay: 0.3s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Error state */
    .contact-section input.error,
    .contact-section textarea.error {
        border-color: var(--primary-red);
        background: var(--primary-red-light);
        animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Success message styling */
    .contact-success {
        background: #d4edda;
        color: #155724;
        padding: 12px 20px;
        border-radius: var(--card-border-radius);
        margin-bottom: 20px;
        border-left: 4px solid #28a745;
        animation: fadeInUp 0.5s ease-out;
    }

    .contact-error {
        background: #f8d7da;
        color: #721c24;
        padding: 12px 20px;
        border-radius: var(--card-border-radius);
        margin-bottom: 20px;
        border-left: 4px solid var(--primary-red);
        animation: fadeInUp 0.5s ease-out;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .contact-section .form-inner {
            padding: 32px 24px;
        }
        
        .contact-section .sec-title h2 {
            font-size: 28px;
        }
        
        .contact-section .theme-btn {
            width: 100%;
            min-width: auto;
        }
        
        .contact-section .row {
            margin: 0;
        }
        
        .contact-section [class*="col-"] {
            padding: 0;
        }
    }

    /* Loading state for submit button */
    .contact-section .theme-btn.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .contact-section .theme-btn.loading::after {
        content: '';
        width: 18px;
        height: 18px;
        border: 2px solid white;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>



 @endsection