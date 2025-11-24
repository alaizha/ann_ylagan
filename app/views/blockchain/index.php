<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blockchain Transactions | HIV Monitoring</title>
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
    .appointment-card {
      background: white;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin-bottom: 10px;
      transition: all 0.2s ease;
    }
    .appointment-card:hover {
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .appointment-card .card-body {
      padding: 12px;
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
  </style>
</head>
<body>
  <div class="main-container">
    <!-- Header Section -->
    <div class="header-section">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?php echo site_url('dashboard'); ?>" class="back-button">
          <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
        <div class="text-end">
          <span class="badge bg-primary">Blockchain Billing</span>
        </div>
      </div>
      
      <h1 class="page-title">
        <i class="fas fa-receipt me-2"></i>Blockchain Transactions
      </h1>
    </div>

    <div class="row">
      <!-- Main Transactions Section -->
      <div class="col-lg-8">
        <div class="card-custom">
          <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-list me-2"></i> Transaction Records</h5>
              <a href="<?php echo site_url('blockchain/create'); ?>" class="btn btn-primary-custom">
                <i class="fas fa-plus me-1"></i> New Transaction
              </a>
            </div>
          </div>
          
          <div class="card-body">
            <!-- Search Section -->
            <div class="search-section">
              <form method="GET" action="<?php echo site_url('blockchain'); ?>">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <div class="input-group">
                      <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                      </span>
                      <input type="text" name="search" class="form-control" placeholder="Search transactions..."
                             value="<?php echo isset($search) ? $search : ''; ?>">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <button type="submit" class="btn btn-primary-custom w-100">
                      <i class="fas fa-search me-1"></i> Search
                    </button>
                  </div>
                </div>
              </form>
            </div>

            <!-- Transactions Table -->
            <div class="table-responsive">
              <table class="table table-custom table-hover">
                <thead>
                  <tr>
                    <th>TX No</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $tx): ?>
                    <tr>
                      <td>
                        <strong class="text-primary"><?php echo $tx['tx_no']; ?></strong>
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <i class="fas fa-user-circle me-2 text-muted"></i>
                          <?php echo $tx['patient_name']; ?>
                        </div>
                      </td>
                      <td>
                        <span class="fw-bold text-success">₱<?php echo number_format($tx['amount'], 2); ?></span>
                      </td>
                      <td>
                        <small class="text-muted"><?php echo $tx['description']; ?></small>
                      </td>
                      <td>
                        <?php if (strtolower($tx['status']) == 'confirmed'): ?>
                          <span class="badge bg-success badge-custom">
                            <i class="fas fa-check-circle me-1"></i>Confirmed
                          </span>
                        <?php elseif (strtolower($tx['status']) == 'pending'): ?>
                          <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-clock me-1"></i>Pending
                          </span>
                        <?php else: ?>
                          <span class="badge bg-danger badge-custom">
                            <i class="fas fa-times-circle me-1"></i>Failed
                          </span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <small><?php echo date('M d, Y h:i A', strtotime($tx['created_at'])); ?></small>
                      </td>
                      <td>
                        <div class="action-buttons">
                          <a href="<?php echo site_url('blockchain/edit/'.$tx['id']); ?>" 
                             class="btn btn-warning btn-action" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="<?php echo site_url('transactions/print_receipt/'.$tx['id']); ?>" 
                             class="btn btn-info btn-action" target="_blank" title="Print Receipt">
                            <i class="fas fa-print"></i>
                          </a>
                          <a href="<?php echo site_url('blockchain/delete/'.$tx['id']); ?>"
                             class="btn btn-danger btn-action"
                             onclick="return confirm('Are you sure you want to delete this transaction?');"
                             title="Delete">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="7" class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <h6 class="mt-2">No Transactions Found</h6>
                        <p class="text-muted mb-2">Start by creating your first blockchain transaction</p>
                        <a href="<?php echo site_url('blockchain/create'); ?>" class="btn btn-primary-custom">
                          <i class="fas fa-plus me-1"></i>Create Transaction
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

      <!-- Appointments Sidebar -->
      <div class="col-lg-4">
        <div class="card-custom">
          <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fas fa-calendar-day me-2"></i> Today's Appointments</h5>
              <a href="<?php echo site_url('appointments/create'); ?>" class="btn btn-primary-custom">
                <i class="fas fa-plus me-1"></i> Add
              </a>
            </div>
          </div>
          
          <div class="card-body">
            <div class="appointments-list">
              <?php 
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
                <?php foreach($todays_appointments as $appt): ?>
                <div class="appointment-card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                      <div class="flex-grow-1">
                        <h6 class="mb-1 fw-bold">
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
                        </h6>
                        <div class="d-flex align-items-center mb-1">
                          <i class="fas fa-clock me-2 text-muted"></i>
                          <small class="text-muted"><?= date('h:i A', strtotime($appt['appointment_time'])) ?></small>
                        </div>
                        <small class="text-muted"><i class="fas fa-stethoscope me-2"></i><?= $appt['purpose'] ?></small>
                      </div>
                      <span class="badge bg-<?= 
                        $appt['status'] == 'Confirmed' ? 'success' : 
                        ($appt['status'] == 'Pending' ? 'warning text-dark' : 'secondary')
                      ?> badge-custom">
                        <?= $appt['status'] ?>
                      </span>
                    </div>
                  </div>
                </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="empty-state">
                  <i class="fas fa-calendar-times"></i>
                  <h6 class="mt-2">No Appointments Today</h6>
                  <p class="small text-muted mb-2">Schedule appointments for better patient management</p>
                  <a href="<?= site_url('appointments/create') ?>" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-1"></i>Schedule Now
                  </a>
                </div>
              <?php endif; ?>
            </div>

            <div class="text-center mt-3">
              <a href="<?= site_url('appointments') ?>" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-list me-1"></i>View All Appointments
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>