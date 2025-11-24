<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Transactions extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Transaction_model');
        $this->call->model('Patient_model');
    }

    // Fetch transactions for frontend AJAX
    public function fetch() {
        $term = strtolower(trim($_GET['term'] ?? ''));
        $transactions = $this->Transaction_model->get_all();

        if ($term !== '') {
            $firstChar = $term[0];

            if (is_numeric($firstChar)) {
                // Filter by TX No
                $transactions = array_filter($transactions, function($tx) use ($term){
                    return strpos(strtolower($tx['tx_no']), $term) === 0;
                });
            } else {
                // Filter by first letter of first name
                $transactions = array_filter($transactions, function($tx) use ($firstChar){
                    $firstName = strtolower(explode(' ', $tx['patient_name'])[0]);
                    return isset($firstName[0]) && $firstName[0] === $firstChar;
                });
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array_values($transactions));
        exit;
    }

    // Add new transaction
    public function add() {
        $patient_id = $this->io->post('patient_id');
        $amount = $this->io->post('amount');
        $description = $this->io->post('description');
        $status = $this->io->post('status');

        $tx_no = 'TX-' . uniqid();

        $data = [
            'tx_no'        => $tx_no,
            'patient_id'   => $patient_id,
            'amount'       => $amount,
            'description'  => $description,
            'status'       => $status,
            'created_at'   => date('Y-m-d H:i:s')
        ];

        $inserted = $this->Transaction_model->insert_transaction($data);

        header('Content-Type: application/json');
        echo json_encode(['success' => $inserted]);
        exit;
    }

    // PRINT RECEIPT
    public function print_receipt($id)
    {
        // Model is already loaded inside __construct()

        $transaction = $this->Transaction_model->get_transaction_by_id($id);

        if (!$transaction) {
            show_404();
            return;
        }

        // Load view (correct way in LavaLust)
        $this->call->view('transactions/receipt', [
            'transaction' => $transaction
        ]);
    }

}
?>