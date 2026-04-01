@extends('Frontend.master')

@section('title', 'Login')

@section('content')

    <!-- sign-section -->
    <section class="sign-section pt_70 pb_80" style="background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% 
        );">
            <div class="auto-container">
                <div class="sec-title mb_50 centred">
                    <h2>Login to your Account</h2>
                </div>
                <div class="form-inner">
                    <form method="POST" action="{{ route('Frontend.login.authenticate') }}">
                        @csrf

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required>
                        </div>

                        <div class="form-group message-btn">
                            <button type="submit" class="theme-btn">
                                Log In<span></span><span></span><span></span><span></span>
                            </button>
                        </div>
                    </form>

                    <div class="other-option">
                        <!--<div class="check-box">
                            <input class="check" type="checkbox" id="checkbox1">
                            <label for="checkbox1">Remember me</label>
                        </div>-->
                        <button type="button" onclick="window.location='{{ route('forgot.password') }}'" class="forgot-password">
                            Forget password?
                        </button>
                    </div>
                    <div class="lower-text centred"><p>Not registered yet? <a href="{{ route('Frontend.register') }}">Create an Account</a></p></div>
                </div>
            </div>
        </section>
        <!-- sign-section end -->

 @endsection