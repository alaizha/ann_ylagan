<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Transaction_model extends Model {

    public function get_all() {
        return $this->db->table('transactions')
                        ->order_by('created_at', 'DESC')
                        ->get_all();
    }

    public function count_total_transactions() {
        return $this->db->table('transactions')->count();
    }

    public function get_recent_transactions($limit = 5) {
        return $this->db->table('transactions')
                        ->order_by('created_at', 'DESC')
                        ->limit($limit)
                        ->get_all();
    }

    public function insert_transaction($data) {
        return $this->db->table('transactions')->insert($data);
    }

    public function get_last_tx_no() {
        $row = $this->db->table('transactions')
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get();

        if (!empty($row) && isset($row[0]->tx_no)) {
            return $row[0]->tx_no;
        }
        return null;
    }

    // ✅ TAMA NA get_transaction_by_id
   public function get_transaction_by_id($id)
{
    $sql = "SELECT 
                t.id, 
                t.tx_no, 
                t.amount, 
                t.description, 
                t.status, 
                t.created_at,
                p.first_name,
                p.last_name
            FROM transactions t
            LEFT JOIN patients p ON p.id = t.patient_id
            WHERE t.id = ?";

    // Execute
    $stmt = $this->db->raw($sql, [$id]);

    // Fetch result as array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    // Create full patient name
    $row['patient_name'] = $row['first_name'] . ' ' . $row['last_name'];

    return $row;
}



}
?>
