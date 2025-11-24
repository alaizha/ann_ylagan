<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | HIV Treatment Monitoring System</title>
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

    .register-container {
      width: 440px;
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

    .register-container h2 {
      text-align: center;
      color: var(--text-dark);
      font-weight: 600;
      margin-bottom: 25px;
      font-size: 1.8em;
    }

    .inputBox {
      margin-bottom: 18px;
      position: relative;
    }

    .inputBox input,
    .inputBox select {
      width: 100%;
      padding: 12px 40px 12px 15px;
      border-radius: 10px;
      border: 1px solid var(--border-light);
      font-size: 1em;
      outline: none;
      transition: 0.3s ease;
    }

    .inputBox input:focus,
    .inputBox select:focus {
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

    footer {
      text-align: center;
      font-size: 0.8em;
      color: var(--text-muted);
      margin-top: 25px;
    }
  </style>
</head>

<body>
  <div class="register-container">
    <h2>Create Account</h2>

    <form method="POST" action="<?= site_url('auth/register'); ?>">
      <div class="inputBox">
        <input type="text" name="username" placeholder="Username" required />
      </div>

      <div class="inputBox">
        <input type="email" name="email" placeholder="Email" required />
      </div>

      <div class="inputBox">
        <input type="password" id="password" name="password" placeholder="Password" required />
        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
      </div>

      <div class="inputBox">
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required />
        <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword"></i>
      </div>

      <div class="inputBox">
        <select name="role" required>
          <option value="" disabled selected>Select Role</option>
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select>
      </div>

      <button type="submit">Register</button>
    </form>

    <div class="group">
      <p>Already have an account? <a href="<?= site_url('auth/login'); ?>">Login here</a></p>
    </div>

    <footer>© 2025 HIV Treatment Monitoring System</footer>
  </div>

  <script>
    function toggleVisibility(toggleId, inputId) {
      const toggle = document.getElementById(toggleId);
      const input = document.getElementById(inputId);

      toggle.addEventListener("click", function () {
        const type = input.getAttribute("type") === "password" ? "text" : "password";
        input.setAttribute("type", type);
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
      });
    }

    toggleVisibility("togglePassword", "password");
    toggleVisibility("toggleConfirmPassword", "confirmPassword");
  </script>
</body>
</html>
