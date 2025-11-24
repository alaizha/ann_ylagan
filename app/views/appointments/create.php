<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$user_role = $_SESSION['role'] ?? 'user';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Appointment - HIV Treatment Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Create New Appointment
                            <?php if($user_role == 'admin'): ?>
                                <span class="badge bg-warning float-end">Admin Mode</span>
                            <?php else: ?>
                                <span class="badge bg-info float-end">User Mode</span>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('appointments/create') ?>" method="POST">
                            
                            <?php if($user_role == 'admin'): ?>
                                <!-- 👑 ADMIN: Select Existing Patient -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        <i class="fas fa-user me-2"></i>Select Existing Patient
                                    </label>
                                    <select class="form-select" name="patient_id" required>
                                        <option value="">-- Choose Patient --</option>
                                        <?php if(!empty($patients)): ?>
                                            <?php foreach($patients as $patient): ?>
                                                <option value="<?= $patient['id'] ?>">
                                                    <?= htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']) ?> 
                                                    (<?= $patient['contact_number'] ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <small class="text-muted">You are viewing all patients as an administrator</small>
                                </div>
                            <?php else: ?>
                                <!-- 👤 USER: Fill Up New Patient Information -->
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>New Patient Registration</strong> - Please fill up your information below
                                </div>
                                
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">First Name</label>
                                        <input type="text" class="form-control" name="first_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Birth Date</label>
                                        <input type="date" class="form-control" name="birth_date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Gender</label>
                                        <select class="form-select" name="gender" required>
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Address</label>
                                    <input type="text" class="form-control" name="address">
                                </div>
                                <hr class="my-4">
                            <?php endif; ?>

                            <!-- Common Appointment Fields for Both -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Appointment Date</label>
                                    <input type="date" class="form-control" name="appointment_date" min="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Appointment Time</label>
                                    <input type="time" class="form-control" name="appointment_time" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Purpose of Appointment</label>
                                <select class="form-select" name="purpose" required>
                                    <option value="">-- Select Purpose --</option>
                                    <option value="Regular Check-up">Regular Check-up</option>
                                    <option value="Medication Refill">Medication Refill</option>
                                    <option value="Lab Test">Lab Test</option>
                                    <option value="Consultation">Consultation</option>
                                    <option value="Follow-up">Follow-up</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="<?= site_url('appointments') ?>" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Create Appointment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>