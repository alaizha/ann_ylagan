<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UserManagementController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('UsersModel');
    }

    public function index() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }

        $logged_in_user = $_SESSION['user']; 
        $data['logged_in_user'] = $logged_in_user;

        $page = isset($_GET['page']) ? (int)$this->io->get('page') : 1;
        $q = isset($_GET['q']) ? trim($this->io->get('q')) : '';
        $records_per_page = 10;

        $users = $this->UsersModel->page($q, $records_per_page, $page);
        $data['users'] = $users['records'];
        $total_rows = $users['total_rows'];

        $this->pagination->set_options([
            'first_link' => '⏮ First',
            'last_link' => 'Last ⏭',
            'next_link' => 'Next →',
            'prev_link' => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');
        $this->pagination->initialize($total_rows, $records_per_page, $page, 'user_management?q='.$q);
        $data['page'] = $this->pagination->paginate();

        // Load user management view
        $this->call->view('user_management/index', $data);
    }

    public function create() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }

        $data['logged_in_user'] = $_SESSION['user'];
        $this->call->view('user_management/create', $data);
    }

    public function add() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }
        
        // Validate required fields
        $required_fields = ['first_name', 'last_name', 'email', 'username', 'password', 'role'];
        foreach ($required_fields as $field) {
            if (empty($this->io->post($field))) {
                $_SESSION['error_message'] = 'Please fill in all required fields.';
                redirect('user_management/create');
            }
        }

        // Check if email already exists
        if ($this->UsersModel->email_exists($this->io->post('email'))) {
            $_SESSION['error_message'] = 'Email already exists.';
            redirect('user_management/create');
        }

        // Check if username already exists
        if ($this->UsersModel->username_exists($this->io->post('username'))) {
            $_SESSION['error_message'] = 'Username already exists.';
            redirect('user_management/create');
        }

        $user_data = [
            'first_name' => $this->io->post('first_name'),
            'last_name' => $this->io->post('last_name'),
            'email' => $this->io->post('email'),
            'username' => $this->io->post('username'),
            'password' => password_hash($this->io->post('password'), PASSWORD_DEFAULT),
            'role' => $this->io->post('role'),
            'phone' => $this->io->post('phone'),
            'birth_date' => $this->io->post('birth_date'),
            'gender' => $this->io->post('gender'),
            'address' => $this->io->post('address'),
            'city' => $this->io->post('city'),
            'province' => $this->io->post('province'),
            'zip_code' => $this->io->post('zip_code'),
            'is_active' => $this->io->post('is_active') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->UsersModel->insert_user($user_data)) {
            $_SESSION['success_message'] = 'User created successfully!';
            redirect('/user_management');
        } else {
            $_SESSION['error_message'] = 'Failed to create user.';
            redirect('user_management/create');
        }
    }

    public function edit($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }

        $user = $this->UsersModel->get_user_by_id($id);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/user_management');
        }

        $data['user'] = $user;
        $data['logged_in_user'] = $_SESSION['user'];
        $this->call->view('user_management/edit', $data);
    }

    public function update($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }

        $user = $this->UsersModel->get_user_by_id($id);
        if (!$user) {
            $_SESSION['error_message'] = 'User not found.';
            redirect('/user_management');
        }

        // Validate required fields
        $required_fields = ['first_name', 'last_name', 'email', 'username', 'role'];
        foreach ($required_fields as $field) {
            if (empty($this->io->post($field))) {
                $_SESSION['error_message'] = 'Please fill in all required fields.';
                redirect('user_management/edit/' . $id);
            }
        }

        // Check if email already exists (excluding current user)
        if ($this->UsersModel->email_exists($this->io->post('email'), $id)) {
            $_SESSION['error_message'] = 'Email already exists.';
            redirect('user_management/edit/' . $id);
        }

        // Check if username already exists (excluding current user)
        if ($this->UsersModel->username_exists($this->io->post('username'), $id)) {
            $_SESSION['error_message'] = 'Username already exists.';
            redirect('user_management/edit/' . $id);
        }

        $user_data = [
            'first_name' => $this->io->post('first_name'),
            'last_name' => $this->io->post('last_name'),
            'email' => $this->io->post('email'),
            'username' => $this->io->post('username'),
            'role' => $this->io->post('role'),
            'phone' => $this->io->post('phone'),
            'birth_date' => $this->io->post('birth_date'),
            'gender' => $this->io->post('gender'),
            'address' => $this->io->post('address'),
            'city' => $this->io->post('city'),
            'province' => $this->io->post('province'),
            'zip_code' => $this->io->post('zip_code'),
            'is_active' => $this->io->post('is_active') ? 1 : 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Update password only if provided
        if (!empty($this->io->post('password'))) {
            $user_data['password'] = password_hash($this->io->post('password'), PASSWORD_DEFAULT);
        }

        if ($this->UsersModel->update_user($id, $user_data)) {
            $_SESSION['success_message'] = 'User updated successfully!';
            redirect('/user_management');
        } else {
            $_SESSION['error_message'] = 'Failed to update user.';
            redirect('user_management/edit/' . $id);
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
            redirect('/auth/login');
            exit;
        }

        // Prevent admin from deleting themselves
        if ($id == $_SESSION['user']['id']) {
            $_SESSION['error_message'] = 'You cannot delete your own account.';
            redirect('/user_management');
        }

        if ($this->UsersModel->delete_user($id)) {
            $_SESSION['success_message'] = 'User deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete user.';
        }
        redirect('/user_management');
    }
}