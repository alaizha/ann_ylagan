<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments | HIV Treatment Monitoring</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    /* Same CSS as previous appointment page */
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
    .view-only {
      color: #6c757d;
      font-size: 12px;
      font-style: italic;
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
          <span class="badge bg-primary">
            <?= ($user_role ?? 'user') == 'admin' ? 'Admin View' : 'My Appointments' ?>
          </span>
        </div>
      </div>
      
      <h1 class="page-title">
        <i class="fas fa-calendar-alt me-2"></i>
        <?= ($user_role ?? 'user') == 'admin' ? 'Appointments Management' : 'My Appointments' ?>
      </h1>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="stats-card">
          <div class="stats-number">
            <?php 
            $todayCount = 0;
            $today = date('Y-m-d');
            if(!empty($appointments)) {
              foreach($appointments as $appt) {
                if($appt['appointment_date'] == $today) {
                  $todayCount++;
                }
              }
            }
            echo $todayCount;
            ?>
          </div>
          <div class="stats-label">Today's Appointments</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stats-card">
          <div class="stats-number"><?= !empty($appointments) ? count($appointments) : 0 ?></div>
          <div class="stats-label">Total Appointments</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stats-card">
          <div class="stats-number">
            <?php 
            $pendingCount = 0;
            if(!empty($appointments)) {
              foreach($appointments as $appt) {
                if($appt['status'] == 'Pending') {
                  $pendingCount++;
                }
              }
            }
            echo $pendingCount;
            ?>
          </div>
          <div class="stats-label">Pending</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stats-card">
          <div class="stats-number">
            <?php 
            $confirmedCount = 0;
            if(!empty($appointments)) {
              foreach($appointments as $appt) {
                if($appt['status'] == 'Confirmed') {
                  $confirmedCount++;
                }
              }
            }
            echo $confirmedCount;
            ?>
          </div>
          <div class="stats-label">Confirmed</div>
        </div>
      </div>
    </div>

    <!-- Appointments Table -->
    <div class="card-custom">
      <div class="card-header-custom">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-list me-2"></i> 
            <?= ($user_role ?? 'user') == 'admin' ? 'Appointment Records' : 'My Appointment History' ?>
          </h5>
          <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary-custom">
            <i class="fas fa-plus me-1"></i> 
            <?= ($user_role ?? 'user') == 'admin' ? 'Add Appointment' : 'Book Appointment' ?>
          </a>
        </div>
      </div>
      
      <div class="card-body">
        <!-- Search Section -->
        <div class="search-section">
          <form method="GET" action="<?= site_url('appointments') ?>" class="row align-items-center">
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-text bg-white">
                  <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control" placeholder="Search by patient name or purpose...">
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-primary-custom w-100">
                <i class="fas fa-search me-1"></i> Search
              </button>
            </div>
          </form>
        </div>

        <!-- Appointments Table -->
        <div class="table-responsive">
          <table class="table table-custom table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Patient Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($appointments)): ?>
                <?php foreach($appointments as $appt): ?>
                <tr>
                  <td>
                    <strong class="text-primary">#<?= $appt['id'] ?></strong>
                  </td>
                  <td>
                    <div class="d-flex align-items-center">
                      <i class="fas fa-user-circle me-2 text-muted"></i>
                      <?php 
                      // ✅ Direct access to patient name from joined query
                      if(!empty($appt['first_name']) && !empty($appt['last_name'])) {
                        echo htmlspecialchars($appt['first_name'] . ' ' . $appt['last_name']);
                      } else {
                        echo '<span class="text-muted">Unknown Patient</span>';
                      }
                      ?>
                    </div>
                  </td>
                  <td>
                    <strong><?= date('M d, Y', strtotime($appt['appointment_date'])) ?></strong>
                  </td>
                  <td>
                    <span class="text-muted"><?= date('h:i A', strtotime($appt['appointment_time'])) ?></span>
                  </td>
                  <td>
                    <small class="text-muted"><?= $appt['purpose'] ?></small>
                  </td>
                  <td>
                    <span class="badge badge-custom bg-<?= 
                      $appt['status'] == 'Confirmed' ? 'success' : 
                      ($appt['status'] == 'Pending' ? 'warning text-dark' : 
                      ($appt['status'] == 'Completed' ? 'info' : 'danger'))
                    ?>">
                      <i class="fas fa-<?= 
                        $appt['status'] == 'Confirmed' ? 'check-circle' : 
                        ($appt['status'] == 'Pending' ? 'clock' : 
                        ($appt['status'] == 'Completed' ? 'check' : 'exclamation-triangle'))
                      ?> me-1"></i>
                      <?= $appt['status'] ?>
                    </span>
                  </td>
                  <td>
                    <div class="action-buttons">
                      <?php if(($user_role ?? 'user') == 'admin'): ?>
                        <!-- ADMIN: Can Edit and Delete -->
                        <a href="<?= site_url('appointments/edit/'.$appt['id']) ?>" class="btn btn-warning btn-action" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('appointments/delete/'.$appt['id']) ?>" class="btn btn-danger btn-action" 
                           onclick="return confirm('Are you sure you want to delete this appointment?')" title="Delete">
                          <i class="fas fa-trash"></i>
                        </a>
                      <?php else: ?>
                        <!-- USER: View Only -->
                        <span class="view-only">View Only</span>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <h6 class="mt-2">No Appointments Found</h6>
                    <p class="text-muted mb-2">Start by scheduling your first appointment</p>
                    <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary-custom">
                      <i class="fas fa-plus me-1"></i>
                      <?= ($user_role ?? 'user') == 'admin' ? 'Schedule Appointment' : 'Book Appointment' ?>
                    </a>
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>