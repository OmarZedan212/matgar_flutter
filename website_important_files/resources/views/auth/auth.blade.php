@extends('layouts.guest')
@section('title','Account')

@push('head')
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow: hidden;
      background: linear-gradient(-45deg, #0f1e3d, #1c3158, #3b82f6, #80bbd1);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .container {
        width: 928px;
        max-width: 90%;
        min-height: 550px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        display: flex;
        position: relative;
        height: 673px;
    }
    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      width: 50%;
      transition: all 0.6s cubic-bezier(1, -0.4, 0.5, 1);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form {
      width: 80%;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .form h2 {
      margin-bottom: 20px;
      font-size: 28px;
      color: #fff;
      font-weight: 700;
    }

    .form input {
      width: 100%;
      padding: 12px 15px;
      margin: 8px 0;
      border: none;
      border-radius: 8px;
      background-color: rgba(255,255,255, 0.9);
      outline: none;
      font-size: 14px;
    }

    .form button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      border: none;
      border-radius: 8px;
      background: #3b82f6;
      color: #ffffff;
      font-size: 14px;
      font-weight: bold;
      text-transform: uppercase;
      cursor: pointer;
      transition: 0.3s;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .form button:hover {
      background: #2563eb;
      transform: translateY(-2px);
    }

    .form a,
    .form .forgot-pass {
      margin-top: 15px;
      font-size: 13px;
      color: #fff;
      text-decoration: none;
      cursor: pointer;
      border: none;
      width: auto;
    }

    .form a:hover,
    .form .forgot-pass:hover {
      text-decoration: underline;
    }

    /* Overlay */
    .overlay-container {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      transition: transform 0.6s ease-in-out;
      z-index: 100;
    }

    .overlay {
      background: linear-gradient(to right, #1c3158, #3b82f6);
      color: #ffffff;
      position: relative;
      left: -100%;
      height: 100%;
      width: 200%;
      transform: translateX(0);
      transition: transform 0.6s ease-in-out;
    }

    .overlay-panel {
      position: absolute;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 0 40px;
      height: 100%;
      width: 50%;
      text-align: center;
      top: 0;
      transform: translateX(0);
      transition: transform 0.6s ease-in-out;
    }

    .overlay-left { transform: translateX(-20%); }
    .overlay-right { right: 0; transform: translateX(0); }

    .overlay-panel h2 {
      font-size: 30px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .overlay-panel p {
      font-size: 14px;
      line-height: 20px;
      margin-bottom: 30px;
    }

    .ghost {
      background-color: transparent;
      border: 2px solid #ffffff;
      border-radius: 8px;
      padding: 10px 30px;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      cursor: pointer;
      transition: 0.3s;
    }

    .ghost:hover {
      background: #fff;
      color: #1c3158;
    }

    /* Animations */
    .login-container { left: 0; width: 50%; z-index: 2; }
    .register-container { left: 0; width: 50%; opacity: 0; z-index: 1; }

    /* Active State (Switching) - نستخدم right-panel-active بدل active */
    .container.right-panel-active .login-container {
      transform: translateX(100%);
      opacity: 0;
    }
    .container.right-panel-active .register-container {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
      animation: show 0.6s;
    }
    .container.right-panel-active .overlay-container {
      transform: translateX(-100%);
    }
    .container.right-panel-active .overlay {
      transform: translateX(50%);
    }
    .container.right-panel-active .overlay-left {
      transform: translateX(0);
    }
    .container.right-panel-active .overlay-right {
      transform: translateX(20%);
    }

    @keyframes show {
      0%, 49.99% { opacity: 0; z-index: 1; }
      50%, 100% { opacity: 1; z-index: 5; }
    }

    /* Forgot Password Modal */
    .forgot-container {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #1c3158, #3b82f6);
      z-index: 200;
      transition: top 0.5s ease;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .container.show-forgot .forgot-container {
      top: 0;
    }
    .forgot-container .form {
      width: 400px;
      max-width: 90%;
    }
    .back-btn {
      margin-top: 10px;
      background: transparent !important;
      border: 1px solid #fff !important;
    }
    .forgot-container p {
      color: #fff;
      margin-bottom: 15px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .container {
        min-height: 600px;
        flex-direction: column;
      }
      .form-container {
        width: 100%;
        height: 100%;
        position: relative;
      }
      .overlay-container {
        display: none;
      }

      .login-container,
      .register-container {
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 1;
        transform: none !important;
        z-index: 1;
        background: rgba(0,0,0,0.2);
      }

      .register-container {
        display: none; /* show login by default on mobile */
      }

      .mobile-switch {
        display: block !important;
        margin-top: 20px;
        color: #fff;
        cursor: pointer;
        text-decoration: underline;
      }
    }

    .mobile-switch { display: none; }

    /* Toast Notification */
    #toast {
      visibility: hidden;
      min-width: 300px;
      background-color: #3b82f6;
      color: #fff;
      text-align: center;
      border-radius: 50px;
      padding: 16px;
      position: fixed;
      z-index: 1000;
      left: 50%;
      bottom: 30px;
      font-size: 16px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      opacity: 0;
      transform: translateX(-50%) translateY(50px);
      transition: all 0.5s cubic-bezier(0.68,-0.55,0.265,1.55);
    }

    #toast.show {
      visibility: visible;
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    .gender-group {
      display: flex;
      gap: 20px;      /* space between male & female */
      align-items: center;
      margin-left: 150px;
      margin-top: -35px;
  }

  .gender-option {
      display: flex;
      align-items: center;
      gap: 5px;       /* space between radio circle & text */
      font-size: 16px;
      cursor: pointer;
  }
  label.gender-option {
      color: #fff;
  }
    .row-inputs {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
    }

    .input-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .input-row label {
            width: 120px;   /* space for label */
            font-weight: bold;
        }

        .input-row input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input.date {
          width: 38%;
          margin-right: 226px;
        }
        .row-half {
          display: flex;
          gap: 10px;
          margin-bottom: 15px;
        }

        .row-half .left,
        .row-half .right {
            width: 50%;
        }
.row-container {
        display: flex;
        gap: 10px;
        width: 100%;
        margin: 8px 0; /* Matches margin of other inputs */
    }

    /* 2. The Box Style (Matches your other white inputs) */
    .styled-fieldset {
        background-color: rgba(255,255,255, 0.9); /* Same background as your other inputs */
        border: 1px solid transparent; /* Keeps sizing consistent */
        border-radius: 8px;
        padding: 0 15px; /* Padding for content inside */
        flex: 1; /* Makes them split width 50/50 */
        text-align: left; /* Aligns text inside to left */
        min-width: 0;
    }

    /* 3. The Title on the Border */
    .styled-fieldset legend {
        font-size: 14px;
        color: #000000;
        font-weight: 500;
        padding-top: 19px;
    }

    /* 4. Fix inputs inside the fieldset to be transparent */
    .styled-fieldset input {
        background: transparent !important;
        border: none !important;
        padding: 5px 0 10px 0 !important;
        margin: 0 !important;
        width: 100%;
        color: #333;
    }

    /* 5. Radio button group styling */
    .radio-group {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 5px 0 10px 0;
    }
    
    .radio-group label {
        font-size: 14px;
        color: #333;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Reset radio input size so it's not huge like text inputs */
    .radio-group input[type="radio"] {
        width: auto !important;
        margin: 0 !important;
    }
    input.phone {
        margin-bottom: -6px;
    }
</style>
@endpush

@section('content')
  <div class="container" id="container">

    {{-- Register Form --}}
    <div class="form-container register-container" id="registerFormBox">
      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="_form" value="register">
        <h2>Register</h2>

        <input
          type="text"
          name="name"
          value="{{ old('name') }}"
          placeholder="Full Name"
          required
        >
        <input type="text" name="address"value="{{ old('address') }}" placeholder="Address" required>
        <input type="text" name="phone" value="{{ old('phone') }}"class="phone" placeholder="Phone" required>
        <div class="row-container">
            <fieldset class="styled-fieldset">
                <legend>Date of birth</legend>
                <input type="date"value="{{ old('dob') }}" name="dob"required>
            </fieldset>
            <fieldset class="styled-fieldset">
                <legend>Gender</legend>
                <div class="radio-group">
                    <label>
                        <input type="radio" name="gender"value="{{ old('gender') }}" value="male"required> Male
                    </label>
                    <label>
                        <input type="radio" name="gender"value="{{ old('gender') }}" value="female"required> Female
                    </label>
                </div>
            </fieldset>
        </div>
          <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="Email"
          required
        >
        <input
          type="password"
          name="password"
          placeholder="Password"
          required
        >
        <input
          type="password"
          name="password_confirmation"
          placeholder="Confirm Password"
          required
        >

        <button type="submit">Register</button>

        <p class="mobile-switch" onclick="toggleMobile('login')">
          Already have an account? Login
        </p>
      </form>
    </div>

    {{-- Login Form --}}
    <div class="form-container login-container" id="loginFormBox">
      <form class="form" method="POST" action="{{ route('login') }}">
        @csrf
        <input type="hidden" name="_form" value="login">
        <h2>Login</h2>

        <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="Email"
          required
          autofocus
        >
        <input
          type="password"
          name="password"
          placeholder="Password"
          required
          autocomplete="current-password"
        >

        <a class="forgot-pass" id="forgotLink">Forgot password?</a>
        <button type="submit">Login</button>

        <p class="mobile-switch" onclick="toggleMobile('register')">
          Don't have an account? Register
        </p>
      </form>
    </div>

    {{-- Overlay (same idea as second file) --}}
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <h2>Welcome Back!</h2>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn" type="button">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
          <h2>Hello, Friend!</h2>
          <p>Enter your personal details and start your journey with us</p>
          <button class="ghost" id="signUp" type="button">Sign Up</button>
        </div>
      </div>
    </div>

    {{-- Forgot Password --}}
    <div class="forgot-container" id="forgotContainer">
      <form class="form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="hidden" name="_form" value="forgot">
        <h2>Forgot Password</h2>
        <p>Enter your email to receive reset link</p>
        <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          placeholder="Enter your email"
          required
        >
        <button type="submit">Email Reset Link</button>
        <button type="button" class="back-btn" id="backToLogin">Back to Login</button>
      </form>
    </div>
  </div>

  {{-- Toast (يمكن تستخدمه لاحقًا مع flash messages) --}}
  <div id="toast"></div>
@endsection

@push('scripts')
<script>
  const container     = document.getElementById('container');
  const signUpBtn     = document.getElementById('signUp');
  const signInBtn     = document.getElementById('signIn');
  const forgotLink    = document.getElementById('forgotLink');
  const backToLogin   = document.getElementById('backToLogin');

  // Mobile boxes
  const loginBox      = document.getElementById('loginFormBox');
  const regBox        = document.getElementById('registerFormBox');

  // 🔁 Helpers to switch views (desktop + mobile)
  function goRegister() {
    container.classList.add('right-panel-active');
    container.classList.remove('show-forgot');

    if (window.innerWidth <= 768) {
      loginBox.style.display = 'none';
      regBox.style.display   = 'flex';
    }
  }

  function goLogin() {
    container.classList.remove('right-panel-active');
    container.classList.remove('show-forgot');

    if (window.innerWidth <= 768) {
      loginBox.style.display = 'flex';
      regBox.style.display   = 'none';
    }
  }

  function toggleMobile(view) {
    if (view === 'register') {
      goRegister();
    } else {
      goLogin();
    }
  }

  // Slider buttons (new UI)
  if (signUpBtn) {
    signUpBtn.addEventListener('click', goRegister);
  }
  if (signInBtn) {
    signInBtn.addEventListener('click', goLogin);
  }

  // Forgot Password (same idea as old file)
  if (forgotLink) {
    forgotLink.addEventListener('click', () => {
      container.classList.add('show-forgot');
    });
  }
  if (backToLogin) {
    backToLogin.addEventListener('click', () => {
      container.classList.remove('show-forgot');
    });
  }

  // ✅ URL hash logic (#register / #login) – من الملف القديم
  function fromHash() {
    const hash  = location.hash.replace('#','');
    const isReg = (hash === 'register');
    if (isReg) {
      goRegister();
    } else {
      goLogin();
    }
  }
  window.addEventListener('hashchange', fromHash);
  fromHash();

  // ✅ بعد validation errors: افتح التاب اللي كان متبعت فعلاً – منطق الملف الأول
  @if ($errors->any())
  (function () {
    const submitted = @json(old('_form')); // "login" | "register" | "forgot" | null
    if (submitted === 'register') {
      goRegister();
    } else if (submitted === 'forgot') {
      container.classList.add('show-forgot');
    } else {
      goLogin(); // default to login
    }
  })();
  @endif

  // Toast (لو حبيت تستخدمه مع سيشن فلاش مثلاً)
  function showToast(message) {
    const toast = document.getElementById('toast');
    if (!toast) return;
    toast.innerText = message;
    toast.className = 'show';
    setTimeout(() => {
      toast.className = toast.className.replace('show', '');
    }, 3000);
  }

  // مثال: لو عندك flash في السيشن تقدر تستخدمه كده
  @if (session('status'))
    showToast(@json(session('status')));
  @endif
</script>
@endpush
