<!DOCTYPE html>
<html>
<head>
    <title>Edit Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>Edit Blockchain Transaction</h3>
<hr>

<form action="<?= site_url('blockchain/update/' . $transaction['id']); ?>" method="POST">

    <div class="mb-3">
        <label>Patient Name</label>
        <select name="patient" class="form-control" required>
            <?php foreach ($patients as $p): ?>
                <option value="<?= $p['id']; ?>" <?= ($p['id'] == $transaction['patient_id']) ? 'selected' : ''; ?>>
                    <?= $p['first_name'] . " " . $p['last_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Amount (₱)</label>
        <input type="number" name="amount" class="form-control" value="<?= $transaction['amount']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required><?= $transaction['description']; ?></textarea>
    </div>

    <div class="mb-3">
        <label>Status</label>
        <select name="status" class="form-control" required>
            <option value="pending"   <?= ($transaction['status']=="pending")?'selected':''; ?>>Pending</option>
            <option value="confirmed" <?= ($transaction['status']=="confirmed")?'selected':''; ?>>Confirmed</option>
            <option value="failed"    <?= ($transaction['status']=="failed")?'selected':''; ?>>Failed</option>
        </select>
    </div>

    <button class="btn btn-primary">Save Changes</button>
    <a href="<?= site_url('blockchain'); ?>" class="btn btn-secondary">Cancel</a>

</form>

</body>
</html>
