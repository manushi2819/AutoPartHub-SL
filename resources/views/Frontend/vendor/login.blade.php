@extends('Frontend.master')

@section('title','Vendor Login')

@section('content')

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <h2>VENDOR LOGIN</h2>
            <p>Access your vendor dashboard</p>
        </div>

        <form method="POST" action="{{ route('vendor.login.store') }}">
            @csrf

            @if (session('success'))
                <div class="flash-message flash-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Display validation errors -->
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Email Field -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required class="@error('email') is-invalid @enderror">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required class="@error('password') is-invalid @enderror">
                <span class="password-toggle" onclick="togglePassword()">👁️</span>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Options 
            <div class="form-options">
                <a href="" class="forgot-link">Forgot Password?</a>
            </div>-->

            <!-- Submit Button -->
            <button type="submit" class="login-btn">LOGIN</button>
        </form>

    
        <!-- Register Link -->
        <div class="register-link">
            <p>Don't have account? <a href="{{ route('vendor.register') }}">Register</a></p>
        </div>

    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-toggle');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '🙈';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }
</script>

<style>
    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% );
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    .login-card {
        background: white;
        margin-top: 30px;
        max-width: 500px;
        width: 100%;
        padding: 48px 40px;
        position: relative;
        z-index: 1;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .login-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .login-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .login-header h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .login-header p {
        color: #666;
        font-size: 14px;
    }

    .login-form {
        margin-bottom: 24px;
    }

    .form-group {
        margin-bottom: 24px;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--primary-black);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e0e0e0;
        background: white;
        font-size: 15px;
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        color: var(--primary-black);
        box-sizing: border-box;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-red);
        background: var(--primary-red-light);
    }

    .form-group input::placeholder {
        color: #aaa;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50px;
        cursor: pointer;
        user-select: none;
        font-size: 18px;
        opacity: 0.6;
        transition: var(--transition-smooth);
    }

    .password-toggle:hover {
        opacity: 1;
    }

    .form-options {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 28px;
    }

    .forgot-link {
        color: #666;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition-smooth);
        background: none;
        border: none;
        cursor: pointer;
    }

    .forgot-link:hover {
        color: var(--primary-red-dark);
        text-decoration: underline;
    }

    .login-btn {
        width: 100%;
        padding: 16px;
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
    }

    .login-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .login-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .login-btn:hover {
        background: var(--primary-red-dark);
        transform: translateY(-2px);
    }

    .divider {
        text-align: center;
        margin: 30px 0 20px;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e0e0e0;
    }

    .divider span {
        background: white;
        padding: 0 16px;
        position: relative;
        z-index: 1;
        color: #999;
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .google-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        width: 100%;
        padding: 14px;
        background: white;
        color: var(--primary-black);
        font-weight: 600;
        text-decoration: none;
        border: 2px solid #e0e0e0;
        transition: var(--transition-smooth);
        cursor: pointer;
        border-radius: var(--card-border-radius);
        margin-top: 10px;
    }

    .google-btn:hover {
        border-color: var(--primary-red);
        background: var(--primary-red-light);
        transform: translateY(-2px);
    }

    .register-link {
        text-align: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e0e0e0;
    }

    .register-link p {
        color: #666;
        font-size: 14px;
    }

    .register-link a {
        color: var(--primary-red);
        text-decoration: none;
        font-weight: 700;
        margin-left: 8px;
        transition: var(--transition-smooth);
    }

    .register-link a:hover {
        color: var(--primary-red-dark);
        text-decoration: underline;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .error-shake {
        animation: shake 0.3s ease-in-out;
        border-color: var(--primary-red) !important;
    }

    .flash-message {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .flash-message p {
        margin: 0;
        font-size: 14px;
    }

    .flash-success {
        background: #ecffe6;
        border-left: 4px solid #4caf50;
        color: #2e7d32;
    }

    .flash-warning {
        background: #fff8e1;
        border-left: 4px solid #ffc107;
        color: #8a6d3b;
    }

    .flash-error {
        background: #ffecec;
        border-left: 4px solid #ff4d4d;
        color: #cc0000;
    }

    /* Error box */
    .error-box {
        background: #ffecec;
        border-left: 4px solid #ff4d4d;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .error-box ul {
        margin: 0;
        padding-left: 20px;
    }

    .error-box li {
        color: #cc0000;
        font-size: 14px;
    }

    /* Field error */
    .is-invalid {
        border: 2px solid #ff4d4d !important;
        background: #fff5f5;
    }

    /* Error text */
    .error-text {
        color: #ff4d4d;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 32px 24px;
        }
        
        .login-header h2 {
            font-size: 28px;
        }
    }
</style>

@endsection