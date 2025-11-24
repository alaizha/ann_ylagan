<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Blockchain extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Blockchain_model');
        $this->call->model('Patient_model');
    }

    // 🛑 Check if user is admin - REDIRECT if not
    private function check_admin_access() {
        $role = $_SESSION['role'] ?? 'user';
        if($role != 'admin') {
            redirect('dashboard'); // Redirect to dashboard if not admin
        }
    }

    // List + Search
    public function index()
    {
        $this->check_admin_access(); // Check access before proceeding
        
        $search = isset($_GET['search']) ? $_GET['search'] : null;

        $data['search'] = $search;
        $data['transactions'] = $this->Blockchain_model->get_all_transactions($search);

        $this->call->view('blockchain/index', $data);
    }

    // Show Create Form
    public function create()
    {
        $this->check_admin_access(); // Check access before proceeding
        
        $data['patients'] = $this->Patient_model->get_all();
        $this->call->view('blockchain/create', $data);
    }

    // Save Transaction
    public function store() 
    {
        $this->check_admin_access(); // Check access before proceeding
        
        $data = [
            'tx_no'       => uniqid('TX-'),
            'patient_id'  => $this->io->post('patient'),
            'amount'      => $this->io->post('amount'),
            'description' => $this->io->post('description'),
            'status'      => $this->io->post('status'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->Blockchain_model->insert_transaction($data);
        redirect('blockchain');
    }

    // Edit Form
    public function edit($id) 
    {
        $this->check_admin_access(); // Check access before proceeding
        
        $data['transaction'] = $this->Blockchain_model->get_transaction($id);
        $data['patients'] = $this->Patient_model->get_all();
        $this->call->view('blockchain/edit', $data);
    }

    // Update
    public function update($id)
    {
        $this->check_admin_access(); // Check access before proceeding
        
        $data = [
            'patient_id'  => $this->io->post('patient'),
            'amount'      => $this->io->post('amount'),
            'description' => $this->io->post('description'),
            'status'      => $this->io->post('status')
        ];

        $this->Blockchain_model->update_transaction($id, $data);
        redirect('blockchain');
    }

    // Delete
    public function delete($id) {
        $this->check_admin_access(); // Check access before proceeding
        
        $this->Blockchain_model->delete_transaction($id);
        redirect('blockchain');
    }
}
?>