<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Appointment</h3>
                    <a href="<?= site_url('appointments') ?>" class="btn btn-secondary float-right">Back to Appointments</a>
                </div>
                <div class="card-body">

                    <form action="<?= site_url('appointments/edit/'.$appointment['id']) ?>" method="POST">

                        <div class="form-group">
                            <label>Patient</label>
                            <select name="patient_id" class="form-control" required>
                                <option value="">Select Patient</option>
                                <?php foreach($patients as $patient): ?>
                                <option value="<?= $patient['id'] ?>"
                                    <?= $patient['id'] == $appointment['patient_id'] ? 'selected' : '' ?>>
                                    <?= $patient['first_name'] ?> <?= $patient['last_name'] ?> (ID: <?= $patient['id'] ?>)
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="appointment_date" class="form-control"
                                value="<?= $appointment['appointment_date'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Time</label>
                            <input type="time" name="appointment_time" class="form-control"
                                value="<?= $appointment['appointment_time'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Purpose</label>
                            <input type="text" name="purpose" class="form-control"
                                value="<?= $appointment['purpose'] ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Pending"   <?= $appointment['status']=='Pending' ? 'selected':'' ?>>Pending</option>
                                <option value="Confirmed" <?= $appointment['status']=='Confirmed' ? 'selected':'' ?>>Confirmed</option>
                                <option value="Cancelled" <?= $appointment['status']=='Cancelled' ? 'selected':'' ?>>Cancelled</option>
                                <option value="Completed" <?= $appointment['status']=='Completed' ? 'selected':'' ?>>Completed</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Update Appointment</button>
                            <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">Cancel</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
