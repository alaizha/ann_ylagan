<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class System_activity_model extends Model {
    
    public function get_recent_activities($limit = 5) {
        return [
            [
                'activity' => 'Patient data updated - Juan Dela Cruz',
                'timestamp' => 'just now'
            ],
            [
                'activity' => 'New AI prediction generated',
                'timestamp' => '5 minutes ago' 
            ],
            [
                'activity' => 'System backup completed',
                'timestamp' => '1 hour ago'
            ],
            [
                'activity' => 'New patient registered - Ana Reyes',
                'timestamp' => '2 hours ago'
            ],
            [
                'activity' => 'IoT device connected - Vital Signs Monitor',
                'timestamp' => '3 hours ago'
            ]
        ];
    }
    public function get_all_activities() {
    return [
        // Return all activities
        ['activity' => 'System backup completed', 'timestamp' => '1 hour ago'],
        // Add more activities
    ];
}
}