<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Analytics_model extends Model {
    
    public function get_model_accuracy() {
        // ✅ Placeholder for AI accuracy — ideally fetched dynamically later
        return '89%';
    }
    
    public function get_latest_predictions($limit = 3) {
        return $this->db->table('ai_predictions')
                        ->join('patients', 'patients.patient_id = ai_predictions.patient_id')
                        ->select('ai_predictions.*, patients.name AS patient_name')
                        ->order_by('ai_predictions.created_at', 'DESC')
                        ->limit($limit)
                        ->get_all();
    }
    
    public function get_high_risk_patients() {
        return $this->db->table('ai_predictions')
                        ->where('status', 'High Risk')
                        ->order_by('risk_score', 'DESC')
                        ->get_all();
    }

    // ✅ Optional utility: count how many high-risk predictions exist
    public function count_high_risk_patients() {
        $query = $this->db->table('ai_predictions')
                          ->where('status', 'High Risk')
                          ->get();
        return $query->num_rows();
    }
}
