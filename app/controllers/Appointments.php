<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Appointments extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Appointment_model');
        $this->call->model('Patient_model');
    }

    /* ======================
       LIST APPOINTMENTS
    ====================== */
    /* ======================
   LIST APPOINTMENTS
====================== */
public function index() {
    if(!isset($_SESSION['logged_in'])) {
        redirect('auth/login');
    }

    $user_role = $_SESSION['role'] ?? 'user';
    $user_id   = $_SESSION['id'];
    
    // ✅ GET SEARCH TERM
    $search = $this->io->get('search', true) ?? '';

    if ($user_role == 'admin') {
        // Admin sees ALL appointments with search capability
        if(!empty($search)) {
            $data['appointments'] = $this->Appointment_model->search_appointments($search);
        } else {
            $data['appointments'] = $this->Appointment_model->get_appointments_with_patients();
        }
    } else {
        // User sees ONLY own appointments with search
        if(!empty($search)) {
            $data['appointments'] = $this->Appointment_model->search_appointments_by_user($user_id, $search);
        } else {
            $data['appointments'] = $this->Appointment_model->get_appointments_by_user($user_id);
        }
    }

    $data['patients']   = $this->Patient_model->get_all();
    $data['title']      = 'Appointments';
    $data['user_role']  = $user_role;
    $data['search']     = $search; // ✅ PASS SEARCH TERM TO VIEW

    $this->call->view('layouts/header', $data);
    $this->call->view('layouts/sidebar');
    $this->call->view('appointments/index', $data);
    $this->call->view('layouts/footer');
}

    /* ======================
       CREATE APPOINTMENT (BOTH FORM AND SAVE)
    ====================== */
    /* ======================
   CREATE APPOINTMENT (BOTH FORM AND SAVE)
====================== */
public function create() {
    if(!isset($_SESSION['logged_in'])) {
        redirect('auth/login');
    }

    // ✅ PROCESS FORM SUBMISSION (POST)
    if ($this->io->method() === 'post') {
        $user_role = $_SESSION['role'];
        $user_id   = $_SESSION['id'];

        if($user_role == 'admin') {
            $data = [
                'patient_id'       => $this->io->post('patient'),
                'appointment_date' => $this->io->post('appointment_date'),
                'appointment_time' => $this->io->post('appointment_time'),
                'purpose'          => $this->io->post('purpose'),
                'status'           => 'Pending',
                'created_by'       => $user_id,
                'created_at'       => date('Y-m-d H:i:s')
            ];
        } else {
            // ✅ FIXED: Gamitin ang birth_date instead of age
            $patient_data = [
                'first_name'     => $this->io->post('first_name'),
                'last_name'      => $this->io->post('last_name'),
                'birth_date'     => $this->io->post('birth_date'), // ✅ BIRTH_DATE NOT AGE
                'gender'         => $this->io->post('gender'),
                'contact_number' => $this->io->post('contact_number'),
                'address'        => $this->io->post('address'),
                'email'          => $this->io->post('email'),
                'status'         => 'Monitored'
            ];

            $patient_id = $this->Patient_model->insert_patient($patient_data);

            $data = [
                'patient_id'       => $patient_id,
                'appointment_date' => $this->io->post('appointment_date'),
                'appointment_time' => $this->io->post('appointment_time'),
                'purpose'          => $this->io->post('purpose'),
                'status'           => 'Pending',
                'created_by'       => $user_id,
                'created_at'       => date('Y-m-d H:i:s')
            ];
        }

        if ($this->Appointment_model->insert_appointment($data)) {
            $_SESSION['success_message'] = 'Appointment created successfully!';
            redirect('/appointments');
        } else {
            $_SESSION['error_message'] = 'Failed to create appointment.';
            redirect('/appointments/create');
        }
    } 
    // ✅ SHOW CREATE FORM (GET)
    else {
        $data['title']     = 'Create Appointment';
        $data['user_role'] = $_SESSION['role'];

        // admin can select any patient
        if($_SESSION['role'] == 'admin') {
            $data['patients'] = $this->Patient_model->get_all();
        }

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('appointments/create', $data);
        $this->call->view('layouts/footer');
    }
}

    /* ======================
       EDIT FORM - ADMIN ONLY
    ====================== */
    public function edit($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can edit appointments.';
            redirect('/appointments');
        }

        $data['appointment'] = $this->Appointment_model->get_appointment_with_patient($id);
        $data['patients']    = $this->Patient_model->get_all();
        $data['title']       = 'Edit Appointment';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('appointments/edit', $data);
        $this->call->view('layouts/footer');
    }

    /* ======================
       UPDATE - ADMIN ONLY
    ====================== */
    public function update($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can update appointments.';
            redirect('/appointments');
        }

        $data = [
            'patient_id'       => $this->io->post('patient'),
            'appointment_date' => $this->io->post('appointment_date'),
            'appointment_time' => $this->io->post('appointment_time'),
            'purpose'          => $this->io->post('purpose'),
            'status'           => $this->io->post('status')
        ];

        if ($this->Appointment_model->update_appointment($id, $data)) {
            $_SESSION['success_message'] = 'Appointment updated successfully!';
            redirect('appointments');
        } else {
            $_SESSION['error_message'] = 'Failed to update appointment.';
            redirect('appointments/edit/' . $id);
        }
    }

    /* ======================
       DELETE - ADMIN ONLY
    ====================== */
    public function delete($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        if($user_role !== 'admin') {
            $_SESSION['error_message'] = 'Only administrators can delete appointments.';
            redirect('/appointments');
        }

        if ($this->Appointment_model->delete_appointment($id)) {
            $_SESSION['success_message'] = 'Appointment deleted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to delete appointment.';
        }

        redirect('appointments');
    }
}
?>