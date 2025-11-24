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

        $this->call->view('iot_devices/index', [
            'devices' => $devices,
            'connectedCount' => $connectedCount,
            'search' => $search
        ]);
    }

    public function store()
    {
        $this->require_admin();

        $data = [
            'device_id' => $this->io->post('device_id'),
            'type'      => $this->io->post('type'),
            'patient'   => $this->io->post('patient'),
            'status'    => 'Connected',
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
