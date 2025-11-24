<?php 
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class PatientsController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->call->model('Patient_model');
        $this->check_access();
    }

    /* ==========================================
       🔐 ADMIN ACCESS ONLY
    =========================================== */
    private function check_access() {
        $role = $_SESSION['role'] ?? 'user';
        if ($role !== 'admin') {
            redirect('dashboard');
        }
    }

    /* ==========================================
       📄 VIEW ALL PATIENTS (Fix: safe search input)
    =========================================== */
    public function index() {
    // ✅ TAMA - Gamitin ang Lavalust IO
    $search = $this->io->get('search') ?? '';
    
    $data['search'] = $search;
    $data['patients'] = $this->Patient_model->get_all_patients($search);
    $this->call->view('patients/index', $data);
}

    /* ==========================================
       ➕ ADD NEW PATIENT (POST)
    =========================================== */
    public function add() {

        $input = [
            'first_name'     => trim($this->io->post('first_name')),
            'last_name'      => trim($this->io->post('last_name')),
            'birth_date'     => $this->io->post('birth_date') ?: null,
            'gender'         => $this->io->post('gender'),
            'contact_number' => trim($this->io->post('contact_number')),
            'address'        => trim($this->io->post('address')),
            'email'          => trim($this->io->post('email')),
            'status'         => $this->io->post('status') ?: 'Monitored'
        ];

        $this->Patient_model->insert_patient($input);
        redirect('patients');
    }

    /* ==========================================
       ✏️ EDIT PAGE
    =========================================== */
    public function edit($id) {
        $data['patient'] = $this->Patient_model->get_patient_by_id($id);

        if (!$data['patient']) {
            echo "Patient not found!";
            return;
        }

        $this->call->view('patients/edit', $data);
    }

    /* ==========================================
       🔄 UPDATE PATIENT (POST)
    =========================================== */
    public function update($id) {

        $input = [
            'first_name'     => trim($this->io->post('first_name')),
            'last_name'      => trim($this->io->post('last_name')),
            'birth_date'     => $this->io->post('birth_date') ?: null,
            'gender'         => $this->io->post('gender'),
            'contact_number' => trim($this->io->post('contact_number')),
            'address'        => trim($this->io->post('address')),
            'email'          => trim($this->io->post('email')),
            'status'         => $this->io->post('status')
        ];

        $this->Patient_model->update_patient($id, $input);

        redirect('patients');
    }

    /* ==========================================
       🗑 DELETE PATIENT
    =========================================== */
    public function delete($id) {
        $this->Patient_model->delete_patient($id);
        redirect('patients');
    }

    /* ==========================================
       📤 EXPORT CSV (AUTO-INCLUDES AGE)
    =========================================== */
    public function exportCSV() {

        $patients = $this->Patient_model->get_all_patients();

        $filename = 'patients_' . date('Y-m-d') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: text/csv; charset=utf-8");

        $output = fopen("php://output", "w");

        // CSV HEADER
        fputcsv($output, [
            'ID', 'Full Name', 'Birth Date', 'Age',
            'Gender', 'Contact', 'Address', 'Email', 'Status'
        ]);

        // DATA ROWS
        foreach ($patients as $row) {

            // Ensure age exists in row
            $age = $row['age'] ?? '';

            fputcsv($output, [
                $row['id'],
                $row['first_name'] . ' ' . $row['last_name'],
                $row['birth_date'],
                $age,
                $row['gender'],
                $row['contact_number'],
                $row['address'],
                $row['email'],
                $row['status']
            ]);
        }

        fclose($output);
        exit;
    }
}
