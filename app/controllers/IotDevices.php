<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class IotDevices extends Controller
{
    protected $iotDeviceModel;

    public function __construct()
    {
        parent::__construct();

        $this->call->model('IotDevice_model');
        $this->iotDeviceModel = new IotDevice_model();

        // ✅ Require login
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            exit;
        }

        // ✅ Require admin access
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Access Denied: Admins Only.');
            exit;
        }
    }

    private function require_admin()
    {
        if ($this->session->userdata('role') !== 'admin') {
            show_error('Access Denied: Admins Only.');
            exit;
        }
    }

    public function index()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $devices = $this->iotDeviceModel->get_all_devices($search);
        $connectedCount = $this->iotDeviceModel->count_connected_devices();
        
        // Get patients for dropdown
        $patients = $this->iotDeviceModel->get_all_patients();

        $this->call->view('iot_devices/index', [
            'devices' => $devices,
            'connectedCount' => $connectedCount,
            'search' => $search,
            'patients' => $patients
        ]);
    }

    public function get_all_devices($search = '') {
        $builder = $this->db->table($this->table);

        if (!empty($search)) {
            $search = $search . '%'; // starts with
            $builder->like('patient', $search)
                    ->or_like('device_id', $search)
                    ->or_like('type', $search);
        }

        return $builder->get_all(); // Make sure you return this
    }


    public function store()
{
    $this->require_admin();

    // Set timezone to Philippines
    date_default_timezone_set('Asia/Manila');

    $data = [
        'device_id'  => $this->io->post('device_id'),
        'type'       => $this->io->post('type'),
        'patient'    => $this->io->post('patient'),
        'status'     => 'Connected',
        'registered_at' => date('Y-m-d H:i:s') // 24-hour format para sa database

    ];

    $this->iotDeviceModel->add_device($data);
    redirect('/iot-devices');
}


    public function delete($device_id)
    {
        $this->require_admin();

        $this->iotDeviceModel->delete_device($device_id);
        redirect('/iot-devices');
    }

    public function edit($device_id)
    {
        $this->require_admin();

        $device = $this->iotDeviceModel->get_device($device_id);
        $this->call->view('iot_devices/edit', ['device' => $device]);
    }

    public function update($device_id)
    {
        $this->require_admin();

        $data = [
            'type'      => $this->io->post('type'),
            'patient'   => $this->io->post('patient'),
            'status'    => $this->io->post('status'),
        ];

        $this->db->table('iot_devices')
                 ->where('device_id', $device_id)
                 ->update($data);

        redirect('/iot-devices');
    }
}
