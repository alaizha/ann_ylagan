<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class MedicalRecords extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('MedicalRecord_model');
        $this->call->model('UsersModel');
    }

    /* ======================
       LIST MEDICAL RECORDS
    ====================== */
    public function index() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        $user_id   = $_SESSION['id'];

        if ($user_role == 'admin') {
            $data['medical_records'] = $this->MedicalRecord_model->get_all_records();
        } else {
            $data['medical_records'] = $this->MedicalRecord_model->get_records_by_user($user_id);
        }

        $data['title']      = 'Medical Records';
        $data['user_role']  = $user_role;

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('medical_records/index', $data);
        $this->call->view('layouts/footer');
    }

    /* ======================
       CREATE MEDICAL RECORD (ADMIN ONLY)
    ====================== */
    public function create() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can create medical records.';
            redirect('/medical-records');
        }

        if ($this->io->method() === 'post') {
            $data = [
                'user_id'       => $this->io->post('user_id'),
                'record_date'   => $this->io->post('record_date'),
                'type'          => $this->io->post('type'),
                'doctor'        => $this->io->post('doctor'),
                'diagnosis'     => $this->io->post('diagnosis'),
                'treatment'     => $this->io->post('treatment')
            ];

            if ($this->MedicalRecord_model->insert_medical_record($data)) {
                $_SESSION['success_message'] = 'Medical record created successfully!';
                redirect('/medical-records');
            } else {
                $_SESSION['error_message'] = 'Failed to create medical record.';
                redirect('/medical-records/create');
            }
        } else {
            $data['users'] = $this->UsersModel->get_all_users();
            $data['title'] = 'Create Medical Record';
            
            $this->call->view('layouts/header', $data);
            $this->call->view('layouts/sidebar');
            $this->call->view('medical_records/create', $data);
            $this->call->view('layouts/footer');
        }
    }

    /* ======================
       VIEW MEDICAL RECORD
    ====================== */
    public function view($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        $user_id   = $_SESSION['id'];

        $medical_record = $this->MedicalRecord_model->get_medical_record($id);
        
        if(!$medical_record) {
            $_SESSION['error_message'] = 'Medical record not found.';
            redirect('/medical-records');
        }
        
        if($user_role !== 'admin' && $medical_record['user_id'] != $user_id) {
            $_SESSION['error_message'] = 'Access denied.';
            redirect('/medical-records');
        }

        $data['medical_record'] = $medical_record;
        $data['title']          = 'View Medical Record';
        $data['user_role']      = $user_role;

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('medical_records/view', $data);
        $this->call->view('layouts/footer');
    }

    /* ======================
       EDIT MEDICAL RECORD (ADMIN ONLY)
    ====================== */
    public function edit($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can edit medical records.';
            redirect('/medical-records');
        }

        $data['medical_record'] = $this->MedicalRecord_model->get_medical_record($id);
        $data['users']          = $this->UsersModel->get_all_users();
        $data['title']          = 'Edit Medical Record';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('medical_records/edit', $data);
        $this->call->view('layouts/footer');
    }

    /* ======================
       UPDATE MEDICAL RECORD (ADMIN ONLY)
    ====================== */
    public function update($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can update medical records.';
            redirect('/medical-records');
        }

        $data = [
            'user_id'       => $this->io->post('user_id'),
            'record_date'   => $this->io->post('record_date'),
            'type'          => $this->io->post('type'),
            'doctor'        => $this->io->post('doctor'),
            'diagnosis'     => $this->io->post('diagnosis'),
            'treatment'     => $this->io->post('treatment')
        ];

        if ($this->MedicalRecord_model->update_medical_record($id, $data)) {
            $_SESSION['success_message'] = 'Medical record updated successfully!';
            redirect('medical-records');
        } else {
            $_SESSION['error_message'] = 'Failed to update medical record.';
            redirect('medical-records/edit/' . $id);
        }
    }

    /* ======================
       DELETE MEDICAL RECORD (ADMIN ONLY)
    ====================== */
    public function delete($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can delete medical records.';
            redirect('/medical-records');
        }

        if ($this->MedicalRecord_model->delete_medical_record($id)) {
            $_SESSION['success_message'] = 'Medical record deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete medical record.';
        }

        redirect('medical-records');
    }
}
?>