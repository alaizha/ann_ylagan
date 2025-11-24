<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | HIV Treatment Monitoring</title>
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
            color: #ffffff;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
        }

        /* Back Buttons */
        .back-buttons {
            margin-bottom: 25px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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
            color: #ffffff;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.6);
        }

        .btn-outline-secondary {
            background: rgba(107, 114, 128, 0.2);
            border: 1px solid rgba(107, 114, 128, 0.4);
        }

        .btn-outline-secondary:hover {
            background: rgba(107, 114, 128, 0.3);
            border-color: rgba(107, 114, 128, 0.6);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            color: #ffffff;
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
            color: #ffffff;
            font-size: 14px;
        }

        /* Form Header */
        .form-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .form-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #ffffff;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 10px;
            background: rgba(31, 41, 55, 0.8);
            color: #ffffff !important;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #d1d5db;
            opacity: 1;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(31, 41, 55, 0.9);
            color: #ffffff !important;
        }

        .form-control::selection {
            background: #10b981;
            color: #ffffff;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        textarea:-webkit-autofill, 
        textarea:-webkit-autofill:hover, 
        textarea:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(31, 41, 55, 0.8) inset;
            -webkit-text-fill-color: #ffffff !important;
        }

        .form-text {
            display: block;
            text-align: center;
            margin-top: 8px;
            font-size: 12px;
            color: #ffffff;
            font-style: italic;
        }

        /* Action Buttons */
        .action-buttons {
            text-align: center;
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #ffffff;
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

            .back-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
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
        <!-- Back Buttons -->
        <div class="back-buttons">
            <a href="/profile" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
            <a href="/dashboard" class="btn btn-outline-secondary">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </div>

        <!-- Page Header -->
        <div class="card">
            <div class="card-body header-card">
                <h1>Edit Profile</h1>
                <p>Update your account information</p>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="card">
            <div class="form-header">
                <h5>Edit Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/profile/update">
                    <!-- Username Field -->
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="fas fa-user me-2"></i>Username
                        </label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= $user['username'] ?>" required placeholder="Enter your username">
                    </div>
                    
                    <!-- Email Field -->
                    <<div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address
                        </label>
                        <input type="email" class="form-control" id="email" name="email" 
                            value="<?= $user['email'] ?>" required placeholder="Enter your email" readonly>
                    </div>

                    
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>New Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Enter new password">
                        <div class="form-text">Leave blank to keep current password</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <a href="/profile" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2025 HIV Treatment Monitoring System</p>
        </div>
    </div>
</body>
</html>
