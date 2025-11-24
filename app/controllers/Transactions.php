<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Transactions extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Transaction_model');
        $this->call->model('Patient_model'); // para sa dropdown
    }

    // Dashboard list
    public function index() {
        $data['transactions'] = $this->Transaction_model->get_all();
        $this->call->view('blockchain/index', $data);
    }

    // Add Form Page
    public function create() {
        $data['patients'] = $this->Patient_model->get_all();
        $this->call->view('blockchain/create', $data);
    }

    // Save new transaction
    public function add() {

        $last_tx = $this->Transaction_model->get_last_tx_no();

        if ($last_tx) {
            $num = (int) filter_var($last_tx, FILTER_SANITIZE_NUMBER_INT);
            $tx_no = 'T' . str_pad($num + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $tx_no = 'T001';
        }

        // ✅ Get patient_id, NOT patient_name
        $patient_id = $this->io->post('patient');

        $amount = $this->io->post('amount');
        $description = $this->io->post('description');
        $status = $this->io->post('status');

        $data = [
            'tx_no' => $tx_no,
            'patient_id' => $patient_id,

            'amount' => $amount,
            'description' => $description,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Transaction_model->insert_transaction($data)) {
            redirect('transactions');
        } else {
            echo "❌ Failed to add transaction.";
        }
    }

    // 🧾 Print Receipt
    public function print_receipt($id)
    {
        $transaction = $this->Transaction_model->get_transaction_by_id($id);

        if (!$transaction) {
            die("Transaction not found.");
        }

        // ✅ Join output already includes full name, use it
        $this->call->view('transactions/receipt', ['transaction' => $transaction]);
    }
}
