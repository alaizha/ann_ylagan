<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Back to Dashboard Button -->
            <div class="mb-4">
                <a href="/dashboard" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <!-- Page Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="h3 mb-2 text-primary">My Profile</h1>
                    <p class="text-muted">Manage your account information</p>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success text-center"><?= $_SESSION['success_message'] ?></div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger text-center"><?= $_SESSION['error_message'] ?></div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <!-- Profile Information Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="card-title mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- Profile Details -->
                            <div class="profile-details text-center">
                                <div class="mb-4">
                                    <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                                </div>
                                
                                <div class="row text-start">
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                            <span class="fw-bold">Username:</span>
                                            <span class="text-muted"><?= $user['username'] ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                            <span class="fw-bold">Email:</span>
                                            <span class="text-muted"><?= $user['email'] ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                            <span class="fw-bold">Role:</span>
                                            <span class="badge bg-info"><?= ucfirst($user['role']) ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <div class="d-flex justify-content-between align-items-center p-3 border rounded">
                                            <span class="fw-bold">Member Since:</span>
                                            <span class="text-muted"><?= date('F j, Y', strtotime($user['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center">
                                <a href="/profile/edit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-edit"></i> Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4">
                <p class="text-muted">&copy; 2025 HIV Treatment Monitoring System</p>
            </div>
        </div>
    </div>
</div>