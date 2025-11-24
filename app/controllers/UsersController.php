<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UsersController extends Controller {

    public function __construct() {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->call->model('UsersModel');
        $this->call->library('auth');

        // SMTP Config
        $this->smtpHost = 'smtp.gmail.com';
        $this->smtpPort = 587;
        $this->smtpSecure = 'tls';
        $this->smtpUser = 'kayemarquez026@gmail.com';
        $this->smtpPass = 'mfau qgnl zisp fujy';
        $this->fromEmail = 'kayemarquez026@gmail.com';
        $this->fromName  = 'HIV Treatment Monitoring System';
    }

    // ==============================
    // 🔒 ADMIN RESTRICTION
    // ==============================
    private function require_admin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/profile');
            exit;
        }
    }

    // ==============================
    // 👑 ADMIN: USER MANAGEMENT
    // ==============================
    public function index() {
        $this->require_admin();

        $page = isset($_GET['page']) ? (int)$this->io->get('page') : 1;
        $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';
        $records_per_page = 10;

        $users = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $users['records'];
        $total_rows = $users['total_rows'];
        $data['logged_in_user'] = $_SESSION['user'];

        $this->pagination->set_options([
            'first_link' => '⏮ First',
            'last_link'  => 'Last ⏭',
            'next_link'  => 'Next →',
            'prev_link'  => '← Prev',
            'page_delimiter' => '&page='
        ]);

        $this->pagination->set_theme('custom');
        $this->pagination->initialize($total_rows, $records_per_page, $page, 'users?q='.$q);
        $data['page'] = $this->pagination->paginate();

        $this->call->view('users/index', $data);
    }

    // ==============================
    // 📝 CREATE USER (ADMIN)
    // ==============================
    public function create() {
        $this->require_admin();

        if ($this->io->method() === 'post') {
            $required_fields = ['email', 'username', 'password'];
            foreach ($required_fields as $field) {
                if (empty($this->io->post($field))) {
                    $_SESSION['error_message'] = 'Please fill in all required fields.';
                    redirect('users/create');
                }
            }

            if ($this->UsersModel->email_exists($this->io->post('email'))) {
                $_SESSION['error_message'] = 'Email already exists.';
                redirect('users/create');
            }

            if ($this->UsersModel->username_exists($this->io->post('username'))) {
                $_SESSION['error_message'] = 'Username already exists.';
                redirect('users/create');
            }

            $user_data = [
                'email' => $this->io->post('email'),
                'username' => $this->io->post('username'),
                'password' => password_hash($this->io->post('password'), PASSWORD_DEFAULT),
                'role' => 'user', // admin can only be manually added by first registration
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->UsersModel->insert_user($user_data)) {
                $_SESSION['success_message'] = 'User created successfully!';
                redirect('/users');
            } else {
                $_SESSION['error_message'] = 'Failed to create user.';
                redirect('users/create');
            }
        } else {
            $data['logged_in_user'] = $_SESSION['user'];
            $this->call->view('users/create', $data);
        }
    }

    // ==============================
    // ✏️ EDIT USER
    // ==============================
    public function edit($id) {
        $this->require_admin();

        $data['user'] = $this->UsersModel->get_user_by_id($id);
        if (!$data['user']) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/users');
        }

        $data['logged_in_user'] = $_SESSION['user'];
        $this->call->view('users/edit', $data);
    }

    // ==============================
    // 🔄 UPDATE USER
    // ==============================
    public function update($id) {
        $this->require_admin();

        if ($this->io->method() === 'post') {
            $user = $this->UsersModel->get_user_by_id($id);
            if (!$user) {
                $_SESSION['error_message'] = 'User not found.';
                redirect('/users');
            }

            $required_fields = ['username', 'email'];
            foreach ($required_fields as $field) {
                if (empty($this->io->post($field))) {
                    $_SESSION['error_message'] = 'Please fill in all required fields.';
                    redirect('users/edit/' . $id);
                }
            }

            $user_data = [
                'username' => $this->io->post('username'),
                'email' => $this->io->post('email'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($this->io->post('password'))) {
                $user_data['password'] = password_hash($this->io->post('password'), PASSWORD_DEFAULT);
            }

            if ($this->UsersModel->update_user($id, $user_data)) {
                $_SESSION['success_message'] = 'User updated successfully!';
                redirect('/users');
            } else {
                $_SESSION['error_message'] = 'Failed to update user.';
                redirect('users/edit/' . $id);
            }
        } else {
            redirect('/users');
        }
    }

    // ==============================
    // 🗑️ DELETE USER
    // ==============================
    public function delete($id) {
        $this->require_admin();

        if($id == $_SESSION['user']['id']) {
            $_SESSION['error_message'] = 'You cannot delete your own account!';
            redirect('/users');
        }

        if ($this->UsersModel->delete_user($id)) {
            $_SESSION['success_message'] = 'User deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete user.';
        }

        redirect('/users');
    }

    // ==============================
    // 📝 REGISTER USER (EMAIL VERIFICATION)
    // ==============================
    public function register() {
        if ($this->io->method() == 'post') {
            $username = trim($this->io->post('username'));
            $email = trim($this->io->post('email'));
            $password = $this->io->post('password');

            $username_exists = $this->UsersModel->username_exists($username);
            $email_exists = $this->UsersModel->email_exists($email);

            // Handle duplicated username/email
            if ($username_exists && $email_exists) {
                $_SESSION['error_message'] = "Username and Email already exist, try another.";
                redirect('/auth/register');
            } elseif ($username_exists) {
                $_SESSION['error_message'] = "Username already exists, try another one.";
                redirect('/auth/register');
            } elseif ($email_exists) {
                $_SESSION['error_message'] = "Email already exists, try another one.";
                redirect('/auth/register');
            }

            // Determine role: first user = admin, else user
            $role = $this->UsersModel->has_admin() ? 'user' : 'admin';

            // Insert user
            $userData = [
                'username' => $username,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role'     => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'verified_at' => null
            ];

            $inserted = $this->UsersModel->insert_user($userData);
            if ($inserted) {
                $userId = is_int($inserted) ? $inserted : $this->UsersModel->get_user_by_email($email)['id'];
                $this->_sendVerificationEmail($userId, $email, $username);

                $_SESSION['success_message'] = 'Registration successful. Check your email to verify before login.';
                redirect('/auth/login');
            } else {
                $_SESSION['error_message'] = 'Failed to register. Please try again.';
                redirect('/auth/register');
            }
        }

        $data['error'] = $_SESSION['error_message'] ?? null;
        unset($_SESSION['error_message']);

        $data['success'] = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);

        $this->call->view('auth/register', $data);
    }

    // ==============================
    // 🔑 LOGIN (check verification)
    // ==============================
    public function login() {
        $error = null;

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $user = $this->UsersModel->get_user_by_username($username);

            if ($user) {
                if (empty($user['verified_at'])) {
                    $error = "Account not verified. Check your email for the verification link.";
                } elseif ($this->auth->login($username, $password)) {
                    $_SESSION['user'] = [
                        'id'       => $user['id'],
                        'username' => $user['username'],
                        'role'     => $user['role']
                    ];
                    redirect($user['role'] === 'admin' ? '/dashboard' : '/profile');
                } else {
                    $error = "Invalid username or password!";
                }
            } else {
                $error = "Invalid username or password!";
            }
        }

        $success = $_SESSION['success_message'] ?? null;
        unset($_SESSION['success_message']);
        $this->call->view('auth/login', ['error' => $error, 'success' => $success]);
    }

    // ==============================
    // 🚪 LOGOUT
    // ==============================
    public function logout() {
        $this->auth->logout();
        redirect('/auth/login');
    }

    // ==============================
    // ✅ VERIFY EMAIL
    // ==============================
    public function verify($id = null) {
        if (!$id) {
            $_SESSION['error_message'] = 'Invalid verification link.';
            redirect('/auth/login');
        }

        $user = $this->UsersModel->get_user_by_id($id);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/auth/login');
        }

        if (!empty($user['verified_at'])) {
            $_SESSION['success_message'] = 'Account already verified. You can login now.';
            redirect('/auth/login');
        }

        if ($this->UsersModel->update_user($id, ['verified_at' => date('Y-m-d H:i:s')])) {
            $_SESSION['success_message'] = 'Email verified successfully. You can now login.';
        } else {
            $_SESSION['error_message'] = 'Failed to verify email. Contact admin.';
        }

        redirect('/auth/login');
    }

    // ==============================
    // ✉️ SEND VERIFICATION EMAIL
    // ==============================
    private function _sendVerificationEmail($userId, $toEmail, $toName) {
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $autoloadPath = __DIR__ . '/../../vendor/autoload.php';
            if (file_exists($autoloadPath)) require_once $autoloadPath;
        }

        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) return false;

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $this->smtpUser;
            $mail->Password = $this->smtpPass;
            $mail->SMTPSecure = $this->smtpSecure;
            $mail->Port = $this->smtpPort;

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($toEmail, $toName);

            $mail->isHTML(true);
            $mail->Subject = 'Please verify your email';
            $verifyLink = site_url("auth/verify/{$userId}");
            $mail->Body = "
                <p>Hi " . htmlspecialchars($toName) . ",</p>
                <p>Thank you for registering. Please click the link below to verify your email:</p>
                <p><a href='{$verifyLink}'>Verify my email</a></p>
                <p>If the link doesn't work, copy & paste this URL into your browser: {$verifyLink}</p>
                <p>— {$this->fromName}</p>
            ";
            $mail->AltBody = "Hi {$toName},\nPlease verify your email: {$verifyLink}\n— {$this->fromName}";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
