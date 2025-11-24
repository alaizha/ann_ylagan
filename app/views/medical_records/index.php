<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="/dashboard" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <!-- Page Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="h3 mb-2 text-primary">My Medical Records</h1>
                    <p class="text-muted">Your complete medical history and treatment records</p>
                </div>
            </div>

            <!-- Medical History -->
            <!-- Medical History -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title mb-0">
            <i class="fas fa-history"></i> Medical History
        </h5>
    </div>
    <div class="card-body">
        <?php if(!empty($medical_history) && is_array($medical_history)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Doctor</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($medical_history as $record): ?>
                        <tr>
                            <td><?= date('M j, Y', strtotime($record['record_date'])) ?></td>
                            <td>
                                <span class="badge bg-info"><?= $record['type'] ?? 'General' ?></span>
                            </td>
                            <td><?= $record['doctor'] ?? 'Not specified' ?></td>
                            <td><?= $record['diagnosis'] ?? 'No diagnosis recorded' ?></td>
                            <td><?= $record['treatment'] ?? 'No treatment recorded' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center text-muted py-4">
                <i class="fas fa-file-medical fa-3x mb-3"></i>
                <p>No medical records found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

            <!-- Appointments History -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar-check"></i> Appointment History
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(!empty($appointments) && is_array($appointments)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Purpose</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($appointments as $appt): ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            if(isset($appt['appointment_date']) && !empty($appt['appointment_date'])) {
                                                echo date('M j, Y', strtotime($appt['appointment_date']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if(isset($appt['appointment_time']) && !empty($appt['appointment_time'])) {
                                                echo date('h:i A', strtotime($appt['appointment_time']));
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($appt['purpose'] ?? 'No purpose specified') ?></td>
                                        <td>
                                            <span class="badge bg-<?= 
                                                ($appt['status'] ?? 'Pending') == 'Confirmed' ? 'success' : 
                                                (($appt['status'] ?? 'Pending') == 'Pending' ? 'warning' : 'secondary')
                                            ?>">
                                                <?= $appt['status'] ?? 'Pending' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>No appointment history found.</p>
                            <?php if(($_SESSION['role'] ?? 'user') == 'admin'): ?>
                                <a href="/appointments/create" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Schedule Appointment
                                </a>
                            <?php else: ?>
                                <a href="/appointments/create" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i> Book Appointment
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="text-muted">&copy; 2025 HIV Treatment Monitoring System</p>
            </div>
        </div>
    </div>
</div>