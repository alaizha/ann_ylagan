<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">

            <!-- Back Buttons -->
            <div class="mb-4">
                <a href="/dashboard" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <a href="/dashboard/patients" class="btn btn-outline-secondary">
                    <i class="fas fa-users"></i> View All Patients
                </a>
            </div>

            <!-- Page Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="h3 mb-2 text-primary">Patient Details</h1>
                    <p class="text-muted">Complete patient information and records</p>
                </div>
            </div>

            <?php if(empty($patient)): ?>
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle"></i> Patient not found!
                </div>
            <?php else: ?>

                <!-- Patient Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-circle"></i> Patient Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <strong class="text-primary">Patient ID:</strong>
                                    <span class="badge bg-secondary ms-2">#<?= $patient['id'] ?></span>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-primary">First Name:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($patient['first_name']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-primary">Last Name:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($patient['last_name']) ?></p>
                                </div>

                                <!-- AGE + BIRTH DATE DISPLAY -->
                                <div class="mb-3">
                                    <strong class="text-primary">Age:</strong>
                                    <p class="mb-0">
                                        <?php 
                                            if (!empty($patient['birth_date']) && $patient['birth_date'] != '0000-00-00') {
                                                // Calculate age
                                                $dob = new DateTime($patient['birth_date']);
                                                $today = new DateTime();
                                                $age = $today->diff($dob)->y;
                                                echo $age . " years old";
                                            } else {
                                                echo "N/A";
                                            }
                                        ?>

                                        <?php if (!empty($patient['birth_date']) && $patient['birth_date'] != '0000-00-00'): ?>
                                            <br><small class="text-muted">(Born: <?= date('F j, Y', strtotime($patient['birth_date'])) ?>)</small>
                                        <?php endif; ?>
                                    </p>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <strong class="text-primary">Gender:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($patient['gender']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-primary">Contact Number:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($patient['contact_number']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-primary">Email:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($patient['email']) ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-primary">Status:</strong>
                                    <span class="badge bg-<?= ($patient['status'] == 'Monitored' ? 'success' : 'warning') ?>">
                                        <?= htmlspecialchars($patient['status']) ?>
                                    </span>
                                </div>

                            </div>
                        </div>

                        <?php if(!empty($patient['address'])): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <strong class="text-primary">Address:</strong>
                                <p class="mb-0"><?= htmlspecialchars($patient['address']) ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Medical Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-heartbeat"></i> Medical Information
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-info">CD4 Count:</strong>
                                    <p class="mb-0"><?= $patient['cd4_count'] ?? 'Not recorded' ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-info">Viral Load:</strong>
                                    <p class="mb-0"><?= $patient['viral_load'] ?? 'Not recorded' ?></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <strong class="text-info">ART Regimen:</strong>
                                    <p class="mb-0"><?= $patient['art_regimen'] ?? 'Not specified' ?></p>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-info">Last Visit:</strong>
                                    <p class="mb-0">
                                        <?= !empty($patient['last_visit_date']) ? date('F j, Y', strtotime($patient['last_visit_date'])) : 'No visits recorded' ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="/appointments/create?patient_id=<?= $patient['id'] ?>" class="btn btn-primary me-2">
                        <i class="fas fa-calendar-plus"></i> Schedule Appointment
                    </a>

                    <a href="/patients/edit/<?= $patient['id'] ?>" class="btn btn-warning me-2">
                        <i class="fas fa-edit"></i> Edit Patient
                    </a>

                    <a href="/dashboard" class="btn btn-secondary">
                        <i class="fas fa-tachometer-alt"></i> Back to Dashboard
                    </a>
                </div>

            <?php endif; ?>

            <div class="text-center mt-5">
                <p class="text-muted">&copy; 2025 HIV Treatment Monitoring System</p>
            </div>

        </div>
    </div>
</div>
