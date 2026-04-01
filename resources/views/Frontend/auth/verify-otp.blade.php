@extends('Frontend.master')

@section('title', 'Verify OTP')

@section('content')
 <section class="sign-section pt_70 pb_80" style="background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% 
        );">
            <div class="auto-container">
        <div class="sec-title mb_50 centred">
            <h2>Enter OTP</h2>
        </div>

         <div class="form-inner">
        <form method="POST" action="{{ route('verify.otp.post') }}">
            @csrf

            <div class="form-group">
                <label>6 Digit OTP</label>
                <input type="text" name="otp" required maxlength="6">
            </div>

            <button type="submit" class="theme-btn">Verify OTP
                <span></span><span></span><span></span><span></span>
            </button>
        </form>
        </div>
    </div>
</section>
@endsection