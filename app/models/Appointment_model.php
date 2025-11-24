<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Appointment_model extends Model {

    protected $table = 'appointments';

    public function __construct() {
        parent::__construct();
    }

    /* ===========================================================
     * BASIC GETTERS (Single Appointment)
     * =========================================================== */

    // Controller expects this:
    public function get_by_id($id)
    {
        $sql = "SELECT * FROM appointments WHERE id = ?";
        return $this->db->raw($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    // Alias for backward compatibility
    public function get_appointment_by_id($id)
    {
        return $this->get_by_id($id);
    }

    // Get with joined patient info
    public function get_appointment_with_patient($id) {
        $sql = "SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id
                WHERE a.id = ?";
        
        return $this->db->raw($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    // Simple shorthand alias
    public function get($id) {
        return $this->get_appointment_with_patient($id);
    }

    /* ===========================================================
     * GET MULTIPLE APPOINTMENTS
     * =========================================================== */

    public function get_all_appointments() {
        return $this->db->table($this->table)
                        ->order_by('appointment_date', 'DESC')
                        ->order_by('appointment_time', 'DESC')
                        ->get_all();
    }

    public function get_appointments_with_patients() {
        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";

        return $this->db->raw($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_appointments_by_patient($patient_id) {
        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id
                WHERE a.patient_id = ?
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";

        return $this->db->raw($sql, [$patient_id])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_appointments_by_user($user_id) {
        return $this->db->table('appointments as a')
                        ->select('a.*, p.first_name, p.last_name, p.contact_number')
                        ->join('patients as p', 'a.patient_id = p.id')
                        ->where('a.created_by', $user_id)
                        ->order_by('a.appointment_date', 'DESC')
                        ->get_all();
    }

    public function get_todays_appointments() {
        $today = date('Y-m-d');

        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id
                WHERE a.appointment_date = ?
                ORDER BY a.appointment_time ASC";

        return $this->db->raw($sql, [$today])->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
     * SEARCH FUNCTIONS
     * =========================================================== */

    public function search_appointments($search = '') {
        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id";

        if (!empty($search)) {
            $sql .= " WHERE p.first_name LIKE ?
                      OR p.last_name LIKE ?
                      OR a.purpose LIKE ?";
            $s = "%$search%";
            return $this->db->raw($sql, [$s, $s, $s])->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        return $this->db->raw($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search_appointments_by_user($user_id, $search = '') {
        $sql = "SELECT a.*, p.first_name, p.last_name
                FROM appointments a
                LEFT JOIN patients p ON p.id = a.patient_id
                WHERE a.created_by = ?";

        if (!empty($search)) {
            $sql .= " AND (p.first_name LIKE ?
                        OR p.last_name LIKE ?
                        OR a.purpose LIKE ?)";
            $s = "%$search%";
            return $this->db->raw($sql, [$user_id, $s, $s, $s])->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        return $this->db->raw($sql, [$user_id])->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
     * INSERT, UPDATE, DELETE
     * =========================================================== */

    public function insert_appointment($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_appointment($id, $data) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    public function delete_appointment($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }
}
?>
