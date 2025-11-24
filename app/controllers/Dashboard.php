<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Dashboard extends Controller {
    
    public function __construct() {
        parent::__construct();
        // Load models
        $this->call->model('Patient_model');
        $this->call->model('IotDevice_model');
        $this->call->model('Transaction_model');
        $this->call->model('System_activity_model');
    }
    
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        // Get dashboard data
        $data['active_patients'] = $this->Patient_model->count_active_patients();
        $data['connected_devices'] = $this->IotDevice_model->count_connected_devices();
        $data['ai_accuracy'] = '92.3%';
        $data['total_transactions'] = $this->Transaction_model->count_total_transactions();
        
        // ✅ ANALYTICS DATA (palit ng patients data)
        $data['analytics_data'] = [
            'viral_load_suppression' => '87%',
            'art_adherence_rate' => '92%',
            'new_patients_month' => 15,
            'avg_appointments_day' => 8
        ];

        // Get monitored patients (keep for reference)
        $data['monitored_patients'] = $this->Patient_model->get_all_patients();
        
        // ✅ REMOVED: AI Predictions
        // $data['ai_predictions'] = $this->Patient_model->get_ai_predictions(3);
        
        // Get recent transactions
        $data['recent_transactions'] = $this->Transaction_model->get_recent_transactions(5);
        
        // Get system activities
        $data['system_activities'] = $this->System_activity_model->get_recent_activities(5);
        
        // Set page title and user role
        $data['title'] = 'Dashboard Overview';
        $data['user_role'] = $_SESSION['role'] ?? 'user';
        
        // Load view with layout
        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('dashboard/index', $data);
        $this->call->view('layouts/footer');
    }
    
    // Para sa "View All" ng patients
    public function patients() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $data['patients'] = $this->Patient_model->get_all_patients();
        $data['title'] = 'All Patients';
        $data['user_role'] = $_SESSION['role'] ?? 'user';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('patients/index', $data);
        $this->call->view('layouts/footer');
    }
    
    // Para sa "View All" ng IoT Devices
    public function iot_devices() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        // Get all devices from the model
        $data['devices'] = $this->IotDevice_model->get_all_devices();

        // Count connected devices
        $data['connectedCount'] = 0;
        if (!empty($data['devices'])) {
            foreach ($data['devices'] as $device) {
                if (isset($device['status']) && strtolower($device['status']) === 'connected') {
                    $data['connectedCount']++;
                }
            }
        }

        $data['title'] = 'IoT Devices';
        $data['user_role'] = $_SESSION['role'] ?? 'user';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('iot_devices/index', $data);
        $this->call->view('layouts/footer');
    }
    
    // Para sa "View All" ng Blockchain Transactions
    public function blockchain() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $this->call->model('Blockchain_model');
        $this->call->model('Patient_model');

        // Get all transactions
        $data['transactions'] = $this->Blockchain_model->get_all_transactions();

        // Get patient list for dropdown sa Add Form
        $data['patients'] = $this->Patient_model->get_all();

        $data['title'] = 'Blockchain Transactions';
        $data['user_role'] = $_SESSION['role'] ?? 'user';

        // Load the correct Blockchain Billing UI
        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('blockchain/index', $data);
        $this->call->view('layouts/footer');
    }
    
    // Para sa "View All" ng System Activities
    public function system_activities() {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        $data['all_activities'] = $this->System_activity_model->get_all_activities();
        $data['title'] = 'System Activities';
        $data['user_role'] = $_SESSION['role'] ?? 'user';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('system_activities/index', $data);
        $this->call->view('layouts/footer');
    }
    
    // ✅ FIXED: Para sa patient details - CORRECT METHOD NAME
    public function patient_details($id) {
        if(!isset($_SESSION['logged_in'])) {
            redirect('auth/login');
        }

        // ✅ USE THE CORRECT METHOD NAME - get_patient_by_id
        $data['patient'] = $this->Patient_model->get_patient_by_id($id);
        
        // Check if patient exists
        if(empty($data['patient'])) {
            show_404(); // Patient not found
        }

        $data['title'] = 'Patient Details';
        $data['user_role'] = $_SESSION['role'] ?? 'user';

        $this->call->view('layouts/header', $data);
        $this->call->view('layouts/sidebar');
        $this->call->view('patients/details', $data);
        $this->call->view('layouts/footer');
    }
    
    // Logout function
    public function logout() {
        // Destroy session or perform logout logic
        session_destroy();
        redirect('auth/login');
    }
}