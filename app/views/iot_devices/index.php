<?php
// ========================
// IoT Devices Management
// ========================

// Sample $devices and $patients arrays for demonstration (replace with DB fetch)
$devices = $devices ?? [
    ['device_id'=>'D001','type'=>'Heart Rate Monitor','patient'=>'John Doe','status'=>'connected','registered_at'=>'2025-11-23 12:30:00'],
    ['device_id'=>'D002','type'=>'Blood Pressure Sensor','patient'=>'Jane Smith','status'=>'disconnected','registered_at'=>'2025-11-22 09:15:00'],
    ['device_id'=>'D003','type'=>'Temperature Sensor','patient'=>null,'status'=>'maintenance','registered_at'=>'2025-11-20 18:45:00'],
];

$patients = $patients ?? [
    ['id'=>1,'first_name'=>'John','last_name'=>'Doe'],
    ['id'=>2,'first_name'=>'Jane','last_name'=>'Smith']
];

// ========================
// Stats Calculation
// ========================
$connectedCount = 0;
$disconnectedCount = 0;
$maintenanceCount = 0;
$totalDevices = count($devices);

if(!empty($devices)){
    foreach($devices as $device){
        $status = strtolower($device['status']);
        if($status=='connected') $connectedCount++;
        elseif($status=='disconnected') $disconnectedCount++;
        elseif($status=='maintenance') $maintenanceCount++;
    }
}

date_default_timezone_set('Asia/Manila'); // PH timezone
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>IoT Devices | HIV Treatment Monitoring</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    padding: 20px;
    color: #e5e7eb;
    min-height: 100vh;
}

.main-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Header Section */
.header-section {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 15px;
    padding: 25px 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    margin-bottom: 25px;
}

.back-button {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
    font-size: 14px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.back-button:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    color: white;
}

.page-title {
    text-align: center;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2rem;
    font-weight: 700;
    margin: 15px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.page-title i {
    color: #10b981;
    -webkit-text-fill-color: #10b981;
}

/* Stats Cards */
.stats-card {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stats-label {
    font-size: 0.9rem;
    color: #9ca3af;
}

/* Card Custom */
.card-custom {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 15px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    margin-bottom: 25px;
    overflow: hidden;
}

.card-header-custom {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 18px 25px;
    border-bottom: 2px solid rgba(16, 185, 129, 0.3);
}

.card-header-custom h5 {
    margin: 0;
    font-size: 1.2rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-body {
    padding: 25px;
    background: transparent !important;
}

/* Form Styling */
.form-label {
    color: #d1d5db;
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control, .form-select {
    background: rgba(31, 41, 55, 0.6);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 8px;
    color: #e5e7eb;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    background: rgba(31, 41, 55, 0.8);
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    color: #e5e7eb;
    outline: none;
}

.form-control::placeholder {
    color: #6b7280;
}

.form-select option {
    background: #1f2937;
    color: #e5e7eb;
}

/* Buttons */
.btn-primary-custom {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    color: white;
}

/* Table Styling - FIXED FOR DARK THEME */
.table-responsive {
    overflow-x: auto;
    background: transparent !important;
}

.table-responsive * {
    background: transparent !important;
}

.table, .table > *, .table tbody, .table thead, .table tr, .table td, .table th {
    background-color: transparent !important;
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: transparent !important;
}

.table-custom thead {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white;
}

.table-custom tbody {
    background: transparent !important;
}

.table-custom th {
    padding: 15px 12px;
    font-weight: 600;
    text-align: left;
    font-size: 14px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    background: transparent !important;
}

.table-custom th:first-child {
    border-top-left-radius: 10px;
}

.table-custom th:last-child {
    border-top-right-radius: 10px;
}

.table-custom tbody tr {
    background: transparent !important;
    border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    transition: all 0.2s ease;
}

.table-custom tbody tr:hover {
    background: rgba(16, 185, 129, 0.1) !important;
    transform: scale(1.01);
    border-left: 3px solid #10b981;
}

.table-custom td {
    padding: 15px 12px;
    font-size: 14px;
    color: #d1d5db;
    vertical-align: middle;
    background: transparent !important;
}

.text-primary {
    color: #10b981 !important;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    font-size: 13px;
}

.btn-warning.btn-action {
    background: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.3);
}

.btn-warning.btn-action:hover {
    background: rgba(251, 191, 36, 0.3);
    transform: translateY(-2px);
}

.btn-danger.btn-action {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.btn-danger.btn-action:hover {
    background: rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
}

/* Badges */
.badge-custom {
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.bg-success {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #34d399 !important;
    border: 1px solid rgba(16, 185, 129, 0.4);
}

.bg-warning {
    background: rgba(251, 191, 36, 0.2) !important;
    color: #fbbf24 !important;
    border: 1px solid rgba(251, 191, 36, 0.4);
}

.bg-danger {
    background: rgba(239, 68, 68, 0.2) !important;
    color: #f87171 !important;
    border: 1px solid rgba(239, 68, 68, 0.4);
}

.bg-primary {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white !important;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}

.empty-state i {
    font-size: 4rem;
    color: rgba(16, 185, 129, 0.3);
    margin-bottom: 20px;
}

.empty-state h6 {
    font-size: 1.1rem;
    color: #d1d5db;
    margin-top: 15px;
}

.empty-state p {
    color: #9ca3af;
}

/* Text Utilities */
.text-muted {
    color: #9ca3af !important;
}

/* Search Input in Header */
#deviceSearch {
    background: rgba(31, 41, 55, 0.6);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 8px;
    color: #e5e7eb;
    padding: 8px 15px;
}

#deviceSearch:focus {
    background: rgba(31, 41, 55, 0.8);
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    outline: none;
}

#deviceSearch::placeholder {
    color: #6b7280;
}

/* Responsive */
@media (max-width: 768px) {
    body {
        padding: 15px;
    }

    .header-section {
        padding: 20px;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .stats-number {
        font-size: 2rem;
    }

    #deviceSearch {
        width: 100% !important;
        margin-top: 10px;
    }

    .table-custom {
        font-size: 12px;
    }

    .table-custom th,
    .table-custom td {
        padding: 10px 8px;
    }
}

/* Scrollbar */
::-webkit-scrollbar {
    width: 10px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(31, 41, 55, 0.5);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #10b981;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #059669;
}
</style>
</head>
<body>
<div class="main-container">
<div class="header-section">
<div class="d-flex justify-content-between align-items-center mb-3">
<a href="<?= site_url('dashboard') ?>" class="back-button"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
<div class="text-end"><span class="badge bg-primary">IoT Management</span></div>
</div>
<h1 class="page-title"><i class="fas fa-microchip"></i>IoT Devices Management</h1>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
<div class="col-md-3"><div class="stats-card"><div class="stats-number"><?= $connectedCount ?></div><div class="stats-label"><i class="fas fa-wifi me-2"></i>Connected Devices</div></div></div>
<div class="col-md-3"><div class="stats-card"><div class="stats-number"><?= $disconnectedCount ?></div><div class="stats-label"><i class="fas fa-plug me-2"></i>Disconnected Devices</div></div></div>
<div class="col-md-3"><div class="stats-card"><div class="stats-number"><?= $maintenanceCount ?></div><div class="stats-label"><i class="fas fa-tools me-2"></i>Under Maintenance</div></div></div>
<div class="col-md-3"><div class="stats-card"><div class="stats-number"><?= $totalDevices ?></div><div class="stats-label"><i class="fas fa-list me-2"></i>Total Devices</div></div></div>
</div>

<!-- Add Device Form -->
<?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
<div class="card-custom mb-4">
<div class="card-header-custom"><h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add New Device</h5></div>
<div class="card-body">
<form action="<?= site_url('iot-devices/store') ?>" method="POST" class="row g-3" id="deviceForm">
<div class="col-md-3"><label class="form-label">Device ID</label>
<input name="device_id" type="text" class="form-control" placeholder="D001" pattern="D[0-9]{1,}" title="Device ID must start with 'D' followed by numbers" required></div>
<div class="col-md-3"><label class="form-label">Device Type</label>
<select name="type" class="form-control form-select" required>
<option value="">Select Type</option>
<option value="Heart Rate Monitor">Heart Rate Monitor</option>
<option value="Blood Pressure Sensor">Blood Pressure Sensor</option>
<option value="Temperature Sensor">Temperature Sensor</option>
<option value="Oxygen Monitor">Oxygen Monitor</option>
<option value="Activity Tracker">Activity Tracker</option>
</select></div>
<div class="col-md-3"><label class="form-label">Assigned Patient</label>
<select name="patient" class="form-control form-select">
<option value="">Select Patient</option>
<?php foreach($patients as $p): ?>
<option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['first_name'].' '.$p['last_name']) ?></option>
<?php endforeach; ?>
</select></div>
<div class="col-md-3"><label class="form-label">Status</label>
<select name="status" class="form-control form-select" required>
<option value="connected">Connected</option>
<option value="disconnected">Disconnected</option>
<option value="maintenance">Maintenance</option>
</select></div>
<div class="col-12"><button type="submit" class="btn btn-primary-custom"><i class="fas fa-save me-2"></i>Register Device</button></div>
</form>
</div>
</div>
<?php endif; ?>

<!-- Devices Table -->
<div class="card-custom">
<div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap">
<h5 class="mb-0"><i class="fas fa-list me-2"></i>Registered IoT Devices</h5>
<input type="text" id="deviceSearch" class="form-control" placeholder="Search device or patient..." style="width:300px;">
</div>
<div class="card-body table-responsive">
<table class="table table-custom table-hover">
<thead><tr>
<th>Device ID</th><th>Type</th><th>Assigned Patient</th><th>Status</th><th>Registered At</th><th>Actions</th>
</tr></thead>
<tbody id="devicesTableBody">
<?php foreach($devices as $device): ?>
<tr>
<td><strong class="text-primary"><?= htmlspecialchars($device['device_id']) ?></strong></td>
<td><i class="fas fa-microchip me-2 text-muted"></i><?= htmlspecialchars($device['type']) ?></td>
<td><?= !empty($device['patient'])? '<i class="fas fa-user me-2 text-muted"></i>'.htmlspecialchars($device['patient']):'<span class="text-muted">Not Assigned</span>' ?></td>
<td><?php $status=strtolower($device['status']); 
if($status=='connected') echo '<span class="badge bg-success badge-custom"><i class="fas fa-wifi me-1"></i>Connected</span>';
elseif($status=='maintenance') echo '<span class="badge bg-warning text-dark badge-custom"><i class="fas fa-tools me-1"></i>Maintenance</span>';
else echo '<span class="badge bg-danger badge-custom"><i class="fas fa-plug me-1"></i>Disconnected</span>';
?></td>
<td><?php if(!empty($device['registered_at'])){$dt=new DateTime($device['registered_at']);$dt->setTimezone(new DateTimeZone('Asia/Manila')); echo $dt->format('M d, Y h:i A');}else echo '-'; ?></td>
<td>
<div class="action-buttons">
<?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
<a href="<?= site_url('iot-devices/edit/'.$device['device_id']) ?>" class="btn btn-warning btn-action" title="Edit"><i class="fas fa-edit"></i></a>
<a href="<?= site_url('iot-devices/delete/'.$device['device_id']) ?>" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this device?');" title="Delete"><i class="fas fa-trash"></i></a>
<?php else: ?><span class="text-muted small">View Only</span><?php endif; ?>
</div>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// FORM VALIDATION
const deviceForm=document.getElementById('deviceForm');
if(deviceForm){
const deviceIdInput=deviceForm.querySelector('input[name="device_id"]');
const typeInput=deviceForm.querySelector('select[name="type"]');
const statusInput=deviceForm.querySelector('select[name="status"]');
deviceForm.addEventListener('submit',function(e){
let errors=[];
if(!/^D[0-9]+$/.test(deviceIdInput.value.trim())) errors.push("Device ID must start with 'D' followed by numbers.");
if(typeInput.value.trim()==="") errors.push("Please select a Device Type.");
if(statusInput.value.trim()==="") errors.push("Please select a Status for the device.");
if(errors.length>0){ e.preventDefault(); alert(errors.join("\n")); }
});
deviceIdInput.addEventListener('input',function(){ this.value=this.value.toUpperCase().replace(/[^D0-9]/g,''); });
}

// LIVE SEARCH
const devicesData = <?= json_encode($devices) ?>;
const searchInput = document.getElementById('deviceSearch');
const tableBody = document.getElementById('devicesTableBody');

function renderRows(data) {
    if(data.length === 0){
        tableBody.innerHTML = `<tr><td colspan="6" class="empty-state">
        <i class="fas fa-microchip"></i>
        <h6 class="mt-2">No Devices Found</h6>
        <p class="text-muted mb-2">No IoT devices match your search</p>
        </td></tr>`;
        return;
    }
    let html = '';
    data.forEach(d => {
        let statusBadge = '';
        switch(d.status.toLowerCase()){
            case 'connected': statusBadge = '<span class="badge bg-success badge-custom"><i class="fas fa-wifi me-1"></i>Connected</span>'; break;
            case 'maintenance': statusBadge = '<span class="badge bg-warning text-dark badge-custom"><i class="fas fa-tools me-1"></i>Maintenance</span>'; break;
            default: statusBadge = '<span class="badge bg-danger badge-custom"><i class="fas fa-plug me-1"></i>Disconnected</span>';
        }
        let patientDisplay = d.patient ? `<i class="fas fa-user me-2 text-muted"></i>${d.patient}` : '<span class="text-muted">Not Assigned</span>';
        let registeredAt = '-';
        if(d.registered_at){
            const dt = new Date(d.registered_at);
            registeredAt = dt.toLocaleString('en-PH',{month:'short',day:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit',hour12:true});
        }
        let actions = '';
<?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
        actions = `<a href="<?= site_url('iot-devices/edit/')?>${d.device_id}" class="btn btn-warning btn-action" title="Edit"><i class="fas fa-edit"></i></a>
                   <a href="<?= site_url('iot-devices/delete/')?>${d.device_id}" class="btn btn-danger btn-action" onclick="return confirm('Are you sure you want to remove this device?');" title="Delete"><i class="fas fa-trash"></i></a>`;
<?php else: ?>
        actions = '<span class="text-muted small">View Only</span>';
<?php endif; ?>

        html += `<tr>
            <td><strong class="text-primary">${d.device_id}</strong></td>
            <td><i class="fas fa-microchip me-2 text-muted"></i>${d.type}</td>
            <td>${patientDisplay}</td>
            <td>${statusBadge}</td>
            <td>${registeredAt}</td>
            <td><div class="action-buttons">${actions}</div></td>
        </tr>`;
    });
    tableBody.innerHTML = html;
}

searchInput.addEventListener('input', function() {
    const term = this.value.trim().toLowerCase();
    if(term === '') { renderRows(devicesData); return; }

    const isNumber = /^\d/.test(term);

    const filtered = devicesData.filter(d => {
        if(isNumber) {
            // Match first digit of Assigned Patient
            if(!d.patient) return false;
            const firstDigit = d.patient.match(/\d/);
            return firstDigit && firstDigit[0] === term[0];
        } else {
            // Match first letter of Type
            return d.type[0]?.toLowerCase() === term[0];
        }
    });

    renderRows(filtered);
});
</script>
</body>
</html>