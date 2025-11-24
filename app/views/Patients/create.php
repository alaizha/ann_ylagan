<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
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
            color: #e5e7eb;
            min-height: 100vh;
            padding: 40px 20px;
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

        .container {
            max-width: 700px;
            margin: 0 auto;
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
            padding: 30px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .content {
            padding: 35px 40px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid rgba(16, 185, 129, 0.3);
            background: rgba(31, 41, 55, 0.5);
            color: #e5e7eb;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            border-color: #10b981;
            background: rgba(31, 41, 55, 0.8);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        select.form-control {
            cursor: pointer;
        }

        option {
            background: #1f2937;
            color: #e5e7eb;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(107, 114, 128, 0.5);
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .content {
                padding: 25px 20px;
            }

            .button-group {
                flex-direction: column;
            }

            h2 {
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
            <h2>
                <i class="fas fa-user-plus"></i> Add New Patient
            </h2>
        </div>

        <div class="content">
            <form method="POST" action="<?= site_url('patients/add') ?>">

                <input type="text" name="first_name" placeholder="First Name" required class="form-control">

                <input type="text" name="last_name" placeholder="Last Name" required class="form-control">

                <input type="date" name="birth_date" required class="form-control" 
                       max="<?= date('Y-m-d') ?>" placeholder="Birth Date">

                <select name="gender" class="form-control">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <input type="text" name="contact_number" placeholder="Contact Number" class="form-control">

                <input type="text" name="address" placeholder="Address" class="form-control">

                <input type="email" name="email" placeholder="Email" class="form-control">

                <select name="status" class="form-control">
                    <option value="Monitored">Monitored</option>
                    <option value="Discharged">Discharged</option>
                </select>

                <div class="button-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a href="<?= site_url('patients') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>