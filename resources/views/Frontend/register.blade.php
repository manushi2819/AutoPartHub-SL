@extends('Frontend.master')

@section('title', 'Register')

@section('content')

     <!-- sign-section -->
        <section class="sign-section pt_70 pb_80">
            <div class="auto-container">
                <div class="sec-title mb_50 centred">
                    <h2>Create Your Account</h2>
                </div>
                <div class="form-inner">
                    <form method="post" action="signup.html">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="form-group message-btn">
                            <button type="submit" class="theme-btn">Sign Up<span></span><span></span><span></span><span></span></button>
                        </div>
                      
                    </form>
                    <div class="other-option">
                        <div class="check-box">
                            <input class="check" type="checkbox" id="checkbox1">
                            <label for="checkbox1">Remember me</label>
                        </div>
                        <button class="forgot-password">Forget password?</button>
                    </div>
                    <div class="lower-text centred"><p>Already have an account? <a href="{{ route('Frontend.login') }}">Login Here</a></p></div>
                </div>
            </div>
        </section>
        <!-- sign-section end -->

 @endsection