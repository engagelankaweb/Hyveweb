<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal Login | HYVE Real Estate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    :root {
      --color-accent: #D4AF37;
      --color-accent-hover: #E5C158;
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
    }

    body {
      background: #F4F7F6;
      color: #1E293B;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      position: relative;
      overflow-x: hidden;
      font-family: 'Roboto', sans-serif;
    }

    body::before {
      content: '';
      position: absolute;
      width: 550px;
      height: 550px;
      background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
      top: -120px;
      right: -120px;
      pointer-events: none;
    }

    body::after {
      content: '';
      position: absolute;
      width: 550px;
      height: 550px;
      background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
      bottom: -120px;
      left: -120px;
      pointer-events: none;
    }

    .login-container {
      width: 100%;
      max-width: 440px;
      background: #FFFFFF;
      border: 1px solid #E2E8F0;
      border-radius: var(--radius-lg);
      padding: 2.8rem 2.4rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      z-index: 10;
      animation: loginFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes loginFadeIn {
      from {
        opacity: 0;
        transform: translateY(24px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .login-logo {
      font-family: 'Roboto', sans-serif;
      font-size: 2.4rem;
      font-weight: 700;
      letter-spacing: -0.5px;
      color: #0F172A;
      margin-bottom: 0.4rem;
    }

    .login-logo span {
      color: var(--color-accent);
    }

    .login-subtitle {
      color: #64748B;
      font-size: 0.92rem;
      letter-spacing: 0.3px;
    }

    .alert-error {
      background: #FEF2F2;
      border: 1px solid #FECACA;
      color: #DC2626;
      padding: 12px 16px;
      border-radius: var(--radius-sm);
      font-size: 0.88rem;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: loginFadeIn 0.4s ease;
    }

    .form-group {
      margin-bottom: 1.3rem;
    }

    .form-label {
      display: block;
      color: #475569;
      font-size: 0.82rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin-bottom: 0.45rem;
    }

    .form-control {
      width: 100%;
      background: #F8FAFC;
      border: 1px solid #CBD5E1;
      border-radius: var(--radius-sm);
      padding: 12px 14px;
      color: #1E293B;
      font-family: 'Roboto', sans-serif;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--color-accent);
      background: #FFFFFF;
      box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
    }

    .form-control::placeholder {
      color: #94A3B8;
    }

    .form-check {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 1.5rem;
      font-size: 0.85rem;
      color: #475569;
      cursor: pointer;
    }

    .form-check input {
      accent-color: var(--color-accent);
      cursor: pointer;
    }

    .btn-login {
      width: 100%;
      background: var(--color-accent);
      color: #FFFFFF;
      border: none;
      border-radius: var(--radius-sm);
      padding: 14px;
      font-family: 'Roboto', sans-serif;
      font-weight: 700;
      font-size: 0.98rem;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-login:hover {
      background: var(--color-accent-hover);
      box-shadow: 0 8px 24px rgba(212, 175, 55, 0.25);
      transform: translateY(-1px);
    }

    .btn-login:disabled {
      background: #E2E8F0;
      color: #94A3B8;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .spinner {
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: #FFFFFF;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Quick demo test accounts */
    .demo-accounts {
      margin-top: 1.8rem;
      padding-top: 1.4rem;
      border-top: 1px solid #E2E8F0;
      text-align: center;
    }

    .demo-title {
      font-size: 0.75rem;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      color: #64748B;
      margin-bottom: 0.8rem;
      font-weight: 600;
    }

    .demo-pills {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .demo-pill-btn {
      background: #F8FAFC;
      border: 1px solid #E2E8F0;
      border-radius: var(--radius-sm);
      color: #334155;
      padding: 8px 12px;
      font-size: 0.8rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.2s ease;
      text-align: left;
    }

    .demo-pill-btn:hover {
      background: rgba(212, 175, 55, 0.05);
      border-color: rgba(212, 175, 55, 0.3);
      color: #0F172A;
    }

    .demo-pill-btn span.badge-role {
      font-size: 0.7rem;
      background: #FFFFFF;
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: 600;
      border: 1px solid #E2E8F0;
    }

    .back-home {
      text-align: center;
      margin-top: 1.4rem;
    }

    .back-link {
      color: #64748B;
      font-size: 0.85rem;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: var(--color-accent);
    }

    @media (max-width: 480px) {
      .login-container {
        padding: 2rem 1.5rem;
      }
      .login-logo {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-header">
      <div class="login-logo">HYVE<span>.</span></div>
      <div class="login-subtitle">Administrator & Staff Portal</div>
    </div>

    @if(session('error'))
      <div class="alert-error">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span>{{ session('error') }}</span>
      </div>
    @endif

    <form id="login-form" action="{{ url('/admin/login') }}" method="POST">
      @csrf
      
      <div class="form-group">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="admin@hyve.com" value="{{ old('email') }}" required autofocus autocomplete="email">
      </div>

      <div class="form-group">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
      </div>

      <label class="form-check">
        <input type="checkbox" name="remember" value="1">
        <span>Remember this device</span>
      </label>

      <button type="submit" id="submit-btn" class="btn-login">
        <span class="spinner" id="btn-spinner"></span>
        <span id="btn-text">Sign In to Dashboard</span>
      </button>
    </form>

    <!-- Quick Access Demo Helpers -->
    <div class="demo-accounts">
      <div class="demo-title">Quick Fill Demo Roles</div>
      <div class="demo-pills">
        <button type="button" class="demo-pill-btn" onclick="fillCredentials('admin@hyve.com', 'admin123')">
          <span><strong>Main Admin:</strong> admin@hyve.com</span>
          <span class="badge-role" style="color: #D4AF37;">Executive</span>
        </button>
        <button type="button" class="demo-pill-btn" onclick="fillCredentials('staff@hyve.com', 'staff123')">
          <span><strong>Staff:</strong> staff@hyve.com</span>
          <span class="badge-role" style="color: #60A5FA;">Manager</span>
        </button>
        <button type="button" class="demo-pill-btn" onclick="fillCredentials('agent@hyve.com', 'agent123')">
          <span><strong>Agent:</strong> agent@hyve.com</span>
          <span class="badge-role" style="color: #34D399;">Agent</span>
        </button>
      </div>
    </div>

    <div class="back-home">
      <a href="{{ url('/') }}" class="back-link">
        ← Return to HYVE Website
      </a>
    </div>
  </div>

  <script>
    function fillCredentials(email, password) {
      document.getElementById('email').value = email;
      document.getElementById('password').value = password;
    }

    document.getElementById('login-form').addEventListener('submit', () => {
      const submitBtn = document.getElementById('submit-btn');
      const btnSpinner = document.getElementById('btn-spinner');
      const btnText = document.getElementById('btn-text');

      submitBtn.disabled = true;
      btnSpinner.style.display = 'block';
      btnText.textContent = 'Authenticating...';
    });
  </script>
</body>
</html>
