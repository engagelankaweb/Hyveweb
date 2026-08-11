<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | HYVE Real Estate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
      background: radial-gradient(circle at center, #1E1E1E 0%, #121212 100%);
      color: #FFFFFF;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--spacing-md);
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: '';
      position: absolute;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
      top: -100px;
      right: -100px;
      pointer-events: none;
    }

    body::after {
      content: '';
      position: absolute;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
      bottom: -100px;
      left: -100px;
      pointer-events: none;
    }

    .login-container {
      width: 100%;
      max-width: 420px;
      background: rgba(30, 30, 30, 0.75);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.05);
      border-radius: var(--radius-lg);
      padding: 3rem 2.5rem;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      z-index: 10;
      animation: loginFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes loginFadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      text-align: center;
      margin-bottom: 2.5rem;
    }

    .login-logo {
      font-family: var(--font-secondary);
      font-size: 2.5rem;
      font-weight: 700;
      letter-spacing: -1px;
      color: #FFFFFF;
      margin-bottom: 0.5rem;
    }

    .login-logo span {
      color: var(--color-accent);
    }

    .login-subtitle {
      color: #999999;
      font-size: 0.95rem;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-label {
      display: block;
      color: #CCCCCC;
      font-size: 0.85rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 0.5rem;
    }

    .input-wrapper {
      position: relative;
    }

    .form-control {
      width: 100%;
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: var(--radius-sm);
      padding: 12px 16px;
      color: #FFFFFF;
      font-family: var(--font-primary);
      font-size: 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--color-accent);
      background: rgba(255, 255, 255, 0.06);
      box-shadow: 0 0 10px rgba(212, 175, 55, 0.15);
    }

    .btn-login {
      width: 100%;
      background: var(--color-accent);
      color: #121212;
      border: none;
      border-radius: var(--radius-sm);
      padding: 14px;
      font-family: var(--font-primary);
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      margin-top: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-login:hover {
      background: var(--color-accent-hover);
      box-shadow: 0 8px 20px rgba(212, 175, 55, 0.25);
      transform: translateY(-1px);
    }

    .btn-login:active {
      transform: translateY(1px);
    }

    .btn-login:disabled {
      background: #555555;
      color: #888888;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .spinner {
      width: 20px;
      height: 20px;
      border: 2px solid rgba(18, 18, 18, 0.1);
      border-top-color: #121212;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      display: none;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .back-home {
      text-align: center;
      margin-top: 2rem;
    }

    .back-link {
      color: #888888;
      font-size: 0.9rem;
      transition: color 0.3s ease;
    }

    .back-link:hover {
      color: var(--color-accent);
    }
  </style>
</head>
<body>

  <div class="login-container">
    <div class="login-header">
      <div class="login-logo">HYVE<span>.</span></div>
      <div class="login-subtitle">Administrative Portal Access</div>
    </div>

    @if(session('error'))
      <div style="background: rgba(230, 57, 70, 0.15); border: 1px solid rgba(230, 57, 70, 0.3); color: #ff6b6b; padding: 12px; border-radius: var(--radius-sm); font-size: 0.9rem; text-align: center; margin-bottom: 1.5rem; animation: loginFadeIn 0.5s ease;">
        {{ session('error') }}
      </div>
    @endif

    <form id="login-form" action="{{ url('/admin/login') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="password" class="form-label">Admin Password</label>
        <div class="input-wrapper">
          <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required autocomplete="current-password">
        </div>
      </div>

      <button type="submit" id="submit-btn" class="btn-login">
        <span class="spinner" id="btn-spinner"></span>
        <span id="btn-text">Sign In</span>
      </button>
    </form>

    <div class="back-home">
      <a href="{{ url('/') }}" class="back-link">
        ← Back to HYVE Homepage
      </a>
    </div>
  </div>

  <script>
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
