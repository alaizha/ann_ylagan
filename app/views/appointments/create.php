<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$user_role = $_SESSION['role'] ?? 'user';
$user_id   = $_SESSION['user']['id'] ?? 0;

// Fetch user email from DB
$email = '';
if($user_id) {
    $db = new mysqli('localhost', 'root', '', 'mockdata'); // adjust DB credentials
    if($db->connect_error){
        die("DB connection failed: " . $db->connect_error);
    }
    $stmt = $db->prepare("SELECT email FROM user WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Appointment - HIV Treatment Monitoring System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%); color: #ffffff; min-height: 100vh; padding: 20px; position: relative; overflow-x: hidden; }
        body::before { content: ''; position: fixed; width: 500px; height: 500px; background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%); top: -200px; right: -200px; animation: float 8s ease-in-out infinite; pointer-events: none; }
        body::after { content: ''; position: fixed; width: 400px; height: 400px; background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%); bottom: -150px; left: -150px; animation: float 10s ease-in-out infinite reverse; pointer-events: none; }
        @keyframes float { 0%,100%{ transform: translate(0,0); } 50%{ transform: translate(20px,-20px); } }
        .container { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }
        .back-btn { margin-bottom: 25px; }
        .btn { padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; border: none; cursor: pointer; color: #ffffff; }
        .btn-secondary { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3); }
        .btn-secondary:hover { background: linear-gradient(135deg, #4b5563 0%, #374151 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(107, 114, 128, 0.5); }
        .btn-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); }
        .btn-primary:hover { background: linear-gradient(135deg, #059669 0%, #047857 100%); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6); }
        .card { background: linear-gradient(135deg, #1f2937 0%, #111827 100%); border: 1px solid rgba(16, 185, 129, 0.2); border-radius: 15px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3); overflow: hidden; animation: fadeIn 0.6s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .card-header { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 20px 30px; border-bottom: 1px solid rgba(16, 185, 129, 0.3); }
        .card-header h4 { margin: 0; font-size: 1.5rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; }
        .badge { padding: 8px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge.bg-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
        .badge.bg-info { background: linear-gradient(135deg, #338552ff 0%, #3f9866ff 100%); color: white; }
        .badge.bg-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
        .card-body { padding: 35px; }
        .alert { padding: 15px 20px; border-radius: 10px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; animation: slideIn 0.5s ease; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        .alert-info { background: rgba(51, 188, 70, 0.2); color: #337943ff; border: 1px solid rgba(68, 224, 91, 0.4); }
        .form-label { display: block; margin-bottom: 8px; color: #d1d5db; font-weight: 600; font-size: 14px; }
        .form-control, .form-select { width: 100%; padding: 12px 16px; border-radius: 10px; border: 1px solid rgba(16, 185, 129, 0.3); background: rgba(31, 41, 55, 0.5); color: #ffffff !important; font-size: 14px; transition: all 0.3s ease; outline: none; caret-color: #ffffff; }
        .form-control:focus, .form-select:focus { border-color: #10b981; background: rgba(31, 41, 55, 0.8); box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2); transform: translateY(-2px); }
        .form-control::placeholder, .form-select::placeholder { color: #9ca3af; }
        .form-select option { color: #ffffff; background: #1f2937; }
        input:-webkit-autofill, input:-webkit-autofill:hover, input:-webkit-autofill:focus, select:-webkit-autofill, select:-webkit-autofill:hover, select:-webkit-autofill:focus, textarea:-webkit-autofill, textarea:-webkit-autofill:hover, textarea:-webkit-autofill:focus { -webkit-box-shadow: 0 0 0px 1000px rgba(31, 41, 55, 0.5) inset !important; -webkit-text-fill-color: #ffffff !important; caret-color: #ffffff !important; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col-md-6 { flex: 0 0 50%; max-width: 50%; padding: 0 10px; margin-bottom: 20px; }
        .mb-4 { margin-bottom: 20px; }
        hr { border: none; border-top: 1px solid rgba(16, 185, 129, 0.2); margin: 30px 0; }
        .d-grid { display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px; }
        @media (max-width: 768px) {
            .col-md-6 { flex: 0 0 100%; max-width: 100%; }
            .card-header h4 { flex-direction: column; gap: 10px; text-align: center; }
            .d-grid { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: rgba(31, 41, 55, 0.5); border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #059669; }
    </style>
</head>
<body>
<div class="container">
    <div class="back-btn">
        <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Appointments
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>
                <span><i class="fas fa-calendar-plus"></i> Create New Appointment</span>
                <?php if($user_role == 'admin'): ?>
                    <span class="badge bg-warning">Admin Mode</span>
                <?php else: ?>
                    <span class="badge bg-info">User Mode</span>
                <?php endif; ?>
            </h4>
        </div>
        <div class="card-body">
            <?php if($user_role == 'admin'): ?>
                <div class="text-center py-4">
                    <div class="alert alert-info">
                        <i class="fas fa-eye fa-2x"></i>
                        <div>
                            <h5>Appointment View Mode</h5>
                            <p style="margin: 5px 0 0;">As an administrator, you can view and manage appointments but cannot create new ones.</p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <form action="<?= site_url('appointments/create') ?>" method="POST">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>New Patient Registration</strong> - Please fill up your information below
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required oninput="this.value=this.value.replace(/[^A-Za-z\s]/g,'')">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Birth Date</label>
                            <input type="date" class="form-control" name="birth_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="gender" required>
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="contact_number" required
                                   oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value.length>11) this.value=this.value.slice(0,11);">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email) ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address">
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Appointment Date</label>
                            <input type="date" class="form-control" name="appointment_date" id="appointment_date" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Appointment Time</label>
                            <input type="time" class="form-control" name="appointment_time" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Purpose of Appointment</label>
                        <select class="form-select" name="purpose" required>
                            <option value="">-- Select Purpose --</option>
                            <option value="Regular Check-up">Regular Check-up</option>
                            <option value="Medication Refill">Medication Refill</option>
                            <option value="Lab Test">Lab Test</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Appointment
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    const appointmentDate = document.getElementById('appointment_date');
    appointmentDate.setAttribute('min', today);
    appointmentDate.addEventListener('input', function() {
        if(this.value < today) this.value = today;
    });
</script>
</body>
</html>
