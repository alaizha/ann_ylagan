<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment - HIV Treatment Monitoring System</title>
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
            color: #ffffff;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
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
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            animation: float 10s ease-in-out infinite reverse;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, -20px); }
        }

        .container-fluid {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeIn 0.6s ease;
            color: #ffffff;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 20px 30px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 35px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            color: #ffffff;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.5);
        }

        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            background: rgba(31, 41, 55, 0.7);
            color: #ffffff !important;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control::placeholder {
            color: #d1d5db;
            opacity: 1;
        }

        .form-control:focus {
            border-color: #10b981;
            background: rgba(31, 41, 55, 0.9);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            transform: translateY(-2px);
            color: #ffffff !important;
        }

        .form-control::selection {
            background: #10b981;
            color: #ffffff;
        }

        select.form-control {
            cursor: pointer;
        }

        .form-control option {
            background: #1f2937;
            color: #ffffff;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px rgba(31, 41, 55, 0.7) inset;
            -webkit-text-fill-color: #ffffff !important;
        }

        .mt-3 {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .mt-3 {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
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
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Appointment
                </h3>
                <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Appointments
                </a>
            </div>
            <div class="card-body">

                <form action="<?= site_url('appointments/edit/'.$appointment['id']) ?>" method="POST">

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Patient</label>
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
                        <label><i class="fas fa-calendar"></i> Date</label>
                        <input type="date" 
                            name="appointment_date" 
                            class="form-control"
                            value="<?= $appointment['appointment_date'] ?>"
                            min="<?= date('Y-m-d') ?>" 
                            required
                        >

                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-clock"></i> Time</label>
                        <input type="time" name="appointment_time" class="form-control"
                            value="<?= $appointment['appointment_time'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-clipboard"></i> Purpose</label>
                        <input type="text" name="purpose" class="form-control"
                            value="<?= $appointment['purpose'] ?>" required placeholder="Enter purpose">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-info-circle"></i> Status</label>
                        <select name="status" class="form-control" required>
                            <option value="Pending"   <?= $appointment['status']=='Pending' ? 'selected':'' ?>>Pending</option>
                            <option value="Confirmed" <?= $appointment['status']=='Confirmed' ? 'selected':'' ?>>Confirmed</option>
                            <option value="Cancelled" <?= $appointment['status']=='Cancelled' ? 'selected':'' ?>>Cancelled</option>
                            <option value="Completed" <?= $appointment['status']=='Completed' ? 'selected':'' ?>>Completed</option>
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Appointment
                        </button>
                        <a href="<?= site_url('appointments') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>
</html>
