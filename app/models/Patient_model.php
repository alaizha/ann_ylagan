<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Patient_model extends Model
{
    protected $table = 'patients';

    public function __construct()
    {
        parent::__construct();
    }

    /* ---------------------------------------------------------
        GET ALL PATIENTS + SEARCH + AGE CALCULATION
    --------------------------------------------------------- */
    public function get_all_patients($search = '')
    {
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

    /* ---------------------------------------------------------
        GET SINGLE PATIENT
    --------------------------------------------------------- */
    public function get_patient($id)
    {
        $patient = $this->db->table($this->table)->where('id', $id)->get();
        return $this->append_age($patient);
    }

    /* ---------------------------------------------------------
        GET PATIENT BY ID (used in Appointments)
    --------------------------------------------------------- */
    public function get_patient_by_id($id)
    {
        $patient = $this->db->table($this->table)->where('id', $id)->get();
        return $this->append_age($patient);
    }

    /* ---------------------------------------------------------
        AGE CALCULATION - FIXED
    --------------------------------------------------------- */
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

    /* ---------------------------------------------------------
        ADD AGE TO RESULT (WORKS FOR SINGLE OR MULTIPLE RECORDS)
    --------------------------------------------------------- */
    private function append_age($data)
    {
        if (empty($data)) {
            return $data;
        }

        // Single record (associative array)
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

    /* ---------------------------------------------------------
        INSERT + UPDATE
    --------------------------------------------------------- */
    public function insert_patient($data)
    {
        if (!empty($data['birth_date'])) {
            $data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }

        return $this->db->table($this->table)->insert($data);
    }

    public function update_patient($id, $data)
    {
        if (!empty($data['birth_date'])) {
            $data['birth_date'] = date('Y-m-d', strtotime($data['birth_date']));
        }

        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    /* ---------------------------------------------------------
        DELETE PATIENT
    --------------------------------------------------------- */
    public function delete_patient($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }

    /* ---------------------------------------------------------
        COUNT ACTIVE PATIENTS
    --------------------------------------------------------- */
    public function count_active_patients()
    {
        $result = $this->db->table($this->table)
                           ->where('status', 'Monitored')
                           ->get_all();

        return is_array($result) ? count($result) : 0;
    }

    /* ---------------------------------------------------------
        AI PREDICTIONS EXAMPLE
    --------------------------------------------------------- */
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

    /* ---------------------------------------------------------
        BASIC GET ALL
    --------------------------------------------------------- */
    public function get_all()
    {
        $patients = $this->db->table($this->table)->get_all();
        return $this->append_age($patients);
    }
}
