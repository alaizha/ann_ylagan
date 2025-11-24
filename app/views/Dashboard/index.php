<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIV Treatment System Dashboard</title>

    <!-- Updated Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ======= CSS RESET & GLOBAL STYLES ======= */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f5f7fa; color: #333; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }

        /* Dashboard Layout */
        .dashboard-container { display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 250px; background: linear-gradient(180deg, #1f2937 0%, #111827 100%); color: #fff; flex-shrink: 0; padding: 20px 0; box-shadow: 2px 0 10px rgba(0,0,0,0.1); display: flex; flex-direction: column; }
        .sidebar-header { padding: 0 20px 20px; border-bottom: 1px solid #374151; margin-bottom: 20px; }
        .sidebar-header h3 { font-size: 1.3rem; font-weight: 600; }
        .sidebar a { padding: 12px 20px; display: flex; align-items: center; color: #d1d5db; transition: 0.3s; font-size: 0.95rem; }
        .sidebar a i { margin-right: 10px; width: 20px; text-align: center; }
        .sidebar a:hover, .sidebar a.active { background-color: #374151; color: #fff; border-left: 4px solid #3b82f6; }
        .sidebar .logout { margin-top: auto; border-top: 1px solid #374151; padding-top: 15px; }

        /* Main Content */
        .main-content { flex: 1; padding: 25px; overflow-y: auto; }
        .page-header h1 { font-size: 1.8rem; font-weight: 600; color: #1f2937; }

        /* Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; }
        .stat-card { background: #fff; border-radius: 12px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); transition: 0.3s; border-left: 4px solid transparent; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px rgba(0,0,0,0.1); }

        /* ICON COLORS */
        .stat-card.patients { border-left-color: #10b981; }
        .stat-card.devices { border-left-color: #3b82f6; }
        .stat-card.transactions { border-left-color: #8b5cf6; }
        .stat-icon { width: 55px; height: 55px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: white; }
        .stat-icon.patients { background: #10b981; }
        .stat-icon.devices { background: #3b82f6; }
        .stat-icon.transactions { background: #8b5cf6; }
        .trend.positive { color: #10b981; font-weight: 600; }

        /* Responsiveness */
        @media (max-width: 768px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-heart-pulse"></i> HIV Treatment</h3>
        </div>

        <a href="<?= base_url('dashboard') ?>" class="active">
            <i class="fa-solid fa-table-cells-large"></i> Dashboard
        </a>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="<?= base_url('patients') ?>"><i class="fa-solid fa-user-injured"></i> Patients</a>
            <a href="<?= base_url('iot-devices') ?>"><i class="fa-solid fa-microchip"></i> IoT Devices</a>
            <a href="<?= base_url('blockchain') ?>"><i class="fa-solid fa-link"></i> Blockchain Billing</a>
            <a href="<?= base_url('users') ?>"><i class="fa-solid fa-users-gear"></i> User Management</a>
            <a href="<?= base_url('medical-records') ?>"><i class="fa-solid fa-file-medical"></i> Medical Records</a>
        <?php else: ?>
            <a href="<?= base_url('profile') ?>"><i class="fa-solid fa-user"></i> My Profile</a>
        <?php endif; ?>

        <a href="<?= base_url('appointments') ?>"><i class="fa-solid fa-calendar-check"></i> Appointments</a>
        <a href="<?= base_url('dashboard/logout') ?>" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <div class="page-header">
                <h1>Admin Dashboard Overview</h1>
                <p>Monitor patient status, appointments, and system metrics</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card patients">
                    <div class="stat-icon patients"><i class="fa-solid fa-user-injured"></i></div>
                    <div class="stat-info">
                        <h2><?= $active_patients ?? 15 ?></h2>
                        <p>Active Patients</p>
                        <span class="trend positive">+12% vs last month</span>
                    </div>
                </div>

                <div class="stat-card devices">
                    <div class="stat-icon devices"><i class="fa-solid fa-microchip"></i></div>
                    <div class="stat-info">
                        <h2><?= $connected_devices ?? 8 ?></h2>
                        <p>Connected IoT Devices</p>
                        <span class="trend positive">88.5% operational</span>
                    </div>
                </div>

                <div class="stat-card transactions">
                    <div class="stat-icon transactions"><i class="fa-solid fa-link"></i></div>
                    <div class="stat-info">
                        <h2><?= $total_transactions ?? 156 ?></h2>
                        <p>Blockchain Transactions</p>
                        <span class="trend positive">All secured</span>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="user-welcome" style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;border-radius:12px;padding:30px;text-align:center;">
                <h1>Welcome, <?= $_SESSION['username'] ?? 'User' ?>!</h1>
                <p>Your Personal Health Dashboard</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card appointments">
                    <div class="stat-icon appointments" style="background:#f59e0b;"><i class="fa-solid fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <h2>3</h2>
                        <p>Upcoming Appointments</p>
                        <span class="trend positive">Next: Tomorrow</span>
                    </div>
                </div>

                <div class="stat-card profile">
                    <div class="stat-icon profile" style="background:#8b5cf6;"><i class="fa-solid fa-user"></i></div>
                    <div class="stat-info">
                        <h2>1</h2>
                        <p>Active Profile</p>
                        <span class="trend positive">Complete</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => new bootstrap.Alert(alert).close());
        }, 5000);
    });
</script>

</body>
</html>
