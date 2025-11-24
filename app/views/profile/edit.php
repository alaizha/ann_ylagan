<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <!-- Back Buttons -->
            <div class="mb-4">
                <a href="/profile" class="btn btn-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left"></i> Back to Profile
                </a>
                <a href="/dashboard" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </div>

            <!-- Page Header -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="h3 mb-2 text-primary">Edit Profile</h1>
                    <p class="text-muted">Update your account information</p>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="card-title mb-0">Edit Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form method="POST" action="/profile/update">
                                <!-- Username Field -->
                                <div class="mb-4">
                                    <label for="username" class="form-label fw-bold">Username</label>
                                    <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                           value="<?= $user['username'] ?>" required>
                                </div>
                                
                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                           value="<?= $user['email'] ?>" required>
                                </div>
                                
                                <!-- Password Field -->
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                           placeholder="Enter new password">
                                    <div class="form-text text-center">Leave blank to keep current password</div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg me-3">
                                        <i class="fas fa-save"></i> Update Profile
                                    </button>
                                    <a href="/profile" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
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