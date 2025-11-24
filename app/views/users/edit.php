<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit User - HIV Treatment System</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { 
    background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #e5e7eb; min-height:100vh; padding:20px; 
}
.container { max-width:900px; margin:0 auto; }

/* Header */
.header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    padding:25px 30px; border-radius:15px; box-shadow:0 8px 32px rgba(0,0,0,0.3);
    border:1px solid rgba(16,185,129,0.2); flex-wrap:wrap; gap:15px; 
}
.header h1 { 
    background:linear-gradient(135deg,#10b981 0%,#34d399 100%);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    font-size:1.8rem; font-weight:700; display:flex; align-items:center; gap:10px; 
}
.header h1 i { color:#10b981; -webkit-text-fill-color:#10b981; }

/* Buttons */
.btn { padding:10px 20px; background:linear-gradient(135deg,#10b981 0%,#059669 100%);
    color:white; text-decoration:none; border-radius:10px; border:none; cursor:pointer;
    display:inline-flex; align-items:center; gap:8px; font-weight:600; font-size:14px;
    transition:all 0.3s ease; box-shadow:0 4px 15px rgba(16,185,129,0.4);
}
.btn:hover { background:linear-gradient(135deg,#059669 0%,#047857 100%); transform:translateY(-2px); }
.btn-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
.btn-cancel { background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); }
.btn-cancel:hover { background:linear-gradient(135deg,#4b5563 0%,#374151 100%); }

/* Card */
.card { background:linear-gradient(135deg,#1f2937 0%,#111827 100%);
    border-radius:15px; box-shadow:0 8px 32px rgba(0,0,0,0.3); overflow:hidden; 
    border:1px solid rgba(16,185,129,0.2);
}
.card-header { padding:20px 25px; border-bottom:1px solid rgba(16,185,129,0.2); background:rgba(16,185,129,0.05);}
.card-header h3 { color:#10b981; font-weight:600; font-size:1.2rem; display:flex; align-items:center; gap:10px;}
.card-body { padding:30px; }

/* Form */
.form-group { margin-bottom:20px; }
.form-label { display:block; margin-bottom:8px; font-weight:500; color:#d1d5db; font-size:14px; }
.form-control { width:100%; padding:12px 15px; border:2px solid rgba(16,185,129,0.3); border-radius:10px;
    font-size:14px; background:rgba(31,41,55,0.6); color:#e5e7eb; transition:all 0.3s ease; 
}
.form-control:focus { outline:none; border-color:#10b981; background:rgba(31,41,55,0.8); }
.form-control[readonly] { background: rgba(31,41,55,0.3); cursor:not-allowed; }
.form-row { display:flex; gap:15px; }
.form-col { flex:1; }

.form-actions { display:flex; justify-content:space-between; margin-top:30px; padding-top:20px; border-top:1px solid rgba(16,185,129,0.2); }
@media(max-width:768px) { .form-row { flex-direction:column; } .form-actions{ flex-direction:column; gap:10px; } .btn{ width:100%; justify-content:center; } }
</style>
</head>
<body>
<div class="container">

    <!-- Flash Messages -->
    <?php if(isset($_SESSION['error_message'])): ?>
        <div style="background:rgba(239,68,68,0.2); color:#f87171; padding:10px; border-radius:8px; margin-bottom:15px;">
            <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="header">
        <h1><i class="fas fa-user-edit"></i> Edit User</h1>
        <div>
            <a href="<?= site_url('users'); ?>" class="btn"><i class="fas fa-arrow-left"></i> Back to Users</a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-user-edit"></i> User Details</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= site_url('users/update/' . $user['id']); ?>">

                <div class="form-group">
                    <label class="form-label" for="id">ID</label>
                    <input type="text" class="form-control" id="id" name="id" value="<?= htmlspecialchars($user['id']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label required" for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role">Role</label>
                    <input type="text" class="form-control" id="role" name="role" value="<?= htmlspecialchars($user['role']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" for="created_at">Created At</label>
                    <input type="text" class="form-control" id="created_at" name="created_at" value="<?= htmlspecialchars($user['created_at']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label class="form-label" for="verified_at">Verified At</label>
                    <input type="text" class="form-control" id="verified_at" name="verified_at" value="<?= htmlspecialchars($user['verified_at']); ?>" readonly>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url('users'); ?>" class="btn btn-cancel"><i class="fas fa-times"></i> Cancel</a>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Username</button>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>
