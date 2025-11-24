<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | HIV Treatment Monitoring System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
      position: relative;
      overflow: hidden;
    }

    /* Animated Background */
    body::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
      top: -250px;
      right: -250px;
      animation: float 6s ease-in-out infinite;
    }

    body::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
      bottom: -200px;
      left: -200px;
      animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    .login-container {
      width: 440px;
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      padding: 45px 40px;
      border-radius: 20px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(16, 185, 129, 0.2);
      border: 1px solid rgba(16, 185, 129, 0.2);
      animation: fadeIn 0.8s ease;
      position: relative;
      z-index: 1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
      border-radius: 20px 20px 0 0;
    }

    .login-container h2 {
      text-align: center;
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-weight: 700;
      margin-bottom: 30px;
      font-size: 2rem;
      letter-spacing: 0.5px;
    }

    .inputBox {
      margin-bottom: 25px;
      position: relative;
    }

    .inputBox input {
      width: 100%;
      padding: 14px 45px 14px 18px;
      border-radius: 12px;
      border: 1px solid rgba(16, 185, 129, 0.3);
      font-size: 1em;
      outline: none;
      transition: all 0.3s ease;
      background: rgba(31, 41, 55, 0.5);
      color: #e5e7eb;
    }

    .inputBox input:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2), 0 4px 12px rgba(16, 185, 129, 0.15);
      background: rgba(31, 41, 55, 0.8);
      transform: translateY(-2px);
    }

    .inputBox input::placeholder {
      color: #9ca3af;
    }

    .toggle-password {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #9ca3af;
      transition: all 0.3s;
      font-size: 1.1em;
    }

    .toggle-password:hover {
      color: #10b981;
      transform: translateY(-50%) scale(1.1);
    }

    button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: #fff;
      font-size: 1.1em;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      letter-spacing: 0.5px;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
      position: relative;
      overflow: hidden;
    }

    button::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.2);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    button:hover::before {
      width: 300px;
      height: 300px;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    button:active {
      transform: translateY(-1px);
    }

    .group {
      text-align: center;
      margin-top: 25px;
    }

    .group p {
      color: #d1d5db;
      font-size: 0.95em;
    }

    .group a {
      text-decoration: none;
      color: #10b981;
      font-weight: 600;
      transition: all 0.3s;
      position: relative;
    }

    .group a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 50%;
      background: #10b981;
      transition: all 0.3s;
      transform: translateX(-50%);
    }

    .group a:hover {
      color: #34d399;
    }

    .group a:hover::after {
      width: 100%;
    }

    .error-box {
      background: rgba(239, 68, 68, 0.2);
      color: #f87171;
      padding: 12px 15px;
      border-radius: 10px;
      text-align: center;
      font-size: 0.9em;
      border: 1px solid rgba(239, 68, 68, 0.4);
      margin-bottom: 20px;
      animation: shake 0.5s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    footer {
      text-align: center;
      font-size: 0.85em;
      color: #9ca3af;
      margin-top: 30px;
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: rgba(31, 41, 55, 0.5);
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
      background: #10b981;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #059669;
    }
  </style>
</head>

<body>

  <div class="login-container">

    <h2>HIV Treatment Monitoring</h2>

    <!-- Error message -->
    <?php if (!empty($error)): ?>
      <div class="error-box">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="<?= site_url('auth/login'); ?>">

      <div class="inputBox">
        <input type="text" placeholder="Username" name="username" required>
      </div>

      <div class="inputBox">
        <input type="password" placeholder="Password" name="password" id="password" required>
        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="group">
      <p>Don't have an account?  
        <a href="<?= site_url('auth/register'); ?>">Register here</a>
      </p>
    </div>

    <footer>© 2025 HIV Treatment Monitoring System</footer>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.type === 'password' ? 'text' : 'password';
      password.type = type;
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>
</html>