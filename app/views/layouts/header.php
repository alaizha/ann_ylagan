<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HIV Treatment Monitoring System</title>

    <!-- Existing CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/style.css">

    <!-- ✅ Add Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Optional Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    .main-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 25px 30px;
        color: #e2e8f0;
        margin-bottom: 30px;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        text-align: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(74, 226, 155, 0.2);
        backdrop-filter: blur(10px);
    }

    .main-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(74, 226, 155, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(74, 226, 155, 0.05) 0%, transparent 50%),
            url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(74, 226, 155, 0.08)" points="0,1000 1000,0 1000,1000"/></svg>');
    }

    .main-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        margin: 0 0 10px 0;
        background: linear-gradient(135deg, #4ae29b 0%, #06d6a0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        z-index: 1;
        text-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .main-header p {
        margin: 0;
        opacity: 0.9;
        font-weight: 500;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
        color: #cbd5e1;
        letter-spacing: 0.5px;
    }

    .main-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #4ae29b, transparent);
        border-radius: 2px;
    }
</style>

<div class="main-header">
    <h1>HIV Treatment System Dashboard</h1>
    <p>Monitor patient status, appointments, and system metrics</p>
</div>