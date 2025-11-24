<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Blockchain_model extends Model {

    // Fetch All Transactions + Patient Name
    public function get_all_transactions($search = null) 
    {
        $sql = "SELECT t.*, CONCAT(p.first_name, ' ', p.last_name) AS patient_name
                FROM transactions t
                LEFT JOIN patients p ON p.id = t.patient_id";

        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE p.first_name LIKE ? OR p.last_name LIKE ? OR t.tx_no LIKE ? OR t.status LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
        }

        return $this->db->raw($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get Single Transaction
    public function get_transaction($id)
    {
        $sql = "SELECT t.*, CONCAT(p.first_name, ' ', p.last_name) AS patient_name
                FROM transactions t
                LEFT JOIN patients p ON p.id = t.patient_id
                WHERE t.id = ?";

        return $this->db->raw($sql, [$id])->fetch(PDO::FETCH_ASSOC);
    }

    // Insert
    public function insert_transaction($data)
    {
        return $this->db->table('transactions')->insert($data);
    }

    // Update
    public function update_transaction($id, $data) 
    {
        return $this->db->table('transactions')->where('id', $id)->update($data);
    }

    // Delete
    public function delete_transaction($id) 
    {
        return $this->db->table('transactions')->where('id', $id)->delete();
    }
}
