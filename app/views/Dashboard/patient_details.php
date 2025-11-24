<?php include APP_DIR . 'views/layouts/header.php'; ?>

<?php if (!empty($patient) && is_object($patient)): ?>
<div class="card p-4 shadow">
    <h4>Patient Details</h4>
    <hr>

    <p><strong>Name:</strong> <?= htmlspecialchars($patient->first_name . ' ' . $patient->last_name) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($patient->age ?? 'N/A') ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($patient->gender ?? 'N/A') ?></p>
    <p><strong>CD4 Count:</strong> <?= htmlspecialchars($patient->cd4_count ?? 'N/A') ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($patient->status ?? 'N/A') ?></p>

    <a href="<?= site_url('/dashboard/patients'); ?>" class="btn btn-primary mt-3">Back to Patients</a>
</div>
<?php else: ?>
<div class="alert alert-warning">
    ⚠️ Patient not found.
    <a href="<?= site_url('/dashboard/patients'); ?>" class="btn btn-secondary mt-2">Back to Patients</a>
</div>
<?php endif; ?>

<?php include APP_DIR . 'views/layouts/footer.php'; ?>
