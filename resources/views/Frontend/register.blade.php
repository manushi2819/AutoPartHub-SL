@extends('Frontend.master')

@section('title', 'Register')

@section('content')

<style>


    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, 
            #e8f4ffd9 0%,  
            #fff9dbaa 50%, 
            #e8fff3 100% );
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }



    .register-card {
        background: white;
        max-width: 750px;
        width: 100%;
        padding: 48px 40px;
        position: relative;
        z-index: 1;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-smooth);
        border-radius: var(--card-border-radius);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .register-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-5px);
    }

    .register-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .register-header h2 {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-black);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .register-header p {
        color: #666;
        font-size: 14px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 0;
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

    .password-group {
        position: relative;
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

    .register-btn {
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
        margin-top: 8px;
    }

    .register-btn::before {
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

    .register-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .register-btn:hover {
        background: var(--primary-red-dark);
        transform: translateY(-2px);
    }

    .login-link {
        text-align: center;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e0e0e0;
    }

    .login-link p {
        color: #666;
        font-size: 14px;
    }

    .login-link a {
        color: var(--primary-red);
        text-decoration: none;
        font-weight: 700;
        margin-left: 8px;
        transition: var(--transition-smooth);
    }

    .login-link a:hover {
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

    /* Password strength indicator */
    .password-strength {
        margin-top: 8px;
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        overflow: hidden;
    }

    .strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.3s ease, background 0.3s ease;
    }

    .strength-text {
        font-size: 11px;
        margin-top: 5px;
        color: #666;
        display: block;
    }

    @media (max-width: 768px) {
        .register-card {
            padding: 32px 24px;
        }
        
        .register-header h2 {
            font-size: 28px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
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
    border: 1px solid #ff4d4d !important;
    background: #fff5f5;
}

/* Error text */
.error-text {
    color: #ff4d4d;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}
</style>

<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <h2>CREATE ACCOUNT</h2>
            <p>Join us and start your journey</p>
        </div>

        <form method="POST" action="{{ route('Frontend.register.store') }}" id="registerForm">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>FIRST NAME</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        value="{{ old('first_name') }}" 
                        placeholder="John"
                        class="@error('first_name') is-invalid @enderror"
                        required
                    >
                    @error('first_name')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label>LAST NAME</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        value="{{ old('last_name') }}" 
                        placeholder="Doe"
                        class="@error('last_name') is-invalid @enderror"
                        required
                    >
                    @error('last_name')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>EMAIL ADDRESS</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="hello@example.com"
                    class="@error('email') is-invalid @enderror"
                    required
                >
                @error('email')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>PHONE NUMBER</label>
                <input 
                    type="tel" 
                    name="phone" 
                    value="{{ old('phone') }}" 
                    placeholder="+1 234 567 8900"
                    class="@error('phone') is-invalid @enderror"
                    required
                >
                @error('phone')
                    <small class="error-text">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group password-group">
                    <label>PASSWORD</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••"
                        class="@error('password') is-invalid @enderror"
                        required
                        onkeyup="checkPasswordStrength()"
                    >
                    <span class="password-toggle" onclick="togglePassword('password', this)">👁️</span>

                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <small class="strength-text" id="strengthText"></small>

                    @error('password')
                        <small class="error-text">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group password-group">
                    <label>CONFIRM PASSWORD</label>
                    <input 
                        type="password" 
                        id="confirm_password" 
                        name="password_confirmation" 
                        placeholder="••••••••"
                        class="@error('password_confirmation') is-invalid @enderror"
                        required
                    >
                    <span class="password-toggle" onclick="togglePassword('confirm_password', this)">👁️</span>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="register-btn">
                    SIGN UP →
                </button>
            </div>
        </form>

        <div class="login-link">
            <p>
                Already have an account?
                <a href="{{ route('Frontend.login') }}">LOGIN HERE</a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId, icon) {
    const passwordField = document.getElementById(fieldId);
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.textContent = "🙈";
    } else {
        passwordField.type = "password";
        icon.textContent = "👁️";
    }
}

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    let strength = 0;
    let message = '';
    let color = '';
    
    if (password.length > 0) {
        // Length check
        if (password.length >= 8) strength++;
        
        // Uppercase check
        if (password.match(/[A-Z]/)) strength++;
        
        // Lowercase check
        if (password.match(/[a-z]/)) strength++;
        
        // Number check
        if (password.match(/[0-9]/)) strength++;
        
        // Special character check
        if (password.match(/[^A-Za-z0-9]/)) strength++;
        
        switch(strength) {
            case 1:
                message = 'Weak password';
                color = '#ff4444';
                break;
            case 2:
                message = 'Fair password';
                color = '#ffaa44';
                break;
            case 3:
                message = 'Strong password';
                color = '#44cc44';
                break;
            case 4:
                message = 'Very strong password!';
                color = '#00aa00';
                break;
            default:
                message = 'Very weak password';
                color = '#ff0000';
        }
        
        const width = (strength / 5) * 100;
        strengthBar.style.width = width + '%';
        strengthBar.style.background = color;
        strengthText.textContent = message;
        strengthText.style.color = color;
    } else {
        strengthBar.style.width = '0%';
        strengthText.textContent = '';
    }
}

// Confirm password validation
document.getElementById('confirm_password').addEventListener('keyup', function() {
    const password = document.getElementById('password').value;
    const confirm = this.value;
    
    if (password !== confirm && confirm.length > 0) {
        this.style.borderColor = '#ff4444';
        this.style.background = '#ffebeb';
    } else {
        this.style.borderColor = '#e0e0e0';
        this.style.background = 'white';
    }
});

</script>

@endsection