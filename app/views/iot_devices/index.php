<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IoT Devices | HIV Treatment Monitoring</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      background: #f8f9fa;
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
      padding: 20px;
    }
    .main-container {
      max-width: 1400px;
      margin: 0 auto;
    }
    .header-section {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 25px;
    }
    .back-button {
      background: #6c63ff;
      color: white;
      padding: 8px 16px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      display: inline-flex;
      align-items: center;
      transition: all 0.2s ease;
      border: none;
      font-size: 14px;
    }
    .back-button:hover {
      background: #5848d0;
      color: white;
      text-decoration: none;
    }
    .page-title {
      color: #2c3e50;
      font-weight: 700;
      font-size: 1.8rem;
      text-align: center;
      margin: 15px 0;
    }
    .card-custom {
      background: white;
      border-radius: 10px;
      border: 1px solid #e0e0e0;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      margin-bottom: 20px;
    }
    .card-header-custom {
      background: #f8f9fa;
      color: #2c3e50;
      padding: 15px 20px;
      border-bottom: 1px solid #e0e0e0;
    }
    .btn-primary-custom {
      background: #6c63ff;
      border: none;
      padding: 6px 12px;
      border-radius: 6px;
      font-weight: 500;
      font-size: 14px;
      transition: all 0.2s ease;
    }
    .btn-primary-custom:hover {
      background: #5848d0;
    }
    .table-custom {
      border-radius: 8px;
      overflow: hidden;
    }
    .table-custom thead {
      background: #4e73df;
      color: white;
    }
    .table-custom th {
      padding: 12px 10px;
      font-weight: 600;
      border: none;
      font-size: 14px;
    }
    .table-custom td {
      padding: 10px;
      vertical-align: middle;
      border-color: #f1f3ff;
      font-size: 14px;
    }
    .table-custom tbody tr:hover {
      background: #f8f9ff;
    }
    .search-section {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    .action-buttons {
      display: flex;
      gap: 5px;
      justify-content: center;
    }
    .btn-action {
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }
    .empty-state {
      text-align: center;
      padding: 30px 15px;
      color: #6c757d;
    }
    .empty-state i {
      font-size: 2.5rem;
      margin-bottom: 15px;
      opacity: 0.5;
    }
    .badge-custom {
      font-size: 11px;
      padding: 4px 8px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      font-weight: 600;
      margin-bottom: 5px;
      color: #555;
    }
    .stats-card {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
    }
    .stats-number {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 5px;
    }
    .stats-label {
      font-size: 0.9rem;
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <div class="main-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?= site_url('dashboard') ?>" class="back-button">
          <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
        <div class="text-end">
          <span class="badge bg-primary">IoT Management</span>
        </div>
      </div>
      
      <h1 class="page-title">
        <i class="fas fa-microchip me-2"></i>IoT Devices Management
      </h1>
    </div>

    <div class="row">
      <!-- Main Content -->
      <div class="col-12">
        <!-- Stats Card -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="stats-card">
              <div class="stats-number"><?= isset($connectedCount) ? $connectedCount : 0 ?></div>
              <div class="stats-label">Connected Devices</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card">
              <div class="stats-number"><?= isset($totalDevices) ? $totalDevices : 0 ?></div>
              <div class="stats-label">Total Devices</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card">
              <div class="stats-number"><?= isset($activePatients) ? $activePatients : 0 ?></div>
              <div class="stats-label">Active Patients</div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="stats-card">
              <div class="stats-number"><?= isset($coverage) ? $coverage : '0%' ?></div>
              <div class="stats-label">Coverage Rate</div>
            </div>
          </div>
        </div>

        <!-- Add Device Form (Admin Only) -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="card-custom">
          <div class="card-header-custom">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Add New Device</h5>
          </div>
          <div class="card-body">
            <form action="<?= site_url('iot-devices/store') ?>" method="POST" class="row g-3">
              <div class="col-md-3">
                <label class="form-label">Device ID</label>
                <input name="device_id" type="text" class="form-control" placeholder="e.g., D001" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Device Type</label>
                <select name="type" class="form-control" required>
                  <option value="">Select Type</option>
                  <option value="Heart Rate Monitor">Heart Rate Monitor</option>
                  <option value="Blood Pressure Sensor">Blood Pressure Sensor</option>
                  <option value="Temperature Sensor">Temperature Sensor</option>
                  <option value="Oxygen Monitor">Oxygen Monitor</option>
                  <option value="Activity Tracker">Activity Tracker</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Assigned Patient</label>
                <input name="patient" type="text" class="form-control" placeholder="Patient Name">
              </div>
              <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                  <option value="connected">Connected</option>
                  <option value="disconnected">Disconnected</option>
                  <option value="maintenance">Maintenance</option>
                </select>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary-custom">
                  <i class="fas fa-save me-1"></i> Register Device
                </button>
              </div>
            </form>
          </div>
        </div>
        <?php endif; ?>

        <!-- Devices Table -->
        <div class="card-custom">
          <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-list me-2"></i> Registered IoT Devices</h5>
              
              <!-- Search Bar -->
              <form method="GET" action="<?= site_url('iot-devices') ?>" class="d-flex" style="width: 300px;">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Search device or patient..."
                       value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
                <button class="btn btn-primary-custom">
                  <i class="fas fa-search me-1"></i> Search
                </button>
              </form>
            </div>
          </div>
          
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-custom table-hover">
                <thead>
                  <tr>
                    <th>Device ID</th>
                    <th>Type</th>
                    <th>Assigned Patient</th>
                    <th>Status</th>
                    <th>Last Update</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($devices)): ?>
                    <?php foreach($devices as $device): ?>
                    <tr>
                      <td>
                        <strong class="text-primary"><?= htmlspecialchars($device['device_id']) ?></strong>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-microchip me-2 text-muted"></i>
                          <?= htmlspecialchars($device['type']) ?>
                        </div>
                      </td>
                      <td>
                        <?php if(!empty($device['patient'])): ?>
                          <i class="fas fa-user me-2 text-muted"></i>
                          <?= htmlspecialchars($device['patient']) ?>
                        <?php else: ?>
                          <span class="text-muted">Not Assigned</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if(strtolower($device['status']) == 'connected'): ?>
                          <span class="badge bg-success badge-custom">
                            <i class="fas fa-wifi me-1"></i>Connected
                          </span>
                        <?php elseif(strtolower($device['status']) == 'maintenance'): ?>
                          <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-tools me-1"></i>Maintenance
                          </span>
                        <?php else: ?>
                          <span class="badge bg-danger badge-custom">
                            <i class="fas fa-plug me-1"></i>Disconnected
                          </span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <small class="text-muted">
                          <?= isset($device['last_update']) ? date('M d, Y h:i A', strtotime($device['last_update'])) : 'N/A' ?>
                        </small>
                      </td>
                      <td>
                        <div class="action-buttons">
                          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <a href="<?= site_url('iot-devices/edit/'.$device['device_id']) ?>" 
                               class="btn btn-warning btn-action" title="Edit">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= site_url('iot-devices/delete/'.$device['device_id']) ?>" 
                               class="btn btn-danger btn-action"
                               onclick="return confirm('Are you sure you want to remove this device?');"
                               title="Delete">
                              <i class="fas fa-trash"></i>
                            </a>
                          <?php else: ?>
                            <span class="text-muted small">View Only</span>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="empty-state">
                        <i class="fas fa-microchip"></i>
                        <h6 class="mt-2">No Devices Found</h6>
                        <p class="text-muted mb-2">No IoT devices are currently registered</p>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                          <a href="javascript:void(0)" onclick="document.querySelector('form').scrollIntoView()" class="btn btn-primary-custom">
                            <i class="fas fa-plus me-1"></i>Add First Device
                          </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>