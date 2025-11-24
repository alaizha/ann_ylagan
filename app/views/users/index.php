<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - HIV Treatment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            max-width: 1400px; 
            margin: 0 auto; 
        }
        
        /* Header */
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            border: 1px solid rgba(16, 185, 129, 0.2);
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header h1 {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header h1 i {
            color: #10b981;
            -webkit-text-fill-color: #10b981;
        }
        
        /* Buttons */
        .btn { 
            padding: 10px 20px; 
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white; 
            text-decoration: none; 
            border-radius: 10px; 
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }
        
        .btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }
        
        .btn-success { 
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
        
        .btn-danger { 
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.6);
        }
        
        .btn-warning { 
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 6px 20px rgba(245, 158, 11, 0.6);
        }
        
        /* Card */
        .card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            overflow: hidden;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .card-header {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
            background: rgba(16, 185, 129, 0.05);
        }

        .card-header h3 {
            color: #10b981;
            font-weight: 600;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 0;
        }
        
        /* Table */
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: transparent !important;
        }
        
        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            background: transparent !important;
        }
        
        .table th {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: white;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .table th:first-child {
            border-top-left-radius: 10px;
        }

        .table th:last-child {
            border-top-right-radius: 10px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(16, 185, 129, 0.1) !important;
            transform: scale(1.005);
            border-left: 3px solid #10b981;
        }

        .table td {
            color: #d1d5db;
            font-size: 14px;
        }
        
        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .badge-admin { 
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }
        
        .badge-doctor { 
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.4);
        }
        
        .badge-nurse { 
            background: rgba(168, 85, 247, 0.2);
            color: #c084fc;
            border: 1px solid rgba(168, 85, 247, 0.4);
        }
        
        .badge-patient { 
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        
        .badge-active { 
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        
        .badge-inactive { 
            background: rgba(107, 114, 128, 0.2);
            color: #9ca3af;
            border: 1px solid rgba(107, 114, 128, 0.4);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 6px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        /* Search Box */
        .search-box {
            margin-bottom: 25px;
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 15px;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 10px;
            background: rgba(31, 41, 55, 0.6);
            color: #e5e7eb;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(31, 41, 55, 0.8);
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            outline: none;
        }

        .search-input::placeholder {
            color: #6b7280;
        }
        
        /* Pagination */
        .pagination {
            margin-top: 25px;
            padding: 20px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        
        .pagination a {
            padding: 10px 16px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 8px;
            text-decoration: none;
            color: #10b981;
            background: rgba(31, 41, 55, 0.6);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .pagination a:hover {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            margin-bottom: 25px;
            border-radius: 10px;
            display: flex;
            align-items: center;
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

        /* User Avatar */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 12px;
            font-size: 14px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info strong {
            color: #e5e7eb;
            font-size: 14px;
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

        .empty-state p {
            font-size: 1.1rem;
            color: #d1d5db;
            margin: 15px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .search-form {
                flex-direction: column;
            }

            .search-input {
                width: 100%;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
            }

            .action-buttons {
                flex-direction: column;
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

        /* Disabled button style */
        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed !important;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Flash Messages -->
        <?php if(isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-users-cog"></i> User Account Management</h1>
            <div>
                <a href="<?php echo site_url('dashboard'); ?>" class="btn">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Search Box -->
        <div class="search-box">
            <form method="GET" action="<?php echo site_url('users'); ?>" class="search-form">
                <input type="text" name="q" class="search-input" placeholder="Search users by ID, username, email, or role..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                <button type="submit" class="btn">
                    <i class="fas fa-search"></i> Search
                </button>
                <?php if(isset($_GET['q']) && !empty($_GET['q'])): ?>
                    <a href="<?php echo site_url('users'); ?>" class="btn btn-danger">
                        <i class="fas fa-times"></i> Clear
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> System Users (<?php echo count($users); ?> users found)</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Contact Info</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($users)): ?>
                            <?php foreach($users as $usr): ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <?php 
                                                $firstChar = isset($usr['first_name']) ? substr($usr['first_name'], 0, 1) : substr($usr['username'], 0, 1);
                                                $secondChar = isset($usr['last_name']) ? substr($usr['last_name'], 0, 1) : '';
                                                echo strtoupper($firstChar . $secondChar);
                                            ?>
                                        </div>
                                        <div>
                                            <strong>
                                                <?php 
                                                    if(isset($usr['first_name']) && isset($usr['last_name'])) {
                                                        echo htmlspecialchars($usr['first_name'] . ' ' . $usr['last_name']);
                                                    } else {
                                                        echo htmlspecialchars($usr['username']);
                                                    }
                                                ?>
                                            </strong>
                                            <?php if(isset($logged_in_user) && $logged_in_user['id'] == $usr['id']): ?>
                                                <br><span style="color: #10b981; font-size: 12px; font-weight: 600;">(You)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="margin-bottom: 5px;"><strong style="color: #10b981;">Username:</strong> <?php echo htmlspecialchars($usr['username']); ?></div>
                                    <div style="margin-bottom: 5px;"><strong style="color: #10b981;">Email:</strong> <?php echo htmlspecialchars($usr['email']); ?></div>
                                    <?php if(isset($usr['phone']) && !empty($usr['phone'])): ?>
                                        <div><strong style="color: #10b981;">Phone:</strong> <?php echo htmlspecialchars($usr['phone']); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $usr['role']; ?>">
                                        <i class="fas fa-<?php 
                                            switch($usr['role']) {
                                                case 'admin': echo 'crown'; break;
                                                case 'doctor': echo 'user-md'; break;
                                                case 'nurse': echo 'user-nurse'; break;
                                                default: echo 'user';
                                            }
                                        ?>"></i>
                                        <?php echo ucfirst($usr['role']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if(isset($usr['is_active'])): ?>
                                        <span class="badge <?php echo $usr['is_active'] ? 'badge-active' : 'badge-inactive'; ?>">
                                            <i class="fas fa-<?php echo $usr['is_active'] ? 'check-circle' : 'times-circle'; ?>"></i>
                                            <?php echo $usr['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-active">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($usr['created_at'])); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo site_url('users/edit/' . $usr['id']); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <?php if(isset($logged_in_user) && $logged_in_user['id'] != $usr['id']): ?>
                                            <a href="<?php echo site_url('users/delete/' . $usr['id']); ?>" class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        <?php else: ?>
                                            <span class="btn btn-danger btn-sm btn-disabled">
                                                <i class="fas fa-trash"></i> Delete
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <p>No users found</p>
                                    <a href="<?php echo site_url('users/create'); ?>" class="btn btn-success">
                                        <i class="fas fa-user-plus"></i> Add First User
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if(isset($page) && !empty($page)): ?>
                    <div class="pagination">
                        <?php echo $page; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Simple confirmation for delete actions
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('a[href*="/users/delete/"]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>