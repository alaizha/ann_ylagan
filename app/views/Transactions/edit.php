<!DOCTYPE html>
<html>
<head>
  <title>Edit Transaction</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<a href="<?php echo site_url('transactions'); ?>" class="btn btn-secondary mb-3">← Back</a>

<h3>Edit Transaction</h3>

<form action="<?php echo site_url('transactions/update'); ?>" method="POST">

<input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">

<div class="mb-3">
  <label>Patient Name</label>
  <input type="text" name="patient" value="<?php echo $transaction['patient_name']; ?>" class="form-control" required>
</div>

<div class="mb-3">
  <label>Amount</label>
  <input type="number" name="amount" value="<?php echo $transaction['amount']; ?>" class="form-control" required>
</div>

<div class="mb-3">
  <label>Status</label>
  <select name="status" class="form-select">
    <option <?php echo ($transaction['status']=='Confirmed') ? 'selected':''; ?>>Confirmed</option>
    <option <?php echo ($transaction['status']=='Pending') ? 'selected':''; ?>>Pending</option>
  </select>
</div>

<div class="mb-3">
  <label>Description</label>
  <textarea name="description" class="form-control"><?php echo $transaction['description']; ?></textarea>
</div>

<button class="btn btn-primary">Save Changes</button>

</form>

</body>
</html>
