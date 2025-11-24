<!DOCTYPE html>
<html>
<head>
    <title>Edit IoT Device</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 60px auto;
            background: #fff;
            padding: 25px 30px;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin: 6px 0 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            text-align: center;
            width: 100%;
            margin-top: 10px;
            text-decoration: none;
            color: #555;
            font-size: 14px;
        }

        a:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit IoT Device</h2>

        <form method="POST" action="<?= site_url('/iot-devices/update/' . $device['device_id']); ?>">
            <label>Device ID:</label>
            <input type="text" name="device_id" value="<?= $device['device_id']; ?>" readonly>

            <label>Type:</label>
            <input type="text" name="type" value="<?= $device['type']; ?>">

            <label>Patient:</label>
            <input type="text" name="patient" value="<?= $device['patient']; ?>">

            <label>Status:</label>
            <select name="status">
                <option value="Connected" <?= ($device['status'] == 'Connected') ? 'selected' : ''; ?>>Connected</option>
                <option value="Disconnected" <?= ($device['status'] == 'Disconnected') ? 'selected' : ''; ?>>Disconnected</option>
            </select>

            <button type="submit">Update Device</button>
            <a href="<?= site_url('/iot-devices'); ?>">← Cancel</a>
        </form>
    </div>
</body>
</html>
