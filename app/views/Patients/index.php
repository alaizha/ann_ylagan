<?php 
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
$role = $_SESSION['role'] ?? 'user';
?>

<div class="main-container">
    <div class="header-bar">
        <h2>🩺 Patient Management</h2>
        <div class="btn-group">
            <?php if ($role == 'admin'): ?>
            <form method="POST" action="<?= site_url('patients/exportCSV') ?>" style="display:inline;">
                <button type="submit" class="btn-export">📤 Export CSV</button>
            </form>
            <?php endif; ?>
            <a href="<?= site_url('dashboard') ?>" class="btn-back">← Back to Dashboard</a>
        </div>
    </div>

    <!-- ✅ SEARCH FORM -->
    <div class="card search-form">
        <h4>🔍 Search Patients</h4>
        <form method="GET" action="<?= site_url('patients') ?>">
            <div class="form-grid">
                <div class="form-group">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by name, contact, email, or address..." 
                           value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="form-group" style="max-width: 150px;">
                    <button type="submit" class="btn-primary" style="width: 100%;">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <?php if (!empty($search)): ?>
                <div class="form-group" style="max-width: 150px;">
                    <a href="<?= site_url('patients') ?>" class="btn-secondary" style="display: block; text-align: center; padding: 8px 16px; background: #6c757d; color: white; border-radius: 6px; text-decoration: none;">
                        Clear Search
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </form>
        
        <?php if (!empty($search)): ?>
            <div style="margin-top: 10px; padding: 10px; background: #e7f3ff; border-radius: 6px;">
                <strong>Search Results for:</strong> "<?= htmlspecialchars($search) ?>"
                <span style="color: #666; margin-left: 10px;">
                    (<?= count($patients) ?> patient<?= count($patients) != 1 ? 's' : '' ?> found)
                </span>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($role == 'admin'): ?>
    <div class="card add-form">
        <h4>➕ Add New Patient</h4>
        <form action="<?= site_url('/patients/add') ?>" method="POST" class="form-grid">
            
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>

            <!-- ✅ BIRTH DATE ONLY - AGE AUTO CALCULATED -->
            <div class="form-group small">
                <label>Birth Date</label>
                <input type="date" name="birth_date" required max="<?= date('Y-m-d') ?>">
            </div>

            <div class="form-group small">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="">Select</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group small">
                <label>Status</label>
                <select name="status">
                    <option value="Monitored">Monitored</option>
                    <option value="Discharged">Discharged</option>
                </select>
            </div>

            <div class="form-group full text-end">
                <button type="submit" class="btn-primary">Add Patient</button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="card patient-list">
        <h4>📋 Patient Records <?= !empty($search) ? '(Search Results)' : '' ?></h4>
        <div class="table-container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Birth Date</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Status</th>
                        <?php if ($role == 'admin'): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($patients)): ?>
                        <?php foreach ($patients as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></td>
                                <td>
                                    <?php if(isset($p['birth_date']) && $p['birth_date'] != '0000-00-00'): ?>
                                        <?= date('M j, Y', strtotime($p['birth_date'])) ?>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?= $p['age'] ?? 'N/A' ?></td>
                                <td><?= htmlspecialchars($p['gender']) ?></td>
                                <td><?= htmlspecialchars($p['contact_number']) ?></td>
                                <td><?= htmlspecialchars($p['address']) ?></td>
                                <td><?= htmlspecialchars($p['email']) ?></td>
                                <td>
                                    <span class="badge <?= $p['status'] == 'Monitored' ? 'badge-success' : 'badge-gray' ?>">
                                        <?= htmlspecialchars($p['status']) ?>
                                    </span>
                                </td>
                                <?php if ($role == 'admin'): ?>
                                <td>
                                    <a href="<?= site_url('/patients/edit/' . $p['id']); ?>" class="btn-action edit">Edit</a>
                                    <a href="<?= site_url('/patients/delete/' . $p['id']); ?>" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $role == 'admin' ? 10 : 9 ?>" class="text-center empty">
                                <?php if (!empty($search)): ?>
                                    No patients found for "<?= htmlspecialchars($search) ?>"
                                <?php else: ?>
                                    No patients found.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
body {
    background: #f4f6fb;
    font-family: 'Poppins', sans-serif;
    color: #333;
    margin: 0;
    padding: 20px;
}

.main-container {
    max-width: 1200px;
    margin: auto;
}

.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.header-bar h2 {
    font-weight: 600;
    color: #4e44ce;
}

.btn-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-back {
    background: #4e44ce;
    color: white;
    padding: 8px 18px;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s;
}
.btn-back:hover {
    background: #3a33a9;
}

.btn-export {
    background: #22bb33;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 500;
    transition: 0.2s;
}
.btn-export:hover {
    background: #1e9e2a;
}

.card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
}

.search-form h4, .add-form h4, .patient-list h4 {
    margin-bottom: 18px;
    color: #333;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
}
.form-group label {
    font-weight: 500;
    margin-bottom: 5px;
}
.form-group input, .form-group select {
    padding: 8px 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
}
.form-group.full {
    grid-column: 1 / -1;
}
.text-end {
    text-align: right;
}

.btn-primary {
    background: #4e44ce;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}
.btn-primary:hover {
    background: #3a33a9;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    display: block;
    transition: 0.2s;
}
.btn-secondary:hover {
    background: #5a6268;
}

.table-container {
    overflow-x: auto;
}

.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
.styled-table thead {
    background: #4e44ce;
    color: white;
}
.styled-table th, .styled-table td {
    padding: 10px 12px;
    text-align: left;
}
.styled-table tbody tr:nth-child(even) {
    background: #f9f9ff;
}
.styled-table tbody tr:hover {
    background: #f1f0ff;
}
.empty {
    text-align: center;
    color: #999;
}

.badge {
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 12px;
}
.badge-success {
    background: #d4edda;
    color: #155724;
}
.badge-gray {
    background: #e2e3e5;
    color: #383d41;
}

.btn-action {
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 6px;
    margin-right: 4px;
    color: white;
    font-size: 13px;
}
.btn-action.edit {
    background: #ffc107;
}
.btn-action.delete {
    background: #dc3545;
}
.btn-action:hover {
    opacity: 0.85;
}

/* Search results styling */
.search-form .form-grid {
    grid-template-columns: 1fr auto auto;
    align-items: end;
}

@media (max-width: 768px) {
    .search-form .form-grid {
        grid-template-columns: 1fr;
    }
}
</style>