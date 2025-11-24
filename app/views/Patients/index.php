<?php 
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$role = $_SESSION['role'] ?? 'user';
$current_page   = $current_page ?? 1;
$per_page       = $per_page ?? 10;
$total_patients = $total_patients ?? ($patients ? count($patients) : 0);
$start_number   = (($current_page - 1) * $per_page) + 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Management | HIV Treatment Monitoring</title>
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

/* Header Bar */
.header-bar {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 15px;
    padding: 25px 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    margin-bottom: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.header-bar h2 {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-group {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.btn-back, .btn-export {
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
    cursor: pointer;
}

.btn-back:hover, .btn-export:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    color: white;
}

/* Card Styles */
.card {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    border: 1px solid rgba(16, 185, 129, 0.2);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    margin-bottom: 25px;
}

.card h4 {
    color: #10b981;
    font-weight: 600;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 1.2rem;
}

/* Search Form */
.search-form input {
    background: rgba(31, 41, 55, 0.6);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 10px;
    color: #e5e7eb;
    padding: 12px 15px;
    width: 100%;
    transition: all 0.3s ease;
}

.search-form input:focus {
    background: rgba(31, 41, 55, 0.8);
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    outline: none;
}

.search-form input::placeholder {
    color: #6b7280;
}

/* Form Grid */
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
    color: #d1d5db;
    font-weight: 500;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-group input,
.form-group select {
    background: rgba(31, 41, 55, 0.6);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 8px;
    color: #e5e7eb;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    background: rgba(31, 41, 55, 0.8);
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    outline: none;
}

.form-group select option {
    background: #1f2937;
    color: #e5e7eb;
}

.form-group.full {
    grid-column: 1 / -1;
}

.text-end {
    text-align: right;
}

/* Buttons */
.btn-primary {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    cursor: pointer;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
}

/* Results Info */
.results-info {
    margin-bottom: 15px;
    padding: 12px 15px;
    background: rgba(16, 185, 129, 0.1);
    border-radius: 8px;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.results-info strong {
    color: #10b981;
    font-size: 14px;
}

/* Table Styles */
.table-container {
    overflow-x: auto;
    background: transparent !important;
}

.table-container * {
    background: transparent !important;
}

.styled-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: transparent !important;
}

.styled-table thead {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    color: white;
}

.styled-table th {
    padding: 15px 12px;
    font-weight: 600;
    text-align: left;
    font-size: 13px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    background: transparent !important;
}

.styled-table th:first-child {
    border-top-left-radius: 10px;
}

.styled-table th:last-child {
    border-top-right-radius: 10px;
}

.styled-table tbody {
    background: transparent !important;
}

.styled-table tbody tr {
    background: transparent !important;
    border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    transition: all 0.2s ease;
}

.styled-table tbody tr:hover {
    background: rgba(16, 185, 129, 0.1) !important;
    transform: scale(1.005);
    border-left: 3px solid #10b981;
}

.styled-table td {
    padding: 15px 12px;
    font-size: 14px;
    color: #d1d5db;
    vertical-align: middle;
    background: transparent !important;
}

.empty {
    text-align: center;
    color: #9ca3af;
    padding: 40px 20px !important;
}

/* Badges */
.badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-success {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.4);
}

.badge-gray {
    background: rgba(107, 114, 128, 0.2);
    color: #9ca3af;
    border: 1px solid rgba(107, 114, 128, 0.4);
}

/* Action Buttons */
.btn-action {
    text-decoration: none;
    padding: 6px 12px;
    border-radius: 6px;
    margin-right: 5px;
    color: white;
    font-size: 12px;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-action.edit {
    background: rgba(251, 191, 36, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.3);
}

.btn-action.edit:hover {
    background: rgba(251, 191, 36, 0.3);
    transform: translateY(-2px);
}

.btn-action.delete {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.btn-action.delete:hover {
    background: rgba(239, 68, 68, 0.3);
    transform: translateY(-2px);
}

/* Pagination Styles */
.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.pagination-wrapper {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    padding: 15px 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.pagination-wrapper ul.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 8px;
    align-items: center;
}

.pagination-wrapper ul.pagination li {
    margin: 0;
}

.pagination-wrapper ul.pagination li a,
.pagination-wrapper ul.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: all 0.3s ease;
    min-width: 45px;
    border: 1px solid transparent;
}

.pagination-wrapper ul.pagination li a {
    background: rgba(31, 41, 55, 0.6);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.pagination-wrapper ul.pagination li a:hover {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
}

.pagination-wrapper ul.pagination li.active a {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-color: #10b981;
    box-shadow: 0 2px 6px rgba(16, 185, 129, 0.4);
}

.pagination-wrapper ul.pagination li.disabled a,
.pagination-wrapper ul.pagination li.disabled span {
    background: rgba(31, 41, 55, 0.4);
    color: #6b7280;
    border-color: rgba(107, 114, 128, 0.3);
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination-wrapper ul.pagination li.disabled a:hover {
    background: rgba(31, 41, 55, 0.4);
    color: #6b7280;
    border-color: rgba(107, 114, 128, 0.3);
    transform: none;
    box-shadow: none;
}

/* First and Last buttons */
.pagination-wrapper ul.pagination li:first-child a,
.pagination-wrapper ul.pagination li:last-child a {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-color: #10b981;
    font-weight: 600;
}

.pagination-wrapper ul.pagination li:first-child a:hover,
.pagination-wrapper ul.pagination li:last-child a:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    border-color: #047857;
}

/* Previous and Next buttons */
.pagination-wrapper ul.pagination li:nth-child(2) a,
.pagination-wrapper ul.pagination li:nth-last-child(2) a {
    background: rgba(107, 114, 128, 0.3);
    color: #d1d5db;
    border-color: rgba(107, 114, 128, 0.3);
}

.pagination-wrapper ul.pagination li:nth-child(2) a:hover,
.pagination-wrapper ul.pagination li:nth-last-child(2) a:hover {
    background: rgba(107, 114, 128, 0.5);
    border-color: rgba(107, 114, 128, 0.5);
}

/* Responsive */
@media (max-width: 768px) {
    body {
        padding: 15px;
    }

    .header-bar {
        padding: 20px;
    }

    .header-bar h2 {
        font-size: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .pagination-wrapper ul.pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 5px;
    }

    .pagination-wrapper ul.pagination li a,
    .pagination-wrapper ul.pagination li span {
        padding: 8px 12px;
        font-size: 13px;
        min-width: 40px;
    }

    .pagination-wrapper {
        padding: 12px 15px;
    }

    .styled-table {
        font-size: 12px;
    }

    .styled-table th,
    .styled-table td {
        padding: 10px 8px;
    }
}

@media (max-width: 480px) {
    .pagination-wrapper ul.pagination {
        gap: 3px;
    }

    .pagination-wrapper ul.pagination li a,
    .pagination-wrapper ul.pagination li span {
        padding: 6px 10px;
        font-size: 12px;
        min-width: 35px;
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

    <!-- LIVE SEARCH INPUT -->
    <div class="card search-form">
        <h4>🔍 Search Patients</h4>
        <input type="text" id="patientSearch" placeholder="Search by first name, age or contact...">
    </div>

    <?php if ($role == 'admin'): ?>
    <!-- ADD PATIENT FORM -->
    <div class="card add-form">
        <h4>➕ Add New Patient</h4>
        <form action="<?= site_url('/patients/add') ?>" method="POST" class="form-grid" id="addPatientForm">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" required>
            </div>
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
                <input type="text" name="contact_number" required maxlength="11" placeholder="09xxxxxxxxx">
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="example@gmail.com">
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

    <!-- PATIENT TABLE -->
    <div class="card patient-list">
        <h4>📋 Patient Records</h4>
        <div class="results-info">
            <strong>
                <?php if ($total_patients > 0): ?>
                    Showing <?= $start_number ?> to <?= min($current_page * $per_page, $total_patients) ?> of <?= $total_patients ?> patients
                <?php else: ?>
                    No patients found
                <?php endif; ?>
            </strong>
        </div>

        <div class="table-container">
            <table class="styled-table" id="patientsTable">
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
                <tbody id="pagedBody">
                    <?php if (!empty($patients) && count($patients) > 0): ?>
                        <?php foreach ($patients as $i => $p): ?>
                            <tr>
                                <td><?= $start_number + $i ?></td>
                                <td><?= htmlspecialchars($p['first_name'] . ' ' . $p['last_name']) ?></td>
                                <td><?= isset($p['birth_date']) && $p['birth_date'] != '0000-00-00' ? date('M j, Y', strtotime($p['birth_date'])) : 'N/A' ?></td>
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
                                    <a href="<?= site_url('/patients/edit/' . $p['id']); ?>" class="btn-action edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= site_url('/patients/delete/' . $p['id']); ?>" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this patient?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?= $role == 'admin' ? 10 : 9 ?>" class="empty">
                                <i class="fas fa-user-slash" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
                                <br>No patients found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <?php if (isset($page) && !empty($page)): ?>
        <div class="pagination-container">
            <div class="pagination-wrapper">
                <?= $page ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- FORM VALIDATION & LIVE SEARCH -->
<script>
// ====== FORM VALIDATION ======
const form = document.getElementById('addPatientForm');
if(form) {
const firstNameInput = form.querySelector('input[name="first_name"]');
const lastNameInput = form.querySelector('input[name="last_name"]');
const contactInput = form.querySelector('input[name="contact_number"]');
const emailInput = form.querySelector('input[name="email"]');

form.addEventListener('submit', function(e){
    let errors = [];

    const requiredFields = [firstNameInput, lastNameInput, form.querySelector('input[name="birth_date"]'), form.querySelector('select[name="gender"]'), contactInput, form.querySelector('input[name="address"]'), emailInput];
    requiredFields.forEach(f=>{
        if(!f.value.trim()) errors.push(`${f.previousElementSibling.textContent} is required.`);
    });

    const nameRegex = /^[a-zA-Z\s]+$/;
    if(!nameRegex.test(firstNameInput.value.trim())) errors.push("First Name can only contain letters and spaces.");
    if(!nameRegex.test(lastNameInput.value.trim())) errors.push("Last Name can only contain letters and spaces.");

    const contactRegex = /^09\d{9}$/;
    if(!contactRegex.test(contactInput.value.trim())) errors.push("Contact Number must start with 09 and be exactly 11 digits.");

    const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if(!emailRegex.test(emailInput.value.trim())) errors.push("Email must be a valid Gmail address ending with @gmail.com.");

    if(errors.length > 0){
        e.preventDefault();
        alert(errors.join("\n"));
    }
});

[firstNameInput, lastNameInput].forEach(input=>{ input.addEventListener('input', ()=>{ input.value = input.value.replace(/[^a-zA-Z\s]/g,''); }); });
contactInput.addEventListener('input', ()=>{ contactInput.value = contactInput.value.replace(/\D/g,'').slice(0,11); });
}

// ====== LIVE SEARCH ======
const searchInput = document.getElementById('patientSearch');
const pagedBody = document.getElementById('pagedBody');
const resultsInfo = document.querySelector('.results-info strong');
const originalHTML = pagedBody.innerHTML;
const totalPatients = <?= $total_patients ?? 0 ?>;
const allPatientsData = <?= json_encode($all_patients ?? [], JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP); ?>;

searchInput.addEventListener('input', function() {
    const filter = this.value.trim().toLowerCase();
    if(filter === "") {
        pagedBody.innerHTML = originalHTML;
        resultsInfo.textContent = totalPatients > 0 ? `Showing <?= $start_number ?> to <?= min($current_page * $per_page, $total_patients) ?> of ${totalPatients} patients` : 'No patients found';
        return;
    }

    let filtered = [];
    if(/^\d+$/.test(filter)){
        filtered = allPatientsData.filter(p => (p.age ?? '').toString().startsWith(filter) || (p.contact_number ?? '').startsWith(filter));
    } else {
        filtered = allPatientsData.filter(p => (p.first_name ?? '').toLowerCase().startsWith(filter));
    }

    let output = "";
    filtered.forEach((p,index)=>{
        output += `<tr>
            <td>${index+1}</td>
            <td>${p.first_name ?? ''} ${p.last_name ?? ''}</td>
            <td>${p.birth_date && p.birth_date != '0000-00-00' ? new Date(p.birth_date).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : 'N/A'}</td>
            <td>${p.age ?? 'N/A'}</td>
            <td>${p.gender ?? ''}</td>
            <td>${p.contact_number ?? ''}</td>
            <td>${p.address ?? ''}</td>
            <td>${p.email ?? ''}</td>
            <td><span class="badge ${p.status=='Monitored'?'badge-success':'badge-gray'}">${p.status ?? ''}</span></td>
            <?php if($role=='admin'): ?>
            <td>
                <a href="<?= site_url('/patients/edit/') ?>${p.id}" class="btn-action edit"><i class="fas fa-edit"></i> Edit</a>
                <a href="<?= site_url('/patients/delete/') ?>${p.id}" class="btn-action delete" onclick="return confirm('Are you sure you want to delete this patient?');"><i class="fas fa-trash"></i> Delete</a>
            </td>
            <?php endif; ?>
        </tr>`;
    });

    if(filtered.length === 0) {
        output = `<tr><td colspan="<?= $role == 'admin' ? 10 : 9 ?>" class="empty">
            <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
            <br>No patients match your search
        </td></tr>`;
    }

    pagedBody.innerHTML = output;
    resultsInfo.textContent = filtered.length>0 ? `Showing 1 to ${filtered.length} of ${filtered.length} patients` : 'No patients found';
});
</script>
</body>
</html>