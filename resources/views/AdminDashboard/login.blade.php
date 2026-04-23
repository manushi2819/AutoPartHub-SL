<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Admin Dashboard</title>
  <!-- Fav Icon -->
<link rel="icon" href="{{ asset('icon.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/remixicon.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/lib/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* Body + Background */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }


    @keyframes moveBG {
      0% { transform: translate(0,0); }
      100% { transform: translate(50px,50px); }
    }

    /* Login Container */
    .login-container {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      animation: fadeIn 0.8s ease-out forwards;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px);}
      100% { opacity: 1; transform: translateY(0);}
    }

    /* Glassmorphic Login Card */
    .login-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 16px;
      padding: 48px 36px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
      border: 1px solid rgba(255, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #115bcb, #2575fc);
    }

    /* Logo */
    .logo-container {
      text-align: center;
      margin-bottom: 28px;
    }

    .logo-container img {
      width: 150px;
      height: auto;
      border-radius: 12px;
      transition: transform 0.5s ease;
    }

    .logo-container img:hover {
      transform: rotate(10deg) scale(1.05);
    }

    .login-subtitle {
      font-size: 16px;
      color: rgba(98, 97, 97, 0.96);
      margin-top: 8px;
    }

    /* Form Fields */
    .form-group {
      position: relative;
      margin-bottom: 24px;
    }

    .input-wrapper {
      position: relative;
    }

    .form-label{
       color: rgb(0, 0, 0)
    }

    .form-control {
      width: 100%;
      padding: 14px 48px 14px 16px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.3);
      background: rgb(241, 241, 241);
      color: #898585;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #6a11cb;
      outline: none;
      background: rgba(255,255,255,0.1);
      box-shadow: 0 0 10px rgba(106,17,203,0.3);
    }

    .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(13, 13, 13, 0.6);
      font-size: 18px;
    }

    .password-toggle {
      position: absolute;
      right: 48px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: rgba(13, 13, 13, 0.6);
      cursor: pointer;
      font-size: 18px;
      transition: all 0.3s ease;
    }

    .password-toggle:hover {
      color: #1171cb;
    }

    /* Buttons */
    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #1171cb, #2574fccc);
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      color: #fff;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-login:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 20px rgba(0,0,0,0.3);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    /* Remember Me */
    .remember-forgot {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      margin-bottom: 20px;
      color: rgba(50, 50, 50, 0.7);
      font-size: 13px;
    }

    .remember-me input {
      margin-right: 8px;
      accent-color: #6a11cb;
    }

    /* Validation Messages */
    .validation-message {
      color: #ff6b6b;
      font-size: 12px;
      margin-top: 4px;
      display: none;
    }

    .form-control.error {
      border-color: #ff6b6b;
      background: rgba(255, 0, 0, 0.05);
    }

    .form-control.success {
      border-color: #00e676;
    }

    /* Flash Messages */
    .flash-message {
      opacity: 1;
      padding: 10px 16px;
      margin-bottom: 12px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      font-size: 13px;
      gap: 8px;
      transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .flash-message.fade-out {
      opacity: 0;
      transform: translateX(50px);
    }

    .alert-success {
      background: rgba(0,200,0,0.15);
      color: #00c853;
    }

    .alert-danger {
      background: rgba(255,0,0,0.15);
      color: #ff3d00;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <!-- Flash messages -->
    <div id="flash-messages">
      @if(session('success'))
        <div class="alert alert-success flash-message">
          <i class="ri-checkbox-circle-fill"></i>
          {{ session('success') }}
        </div>
      @endif
      @if(session('error') || session('danger'))
        <div class="alert alert-danger flash-message">
          <i class="ri-error-warning-fill"></i>
          {{ session('error') ?? session('danger') }}
        </div>
      @endif
    </div>

    <div class="login-card">
      <div class="logo-container">
        <img src="{{ asset('logo1.png') }}" alt="Logo">
        <p class="login-subtitle">Sign in to your Admin Dashboard</p>
      </div>

      <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
        @csrf
        <div class="form-group">
          <label class="form-label" for="email">Email Address</label>
          <div class="input-wrapper">
            <input type="email" id="email" name="email" placeholder="admin@example.com" required class="form-control" value="{{ old('email') }}">
            <i class="ri-mail-line input-icon"></i>
          </div>
          <div class="validation-message" id="email-error"></div>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <div class="input-wrapper">
            <input type="password" id="password" name="password" placeholder="••••••••" required class="form-control">
            <i class="ri-lock-line input-icon"></i>
            <button type="button" class="password-toggle" id="passwordToggle">
              <i class="ri-eye-line"></i>
            </button>
          </div>
          <div class="validation-message" id="password-error"></div>
        </div>


        <button type="submit" class="btn-login" id="loginButton">
          Sign In <i class="ri-arrow-right-line"></i>
        </button>
      </form>
     
    </div>
  </div>

  <script src="{{ asset('dashboard/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('dashboard/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Flash messages auto-hide
      const flashMessages = document.querySelectorAll('#flash-messages .flash-message');
      flashMessages.forEach(msg => {
        setTimeout(() => {
          msg.classList.add('fade-out');
          setTimeout(() => msg.remove(), 500);
        }, 5000);
      });

      // Password toggle
      const passwordToggle = document.getElementById('passwordToggle');
      const passwordInput = document.getElementById('password');
      if(passwordToggle && passwordInput){
        passwordToggle.addEventListener('click', function(){
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
          this.innerHTML = type === 'password' ? '<i class="ri-eye-line"></i>' : '<i class="ri-eye-off-line"></i>';
        });
      }

      // Form validation
      const loginForm = document.getElementById('loginForm');
      const loginButton = document.getElementById('loginButton');
      loginForm.addEventListener('submit', function(e){
        e.preventDefault();
        let isValid = true;
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        // reset
        document.querySelectorAll('.form-control').forEach(i=> i.classList.remove('error','success'));
        document.querySelectorAll('.validation-message').forEach(m=> m.style.display='none');

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!email){ showError('email','Email is required'); isValid=false;}
        else if(!emailRegex.test(email)){ showError('email','Enter valid email'); isValid=false;}
        else{ showSuccess('email');}

        if(!password){ showError('password','Password is required'); isValid=false;}
        else{ showSuccess('password'); }

        if(isValid){
          loginButton.classList.add('loading');
          loginButton.innerHTML='';
          setTimeout(()=>{
            loginButton.classList.remove('loading');
            loginButton.innerHTML='Sign In <i class="ri-arrow-right-line"></i>';
            this.submit();
          }, 1200);
        }
      });

      function showError(id,msg){
        const input = document.getElementById(id);
        const error = document.getElementById(id+'-error');
        input.classList.add('error');
        error.textContent = msg;
        error.style.display='block';
      }
      function showSuccess(id){
        const input = document.getElementById(id);
        input.classList.add('success');
      }
    });
  </script>
</body>
</html>
