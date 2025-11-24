<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Register | HIV Treatment Monitoring System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
/* ---------- STYLES SAME AS BEFORE ---------- */
* { margin: 0; padding: 0; box-sizing: border-box; font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%); position: relative; overflow: hidden; padding: 20px; }
body::before { content: ''; position: absolute; width: 500px; height: 500px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%); top: -250px; right: -250px; animation: float 6s ease-in-out infinite; }
body::after { content: ''; position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); bottom: -200px; left: -200px; animation: float 8s ease-in-out infinite reverse; }
@keyframes float { 0%,100%{transform:translateY(0);}50%{transform:translateY(-20px);} }

.register-container { width: 480px; background: linear-gradient(135deg, #1f2937 0%, #111827 100%); padding: 45px 40px; border-radius: 20px; border: 1px solid rgba(16, 185, 129, 0.2); box-shadow: 0 8px 32px rgba(0,0,0,0.4),0 0 0 1px rgba(16,185,129,0.2); animation: fadeIn 0.8s ease; position: relative; z-index: 1; }
.register-container::before { content: ''; position: absolute; top:0; left:0; right:0; height:4px; background: linear-gradient(90deg, #10b981 0%, #34d399 100%); border-radius: 20px 20px 0 0; }
@keyframes fadeIn { from {opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }

.register-container h2 { text-align:center; background:linear-gradient(135deg,#10b981 0%,#34d399 100%); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; font-weight:700; margin-bottom:30px; font-size:2rem; letter-spacing:0.5px; }

.alert { padding:12px 18px; border-radius:10px; margin-bottom:20px; font-size:0.95em; border:1px solid rgba(239,68,68,0.4); background: rgba(239,68,68,0.2); color:#f87171; animation: shake 0.5s ease; display:flex; justify-content:center; align-items:center; gap:8px; text-align:center; }
.alert.success { border-color: rgba(16, 185, 129, 0.4); background: rgba(16, 185, 129, 0.2); color: #10b981; animation: fadeInSuccess 0.5s ease; }
@keyframes shake { 0%,100%{transform:translateX(0);} 25%{transform:translateX(-5px);} 75%{transform:translateX(5px);} }
@keyframes fadeInSuccess { from{opacity:0; transform:translateY(-10px);} to{opacity:1; transform:translateY(0);} }

.inputBox { margin-bottom:22px; position:relative; }
.inputBox input, .inputBox select { width:100%; padding:14px 45px 14px 18px; border-radius:12px; border:1px solid rgba(16,185,129,0.3); font-size:1em; outline:none; transition:all 0.3s ease; background: rgba(31,41,55,0.5); color:#e5e7eb; }
.inputBox input:focus, .inputBox select:focus { border-color:#10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.2),0 4px 12px rgba(16,185,129,0.15); background: rgba(31,41,55,0.8); transform:translateY(-2px); }
.inputBox input::placeholder { color:#9ca3af; }

.toggle-password { position:absolute; right:18px; top:50%; transform:translateY(-50%); cursor:pointer; color:#fff; transition:all 0.3s; font-size:1.1em; }
.toggle-password:hover { color:#10b981; transform:translateY(-50%) scale(1.1); }

button { width:100%; padding:14px; background:linear-gradient(135deg,#10b981 0%,#059669 100%); color:#fff; font-size:1.1em; border:none; border-radius:12px; cursor:pointer; transition:all 0.3s ease; font-weight:600; letter-spacing:0.5px; box-shadow:0 4px 15px rgba(16,185,129,0.4); position:relative; overflow:hidden; }
button::before { content:''; position:absolute; top:50%; left:50%; width:0; height:0; border-radius:50%; background: rgba(255,255,255,0.2); transform:translate(-50%,-50%); transition: width 0.6s, height 0.6s; }
button:hover::before { width:300px; height:300px; }
button:hover { transform:translateY(-3px); box-shadow:0 6px 20px rgba(16,185,129,0.6); background:linear-gradient(135deg,#059669 0%,#047857 100%); }
button:active { transform:translateY(-1px); }

.group { text-align:center; margin-top:25px; }
.group p { color:#d1d5db; font-size:0.95em; }
.group a { color:#10b981; font-weight:600; text-decoration:none; transition:all 0.3s; position:relative; }
.group a::after { content:''; position:absolute; width:0; height:2px; bottom:-2px; left:50%; background:#10b981; transition:all 0.3s; transform:translateX(-50%); }
.group a:hover { color:#34d399; }
.group a:hover::after { width:100%; }

footer { text-align:center; margin-top:30px; font-size:0.85em; color:#9ca3af; }

::-webkit-scrollbar { width:10px; }
::-webkit-scrollbar-track { background: rgba(31,41,55,0.5); border-radius:10px; }
::-webkit-scrollbar-thumb { background:#10b981; border-radius:10px; }
::-webkit-scrollbar-thumb:hover { background:#059669; }

@media (max-width: 500px) { .register-container { width:100%; padding:35px 25px; } }
</style>
</head>
<body>
<div class="register-container">
  <h2>Create Account</h2>

  <div id="messageContainer">
    <?php if (!empty($error)): ?>
      <div class="alert" id="messageBox">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($error); ?>
      </div>
    <?php elseif (!empty($success)): ?>
      <div class="alert success" id="messageBox">
        <i class="fas fa-check-circle"></i>
        <?= htmlspecialchars($success); ?> Please check your Gmail for verification before login.
      </div>
    <?php endif; ?>
  </div>

  <form method="POST" action="<?= site_url('auth/register'); ?>" id="registerForm">
    <div class="inputBox">
      <input type="text" name="username" placeholder="Username" required value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>" />
    </div>
    <div class="inputBox">
      <input type="email" name="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@gmail\.com$" title="Email must end with @gmail.com" value="<?= htmlspecialchars($_POST['email'] ?? ''); ?>" />
    </div>
    <div class="inputBox">
      <input type="password" id="password" name="password" placeholder="Password" required />
      <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
    </div>
    <div class="inputBox">
      <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm Password" required />
      <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword"></i>
    </div>
    <button type="submit">Register</button>
  </form>

  <div class="group">
    <p>Already have an account? <a href="<?= site_url('auth/login'); ?>">Login here</a></p>
  </div>

  <footer>© 2025 HIV Treatment Monitoring System</footer>
</div>

<script>
// Toggle password visibility
function toggleVisibility(toggleId, inputId) {
  const toggle = document.getElementById(toggleId);
  const input = document.getElementById(inputId);
  toggle.addEventListener("click", function() {
    input.type = input.type === "password" ? "text" : "password";
  });
}
toggleVisibility("togglePassword", "password");
toggleVisibility("toggleConfirmPassword", "confirmPassword");

// Function to show alert
function showAlert(message, type = 'error') {
  const messageContainer = document.getElementById('messageContainer');
  const oldAlert = document.getElementById('messageBox');
  if (oldAlert) oldAlert.remove();

  const div = document.createElement('div');
  div.className = type === 'success' ? 'alert success' : 'alert';
  div.id = 'messageBox';
  div.style.textAlign = 'center';
  div.innerHTML = type === 'success' ? `✅ ${message}` : `⚠️ ${message}`;
  messageContainer.appendChild(div);

  // Remove after 3 seconds
  setTimeout(() => div.remove(), 3000);
}

// Automatically remove PHP messages
window.addEventListener('DOMContentLoaded', () => {
  const phpMessage = document.getElementById('messageBox');
  if (phpMessage) setTimeout(() => phpMessage.remove(), 3000);
});

// Form validation
const form = document.getElementById('registerForm');
form.addEventListener('submit', function(e) {
  const email = form.querySelector('input[name="email"]').value.trim();
  const usernameInput = form.querySelector('input[name="username"]');
  const passwordInput = form.querySelector('input[name="password"]');
  const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

  if (!email.endsWith('@gmail.com')) {
    e.preventDefault();
    showAlert('Please enter a valid Email address');
    usernameInput.value = '';
    passwordInput.value = '';
    confirmPasswordInput.value = '';
    return;
  }

  if (passwordInput.value !== confirmPasswordInput.value) {
    e.preventDefault();
    showAlert('Passwords do not match');
    passwordInput.value = '';
    confirmPasswordInput.value = '';
    passwordInput.focus();
    return;
  }
});
</script>
</body>
</html>
