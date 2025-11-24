<?php include APP_DIR . 'views/layouts/header.php'; ?>

<div class="card p-4 shadow">
    <h4>Patient Details</h4>
    <hr>

    <p><strong>Name:</strong> <?= $patient->first_name . ' ' . $patient->last_name ?></p>
    <p><strong>Age:</strong> <?= $patient->age ?></p>
    <p><strong>Gender:</strong> <?= $patient->gender ?></p>
    <p><strong>CD4 Count:</strong> <?= $patient->cd4_count ?? 'N/A' ?></p>
    <p><strong>Status:</strong> <?= $patient->status ?? 'N/A' ?></p>

    <a href="<?= site_url('/dashboard/patients'); ?>" class="btn btn-primary mt-3">Back to Patients</a>
</div>

<?php include APP_DIR . 'views/layouts/footer.php'; ?>
