<h2>My Account</h2>

<p><strong>Name:</strong> <?= $user->name ?></p>
<p><strong>Email:</strong> <?= $user->email ?></p>
<p><strong>Role:</strong> <?= $user->role ?></p>

<a href="<?php echo base_url('dashboard'); ?>">Back to Dashboard</a>
