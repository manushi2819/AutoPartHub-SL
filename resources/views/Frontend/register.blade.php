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
                  <form method="POST" action="{{ route('Frontend.register.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group message-btn">
                        <button type="submit" class="theme-btn">
                            Sign Up<span></span><span></span><span></span><span></span>
                        </button>
                    </div>
                </form>

                    <div class="lower-text centred"><p>Already have an account? <a href="{{ route('Frontend.login') }}">Login Here</a></p></div>
                </div>
            </div>
        </section>
        <!-- sign-section end -->

 @endsection