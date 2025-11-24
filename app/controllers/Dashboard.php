<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Dashboard extends Controller {

    public function __construct() {
        parent::__construct();

        if (!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $this->call->model('Patient_model');
        $this->call->model('IotDevice_model');
        $this->call->model('Transaction_model');
        $this->call->model('System_activity_model');
    }

    public function index() {
        $data = [
            'active_patients'      => $this->Patient_model->count_active_patients(),
            'connected_devices'    => $this->IotDevice_model->count_connected_devices(),
            'total_transactions'   => $this->Transaction_model->count_total_transactions(),
            'analytics_data'       => [
                'viral_load_suppression' => '87%',
                'art_adherence_rate'     => '92%',
                'new_patients_month'     => 15,
                'avg_appointments_day'   => 8
            ],
            'recent_transactions'  => $this->Transaction_model->get_recent_transactions(5),
            'system_activities'    => $this->System_activity_model->get_recent_activities(5),
            'title'                => 'Dashboard Overview',
            'user_role'            => $_SESSION['role'] ?? 'user'
        ];

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar', $data);
        $this->call->view('Dashboard/index', $data); // FIXED (capital 'D')
        $this->call->view('layouts/footer');
    }

    public function patients() {
        $data = [
            'patients' => $this->Patient_model->get_all_patients(),
            'title'    => 'All Patients',
            'user_role'=> $_SESSION['role']
        ];

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('patients/index', $data);
        $this->call->view('layouts/footer');
    }

    public function iot_devices() {
        $data['devices'] = $this->IotDevice_model->get_all_devices();
        $data['connectedCount'] = count(array_filter($data['devices'], function($d) {
            return strtolower($d['status']) === 'connected';
        }));
        $data['title'] = 'IoT Devices';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('iot_devices/index', $data);
        $this->call->view('layouts/footer');
    }

    public function blockchain() {
        $this->call->model('Blockchain_model');
        $data = [
            'transactions' => $this->Blockchain_model->get_all_transactions(),
            'patients'     => $this->Patient_model->get_all(),
            'title'        => 'Blockchain Transactions',
        ];

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('blockchain/index', $data);
        $this->call->view('layouts/footer');
    }

    public function logout() {
        session_destroy();
        redirect('auth/login');
    }
}
