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
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background: #f5f7fa; color: #333; }
        
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn { 
            padding: 10px 20px; 
            background: #3498db; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-success { background: #27ae60; }
        .btn-danger { background: #e74c3c; }
        .btn-warning { background: #f39c12; }
        
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-admin { background: #e74c3c; color: white; }
        .badge-doctor { background: #3498db; color: white; }
        .badge-nurse { background: #9b59b6; color: white; }
        .badge-patient { background: #27ae60; color: white; }
        .badge-active { background: #27ae60; color: white; }
        .badge-inactive { background: #95a5a6; color: white; }
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .search-box {
            margin-bottom: 20px;
        }
        
        .search-form {
            display: flex;
            gap: 10px;
        }
        
        .search-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .pagination a {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #3498db;
        }
        
        .pagination a:hover {
            background: #3498db;
            color: white;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .user-info {
            display: flex;
            align-items: center;
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
                <a href="<?php echo site_url('dashboard'); ?>" class="btn" style="background: #95a5a6;">
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
                                                <br><span style="color: #3498db; font-size: 12px;">(You)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div><strong>Username:</strong> <?php echo htmlspecialchars($usr['username']); ?></div>
                                    <div><strong>Email:</strong> <?php echo htmlspecialchars($usr['email']); ?></div>
                                    <?php if(isset($usr['phone']) && !empty($usr['phone'])): ?>
                                        <div><strong>Phone:</strong> <?php echo htmlspecialchars($usr['phone']); ?></div>
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
                                            <?php echo $usr['is_active'] ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-active">Active</span>
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
                                            <span class="btn btn-danger btn-sm" style="opacity: 0.5; cursor: not-allowed;">
                                                <i class="fas fa-trash"></i> Delete
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    <i class="fas fa-users" style="font-size: 48px; color: #bdc3c7; margin-bottom: 10px;"></i>
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