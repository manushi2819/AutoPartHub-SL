@extends('Frontend.master')

@section('title', 'Become a Vendor')

@section('content')

<style>

    
:root {
    --primary-red: #c20d0d;
    --primary-red-dark: #8b0b0b;
    --primary-black: #111111;
    --primary-gray: #6b7280;
    --light-gray: #f5f7fb;
    --surface: #ffffff;
    --card-radius: 28px;
    --shadow-soft: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
    --shadow-sm: 0 8px 22px rgba(0, 0, 0, 0.04);
    --transition: all 0.25s ease;
}
  
    body {
        background: #f7fafc;
    }

    .become-vendor-page {
        padding: 70px 0 60px;
    }

    /* ----- hero panel (refined) ----- */
    .hero-panel {
        background: linear-gradient(145deg, #faf0f0 0%, #ffffff 100%);
        border-radius: 40px;
        padding: 64px 40px;
        margin-bottom: 60px;
        box-shadow: var(--shadow-soft);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(194, 13, 13, 0.08);
    }

    .hero-panel::before {
        content: "🛞";
        position: absolute;
        bottom: -40px;
        right: 20px;
        font-size: 10rem;
        opacity: 0.05;
        transform: rotate(-10deg);
        pointer-events: none;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 48px;
        align-items: center;
    }

    .hero-copy h1 {
        font-size: clamp(2.0rem, 5vw, 3.2rem);
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.1;
        color: #0b0f1a;
        margin-bottom: 18px;
    }

    .hero-copy h1 span {
        color: var(--primary-red);
        background: linear-gradient(145deg, #c20d0d, #b01010);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-copy p {
        font-size: 1.1rem;
        color: var(--primary-gray);
        max-width: 540px;
        margin-bottom: 28px;
        line-height: 1.7;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
    }

    .hero-card {
        background: var(--surface);
        border-radius: var(--card-radius);
        padding: 28px 26px;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(194, 13, 13, 0.08);
        transition: var(--transition);
    }

    .hero-card:hover {
        border-color: rgba(194, 13, 13, 0.2);
    }

    .hero-card h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 8px;
    }

    .hero-card h3 i {
        color: var(--primary-red);
        margin-right: 8px;
        font-size: 1.2rem;
    }

    .hero-card p {
        color: var(--primary-gray);
        font-size: 0.98rem;
        line-height: 1.6;
    }

    .hero-card .badge-group {
        margin-top: 16px;
        display: flex;
        gap: 12px;
        font-size: 0.9rem;
        color: var(--primary-red);
    }

    .hero-card .badge-group i {
        margin-right: 4px;
    }

    /* ----- buttons ----- */
    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.85rem 2.2rem;
        border-radius: 60px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: var(--transition);
        border: 1.5px solid transparent;
        cursor: pointer;
        letter-spacing: 0.01em;
    }

    .btn-primary {
        background: var(--primary-red);
        color: #fff !important;
        border-color: var(--primary-red);
        box-shadow: 0 8px 20px rgba(194, 13, 13, 0.25);
    }
    .btn-primary:hover {
        background: var(--primary-red-dark);
        border-color: var(--primary-red-dark);
        transform: translateY(-3px);
        box-shadow: 0 14px 28px rgba(194, 13, 13, 0.3);
    }

    .btn-secondary {
        background: transparent;
        color: #1f2937 !important;
        border-color: #d1d5db;
    }
    .btn-secondary:hover {
        background: #f1f5f9;
        border-color: #9ca3af;
        transform: translateY(-2px);
    }

    /* ----- section titles ----- */
    .section-title {
        font-size: clamp(2rem, 3.2vw, 2.6rem);
        font-weight: 700;
        text-align: center;
        margin-bottom: 6px;
        color: #0b0f1a;
        letter-spacing: -0.01em;
    }

    .section-sub {
        max-width: 680px;
        margin: 0 auto 48px;
        text-align: center;
        color: var(--primary-gray);
        font-size: 1.05rem;
        line-height: 1.7;
    }

    /* ----- feature grid (4 cards) ----- */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 26px;
        margin-bottom: 60px;
    }

    .feature-card {
        background: var(--surface);
        border-radius: var(--card-radius);
        padding: 34px 28px 28px;
        border: 1px solid #f0f2f5;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .feature-card:hover {
        transform: translateY(-8px);
        border-color: rgba(194, 13, 13, 0.2);
        box-shadow: 0 18px 40px -10px rgba(194, 13, 13, 0.08);
    }

    .feature-card .icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        background: rgba(194, 13, 13, 0.08);
        color: var(--primary-red);
        font-size: 1.9rem;
        margin-bottom: 20px;
    }

    .feature-card h4 {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 8px;
    }

    .feature-card p {
        color: var(--primary-gray);
        line-height: 1.7;
        margin: 0;
        font-size: 0.96rem;
    }

    /* ----- timeline (5 steps) ----- */
    .timeline-section {
        margin-bottom: 60px;
    }

    .timeline-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 22px;
    }

    .timeline-item {
        background: var(--surface);
        border-radius: 24px;
        padding: 30px 20px 24px;
        text-align: center;
        border: 1px solid #edf2f7;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .timeline-item:hover {
        border-color: rgba(194, 13, 13, 0.25);
        transform: translateY(-4px);
    }

    .timeline-item .step-num {
        width: 52px;
        height: 52px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 30px;
        background: var(--primary-red);
        color: #fff;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 16px;
        box-shadow: 0 8px 16px rgba(194, 13, 13, 0.2);
    }

    .timeline-item h5 {
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--primary-black);
    }

    .timeline-item p {
        font-size: 0.92rem;
        color: var(--primary-gray);
        margin: 0;
        line-height: 1.6;
    }

    /* ----- checklist (6 items) ----- */
    .checklist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 18px;
        max-width: 860px;
        margin: 0 auto 54px;
    }

    .check-item {
        display: flex;
        align-items: center;
        gap: 14px;
        background: var(--surface);
        padding: 16px 22px 16px 18px;
        border-radius: 60px;
        border: 1px solid #edf2f7;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .check-item:hover {
        border-color: rgba(194, 13, 13, 0.3);
        background: #fefaf9;
    }

    .check-item span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        background: rgba(194, 13, 13, 0.10);
        color: var(--primary-red);
        border-radius: 40px;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .check-item strong {
        font-weight: 600;
        color: var(--primary-black);
        font-size: 0.96rem;
    }

    /* ----- important box (redesigned) ----- */
    .important-box {
        max-width: 960px;
        margin: 0 auto 50px;
        background: #fcf8f7;
        border-radius: 32px;
        padding: 38px 44px;
        border-left: 8px solid var(--primary-red);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-wrap: wrap;
        gap: 24px 32px;
        align-items: center;
    }

    .important-box h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0b0f1a;
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0;
    }

    .important-box h3 i {
        color: var(--primary-red);
        font-size: 1.8rem;
    }

    .important-box .imp-text {
        flex: 1;
        min-width: 200px;
    }

    .important-box .imp-text p {
        margin: 0 0 4px 0;
        color: #374151;
        line-height: 1.7;
    }

    .important-box .imp-text p:last-of-type {
        margin-bottom: 0;
    }

    .important-box .imp-text i {
        color: var(--primary-red);
        margin-right: 6px;
    }

    /* ----- bottom CTA (dark) ----- */
    .bottom-cta {
        max-width: 980px;
        margin: 0 auto 40px;
        background: #0f172a;
        border-radius: 40px;
        padding: 60px 40px;
        text-align: center;
        color: #fff;
        box-shadow: 0 30px 60px -20px rgba(0,0,0,0.4);
    }

    .bottom-cta h2 {
        font-size: clamp(1.5rem, 3.5vw, 2.2rem);
        font-weight: 700;
        margin-bottom: 14px;
        letter-spacing: -0.01em;
        color:white;
    }

    .bottom-cta p {
        color: rgba(255,255,255,0.75);
        max-width: 600px;
        margin: 0 auto 26px;
        line-height: 1.8;
        font-size: 1.05rem;
    }

    .bottom-cta .btn-primary {
        background: #ffffff;
        color: #0f172a !important;
        border-color: #ffffff;
        box-shadow: 0 12px 24px rgba(0,0,0,0.2);
    }
    .bottom-cta .btn-primary:hover {
        background: #f1f5f9;
        transform: translateY(-3px);
    }

    .bottom-cta .btn-secondary {
        border-color: rgba(255,255,255,0.3);
        color: #fff !important;
    }
    .bottom-cta .btn-secondary:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(255,255,255,0.5);
    }

    .bottom-cta small {
        display: block;
        color: rgba(255,255,255,0.5);
        margin-top: 22px;
        font-size: 0.9rem;
    }

    /* ----- responsive ----- */
    @media (max-width: 960px) {
        .hero-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .hero-panel {
            padding: 40px 28px;
        }
    }

    @media (max-width: 720px) {
        .hero-panel { padding: 30px 18px; }
        .hero-copy h1 { font-size: 2.4rem; }
        .hero-card { padding: 22px; }
        .feature-card, .timeline-item { padding: 24px 16px; }
        .important-box { flex-direction: column; align-items: flex-start; padding: 28px 22px; }
        .bottom-cta { padding: 40px 20px; }
        .check-item { border-radius: 30px; }
    }
</style>

<div class="become-vendor-page auto-container">

    {{-- HERO PANEL --}}
    <div class="hero-panel">
        <div class="hero-grid">
            <div class="hero-copy">
                <h1>Grow your auto parts business with <span>AutoPartHubSL</span></h1>
                <p>Register today to get access to our ready-made marketplace, seamless order management, and a community of customers searching for quality vehicle parts.</p>
                <div class="hero-actions">
                    <a href="{{ route('vendor.register') }}" class="btn-primary">
                        <i class="fas fa-user-plus" style="margin-right: 10px;"></i>Apply as Vendor
                    </a>
                    <a href="{{ route('vendor.login') }}" class="btn-secondary">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Vendor Login
                    </a>
                </div>
            </div>
            <div class="hero-card">
                <h3><i class="fas fa-bolt"></i> Fast onboarding</h3>
                <p>Submit your details, upload your business information, and get approval from our team in just a few days.</p>
                <div class="badge-group">
                    <span><i class="fas fa-check-circle"></i> No Setup Fees</span>
                    <span><i class="fas fa-check-circle"></i> 24/7 support</span>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURES --}}
    <section>
        <h2 class="section-title">Why sell on AutoPartHubSL?</h2>
        <p class="section-sub">Our platform helps small and medium auto parts suppliers reach customers across Sri Lanka with a simple, commission-based model.</p>
        <div class="feature-grid">
            <div class="feature-card">
                <div class="icon"><i class="fas fa-chart-line"></i></div>
                <h4>More visibility</h4>
                <p>Your products appear in front of buyers searching for car parts and accessories.</p>
            </div>
            <div class="feature-card">
                <div class="icon"><i class="fas fa-rocket"></i></div>
                <h4>Quick setup</h4>
                <p>Complete registration in minutes and start listing products without technical setup.</p>
            </div>
            <div class="feature-card">
                <div class="icon"><i class="fas fa-tasks"></i></div>
                <h4>Easy order flow</h4>
                <p>Manage orders, inventory, and deliveries from one vendor dashboard.</p>
            </div>
            <div class="feature-card">
                <div class="icon"><i class="fas fa-shield-alt"></i></div>
                <h4>Secure payments</h4>
                <p>Receive payments on time and let customers choose from online or cash-on-delivery.</p>
            </div>
        </div>
    </section>

    {{-- TIMELINE --}}
    <section class="timeline-section">
        <h2 class="section-title">How it works</h2>
        <p class="section-sub">Join the platform in five clear steps, from registration to your first sale.</p>
        <div class="timeline-list">
            <div class="timeline-item">
                <div class="step-num">1</div>
                <h5>Register</h5>
                <p>Complete the vendor form and submit your business details.</p>
            </div>
            <div class="timeline-item">
                <div class="step-num">2</div>
                <h5>Verification</h5>
                <p>Our team reviews your profile and confirms your eligibility.</p>
            </div>
            <div class="timeline-item">
                <div class="step-num">3</div>
                <h5>Approval</h5>
                <p>Once approved, you can access your vendor dashboard immediately.</p>
            </div>
            <div class="timeline-item">
                <div class="step-num">4</div>
                <h5>List products</h5>
                <p>Add parts, set prices, and start selling to customers across the country.</p>
            </div>
            <div class="timeline-item">
                <div class="step-num">5</div>
                <h5>Get paid</h5>
                <p>Receive payouts for successful orders and grow your business steadily.</p>
            </div>
        </div>
    </section>



    {{-- IMPORTANT BOX --}}
    <div class="important-box">
        <h3><i class="fas fa-info-circle"></i> Important to know</h3>
        <div class="imp-text">
            <p><i class="fas fa-check-circle"></i> Vendor registration is free and approval depends on the completeness of your application.</p>
            <p><i class="fas fa-check-circle"></i> Only approved vendors can list products. Keep your business information accurate for faster verification.</p>
            <p><i class="fas fa-check-circle"></i> AutoPartHubSL charges a small commission only after successful sales — no monthly fees to worry about.</p>
        </div>
    </div>

    {{-- BOTTOM CTA --}}
    <div class="bottom-cta">
        <h2>Ready to become a trusted AutoPartHubSL vendor?</h2>
        <p>Sign up now and start listing your auto parts to thousands of customers looking for quality and reliability.</p>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 16px;">
            <a href="{{ route('vendor.register') }}" class="btn-primary">
                <i class="fas fa-user-plus" style="margin-right: 10px;"></i>Register Now
            </a>
            <a href="{{ route('vendor.login') }}" class="btn-secondary">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>Vendor Login
            </a>
        </div>
        <small>Already registered? Login to access your vendor dashboard.</small>
    </div>

</div>

@endsection