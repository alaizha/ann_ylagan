<h2>User Management (Admin Only)</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    <?php foreach ($users as $u): ?>
    <tr>
        <td><?= $u->name ?></td>
        <td><?= $u->email ?></td>
        <td><?= $u->role ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="<?php echo base_url('dashboard'); ?>">Back to Dashboard</a>
