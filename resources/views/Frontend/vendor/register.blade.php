@extends('Frontend.master')

@section('title','Vendor Register')

@section('content')

<div class="register-wrapper">
    <div class="register-card">

        <div class="register-header">
            <h2>VENDOR REGISTRATION</h2>
            <p>Create your store account</p>
        </div>

        <form method="POST" action="{{ route('vendor.register.store') }}">
            @csrf

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

            <!-- Row 1: Shop Name & Owner Name -->
            <div class="form-row">
                <div class="form-group">
                    <label for="shop_name">Shop Name</label>
                    <input type="text" id="shop_name" name="shop_name" placeholder="Shop Name" value="{{ old('shop_name') }}" required class="@error('shop_name') is-invalid @enderror">
                    @error('shop_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="owner_name">Owner Name</label>
                    <input type="text" id="owner_name" name="owner_name" placeholder="Owner Name" value="{{ old('owner_name') }}" required class="@error('owner_name') is-invalid @enderror">
                    @error('owner_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 2: Email & Phone -->
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required class="@error('email') is-invalid @enderror">
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}" required class="@error('phone') is-invalid @enderror">
                    @error('phone')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 3: NIC -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nic">NIC</label>
                    <input type="text" id="nic" name="nic" placeholder="NIC" value="{{ old('nic') }}" required class="@error('nic') is-invalid @enderror">
                    @error('nic')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Address" value="{{ old('address') }}" class="@error('address') is-invalid @enderror">
                    @error('address')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 4: District & Province -->
            <div class="form-row">
                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" id="district" name="district" placeholder="District" value="{{ old('district') }}" class="@error('district') is-invalid @enderror">
                    @error('district')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="province">Province</label>
                    <input type="text" id="province" name="province" placeholder="Province" value="{{ old('province') }}" class="@error('province') is-invalid @enderror">
                    @error('province')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 5: Bank Name & Branch Name -->
            <div class="form-row">
                <div class="form-group">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{ old('bank_name') }}" class="@error('bank_name') is-invalid @enderror">
                    @error('bank_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="branch_name">Branch Name</label>
                    <input type="text" id="branch_name" name="branch_name" placeholder="Branch Name" value="{{ old('branch_name') }}" class="@error('branch_name') is-invalid @enderror">
                    @error('branch_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 6: Account Name & Account Number -->
            <div class="form-row">
                <div class="form-group">
                    <label for="account_name">Account Name</label>
                    <input type="text" id="account_name" name="account_name" placeholder="Account Name" value="{{ old('account_name') }}" class="@error('account_name') is-invalid @enderror">
                    @error('account_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="account_number">Account Number</label>
                    <input type="text" id="account_number" name="account_number" placeholder="Account Number" value="{{ old('account_number') }}" class="@error('account_number') is-invalid @enderror">
                    @error('account_number')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Row 7: Password & Confirm Password -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" required class="@error('password') is-invalid @enderror">
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <span class="strength-text" id="strengthText">Enter a strong password</span>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required class="@error('password_confirmation') is-invalid @enderror">
                    @error('password_confirmation')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="register-btn">REGISTER AS VENDOR</button>
        </form>

        <div class="login-link">
            <p>Already registered? <a href="{{ route('vendor.login') }}">Login</a></p>
        </div>

    </div>
</div>

<script>
    // Password strength indicator
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        if (password) {
            password.addEventListener('input', function() {
                const val = this.value;
                let strength = 0;
                
                if (val.length >= 8) strength += 25;
                if (val.match(/[a-z]/)) strength += 25;
                if (val.match(/[A-Z]/)) strength += 25;
                if (val.match(/[0-9]/)) strength += 25;
                
                strengthBar.style.width = strength + '%';
                
                if (strength <= 25) {
                    strengthBar.style.background = '#ff4d4d';
                    strengthText.textContent = 'Weak';
                    strengthText.style.color = '#ff4d4d';
                } else if (strength <= 50) {
                    strengthBar.style.background = '#ffa500';
                    strengthText.textContent = 'Fair';
                    strengthText.style.color = '#ffa500';
                } else if (strength <= 75) {
                    strengthBar.style.background = '#ffd700';
                    strengthText.textContent = 'Good';
                    strengthText.style.color = '#ffd700';
                } else {
                    strengthBar.style.background = '#00c853';
                    strengthText.textContent = 'Strong';
                    strengthText.style.color = '#00c853';
                }
                
                if (val.length === 0) {
                    strengthBar.style.width = '0%';
                    strengthText.textContent = 'Enter a strong password';
                    strengthText.style.color = '#666';
                }
            });
        }
    });
</script>

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
</style>

@endsection