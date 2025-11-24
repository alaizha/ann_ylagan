<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit IoT Device | HIV Treatment Monitoring</title>
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
            max-width: 500px;
            margin: 60px auto;
        }

        .card {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 15px;
            padding: 35px 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #d1d5db;
            font-size: 14px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 10px;
            background: rgba(31, 41, 55, 0.6);
            color: #e5e7eb;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            background: rgba(31, 41, 55, 0.8);
        }

        input[readonly] {
            background: rgba(31, 41, 55, 0.4);
            cursor: not-allowed;
            opacity: 0.7;
        }

        select {
            cursor: pointer;
        }

        select option {
            background: #1f2937;
            color: #e5e7eb;
        }

        button {
            width: 100%;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        }

        a {
            display: block;
            text-align: center;
            width: 100%;
            margin-top: 15px;
            padding: 10px;
            text-decoration: none;
            color: #d1d5db;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 10px;
            background: rgba(107, 114, 128, 0.2);
            border: 1px solid rgba(107, 114, 128, 0.3);
        }

        a:hover {
            color: #e5e7eb;
            background: rgba(107, 114, 128, 0.3);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                margin: 30px auto;
            }

            .card {
                padding: 25px 20px;
            }

            h2 {
                font-size: 1.5rem;
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
            <h2>
                <i class="fas fa-microchip" style="color: #10b981;"></i>
                Edit IoT Device
            </h2>

            <form method="POST" action="<?= site_url('/iot-devices/update/' . $device['device_id']); ?>">
                <label>Device ID:</label>
                <input type="text" name="device_id" value="<?= $device['device_id']; ?>" readonly>

                <label>Type:</label>
                <input type="text" name="type" value="<?= $device['type']; ?>" placeholder="Enter device type">

                <label>Patient:</label>
                <input type="text" name="patient" value="<?= $device['patient']; ?>" placeholder="Enter patient name">

                <label>Status:</label>
                <select name="status">
                    <option value="Connected" <?= ($device['status'] == 'Connected') ? 'selected' : ''; ?>>Connected</option>
                    <option value="Disconnected" <?= ($device['status'] == 'Disconnected') ? 'selected' : ''; ?>>Disconnected</option>
                    <option value="Maintenance" <?= ($device['status'] == 'Maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                </select>

                <button type="submit">
                    <i class="fas fa-save"></i> Update Device
                </button>
                <a href="<?= site_url('/iot-devices'); ?>">
                    <i class="fas fa-arrow-left"></i> Cancel
                </a>
            </form>
        </div>
    </div>
</body>
</html>