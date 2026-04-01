@extends('Frontend.master')

@section('title', 'Reset Password')

@section('content')
 <section class="sign-section pt_70 pb_80" style="background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% 
        );">
            <div class="auto-container">
        <div class="sec-title mb_50 centred">
            <h2>Reset Password</h2>
        </div>

         <div class="form-inner">
        <form method="POST" action="{{ route('reset.password.post') }}">
            @csrf

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="theme-btn">Reset Password
                <span></span><span></span><span></span><span></span>
            </button>
        </form>
         </div>
    </div>
</section>
@endsection