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
       📄 VIEW ALL PATIENTS (SAME STRUCTURE AS USERSCONTROLLER)
    =========================================== */
    public function index() {
    $search = $this->io->get('search') ?? '';
    $page = $this->io->get('page') ? (int)$this->io->get('page') : 1;
    $records_per_page = 10;

    // Get paginated patients
    $patients_data = $this->Patient_model->page($search, $records_per_page, $page);
    $data['patients'] = $patients_data['records'];
    $total_rows = $patients_data['total_rows'];

    // Pagination settings
    $this->pagination->set_options([
        'first_link' => '⏮ First',
        'last_link'  => 'Last ⏭',
        'next_link'  => 'Next →',
        'prev_link'  => '← Prev',
        'page_delimiter' => '&page='
    ]);

    $this->pagination->set_theme('custom');
    $this->pagination->initialize($total_rows, $records_per_page, $page, 'patients?search='.$search);
    $data['page'] = $this->pagination->paginate();

    $data['search'] = $search;
    $data['total_patients'] = $total_rows;
    $data['current_page'] = $page;
    $data['total_pages'] = ceil($total_rows / $records_per_page);

    // ✅ REQUIRED FOR GLOBAL SEARCH (ALL PAGES)
    $data['all_patients'] = $this->Patient_model->get_all_patients();

    // Render
    $this->call->view('patients/index', $data);
}


    // ... REST OF YOUR METHODS REMAIN THE SAME ...
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

    public function edit($id) {
        $data['patient'] = $this->Patient_model->get_patient_by_id($id);
        if (!$data['patient']) {
            echo "Patient not found!";
            return;
        }
        $this->call->view('patients/edit', $data);
    }

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

    public function delete($id) {
        $this->Patient_model->delete_patient($id);
        redirect('patients');
    }
    

    public function exportCSV() {
        $patients = $this->Patient_model->get_all_patients();
        $filename = 'patients_' . date('Y-m-d') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: text/csv; charset=utf-8");

        $output = fopen("php://output", "w");
        fputcsv($output, ['ID', 'Full Name', 'Birth Date', 'Age', 'Gender', 'Contact', 'Address', 'Email', 'Status']);

        foreach ($patients as $row) {
            $age = $row['age'] ?? '';
            fputcsv($output, [
                $row['id'], $row['first_name'] . ' ' . $row['last_name'],
                $row['birth_date'], $age, $row['gender'], $row['contact_number'],
                $row['address'], $row['email'], $row['status']
            ]);
        }
        fclose($output);
        exit;
    }
}