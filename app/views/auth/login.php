<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | HIV Treatment Monitoring System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    :root {
      --primary: #6a11cb;
      --secondary: #2575fc;
      --bg-light: #f8f9fc;
      --card-bg: #ffffff;
      --text-dark: #333;
      --text-muted: #666;
      --border-light: #e0e0e0;
      --shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: var(--bg-light);
    }

    .login-container {
      width: 400px;
      background: var(--card-bg);
      padding: 40px 35px;
      border-radius: 16px;
      box-shadow: var(--shadow);
      border: 1px solid var(--border-light);
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-container h2 {
      text-align: center;
      color: var(--text-dark);
      font-weight: 600;
      margin-bottom: 25px;
      font-size: 1.8em;
    }

    .inputBox {
      margin-bottom: 20px;
      position: relative;
    }

    .inputBox input {
      width: 100%;
      padding: 12px 40px 12px 15px;
      border-radius: 10px;
      border: 1px solid var(--border-light);
      font-size: 1em;
      outline: none;
      transition: 0.3s ease;
    }

    .inputBox input:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 3px rgba(37, 117, 252, 0.1);
    }

    .inputBox input::placeholder {
      color: var(--text-muted);
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--text-muted);
      transition: color 0.3s;
    }

    .toggle-password:hover {
      color: var(--secondary);
    }

    button {
      width: 100%;
      padding: 12px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
      font-size: 1.05em;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(37, 117, 252, 0.25);
    }

    .group {
      text-align: center;
      margin-top: 18px;
    }

    .group a {
      text-decoration: none;
      color: var(--secondary);
      font-size: 0.95em;
      transition: 0.3s;
    }

    .group a:hover {
      text-decoration: underline;
    }

    .error-box {
      background: #fde8e8;
      color: #d93025;
      padding: 10px;
      border-radius: 8px;
      text-align: center;
      font-size: 0.9em;
      border: 1px solid #f5c2c0;
      margin-bottom: 15px;
    }

    footer {
      text-align: center;
      font-size: 0.8em;
      color: var(--text-muted);
      margin-top: 25px;
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h2>HIV Treatment Monitoring</h2>

    <?php if (!empty($error)): ?>
      <div class="error-box">
        <?= $error ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/login') ?>">
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
      <p>Don't have an account? <a href="<?= site_url('auth/register'); ?>">Register here</a></p>
    </div>

    <footer>© 2025 HIV Treatment Monitoring System</footer>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
