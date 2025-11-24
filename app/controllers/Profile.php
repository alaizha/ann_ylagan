<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Profile extends Controller {

    public function __construct() {
        parent::__construct();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->call->model('UsersModel');
        
        // Require login
        if (!isset($_SESSION['user'])) {
            redirect('/auth/login');
            exit;
        }
    }

    public function index() {
        $user_id = $_SESSION['user']['id'];
        $user = $this->UsersModel->get_user_by_id($user_id);
        
        $data = [
            'title' => 'My Profile',
            'user' => $user,
            'logged_in_user' => $_SESSION['user']
        ];

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('profile/index', $data);
        $this->call->view('layouts/footer');
    }

    public function edit() {
        $user_id = $_SESSION['user']['id'];
        $user = $this->UsersModel->get_user_by_id($user_id);
        
        $data = [
            'title' => 'Edit Profile',
            'user' => $user,
            'logged_in_user' => $_SESSION['user']
        ];

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('profile/edit', $data);
        $this->call->view('layouts/footer');
    }

    public function update() {
        $user_id = $_SESSION['user']['id'];
        
        $data = [
            'email' => $this->io->post('email'),
            'username' => $this->io->post('username'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // If password is provided, update it
        if (!empty($this->io->post('password'))) {
            $data['password'] = password_hash($this->io->post('password'), PASSWORD_DEFAULT);
        }

        if ($this->UsersModel->update_user($user_id, $data)) {
            $_SESSION['success_message'] = 'Profile updated successfully!';
            
            // Update session
            $_SESSION['user']['username'] = $data['username'];
            $_SESSION['user']['email'] = $data['email'];
            
        } else {
            $_SESSION['error_message'] = 'Failed to update profile.';
        }

        redirect('/profile');
    }
}