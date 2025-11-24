<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class IotDevice_model extends Model
{
    protected $table = 'iot_devices';

    // ✅ Search filter
    // ✅ Search filter (starts with)
public function search_devices($keyword)
{
    $keyword = $keyword . '%'; // append % to match "starts with"

    return $this->db->table($this->table)
                    ->like('device_id', $keyword)
                    ->or_like('type', $keyword)
                    ->or_like('patient', $keyword)
                    ->get_all();
}

// ✅ Get all devices (with search support, starts with)
public function get_all_devices($search = '')
{
    $builder = $this->db->table($this->table);

    if (!empty($search)) {
        $search = $search . '%'; // append % for starts-with
        $builder->like('patient', $search);
        $builder->or_like('device_id', $search);
        $builder->or_like('type', $search);
    }

    return $builder->get_all();
}



    // ✅ Count connected devices
    public function count_connected_devices()
    {
        $query = $this->db->table($this->table)
                          ->where('status', 'Connected')
                          ->get_all();
        return count($query);
    }

    // ✅ Add new device
    public function add_device($data)
{
    $insertData = [
        'device_id'  => $data['device_id'],
        'type'       => $data['type'],
        'patient'    => $data['patient'],
        'status'     => isset($data['status']) ? $data['status'] : 'Connected',
        'registered_at' => isset($data['registered_at']) ? $data['registered_at'] : date('Y-m-d H:i:s')
    ];

    return $this->db->table($this->table)->insert($insertData);
}


    // ✅ Delete device
    public function delete_device($device_id)
    {
        return $this->db->table($this->table)
                        ->where('device_id', $device_id)
                        ->delete();
    }

    // ✅ Get single device by ID
    public function get_device($device_id)
    {
        return $this->db->table($this->table)
                        ->where('device_id', $device_id)
                        ->get();
    }
    // Get all patients
    public function get_all_patients()
    {
        return $this->db->table('patients')
                        ->select('id, first_name, last_name')
                        ->get_all();
    }

}
