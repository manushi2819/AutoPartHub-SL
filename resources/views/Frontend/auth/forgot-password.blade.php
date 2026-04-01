@extends('Frontend.master')

@section('title', 'Forgot Password')

@section('content')
 <!-- sign-section -->
    <section class="sign-section pt_70 pb_80" style="background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% 
        );">
            <div class="auto-container">
        <div class="sec-title mb_50 centred">
            <h2>Forgot Password</h2>
        </div>

         <div class="form-inner">
        <form method="POST" action="{{ route('send.otp') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <button type="submit" class="theme-btn">Send OTP
                <span></span><span></span><span></span><span></span>
            </button>
        </form>
        </div>
    </div>
</section>
@endsection