<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blockchain Transactions | HIV Monitoring</title>
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
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 25px;
      color: #e5e7eb;
    }

    .main-wrapper {
      max-width: 1600px;
      margin: 0 auto;
    }

    /* Header Styling */
    .top-header {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 15px;
      padding: 25px 30px;
      margin-bottom: 30px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    .nav-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .btn-back {
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
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-back:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
      color: white;
    }

    .status-badge {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      padding: 8px 20px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: 600;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .main-title {
      text-align: center;
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      font-size: 2.2rem;
      font-weight: 700;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
    }

    .main-title i {
      color: #10b981;
      -webkit-text-fill-color: #10b981;
    }

    /* Content Grid */
    .content-grid {
      display: grid;
      grid-template-columns: 1fr 380px;
      gap: 25px;
    }

    @media (max-width: 1200px) {
      .content-grid {
        grid-template-columns: 1fr;
      }
    }

    /* Card Styling */
    .content-card {
      background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 15px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
      overflow: hidden;
    }

    .card-title-bar {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      padding: 20px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid rgba(16, 185, 129, 0.3);
    }

    .card-title-bar h5 {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .btn-add {
      background: rgba(255, 255, 255, 0.15);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
    }

    .btn-add:hover {
      background: rgba(255, 255, 255, 0.25);
      border-color: rgba(255, 255, 255, 0.5);
      transform: translateY(-1px);
      color: white;
    }

    .card-content {
      padding: 25px;
    }

    /* Search Bar */
    .search-box {
      background: rgba(16, 185, 129, 0.1);
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .search-input-group {
      display: flex;
      gap: 12px;
    }

    .search-input-wrapper {
      flex: 1;
      position: relative;
    }

    .search-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #10b981;
    }

    .search-field {
      width: 100%;
      padding: 12px 12px 12px 45px;
      border: 2px solid rgba(16, 185, 129, 0.3);
      border-radius: 10px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: rgba(31, 41, 55, 0.5);
      color: #e5e7eb;
    }

    .search-field::placeholder {
      color: #9ca3af;
    }

    .search-field:focus {
      outline: none;
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
      background: rgba(31, 41, 55, 0.8);
    }

    .btn-search {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      white-space: nowrap;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-search:hover {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }

    /* Table Styling */
    .transactions-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    .transactions-table thead {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
    }

    .transactions-table th {
      padding: 15px 12px;
      font-weight: 600;
      text-align: left;
      font-size: 13px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .transactions-table th:first-child {
      border-top-left-radius: 10px;
    }

    .transactions-table th:last-child {
      border-top-right-radius: 10px;
    }

    .transactions-table tbody tr {
      background: rgba(31, 41, 55, 0.6);
      border-bottom: 1px solid rgba(16, 185, 129, 0.1);
      transition: all 0.2s ease;
    }

    .transactions-table tbody tr:hover {
      background: rgba(16, 185, 129, 0.1);
      transform: scale(1.01);
      border-left: 3px solid #10b981;
    }

    .transactions-table td {
      padding: 15px 12px;
      font-size: 14px;
      color: #d1d5db;
    }

    .tx-number {
      font-weight: 700;
      color: #10b981;
      font-size: 15px;
    }

    .patient-info {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .patient-icon {
      color: #10b981;
      font-size: 18px;
    }

    .amount-text {
      font-weight: 700;
      color: #34d399;
      font-size: 15px;
    }

    .description-text {
      color: #9ca3af;
      font-size: 13px;
    }

    .status-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .status-confirmed {
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .status-pending {
      background: rgba(251, 191, 36, 0.2);
      color: #fbbf24;
      border: 1px solid rgba(251, 191, 36, 0.4);
    }

    .status-failed {
      background: rgba(239, 68, 68, 0.2);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.4);
    }

    .date-text {
      color: #9ca3af;
      font-size: 13px;
    }

    .action-group {
      display: flex;
      gap: 6px;
      justify-content: center;
    }

    .btn-icon {
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

    .btn-edit {
      background: rgba(251, 191, 36, 0.2);
      color: #fbbf24;
      border: 1px solid rgba(251, 191, 36, 0.3);
    }

    .btn-edit:hover {
      background: rgba(251, 191, 36, 0.3);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
    }

    .btn-print {
      background: rgba(59, 130, 246, 0.2);
      color: #60a5fa;
      border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .btn-print:hover {
      background: rgba(59, 130, 246, 0.3);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-delete {
      background: rgba(239, 68, 68, 0.2);
      color: #f87171;
      border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
      background: rgba(239, 68, 68, 0.3);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Empty State */
    .no-data {
      text-align: center;
      padding: 60px 20px;
      color: #9ca3af;
    }

    .no-data i {
      font-size: 4rem;
      color: rgba(16, 185, 129, 0.3);
      margin-bottom: 20px;
    }

    .no-data h6 {
      font-size: 1.1rem;
      color: #d1d5db;
      margin-bottom: 10px;
    }

    .no-data p {
      margin-bottom: 20px;
      color: #9ca3af;
    }

    /* Appointments Sidebar */
    .appointment-item {
      background: rgba(31, 41, 55, 0.6);
      border: 1px solid rgba(16, 185, 129, 0.2);
      border-radius: 12px;
      padding: 15px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
    }

    .appointment-item:hover {
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
      transform: translateY(-2px);
      border-color: #10b981;
      background: rgba(16, 185, 129, 0.1);
    }

    .appointment-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
    }

    .patient-name {
      font-weight: 700;
      color: #e5e7eb;
      font-size: 15px;
      margin-bottom: 8px;
    }

    .appointment-info {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #9ca3af;
      font-size: 13px;
      margin-bottom: 6px;
    }

    .appointment-info i {
      color: #10b981;
    }

    .badge-status {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 600;
    }

    .badge-success {
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.4);
    }

    .badge-warning {
      background: rgba(251, 191, 36, 0.2);
      color: #fbbf24;
      border: 1px solid rgba(251, 191, 36, 0.4);
    }

    .badge-secondary {
      background: rgba(107, 114, 128, 0.2);
      color: #9ca3af;
      border: 1px solid rgba(107, 114, 128, 0.4);
    }

    .appointments-empty {
      text-align: center;
      padding: 40px 20px;
      color: #9ca3af;
    }

    .appointments-empty i {
      font-size: 3rem;
      color: rgba(16, 185, 129, 0.3);
      margin-bottom: 15px;
    }

    .view-all-link {
      text-align: center;
      margin-top: 20px;
    }

    .btn-outline {
      background: transparent;
      color: #10b981;
      border: 2px solid #10b981;
      padding: 8px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: all 0.3s ease;
    }

    .btn-outline:hover {
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      body {
        padding: 15px;
      }

      .top-header {
        padding: 20px;
      }

      .main-title {
        font-size: 1.6rem;
      }

      .search-input-group {
        flex-direction: column;
      }

      .transactions-table {
        font-size: 12px;
      }

      .transactions-table th,
      .transactions-table td {
        padding: 10px 8px;
      }

      .content-grid {
        gap: 20px;
      }
    }

    /* Scrollbar Styling */
    .table-responsive::-webkit-scrollbar {
      height: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background: rgba(31, 41, 55, 0.5);
      border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: #10b981;
      border-radius: 10px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #059669;
    }

    /* Glow Effects */
    .content-card:hover {
      box-shadow: 0 8px 32px rgba(16, 185, 129, 0.2);
    }

    .transactions-table tbody tr:hover {
      box-shadow: 0 0 15px rgba(16, 185, 129, 0.15);
    }
  </style>
</head>
<body>
  <div class="main-wrapper">
    <!-- Header Section -->
    <div class="top-header">
      <div class="nav-bar">
        <a href="<?php echo site_url('dashboard'); ?>" class="btn-back">
          <i class="fas fa-arrow-left"></i>
          <span>Back to Dashboard</span>
        </a>
        <span class="status-badge">
          <i class="fas fa-shield-alt me-1"></i>Blockchain Billing
        </span>
      </div>
      
      <h1 class="main-title">
        <i class="fas fa-link"></i>
        Blockchain Transactions
      </h1>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
      <!-- Transactions Section -->
      <div class="content-card">
        <div class="card-title-bar">
          <h5>
            <i class="fas fa-file-invoice-dollar"></i>
            Transaction Records
          </h5>
          <a href="<?php echo site_url('blockchain/create'); ?>" class="btn-add">
            <i class="fas fa-plus-circle"></i>
            New Transaction
          </a>
        </div>
        
        <div class="card-content">
          <!-- Search Section -->
          <div class="search-box">
            <form method="GET" action="<?php echo site_url('blockchain'); ?>">
              <div class="search-input-group">
                <div class="search-input-wrapper">
                  <i class="fas fa-search search-icon"></i>
                  <input type="text" 
                         name="search" 
                         class="search-field" 
                         placeholder="Search by transaction number, patient name, or description..."
                         value="<?php echo isset($search) ? $search : ''; ?>">
                </div>
                <button type="submit" class="btn-search">
                  <i class="fas fa-search me-2"></i>Search
                </button>
              </div>
            </form>
          </div>

          <!-- Transactions Table -->
          <div class="table-responsive">
            <table class="transactions-table">
              <thead>
                <tr>
                  <th>TX Number</th>
                  <th>Patient Name</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Created Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($transactions)): ?>
                  <?php foreach ($transactions as $tx): ?>
                  <tr>
                    <td>
                      <span class="tx-number"><?php echo $tx['tx_no']; ?></span>
                    </td>
                    <td>
                      <div class="patient-info">
                        <i class="fas fa-user-circle patient-icon"></i>
                        <span><?php echo $tx['patient_name']; ?></span>
                      </div>
                    </td>
                    <td>
                      <span class="amount-text">₱<?php echo number_format($tx['amount'], 2); ?></span>
                    </td>
                    <td>
                      <span class="description-text"><?php echo $tx['description']; ?></span>
                    </td>
                    <td>
                      <?php if (strtolower($tx['status']) == 'confirmed'): ?>
                        <span class="status-tag status-confirmed">
                          <i class="fas fa-check-circle"></i>Confirmed
                        </span>
                      <?php elseif (strtolower($tx['status']) == 'pending'): ?>
                        <span class="status-tag status-pending">
                          <i class="fas fa-clock"></i>Pending
                        </span>
                      <?php else: ?>
                        <span class="status-tag status-failed">
                          <i class="fas fa-times-circle"></i>Failed
                        </span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="date-text"><?php echo date('M d, Y', strtotime($tx['created_at'])); ?></span><br>
                      <span class="date-text"><?php echo date('h:i A', strtotime($tx['created_at'])); ?></span>
                    </td>
                    <td>
                      <div class="action-group">
                        <a href="<?php echo site_url('blockchain/edit/'.$tx['id']); ?>" 
                           class="btn-icon btn-edit" 
                           title="Edit Transaction">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?php echo site_url('transactions/print_receipt/'.$tx['id']); ?>" 
                           class="btn-icon btn-print" 
                           target="_blank" 
                           title="Print Receipt">
                          <i class="fas fa-print"></i>
                        </a>
                        <a href="<?php echo site_url('blockchain/delete/'.$tx['id']); ?>"
                           class="btn-icon btn-delete"
                           onclick="return confirm('Are you sure you want to delete this transaction?');"
                           title="Delete Transaction">
                          <i class="fas fa-trash-alt"></i>
                        </a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7">
                      <div class="no-data">
                        <i class="fas fa-receipt"></i>
                        <h6>No Transactions Found</h6>
                        <p>Start by creating your first blockchain transaction to secure patient billing records</p>
                        <a href="<?php echo site_url('blockchain/create'); ?>" class="btn-back">
                          <i class="fas fa-plus-circle"></i>Create New Transaction
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Appointments Sidebar -->
      <div class="content-card">
        <div class="card-title-bar">
          <h5>
            <i class="fas fa-calendar-check"></i>
            Today's Appointments
          </h5>
          <a href="<?php echo site_url('appointments/create'); ?>" class="btn-add">
            <i class="fas fa-plus"></i>
            Add
          </a>
        </div>
        
        <div class="card-content">
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
              <div class="appointment-item">
                <div class="appointment-header">
                  <div>
                    <div class="patient-name">
                      <?php 
                      $patient_name = 'Unknown Patient';
                      if(!empty($patients)) {
                        foreach($patients as $p) {
                          if($p['id'] == $appt['patient_id']) {
                            $patient_name = $p['first_name'] . ' ' . $p['last_name'];
                            break;
                          }
                        }
                      }
                      echo $patient_name;
                      ?>
                    </div>
                    <div class="appointment-info">
                      <i class="fas fa-clock"></i>
                      <span><?= date('h:i A', strtotime($appt['appointment_time'])) ?></span>
                    </div>
                    <div class="appointment-info">
                      <i class="fas fa-stethoscope"></i>
                      <span><?= $appt['purpose'] ?></span>
                    </div>
                  </div>
                  <span class="badge-status <?= 
                    $appt['status'] == 'Confirmed' ? 'badge-success' : 
                    ($appt['status'] == 'Pending' ? 'badge-warning' : 'badge-secondary')
                  ?>">
                    <?= $appt['status'] ?>
                  </span>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="appointments-empty">
                <i class="fas fa-calendar-times"></i>
                <h6>No Appointments Today</h6>
                <p>Schedule appointments for better patient care management</p>
                <a href="<?= site_url('appointments/create') ?>" class="btn-back">
                  <i class="fas fa-calendar-plus"></i>Schedule Appointment
                </a>
              </div>
            <?php endif; ?>
          </div>

          <div class="view-all-link">
            <a href="<?= site_url('appointments') ?>" class="btn-outline">
              <i class="fas fa-calendar-alt"></i>
              View All Appointments
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>