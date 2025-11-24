<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Transaction_model extends Model {

    protected $table = 'transactions';

    /* ================================
       GET ALL TRANSACTIONS
    ================================= */
    public function get_all() {
        return $this->db->table($this->table)
                        ->order_by('created_at', 'DESC')
                        ->get_all();
    }

    /* ================================
       COUNT TOTAL TRANSACTIONS
    ================================= */
    public function count_total_transactions() {
        return $this->db->table($this->table)->count();
    }

    /* ================================
       GET RECENT TRANSACTIONS
    ================================= */
    public function get_recent_transactions($limit = 5) {
        return $this->db->table($this->table)
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get_all();
    }

    /* ================================
       GET LAST TX NUMBER
    ================================= */
    public function get_last_tx_no() {
        $row = $this->db->table($this->table)
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get();

        return (!empty($row) && isset($row[0]->tx_no)) 
            ? $row[0]->tx_no 
            : null;
    }

    /* ================================
       INSERT TRANSACTION
    ================================= */
    public function insert_transaction($data) {

        if (!isset($data['patient_id']) || empty($data['patient_id'])) {
            throw new Exception('Patient ID is required.');
        }

        // Fetch patient
        $patient = $this->db->table('patients')
                            ->where('id', $data['patient_id'])
                            ->get();

        // Auto-generate patient_name
        if (!empty($patient)) {
            $data['patient_name'] = trim($patient[0]->first_name . ' ' . $patient[0]->last_name);
        } else {
            $data['patient_name'] = 'Unknown Patient';
        }

        return $this->db->table($this->table)->insert($data);
    }

    /* ================================
       UPDATE TRANSACTION
    ================================= */
    public function update_transaction($id, $data) {

        // Update patient_name if patient_id changed
        if (isset($data['patient_id'])) {
            $patient = $this->db->table('patients')
                                ->where('id', $data['patient_id'])
                                ->get();

            if (!empty($patient)) {
                $data['patient_name'] = trim($patient[0]->first_name . ' ' . $patient[0]->last_name);
            } else {
                $data['patient_name'] = 'Unknown Patient';
            }
        }

        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->update($data);
    }

    /* ================================
       GET TRANSACTION BY ID (FIXED)
    ================================= */
    public function get_transaction_by_id($id) {

        $sql = "SELECT 
                    t.id,
                    t.tx_no,
                    t.patient_id,
                    t.patient_name,
                    t.amount,
                    t.description,
                    t.status,
                    t.created_at,
                    p.first_name,
                    p.last_name
                FROM transactions t
                LEFT JOIN patients p ON p.id = t.patient_id
                WHERE t.id = ?";

        $stmt = $this->db->raw($sql, [$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return null;

        // Auto-fallback if patient_name is empty
        if (empty($row['patient_name']) && !empty($row['first_name'])) {
            $row['patient_name'] = trim($row['first_name'] . ' ' . $row['last_name']);
        }

        return $row;
    }

    /* ================================
       DELETE TRANSACTION
    ================================= */
    public function delete_transaction($id) {
        return $this->db->table($this->table)
                        ->where('id', $id)
                        ->delete();
    }
}
?>