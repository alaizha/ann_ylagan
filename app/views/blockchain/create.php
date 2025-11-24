<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Blockchain Transaction</title>
    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            padding: 30px;
            display: flex;
            justify-content: center;
        }
        .container {
            width: 100%;
            max-width: 700px;
            background: #fff;
            border-radius: 8px;
            padding: 25px 35px;
            border: 1px solid #ddd;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }
        label {
            font-weight: 600;
            color: #444;
            margin-bottom: 6px;
            display: block;
        }
        input, select, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background: #fff;
            margin-bottom: 18px;
            font-size: 14px;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #377dff;
            outline: none;
        }
        .btn-save {
            width: 100%;
            background: #377dff;
            color: #fff;
            padding: 12px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-save:hover {
            background: #2f6de0;
        }
        .back {
            display: inline-block;
            margin-bottom: 15px;
            color: #377dff;
            text-decoration: none;
            font-size: 14px;
        }
        .back:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
<div class="container">

    <a href="<?php echo site_url('blockchain'); ?>" class="back">← Back to Transactions</a>
    <h1>Add Transaction</h1>

    <form action="<?php echo site_url('blockchain/store'); ?>" method="POST">

        <label for="patient">Patient Name</label>
        <select id="patient" name="patient" required>
            <option value="">-- Select Patient --</option>
            <?php foreach($patients as $p): ?>
                <option value="<?= $p['id']; ?>">
                    <?= $p['first_name'] . " " . $p['last_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="amount">Amount (₱)</label>
        <input type="number" id="amount" name="amount" min="1" placeholder="0.00" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3" placeholder="Transaction details..." required></textarea>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="failed">Failed</option>
        </select>

        <button class="btn-save" type="submit">Save Transaction</button>

    </form>
</div>
</body>
</html>
