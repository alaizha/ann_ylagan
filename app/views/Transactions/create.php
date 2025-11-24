<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Blockchain Billing - Create Transaction</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #4c1d95 0%, #0f172a 100%);
            min-height: 100vh;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .container {
            width: 100%;
            max-width: 900px;
            border-radius: 18px;
            overflow: hidden;
            background: #1e293b;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }

        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            color: white;
            text-align: center;
            padding: 35px 20px;
            position: relative;
        }

        .back-button {
            position: absolute;
            left: 25px;
            top: 50%;
            transform: translateY(-50%);
            background: #10b981;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            color: white;
            transition: .3s ease;
        }

        .back-button:hover {
            background: #059669;
            transform: translateY(-50%) translateX(-7px);
            box-shadow: 0 0 12px rgba(16,185,129,0.6);
        }

        h1 {
            font-size: 2.3rem;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .content {
            padding: 35px 45px;
        }

        .form-card {
            background: #334155;
            padding: 35px;
            border-radius: 12px;
            border: 2px solid #475569;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
        }

        label {
            color: #e2e8f0;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
        }

        input, select, textarea {
            width: 100%;
            padding: 16px;
            margin-bottom: 23px;
            border-radius: 10px;
            font-size: 1rem;
            background: #1e293b;
            border: 2px solid #475569;
            color: #f8fafc;
            transition: .3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 12px rgba(59,130,246,.4);
            outline: none;
        }

        .submit-btn {
            width: 100%;
            font-size: 1.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #10b981 0%, #0f9d68 100%);
            color: white;
            padding: 18px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            transition: .35s;
            letter-spacing: 0.5px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(16,185,129,0.4);
        }

    </style>
</head>

<body>
<div class="container">
    <div class="header">
        <a href="<?php echo site_url('transactions'); ?>" class="back-button">← Back</a>
        <h1>💰 Blockchain Billing</h1>
        <p>Add New Secure Transaction</p>
    </div>

    <div class="content">
        <div class="form-card">
            <form action="<?php echo site_url('transactions/add'); ?>" method="POST">

                <!-- Patient Dropdown CORRECT -->
                <label for="patient_id">Select Patient</label>
                <select id="patient_id" name="patient_id" required>
<label for="patient_id">Select Patient</label>
<select id="patient_id" name="patient_id" required>
    <?php foreach($patients as $p): ?>
        <option value="<?= $p['patient_id']; ?>"><?= $p['name']; ?></option>
    <?php endforeach; ?>
</select>


                <label for="service">Service</label>
                <input type="text" id="service" name="service" placeholder="Ex: Consultation / Lab Test" required>

                <label for="amount">Amount (₱)</label>
                <input type="number" id="amount" name="amount" min="1" placeholder="0.00" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Transaction details..." required></textarea>

                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="Pending">⏳ Pending</option>
                    <option value="Confirmed">✅ Confirmed</option>
                </select>

                <button class="submit-btn" type="submit">🚀 Submit Transaction</button>

            </form>

        </div>
    </div>

</div>
</body>
</html>
