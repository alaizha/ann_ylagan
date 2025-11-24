<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction | HIV Treatment Monitoring</title>
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
            color: #e5e7eb;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 650px;
            margin: 40px auto;
        }

        .card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 15px;
            padding: 35px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.5), transparent);
            margin-bottom: 30px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #d1d5db;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 10px;
            background: rgba(31, 41, 55, 0.6);
            color: #e5e7eb;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(31, 41, 55, 0.8);
        }

        select.form-control {
            cursor: pointer;
        }

        select.form-control option {
            background: #1f2937;
            color: #e5e7eb;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.6);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .button-group .btn {
            flex: 1;
        }

        /* Input number arrows styling */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                margin: 20px auto;
            }

            .card {
                padding: 25px 20px;
            }

            h3 {
                font-size: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
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
    <div class="container">
        <div class="card">
            <h3>
                <i class="fas fa-edit" style="color: #10b981;"></i>
                Edit Blockchain Transaction
            </h3>
            <hr>

            <form action="<?= site_url('blockchain/update/' . $transaction['id']); ?>" method="POST">

                <div class="mb-3">
                    <label><i class="fas fa-user me-2"></i>Patient Name</label>
                    <select name="patient" class="form-control" required>
                        <?php foreach ($patients as $p): ?>
                            <option value="<?= $p['id']; ?>" <?= ($p['id'] == $transaction['patient_id']) ? 'selected' : ''; ?>>
                                <?= $p['first_name'] . " " . $p['last_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label><i class="fas fa-peso-sign me-2"></i>Amount (₱)</label>
                    <input type="number" name="amount" class="form-control" value="<?= $transaction['amount']; ?>" required step="0.01" min="0">
                </div>

                <div class="mb-3">
                    <label><i class="fas fa-file-alt me-2"></i>Description</label>
                    <textarea name="description" class="form-control" required placeholder="Enter transaction description"><?= $transaction['description']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label><i class="fas fa-info-circle me-2"></i>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending"   <?= ($transaction['status']=="pending")?'selected':''; ?>>Pending</option>
                        <option value="confirmed" <?= ($transaction['status']=="confirmed")?'selected':''; ?>>Confirmed</option>
                        <option value="failed"    <?= ($transaction['status']=="failed")?'selected':''; ?>>Failed</option>
                    </select>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="<?= site_url('blockchain'); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>