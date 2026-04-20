@extends('Frontend.master')

@section('title', 'Login')

@section('content')

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
        margin: 10px 0;
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
    }

    .google-btn img {
        width: 20px;
        height: 20px;
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

    @media (max-width: 768px) {
        .login-card {
            padding: 32px 24px;
        }
        
        .login-header h2 {
            font-size: 28px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h2>WELCOME BACK</h2>
            <p>Sign in to continue your journey</p>
        </div>

        <form method="POST" action="{{ route('Frontend.login.authenticate') }}" id="loginForm">
            @csrf

            <div class="form-group">
                <label>EMAIL ADDRESS</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="hello@example.com"
                    required
                    autocomplete="email"
                    autofocus
                >
            </div>

            <div class="form-group">
                <label>PASSWORD</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                <span class="password-toggle" onclick="togglePassword(this)">👁️</span>
            </div>

            <div class="form-options">
                <button type="button" onclick="window.location='{{ route('forgot.password') }}'" class="forgot-link">
                    Forgot Password?
                </button>
            </div>

            <div class="form-group">
                <button type="submit" class="login-btn">
                    SIGN IN →
                </button>
            </div>
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <a href="{{ url('/auth/google') }}" class="google-btn">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google">
            <span>Continue with Google</span>
        </a>

        <div class="register-link">
            <p>
                Don't have an account?
                <a href="{{ route('Frontend.register') }}">CREATE ACCOUNT</a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(icon) {
    const passwordField = document.getElementById("password");
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.textContent = "🙈";
    } else {
        passwordField.type = "password";
        icon.textContent = "👁️";
    }
}

// Add error animation if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.classList.add('error-shake');
            setTimeout(() => {
                input.classList.remove('error-shake');
            }, 300);
        });
    });
@endif
</script>

@endsection