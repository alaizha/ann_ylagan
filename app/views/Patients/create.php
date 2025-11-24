<div class="container mt-5">
    <h2>Add New Patient</h2>

    <form method="POST" action="<?= site_url('patients/add') ?>">

        <input type="text" name="first_name" placeholder="First Name" required class="form-control mb-2">

        <input type="text" name="last_name" placeholder="Last Name" required class="form-control mb-2">

        <!-- Birth Date (replaces Age) -->
        <input type="date" name="birth_date" required class="form-control mb-2" 
               max="<?= date('Y-m-d') ?>" placeholder="Birth Date">

        <select name="gender" class="form-control mb-2">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <input type="text" name="contact_number" placeholder="Contact Number" class="form-control mb-2">

        <input type="text" name="address" placeholder="Address" class="form-control mb-2">

        <input type="email" name="email" placeholder="Email" class="form-control mb-2">

        <!-- Status dropdown (instead of text field) -->
        <select name="status" class="form-control mb-3">
            <option value="Monitored">Monitored</option>
            <option value="Discharged">Discharged</option>
        </select>

        <button type="submit" class="btn btn-success">💾 Save</button>
        <a href="<?= site_url('patients') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
