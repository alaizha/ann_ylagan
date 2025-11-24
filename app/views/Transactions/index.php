<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blockchain Billing | HIV Treatment Monitoring</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #e3f2fd, #f3e5f5);
      min-height: 100vh;
      font-family: 'Poppins', sans-serif;
    }

    .container {
      max-width: 1000px;
    }

    .back-button {
      display: inline-block;
      margin-bottom: 20px;
      padding: 8px 15px;
      background: #6c63ff;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
      transition: all 0.2s ease-in-out;
      font-weight: 500;
    }

    .back-button:hover {
      background: #5848d0;
      text-decoration: none;
      transform: translateY(-2px);
    }

    h2 {
      background: linear-gradient(to right, #6a11cb, #2575fc);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-weight: 700;
    }

    .card {
      border: none;
      border-radius: 15px;
      transition: 0.2s ease-in-out;
    }

    .card:hover {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }

    table {
      border-radius: 10px;
      overflow: hidden;
    }

    thead {
      background: #6c63ff;
      color: white;
    }

    tbody tr:hover {
      background-color: #f5f5ff;
    }

    .btn-primary {
      background: #6c63ff;
      border: none;
      transition: 0.2s;
    }

    .btn-primary:hover {
      background: #5848d0;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <a href="<?php echo site_url('dashboard'); ?>" class="back-button">← Back to Dashboard</a>

    <h2 class="fw-bold mb-4 text-center">💰 Blockchain Billing</h2>

    <!-- ✅ Add Transaction Form -->
    <div class="card shadow-sm p-4 mb-4">
      <h5 class="fw-semibold mb-3">➕ Add New Transaction</h5>

      <form action="<?php echo site_url('transactions/add'); ?>" method="POST" class="row g-3">

        <div class="col-md-3">
          <label class="form-label">Tx/No</label>
          <input type="text" name="tx_no" class="form-control" placeholder="e.g., T001" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Patient Name</label>
          <input type="text" name="patient" class="form-control" placeholder="Patient Name" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Amount</label>
          <input type="number" name="amount" class="form-control" placeholder="₱" required>
        </div>
        <div class="col-md-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select" required>
    <option value="Confirmed">Confirmed</option>
    <option value="Pending">Pending</option>
  </select>
</div>

<div class="col-12">
  <label class="form-label">Description (Optional)</label>
  <textarea name="description" class="form-control" placeholder="Add description here..."></textarea>
</div>

<div class="col-12 text-end">
  <button type="submit" class="btn btn-primary px-4">Add Transaction</button>
</div>


    <!-- ✅ Recent Transactions Table -->
    <div class="card shadow-sm p-4">
      <h5 class="fw-semibold mb-3">🧾 Recent Blockchain Transactions</h5>
      <div class="table-responsive">
        <table class="table align-middle text-center">
          <thead>
            <tr>
              <th>Tx/No</th>
              <th>Patient</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($all_transactions)): ?>
    <?php foreach ($all_transactions as $tx): ?>
        <tr>
            <td><?php echo $tx['tx_no']; ?></td>
            <td><?php echo $tx['patient_name']; ?></td>
            <td><?php echo number_format($tx['amount'], 2); ?></td>
            <td>
                <?php if ($tx['status'] == 'Confirmed'): ?>
                    <span class="badge bg-success">Confirmed</span>
                <?php else: ?>
                    <span class="badge bg-warning">Pending</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
