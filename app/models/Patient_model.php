<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Patient_model extends Model
{
    protected $table = 'patients';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /* ============================
       🔍 GET PATIENT RECORDS
    ============================= */

    // ✅ FIX ADDED: REQUIRED BY APPOINTMENTS CONTROLLER
    public function get_all() {
        $patients = $this->db->table($this->table)->order_by('id', 'DESC')->get_all();
        return $this->append_age($patients);
    }

    public function get_patient_by_id($id) {
        $patient = $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();
        return $this->append_age($patient);
    }

    public function get_patient($id) {
        return $this->get_patient_by_id($id);
    }

    public function get_all_patients($search = '') {
        $db = $this->db->table($this->table);

        if (!empty($search)) {
            $db->like('first_name', $search)
               ->or_like('last_name', $search)
               ->or_like('contact_number', $search)
               ->or_like('email', $search)
               ->or_like('address', $search);
        }

        $patients = $db->order_by('id', 'DESC')->get_all();
        return $this->append_age($patients);
    }

    /* ============================
       📄 PAGINATION + SEARCH
    ============================= */

    public function page($q = '', $records_per_page = 10, $page = 1) 
    {
        $query = $this->db->table($this->table);

        if (!empty($q)) {
            $query->like('first_name', $q)
                  ->or_like('last_name', $q)
                  ->or_like('contact_number', $q)
                  ->or_like('email', $q)
                  ->or_like('address', $q);
        }

        // Clone for counting
        $countQuery = clone $query;

        $data['total_rows'] = $countQuery->select_count('*', 'count')->get()['count'];

        $data['records'] = $query->order_by('id', 'DESC')
                                ->pagination($records_per_page, $page)
                                ->get_all();

        // Add age
        $data['records'] = $this->append_age($data['records']);

        return $data;
    }

    public function get_patients_page($search = '', $limit = 10, $page = 1) {
        return $this->page($search, $limit, $page);
    }

    /* ============================
       ➕ INSERT PATIENT
    ============================= */

    public function insert_patient($data) {
        if (!empty($data['birth_date'])) {
            $data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }
        return $this->db->table($this->table)->insert($data);
    }

    /* ============================
       ✏ UPDATE PATIENT
    ============================= */

    public function update_patient($id, $data) {
        if (!empty($data['birth_date'])) {
            $data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    /* ============================
       ❌ DELETE PATIENT
    ============================= */

    public function delete_patient($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }

    /* ============================
       🔁 CHECK DUPLICATES
    ============================= */

    public function email_exists($email, $exclude_id = null) 
    {
        $query = $this->db->table($this->table)->where('email', $email);
        
        if ($exclude_id !== null) {
            $query->where('id !=', $exclude_id);
        }
        
        $result = $query->get();
        return !empty($result);
    }

    public function contact_exists($contact_number, $exclude_id = null) 
    {
        $query = $this->db->table($this->table)->where('contact_number', $contact_number);
        
        if ($exclude_id !== null) {
            $query->where('id !=', $exclude_id);
        }
        
        $result = $query->get();
        return !empty($result);
    }

    /* ============================
       📊 EXTRA UTILITIES
    ============================= */

    public function get_patients_by_status($status) {
        $patients = $this->db->table($this->table)
                        ->where('status', $status)
                        ->get_all();
        return $this->append_age($patients);
    }

    public function count_patients($status = null) {
        $query = $this->db->table($this->table);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->select_count('*', 'count')
                     ->get()['count'];
    }

    public function count_active_patients() {
        return $this->count_patients('Monitored');
    }

    public function get_recent_patients($limit = 5) {
        $patients = $this->db->table($this->table)
                        ->order_by('id', 'DESC')
                        ->limit($limit)
                        ->get_all();
        return $this->append_age($patients);
    }

    /* ============================
       🔧 AGE CALCULATION UTILITIES
    ============================= */

    private function calculate_age($birth_date)
    {
        if (empty($birth_date) || $birth_date == '0000-00-00') {
            return 'N/A';
        }

        try {
            $birth = new DateTime($birth_date);
            $today = new DateTime();
            return $today->diff($birth)->y;
        } catch (Exception $e) {
            return 'N/A';
        }
    }

    private function append_age($data)
    {
        if (empty($data)) {
            return $data;
        }

        // Single record
        if (isset($data['id'])) {
            $data['age'] = $this->calculate_age($data['birth_date'] ?? null);
            return $data;
        }

        // Multiple records
        foreach ($data as &$patient) {
            $patient['age'] = $this->calculate_age($patient['birth_date'] ?? null);
        }

        return $data;
    }

    /* ============================
       🤖 AI PREDICTIONS
    ============================= */

    public function get_ai_predictions($limit = 3)
    {
        return [
            [
                'patient_name' => 'John Doe',
                'prediction' => 'High Risk',
                'accuracy' => '91%'
            ],
            [
                'patient_name' => 'Jane Smith',
                'prediction' => 'Moderate Risk',
                'accuracy' => '88%'
            ],
            [
                'patient_name' => 'Michael Cruz',
                'prediction' => 'Low Risk',
                'accuracy' => '94%'
            ],
        ];
    }
}
