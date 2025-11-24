<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class MedicalRecord_model extends Model {

    protected $table = 'medical_records';

    public function __construct() {
        parent::__construct();
    }

    // ✅ SIMPLE VERSION: Walang JOIN muna
    public function get_all_records() {
        return $this->db->table($this->table)
                        ->order_by('record_date', 'DESC')
                        ->get_all();
    }

    // ✅ SIMPLE VERSION: Walang JOIN muna
    public function get_records_by_user($user_id) {
        return $this->db->table($this->table)
                        ->where('user_id', $user_id)
                        ->order_by('record_date', 'DESC')
                        ->get_all();
    }

    // ✅ SIMPLE VERSION: Walang JOIN muna
    public function get_medical_record($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->get();
    }

    public function insert_medical_record($data) {
        return $this->db->table($this->table)->insert($data);
    }

    public function update_medical_record($id, $data) {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete_medical_record($id) {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}
?>