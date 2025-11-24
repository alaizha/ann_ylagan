<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIV Treatment System Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ======= CSS RESET & GLOBAL STYLES ======= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
            color: #e5e7eb;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* ======= DASHBOARD LAYOUT ======= */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* ======= SIDEBAR ======= */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            border-right: 1px solid rgba(16, 185, 129, 0.2);
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.3);
            margin-bottom: 20px;
        }

        .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-header h3 i {
            color: #10b981;
            -webkit-text-fill-color: #10b981;
        }

        .sidebar a {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            color: #d1d5db;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .sidebar a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-left: 4px solid #10b981;
        }

        .sidebar .logout {
            margin-top: auto;
            border-top: 1px solid rgba(16, 185, 129, 0.3);
            padding-top: 15px;
        }

        .sidebar .logout:hover {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border-left-color: #ef4444;
        }

        /* ======= MAIN CONTENT ======= */
        .main-content {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 25px;
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .page-header h1 {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .page-header p {
            color: #9ca3af;
            margin-top: 5px;
        }

        /* ======= STATS GRID ======= */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
        }

        .stat-card.patients { border-left-color: #10b981; }
        .stat-card.devices { border-left-color: #3b82f6; }
        .stat-card.transactions { border-left-color: #8b5cf6; }
        .stat-card.appointments { border-left-color: #f59e0b; }
        .stat-card.profile { border-left-color: #10b981; }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
        }

        .stat-icon.patients { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-icon.devices { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .stat-icon.transactions { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }
        .stat-icon.appointments { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .stat-icon.profile { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }

        .stat-info h2 {
            margin: 0;
            font-size: 1.9rem;
            font-weight: 700;
            color: #e5e7eb;
        }

        .stat-info p {
            margin: 5px 0 0;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .trend {
            font-weight: 600;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .trend.positive { color: #10b981; }
        .trend.warning { color: #f59e0b; }

        /* ======= MONITORING SECTION ======= */
        .monitoring-section {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .section-header h3 {
            color: #e5e7eb;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .status-live {
            color: #10b981;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-live::before {
            content: "";
            width: 8px;
            height: 8px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            animation: pulse 1.5s infinite;
            box-shadow: 0 0 10px #10b981;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .patient-monitor {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .patient-monitor:last-child {
            border-bottom: none;
        }

        .patient-info h4 {
            margin: 0;
            font-size: 1.05rem;
            color: #e5e7eb;
        }

        .patient-info p {
            margin: 3px 0 0;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge.stable { 
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        .status-badge.warning { 
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }
        .status-badge.critical { 
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .view-details {
            font-size: 0.85rem;
            color: #10b981;
            font-weight: 500;
            transition: color 0.2s;
        }

        .view-details:hover {
            color: #34d399;
            text-decoration: underline;
        }

        .view-all {
            display: inline-block;
            margin-top: 15px;
            font-size: 0.9rem;
            color: #10b981;
            font-weight: 500;
        }

        .view-all:hover {
            color: #34d399;
        }

        /* ======= BOTTOM GRID ======= */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        /* ======= BLOCKCHAIN PANEL ======= */
        .blockchain-panel {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .blockchain-panel h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.3rem;
            font-weight: 600;
            color: #e5e7eb;
        }

        .transaction-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        .transaction-info p {
            margin: 0;
        }

        .tx-id {
            font-weight: 600;
            color: #10b981;
        }

        .patient-name {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-top: 3px !important;
        }

        .transaction-info small {
            color: #6b7280;
            font-size: 0.8rem;
        }

        .transaction-status {
            text-align: right;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 12px;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 5px;
        }

        .badge.completed { 
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
        }
        .badge.pending { 
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }
        .badge.failed { 
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .amount {
            font-weight: 700;
            color: #10b981;
            margin: 0;
        }

        /* ======= APPOINTMENTS SECTION ======= */
        .appointments-section {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .appointments-table th {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            padding: 14px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid rgba(16, 185, 129, 0.3);
        }

        .appointments-table td {
            padding: 14px 12px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
            color: #d1d5db;
        }

        .appointments-table tr:hover {
            background: rgba(16, 185, 129, 0.05);
        }

        /* ======= BUTTONS ======= */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn i {
            font-size: 0.85rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-warning {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .btn-warning:hover {
            background: rgba(251, 191, 36, 0.3);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.3);
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 182, 212, 0.3);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 182, 212, 0.4);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        /* ======= USER DASHBOARD STYLES ======= */
        .user-welcome {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }

        .user-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .user-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .feature-card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #10b981;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #e5e7eb;
        }

        .feature-card p {
            color: #9ca3af;
        }

        /* ======= ANALYTICS SECTION ======= */
        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .analytics-item {
            background: rgba(16, 185, 129, 0.05);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .analytics-item > div:first-child {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .analytics-item > div:last-child {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        /* ======= UTILITY CLASSES ======= */
        .text-center { text-align: center; }
        .text-muted { color: #9ca3af; }
        .py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }

        /* ======= RESPONSIVE DESIGN ======= */
        @media screen and (max-width: 1024px) {
            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media screen and (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .appointments-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-heartbeat"></i> HIV Treatment System</h3>
            </div>
            <a href="<?= site_url('dashboard') ?>" class="active"><i class="fas fa-th-large"></i> Dashboard</a>
            
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <!-- ADMIN ONLY LINKS -->
                <a href="<?= site_url('patients') ?>"><i class="fas fa-user-injured"></i> Patients</a>
                <a href="<?= site_url('iot-devices') ?>"><i class="fas fa-microchip"></i> IoT Devices</a>
                <a href="<?= site_url('blockchain') ?>"><i class="fas fa-link"></i> Blockchain Billing</a>
                <a href="<?= site_url('users') ?>"><i class="fas fa-users-cog"></i> User Management</a>
            <?php else: ?>
                <!-- USER ONLY LINKS -->
                <a href="<?= site_url('profile') ?>"><i class="fas fa-user"></i> My Profile</a>
            <?php endif; ?>
            
            <!-- COMMON LINKS (Both Admin and User) -->
            <a href="<?= site_url('appointments') ?>"><i class="fas fa-calendar-check"></i> Appointments</a>
            <a href="<?= site_url('dashboard/logout') ?>" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        
        <div class="main-content">
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <!-- ==================== -->
                <!-- ADMIN DASHBOARD -->
                <!-- ==================== -->
                <div class="page-header">
                    <h1>Admin Dashboard Overview</h1>
                    <p>Monitor patient status, appointments, and system metrics</p>
                </div>
                
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card patients">
                        <div class="stat-icon patients">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="stat-info">
                            <h2><?= isset($active_patients) ? $active_patients : 15 ?></h2>
                            <p>Active Patients</p>
                            <span class="trend positive">+12% from last month</span>
                        </div>
                    </div>
                    <div class="stat-card devices">
                        <div class="stat-icon devices">
                            <i class="fas fa-microchip"></i>
                        </div>
                        <div class="stat-info">
                            <h2><?= isset($connected_devices) ? $connected_devices : 8 ?></h2>
                            <p>Connected IoT Devices</p>
                            <span class="trend positive">88.5% operational</span>
                        </div>
                    </div>
                    <div class="stat-card transactions">
                        <div class="stat-icon transactions">
                            <i class="fas fa-link"></i>
                        </div>
                        <div class="stat-info">
                            <h2><?= isset($total_transactions) ? $total_transactions : 156 ?></h2>
                            <p>Blockchain Transactions</p>
                            <span class="trend positive">All secured</span>
                        </div>
                    </div>
                </div>

                <!-- Analytics Overview Section - ADMIN ONLY -->
                <div class="monitoring-section">
                    <div class="section-header">
                        <h3>System Analytics Overview</h3>
                        <span class="status-live">Live Data</span>
                    </div>

                    <!-- Analytics Metrics -->
                    <div class="analytics-grid">
                        <div class="analytics-item">
                            <div style="color: #10b981;"><?= $analytics_data['viral_load_suppression'] ?? '87%' ?></div>
                            <div>Viral Load Suppression</div>
                        </div>
                        <div class="analytics-item">
                            <div style="color: #3b82f6;"><?= $analytics_data['art_adherence_rate'] ?? '92%' ?></div>
                            <div>ART Adherence Rate</div>
                        </div>
                        <div class="analytics-item">
                            <div style="color: #8b5cf6;"><?= $analytics_data['new_patients_month'] ?? 15 ?></div>
                            <div>New Patients This Month</div>
                        </div>
                        <div class="analytics-item">
                            <div style="color: #f59e0b;"><?= $analytics_data['avg_appointments_day'] ?? 8 ?></div>
                            <div>Avg Appointments/Day</div>
                        </div>
                    </div>

                    <!-- Additional Analytics Data -->
                    <div style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2); padding: 20px; border-radius: 8px; margin-top: 15px;">
                        <h4 style="margin-bottom: 15px; color: #e5e7eb;">Monthly Performance</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #10b981;">98%</div>
                                <div style="font-size: 0.8rem; color: #9ca3af;">System Uptime</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #3b82f6;">24h</div>
                                <div style="font-size: 0.8rem; color: #9ca3af;">Avg Response Time</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #8b5cf6;">99.2%</div>
                                <div style="font-size: 0.8rem; color: #9ca3af;">Data Accuracy</div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1.5rem; font-weight: bold; color: #f59e0b;">156</div>
                                <div style="font-size: 0.8rem; color: #9ca3af;">Total Processes</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="/dashboard/patients" class="view-all">View Detailed Analytics</a>
                    </div>
                </div>

                <!-- Bottom Grid -->
                <div class="bottom-grid">
                    <!-- Blockchain Billing -->
                    <div class="blockchain-panel">
                        <h3>Recent Blockchain Transactions</h3>
                        <?php if (!empty($recent_transactions)): ?>
                            <?php foreach($recent_transactions as $transaction): ?>
                            <div class="transaction-item">
                                <div class="transaction-info">
                                    <p class="tx-id">Tx/No: <?= $transaction['tx_no'] ?? 'N/A' ?></p>
                                    <p class="patient-name"><?= $transaction['patient_name'] ?? 'Unknown' ?></p>
                                    <small>
                                        <?= isset($transaction['date']) ? $transaction['date'] : (isset($transaction['created_at']) ? date('M d, Y', strtotime($transaction['created_at'])) : 'N/A') ?>
                                    </small>

                                </div>
                                <div class="transaction-status">
                                    <span class="badge <?= strtolower($transaction['status'] ?? 'completed') ?>">
                                        <?= $transaction['status'] ?? 'Completed' ?>
                                    </span>
                                    <p class="amount">₱<?= number_format($transaction['amount'] ?? 0, 0) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <!-- Fallback dummy transactions -->
                            <div class="transaction-item">
                                <div class="transaction-info">
                                    <p class="tx-id">Tx/No: TX 9647</p>
                                    <p class="patient-name">Juan Dela Cruz</p>
                                    <small>Oct 18, 2023</small>
                                </div>
                                <div class="transaction-status">
                                    <span class="badge completed">Completed</span>
                                    <p class="amount">₱2,500</p>
                                </div>
                            </div>
                            <div class="transaction-item">
                                <div class="transaction-info">
                                    <p class="tx-id">Tx/No: TX 9633</p>
                                    <p class="patient-name">Maria Santos</p>
                                    <small>Oct 18, 2023</small>
                                </div>
                                <div class="transaction-status">
                                    <span class="badge completed">Completed</span>
                                    <p class="amount">₱5,200</p>
                                </div>
                            </div>
                        <?php endif; ?>
                        <a href="index.php/dashboard/blockchain" class="view-all">View All Transactions</a>
                    </div>

                    <!-- Appointments Section -->
                    <div class="appointments-section">
                        <div class="section-header">
                            <h3>Today's Appointments</h3>
                        </div>

                        <?php 
                        // Get today's appointments
                        $today = date('Y-m-d');
                        $todays_appointments = [];
                        if(!empty($appointments)) {
                            foreach($appointments as $appt) {
                                if($appt['appointment_date'] == $today) {
                                    $todays_appointments[] = $appt;
                                }
                            }
                        }
                        ?>
                        
                        <?php if(!empty($todays_appointments)): ?>
                            <div class="table-responsive">
                                <table class="appointments-table">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Time</th>
                                            <th>Purpose</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($todays_appointments as $appt): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                $patient_name = 'Unknown Patient';
                                                foreach($patients as $p) {
                                                    if($p['id'] == $appt['patient_id']) {
                                                        $patient_name = $p['first_name'] . ' ' . $p['last_name'];
                                                        break;
                                                    }
                                                }
                                                echo $patient_name;
                                                ?>
                                            </td>
                                            <td><?= date('h:i A', strtotime($appt['appointment_time'])) ?></td>
                                            <td><?= $appt['purpose'] ?></td>
                                            <td>
                                                <span class="badge" style="background: <?= 
                                                    $appt['status'] == 'Confirmed' ? 'rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4)' : 
                                                    ($appt['status'] == 'Pending' ? 'rgba(251, 191, 36, 0.2); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.4)' : 'rgba(107, 114, 128, 0.2); color: #9ca3af; border: 1px solid rgba(107, 114, 128, 0.4)')
                                                ?>;">
                                                    <?= $appt['status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= site_url('appointments/edit/'.$appt['id']) ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= site_url('appointments/delete/'.$appt['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete appointment?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-2" style="color: rgba(16, 185, 129, 0.3);"></i>
                                <p>No appointments for today</p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="text-center mt-3">
                            <a href="<?= site_url('appointments') ?>" class="view-all">View All Appointments</a>
                        </div>
                    </div>
                </div>

            <?php else: ?>
                <!-- ==================== -->
                <!-- USER DASHBOARD -->
                <!-- ==================== -->
                <div class="user-welcome">
                    <h1>Welcome, <?= $_SESSION['username'] ?? 'User' ?>!</h1>
                    <p>Your Personal Health Dashboard</p>
                </div>

                <!-- User Stats -->
                <div class="user-stats">
                    <div class="stat-card appointments">
                        <div class="stat-icon appointments">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-info">
                            <h2>3</h2>
                            <p>Upcoming Appointments</p>
                            <span class="trend positive">Next: Tomorrow</span>
                        </div>
                    </div>
                    <div class="stat-card profile">
                        <div class="stat-icon profile">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="stat-info">
                            <h2>1</h2>
                            <p>Active Profile</p>
                            <span class="trend positive">Complete</span>
                        </div>
                    </div>
                </div>

                <!-- User Features -->
                <div class="user-features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h3>Schedule Appointment</h3>
                        <p>Book your next medical consultation</p>
                        <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary mt-3">
                            <i class="fas fa-plus"></i> Book Now
                        </a>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <h3>Update Profile</h3>
                        <p>Keep your personal information current</p>
                        <a href="<?= site_url('profile') ?>" class="btn btn-primary mt-3">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3>Appointment History</h3>
                        <p>View your past and upcoming appointments</p>
                        <a href="<?= site_url('appointments') ?>" class="btn btn-primary mt-3">
                            <i class="fas fa-list"></i> View History
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="monitoring-section mt-4">
                    <div class="section-header">
                        <h3>Quick Actions</h3>
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                        <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary" style="text-align: center; padding: 15px;">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i><br>
                            New Appointment
                        </a>
                        <a href="<?= site_url('profile') ?>" class="btn btn-success" style="text-align: center; padding: 15px;">
                            <i class="fas fa-user-edit fa-2x mb-2"></i><br>
                            Update Profile
                        </a>
                        <a href="<?= site_url('appointments') ?>" class="btn btn-info" style="text-align: center; padding: 15px;">
                            <i class="fas fa-history fa-2x mb-2"></i><br>
                            View Appointments
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>