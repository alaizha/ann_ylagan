<?php defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Blockchain Transaction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a2332 0%, #0f1419 100%);
            min-height: 100vh;
            padding: 30px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: float 10s ease-in-out infinite reverse;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        .container {
            width: 100%;
            max-width: 750px;
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(16, 185, 129, 0.2);
            animation: fadeIn 0.6s ease;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
            border-radius: 18px 18px 0 0;
        }

        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        h1 {
            font-size: 2rem;
            margin: 0;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .content {
            padding: 35px 40px;
        }

        .back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .back:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateX(-5px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.5);
        }

        label {
            color: #d1d5db;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        input, select, textarea {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 0.95rem;
            background: rgba(31, 41, 55, 0.5);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #e5e7eb;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(31, 41, 55, 0.8);
            transform: translateY(-2px);
        }

        input::placeholder, textarea::placeholder {
            color: #9ca3af;
        }

        select {
            cursor: pointer;
        }

        option {
            background: #1f2937;
            color: #e5e7eb;
        }

        .btn-save {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 15px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            letter-spacing: 0.5px;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .content {
                padding: 25px 20px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }

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
    <div class="header">
        <h1><i class="fas fa-cubes"></i> Add Transaction</h1>
    </div>

    <div class="content">
        <a href="<?php echo site_url('blockchain'); ?>" class="back">
            <i class="fas fa-arrow-left"></i> Back to Transactions
        </a>

        <form action="<?php echo site_url('blockchain/store'); ?>" method="POST">

            <label for="patient">
                <i class="fas fa-user"></i> Patient Name
            </label>
            <select id="patient" name="patient" required>
                <option value="">-- Select Patient --</option>
                <?php foreach($patients as $p): ?>
                    <option value="<?= $p['id']; ?>">
                        <?= $p['first_name'] . " " . $p['last_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="amount">
                <i class="fas fa-peso-sign"></i> Amount (₱)
            </label>
            <input type="number" id="amount" name="amount" min="1" placeholder="0.00" step="0.01" required>

            <label for="description">
                <i class="fas fa-file-alt"></i> Description
            </label>
            <textarea id="description" name="description" rows="4" placeholder="Transaction details..." required></textarea>

            <label for="status">
                <i class="fas fa-info-circle"></i> Status
            </label>
            <select id="status" name="status" required>
                <option value="pending">⏳ Pending</option>
                <option value="confirmed">✅ Confirmed</option>
                <option value="failed">❌ Failed</option>
            </select>

            <button class="btn-save" type="submit">
                <i class="fas fa-save"></i> Save Transaction
            </button>

        </form>
    </div>

</div>
</body>
</html>