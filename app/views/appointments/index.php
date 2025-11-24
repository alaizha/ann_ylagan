<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments | HIV Treatment Monitoring</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
      padding: 20px;
      color: #e5e7eb;
      min-height: 100vh;
    }

    .main-container {
      max-width: 1400px;
      margin: 0 auto;
    }

    /* Header Section */
    .header-section {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 15px;
      padding: 25px 30px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      margin-bottom: 25px;
    }

    .back-button {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      padding: 10px 20px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      border: none;
      font-size: 14px;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .back-button:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
      color: white;
    }

    .page-title {
      text-align: center;
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-size: 2rem;
      font-weight: 700;
      margin: 15px 0 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }

    .page-title i {
      color: #10b981;
      -webkit-text-fill-color: #10b981;
    }

    /* Stats Cards */
    .stats-card {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }

    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
    }

    .stats-number {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 8px;
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .stats-label {
      font-size: 0.9rem;
      color: #9ca3af;
    }

    /* Card Custom */
    .card-custom {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
      margin-bottom: 25px;
      overflow: hidden;
    }

    .card-header-custom {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      padding: 18px 25px;
      border-bottom: 2px solid rgba(16, 185, 129, 0.3);
    }

    .card-header-custom h5 {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .card-body {
      padding: 25px;
      background: transparent !important;
    }

    /* Search Section */
    .search-section {
      background: rgba(31, 41, 55, 0.6);
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 20px;
      border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .input-group-text {
      background: rgba(31, 41, 55, 0.8) !important;
      border: 2px solid rgba(16, 185, 129, 0.3);
      color: #9ca3af;
    }

    .form-control {
      background: rgba(31, 41, 55, 0.6);
      border: 2px solid rgba(16, 185, 129, 0.3);
      border-left: none;
      color: #e5e7eb;
      padding: 10px 15px;
    }

    .form-control:focus {
      background: rgba(31, 41, 55, 0.8);
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
      color: #e5e7eb;
      outline: none;
    }

    .form-control::placeholder {
      color: #6b7280;
    }

    /* Buttons */
    .btn-primary-custom {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-primary-custom:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
      color: white;
    }

    /* Table Styling */
    .table-responsive {
      overflow-x: auto;
      background: transparent !important;
    }

    .table-responsive * {
      background: transparent !important;
    }

    .table, .table > *, .table tbody, .table thead, .table tr, .table td, .table th {
      background-color: transparent !important;
    }

    .table-custom {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: transparent !important;
    }

    .table-custom thead {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: white;
    }

    .table-custom tbody {
      background: transparent !important;
    }

    .table-custom th {
      padding: 15px 12px;
      font-weight: 600;
      text-align: left;
      font-size: 14px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      background: transparent !important;
    }

    .table-custom th:first-child {
      border-top-left-radius: 10px;
    }

    .table-custom th:last-child {
      border-top-right-radius: 10px;
    }

    .table-custom tbody tr {
      background: transparent !important;
      border-bottom: 1px solid rgba(16, 185, 129, 0.1);
      transition: all 0.2s ease;
    }

    .table-custom tbody tr:hover {
      background: rgba(16, 185, 129, 0.1) !important;
      transform: scale(1.01);
      border-left: 3px solid #10b981;
    }

    .table-custom td {
      padding: 15px 12px;
      font-size: 14px;
      color: #d1d5db;
      vertical-align: middle;
      background: transparent !important;
      border-color: rgba(16, 185, 129, 0.1) !important;
    }

    .text-primary {
      color: #10b981 !important;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      gap: 6px;
      justify-content: center;
    }

    .btn-action {
      width: 32px;
      height: 32px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: all 0.2s ease;
      text-decoration: none;
      font-size: 13px;
    }

    .btn-warning.btn-action {
      background: rgba(251, 191, 36, 0.2);
      color: #fbbf24;
      border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .btn-warning.btn-action:hover {
      background: rgba(251, 191, 36, 0.3);
      transform: translateY(-2px);
    }

    .btn-danger.btn-action {
      background: rgba(239, 68, 68, 0.2);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-danger.btn-action:hover {
      background: rgba(239, 68, 68, 0.3);
      transform: translateY(-2px);
    }

    /* Badges */
    .badge-custom {
      font-size: 12px;
      padding: 6px 12px;
      border-radius: 20px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .bg-success {
      background: rgba(16, 185, 129, 0.2) !important;
      color: #34d399 !important;
      border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .bg-warning {
      background: rgba(251, 191, 36, 0.2) !important;
      color: #fbbf24 !important;
      border: 1px solid rgba(251, 191, 36, 0.4);
    }

    .bg-danger {
      background: rgba(239, 68, 68, 0.2) !important;
      color: #f87171 !important;
      border: 1px solid rgba(239, 68, 68, 0.4);
    }

    .bg-info {
      background: rgba(59, 130, 246, 0.2) !important;
      color: #60a5fa !important;
      border: 1px solid rgba(59, 130, 246, 0.4);
    }

    .bg-primary {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
      color: white !important;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .text-dark {
      color: #1f2937 !important;
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

    .empty-state h6 {
      font-size: 1.1rem;
      color: #d1d5db;
      margin-top: 15px;
    }

    .empty-state p {
      color: #9ca3af;
    }

    /* View Only */
    .view-only {
      color: #9ca3af;
      font-size: 12px;
      font-style: italic;
    }

    /* Text Utilities */
    .text-muted {
      color: #9ca3af !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
      body {
        padding: 15px;
      }

      .header-section {
        padding: 20px;
      }

      .page-title {
        font-size: 1.5rem;
      }

      .stats-number {
        font-size: 2rem;
      }

      .table-custom {
        font-size: 12px;
      }

      .table-custom th,
      .table-custom td {
        padding: 10px 8px;
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
        <i class="fas fa-calendar-alt"></i>
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
          <div class="stats-label"><i class="fas fa-calendar-day me-2"></i>Today's Appointments</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="stats-card">
          <div class="stats-number"><?= !empty($appointments) ? count($appointments) : 0 ?></div>
          <div class="stats-label"><i class="fas fa-list me-2"></i>Total Appointments</div>
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
          <div class="stats-label"><i class="fas fa-clock me-2"></i>Pending</div>
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
          <div class="stats-label"><i class="fas fa-check-circle me-2"></i>Confirmed</div>
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
          <?php if(($user_role ?? 'user') != 'admin'): ?>
            <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary-custom">
              <i class="fas fa-plus me-1"></i> Book Appointment
            </a>
          <?php endif; ?>
        </div>
      </div>
      
      <div class="card-body">
        <!-- Search Section -->
        <div class="search-section">
          <form method="GET" action="<?= site_url('appointments') ?>" class="row align-items-center g-3">
            <div class="col-md-8">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-search"></i>
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
                        <a href="<?= site_url('appointments/edit/'.$appt['id']) ?>" class="btn btn-warning btn-action" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('appointments/delete/'.$appt['id']) ?>" class="btn btn-danger btn-action" 
                           onclick="return confirm('Are you sure you want to delete this appointment?')" title="Delete">
                          <i class="fas fa-trash"></i>
                        </a>
                      <?php else: ?>
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
                    <?php if(($user_role ?? 'user') != 'admin'): ?>
                      <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary-custom">
                        <i class="fas fa-plus me-1"></i> Book Appointment
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>