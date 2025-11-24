<!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
        
        <h2 class="text-center mb-4 text-success">Edit Patient</h2>

        <form method="POST" action="<?= site_url('patients/update/' . $patient['id']) ?>">

            <input type="text" 
                   name="first_name" 
                   value="<?= htmlspecialchars($patient['first_name']) ?>" 
                   class="form-control mb-3" 
                   placeholder="First Name" 
                   required>

            <input type="text" 
                   name="last_name" 
                   value="<?= htmlspecialchars($patient['last_name']) ?>" 
                   class="form-control mb-3" 
                   placeholder="Last Name" 
                   required>

            <!-- Birth Date (Matches new Add Form) -->
            <label class="form-label fw-semibold">Birth Date</label>
            <input type="date" 
                   name="birth_date" 
                   value="<?= htmlspecialchars($patient['birth_date']) ?>" 
                   class="form-control mb-3" 
                   required 
                   max="<?= date('Y-m-d') ?>">

            <label class="form-label fw-semibold">Gender</label>
            <select name="gender" class="form-control mb-3" required>
                <option value="Male"   <?= $patient['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $patient['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <input type="text" 
                   name="contact_number" 
                   value="<?= htmlspecialchars($patient['contact_number']) ?>" 
                   class="form-control mb-3" 
                   placeholder="Contact Number">

            <input type="text" 
                   name="address" 
                   value="<?= htmlspecialchars($patient['address']) ?>" 
                   class="form-control mb-3" 
                   placeholder="Address">

            <input type="email" 
                   name="email" 
                   value="<?= htmlspecialchars($patient['email']) ?>" 
                   class="form-control mb-3" 
                   placeholder="Email">

            <label class="form-label fw-semibold">Status</label>
            <select name="status" class="form-control mb-4">
                <option value="Monitored"  <?= ($patient['status'] == 'Monitored') ? 'selected' : '' ?>>Monitored</option>
                <option value="Discharged" <?= ($patient['status'] == 'Discharged') ? 'selected' : '' ?>>Discharged</option>
            </select>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success px-4">💾 Update</button>
                <a href="<?= site_url('patients') ?>" class="btn btn-secondary px-4">Cancel</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
