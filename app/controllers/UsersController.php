<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller {

    public function __construct() {
        parent::__construct();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->call->model('UsersModel');
        $this->call->library('auth');
    }

    /* =============================
       🔒 RESTRICT NON-ADMIN USERS
    ============================== */
    private function require_admin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/profile');
            exit;
        }
    }

    /* =============================
       👑 ADMIN: USER MANAGEMENT
    ============================== */
    public function index() {
    $this->require_admin();

    $page = isset($_GET['page']) ? (int)$this->io->get('page') : 1;
    $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';
    $records_per_page = 10;

    $users = $this->UsersModel->page($q, $records_per_page, $page);
    $data['users'] = $users['records'];
    $total_rows = $users['total_rows'];

    // ADD THIS LINE - Pass logged in user data to view
    $data['logged_in_user'] = $_SESSION['user']; // ← THIS IS MISSING!

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

    public function create() {
        $this->require_admin();

        if ($this->io->method() === 'post') {
            $required_fields = ['email', 'username', 'password', 'role'];
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
                'role' => $this->io->post('role'),
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

    /* ==========================
       ✏️ EDIT USER FORM
    =========================== */
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

    /* ==========================
       🔄 UPDATE USER
    =========================== */
    public function update($id) {
        $this->require_admin();

        if ($this->io->method() === 'post') {
            $user = $this->UsersModel->get_user_by_id($id);
            
            if (!$user) {
                $_SESSION['error_message'] = 'User not found.';
                redirect('/users');
            }

            // Validate required fields
            $required_fields = ['username', 'email', 'role'];
            foreach ($required_fields as $field) {
                if (empty($this->io->post($field))) {
                    $_SESSION['error_message'] = 'Please fill in all required fields.';
                    redirect('users/edit/' . $id);
                }
            }

            // Prepare update data - ONLY fields that exist in your table
            $user_data = [
                'username' => $this->io->post('username'),
                'email' => $this->io->post('email'),
                'role' => $this->io->post('role'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update password only if provided
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

    /* ==========================
       🗑️ DELETE USER (THIS WAS MISSING!)
    =========================== */
    public function delete($id) {
        $this->require_admin();

        // Prevent self-deletion
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

    /* ==========================
       📝 REGISTRATION
    =========================== */
    public function register() {
        if ($this->io->method() == 'post') {
            $data = [
                'username' => $this->io->post('username'),
                'email'    => $this->io->post('email'),
                'password' => password_hash($this->io->post('password'), PASSWORD_DEFAULT),
                'role'     => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->UsersModel->insert_user($data)) {
                redirect('/auth/login');
            } else {
                echo 'Registration failed.';
            }
        }

        $this->call->view('auth/register');
    }

    /* ==========================
       🔑 LOGIN
    =========================== */
    public function login() {
        $error = null;

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');
            $user = $this->UsersModel->get_user_by_username($username);

            if ($user && $this->auth->login($username, $password)) {

                $_SESSION['user'] = [
                    'id'       => $user['id'],
                    'username' => $user['username'],
                    'role'     => $user['role']
                ];

                if ($user['role'] === 'admin') {
                    redirect('/dashboard');
                }

                if ($user['role'] === 'user') {
                    redirect('/profile');
                }

                redirect('/dashboard');
            } else {
                $error = "Invalid username or password!";
            }
        }

        $this->call->view('auth/login', ['error' => $error]);
    }

    /* ==========================
       🚪 LOGOUT
    =========================== */
    public function logout() {
        $this->auth->logout();
        redirect('/auth/login');
    }
    
}
?>