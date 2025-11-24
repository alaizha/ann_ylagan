<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | HIV Treatment Monitoring</title>
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
            color: #e5e7eb;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        /* Back Button */
        .back-btn {
            margin-bottom: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.6);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        /* Cards */
        .card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-body {
            padding: 30px;
        }

        .header-card {
            text-align: center;
            padding: 35px 30px;
        }

        .header-card h1 {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .header-card p {
            color: #9ca3af;
            font-size: 14px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        /* Profile Card Header */
        .profile-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .profile-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Profile Avatar */
        .profile-avatar {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar i {
            font-size: 5rem;
            color: #10b981;
            margin-bottom: 15px;
        }

        /* Profile Details */
        .profile-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 15px;
            background: rgba(31, 41, 55, 0.6);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .profile-item:hover {
            background: rgba(31, 41, 55, 0.8);
            border-color: rgba(16, 185, 129, 0.4);
            transform: translateX(5px);
        }

        .profile-item-label {
            font-weight: 600;
            color: #d1d5db;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-item-value {
            color: #9ca3af;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }

        /* Action Button */
        .action-center {
            text-align: center;
            margin-top: 30px;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #9ca3af;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header-card h1 {
                font-size: 1.5rem;
            }

            .profile-avatar i {
                font-size: 4rem;
            }

            .profile-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .btn-lg {
                width: 100%;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
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
    <div class="container">
        <!-- Back Button -->
        <div class="back-btn">
            <a href="/dashboard" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Page Header -->
        <div class="card">
            <div class="card-body header-card">
                <h1>My Profile</h1>
                <p>Manage your account information</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= $_SESSION['success_message'] ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= $_SESSION['error_message'] ?>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- Profile Information Card -->
        <div class="card">
            <div class="profile-header">
                <h5>Profile Information</h5>
            </div>
            <div class="card-body">
                <!-- Profile Avatar -->
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <div class="profile-item">
                        <span class="profile-item-label">
                            <i class="fas fa-user"></i> Username:
                        </span>
                        <span class="profile-item-value"><?= $user['username'] ?></span>
                    </div>
                    
                    <div class="profile-item">
                        <span class="profile-item-label">
                            <i class="fas fa-envelope"></i> Email:
                        </span>
                        <span class="profile-item-value"><?= $user['email'] ?></span>
                    </div>
                    
                    <div class="profile-item">
                        <span class="profile-item-label">
                            <i class="fas fa-user-tag"></i> Role:
                        </span>
                        <span class="badge"><?= ucfirst($user['role']) ?></span>
                    </div>
                    
                    <div class="profile-item">
                        <span class="profile-item-label">
                            <i class="fas fa-calendar-alt"></i> Member Since:
                        </span>
                        <span class="profile-item-value"><?= date('F j, Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="action-center">
                    <a href="/profile/edit" class="btn btn-primary btn-lg">
                        <i class="fas fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 HIV Treatment Monitoring System</p>
        </div>
    </div>
</body>
</html>