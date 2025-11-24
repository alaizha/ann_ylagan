<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Appointments extends Controller {

    private $admin_emails = [
        'annalyzhaylagan15@gmail.com',
        'ylaganannalyzha@gmail.com'
    ];

    private $clinic_name = 'Purple Rain Clinic';

    public function __construct() {
        parent::__construct();

        $this->call->model('Appointment_model');
        $this->call->model('Patient_model');

        // Load Mailer Library
        $this->call->library('mailer');
    }


    /* ======================
       LIST APPOINTMENTS
    ====================== */
    public function index() {

        if (!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $user_role = $_SESSION['role'] ?? 'user';
        $user_id   = $_SESSION['id'];
        $search    = $this->io->get('search') ?? '';

        if ($user_role == 'admin') {

            $data['appointments'] = !empty($search)
                ? $this->Appointment_model->search_appointments($search)
                : $this->Appointment_model->get_appointments_with_patients();

        } else {

            $data['appointments'] = !empty($search)
                ? $this->Appointment_model->search_appointments_by_user($user_id, $search)
                : $this->Appointment_model->get_appointments_by_user($user_id);
        }

        $data['patients']  = $this->Patient_model->get_all();
        $data['title']     = 'Appointments';
        $data['user_role'] = $user_role;
        $data['search']    = $search;

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('appointments/index', $data);
        $this->call->view('layouts/footer');
    }



    /* ======================
       CREATE APPOINTMENT
    ====================== */
    public function create() {

        if (!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        if ($this->io->method() === 'post') {

            $user_role = $_SESSION['role'];
            $user_id   = $_SESSION['id'];

            // ADMIN: Select existing patient
            if ($user_role == 'admin') {

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

                // USER: Automatically creates a patient record
                $patient_data = [
                    'first_name'     => $this->io->post('first_name'),
                    'last_name'      => $this->io->post('last_name'),
                    'birth_date'     => $this->io->post('birth_date'),
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


            /* SAVE APPOINTMENT */
            if ($this->Appointment_model->insert_appointment($data)) {

                $patient = $this->Patient_model->get_patient_by_id($data['patient_id']);
                $email   = $patient['email'] ?? '';
                $first   = $patient['first_name'] ?? 'Patient';
                $last    = $patient['last_name'] ?? '';

                /* Send Confirmation to Patient */
                if ($email !== '') {
                    $subject = "Appointment Confirmation - {$this->clinic_name}";
                    $message = "
                        <h2>Appointment Confirmation</h2>
                        <p>Hello <strong>{$first} {$last}</strong>,</p>
                        <p>Your appointment has been submitted:</p>
                        <ul>
                            <li><strong>Date:</strong> {$data['appointment_date']}</li>
                            <li><strong>Time:</strong> {$data['appointment_time']}</li>
                            <li><strong>Purpose:</strong> {$data['purpose']}</li>
                        </ul>
                        <p>We will notify you once it is approved.</p>
                    ";

                    $this->mailer->send($email, $subject, $message);
                }

                /* Notify Admins */
                $admin_subject = "New Appointment Booked - {$this->clinic_name}";
                $admin_message = "
                    <h2>New Appointment Booked</h2>
                    <p>Patient: <strong>{$first} {$last}</strong></p>
                    <ul>
                        <li>Date: {$data['appointment_date']}</li>
                        <li>Time: {$data['appointment_time']}</li>
                        <li>Purpose: {$data['purpose']}</li>
                        <li>Booked by User ID: {$user_id}</li>
                    </ul>
                ";

                foreach ($this->admin_emails as $admin_email) {
                    $this->mailer->send($admin_email, $admin_subject, $admin_message);
                }

                $_SESSION['success_message'] = 'Appointment created successfully!';
                redirect('/appointments');
            }

            $_SESSION['error_message'] = 'Failed to create appointment.';
            redirect('/appointments/create');
        }


        /* Load Create Page */
        $data['title']     = 'Create Appointment';
        $data['user_role'] = $_SESSION['role'];

        if ($_SESSION['role'] == 'admin') {
            $data['patients'] = $this->Patient_model->get_all();
        }

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('appointments/create', $data);
        $this->call->view('layouts/footer');
    }



public function edit($id = null)
{
    if (!isset($_SESSION['logged_in'])) {
        redirect('auth/login');
    }

    if ($id === null) {
        redirect('/appointments');
    }

    // Get appointment
    $appointment = $this->Appointment_model->get_by_id($id);

    if (!$appointment) {
        $_SESSION['error_message'] = "Appointment not found.";
        redirect('/appointments');
    }

    $user_role = $_SESSION['role'];
    $user_id   = $_SESSION['id'];

    // User can only edit their own appointment unless admin
    if ($user_role != 'admin' && $appointment['created_by'] != $user_id) {
        $_SESSION['error_message'] = "You are not allowed to edit this appointment.";
        redirect('/appointments');
    }

    /* ---------------------------
       Handle Form Submission
    ----------------------------*/
    if ($this->io->method() === 'post') {

        $update_data = [
            'appointment_date' => $this->io->post('appointment_date'),
            'appointment_time' => $this->io->post('appointment_time'),
            'purpose'          => $this->io->post('purpose'),
            'status'           => $this->io->post('status')
        ];

        if ($this->Appointment_model->update_appointment($id, $update_data)) {

            // Fetch patient info for email
            $patient = $this->Patient_model->get_patient_by_id($appointment['patient_id']);

            if ($patient && !empty($patient['email'])) {

                // fallback clinic name if not defined
                $clinic_name = $this->clinic_name ?? "Our Clinic";

                $subject = "Your Appointment Has Been Updated - {$clinic_name}";

                $message = "
                    <h2>Appointment Update Notification</h2>
                    <p>Hello <strong>{$patient['first_name']} {$patient['last_name']}</strong>,</p>
                    <p>Your appointment details have been updated:</p>
                    
                    <ul>
                        <li><strong>Date:</strong> {$update_data['appointment_date']}</li>
                        <li><strong>Time:</strong> {$update_data['appointment_time']}</li>
                        <li><strong>Purpose:</strong> {$update_data['purpose']}</li>
                        <li><strong>Status:</strong> {$update_data['status']}</li>
                    </ul>

                    <p>If you have any questions, feel free to contact us.</p>
                ";

                // SEND EMAIL
                $this->mailer->send($patient['email'], $subject, $message);
            }

            $_SESSION['success_message'] = "Appointment updated successfully.";
            redirect('/appointments');
        }

        $_SESSION['error_message'] = "Failed to update appointment.";
        redirect("/appointments/edit/{$id}");
    }

    /* LOAD EDIT VIEW */
    $data['title']       = "Edit Appointment";
    $data['appointment'] = $appointment;
    $data['patients']    = $this->Patient_model->get_all();
    $data['user_role']   = $user_role;

    $this->call->view('layouts/header', $data);
    $this->call->view('layouts/sidebar');
    $this->call->view('appointments/edit', $data);
    $this->call->view('layouts/footer');
}


    public function delete($id)
{
    // Check if appointment exists
    $appointment = $this->Appointment_model->get_appointment_by_id($id);

    if (!$appointment) {
        $_SESSION['error_message'] = "Appointment not found.";
        redirect('/appointments');
    }

    // Perform delete
    if ($this->Appointment_model->delete_appointment($id)) {

        $_SESSION['success_message'] = "Appointment deleted successfully.";
        redirect('/appointments');
    }

    $_SESSION['error_message'] = "Failed to delete appointment.";
    redirect('/appointments');
}

}
?>
