<!DOCTYPE html>
<html>
<head>
<title>Transaction Receipt</title>
<style>
    body {
        font-family: "Courier New", monospace;
        padding: 20px;
        background: #f2f2f2;
    }

    /* Outer border wrapper */
    .outer-border {
        border: 2px dashed #333;
        padding: 10px;
        display: inline-block;
        background: #fff;
    }

    .receipt-container {
        width: 320px;
        margin: auto;
        padding: 20px;
    }

    .center {
        text-align: center;
    }

    .title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .subtitle {
        font-size: 12px;
        margin-bottom: 15px;
    }

    .line {
        border-bottom: 1px dashed #000;
        margin: 10px 0;
    }

    .row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin: 5px 0;
    }

    small {
        font-size: 11px;
    }

    @media print {
        body { background: white; }
        .outer-border {
            border: 2px dashed #000;
        }
    }
</style>
</head>

<body>

<div class="center">
    <div class="outer-border">
        <div class="receipt-container">

            <div class="center">
                <div class="title">HIV TREATMENT CLINIC</div>
                <div class="subtitle">Official Payment Receipt</div>
            </div>

            <div class="line"></div>

            <div class="row">
                <span>Transaction No:</span>
                <span><?= $transaction['tx_no']; ?></span>
            </div>

            <div class="row">
                <span>Patient:</span>
                <span><?= $transaction['patient_name']; ?></span>
            </div>

            <div class="row">
                <span>Description:</span>
                <span><?= $transaction['description']; ?></span>
            </div>

            <div class="row">
                <span>Amount:</span>
                <span>₱<?= number_format($transaction['amount'], 2); ?></span>
            </div>

            <div class="row">
                <span>Status:</span>
                <span><?= ucfirst($transaction['status']); ?></span>
            </div>

            <div class="line"></div>

            <div class="center">
                <small>Date Issued: <?= date("M d, Y h:i A", strtotime($transaction['created_at'])); ?></small>
                <br>
                <small>Thank you for your payment.</small>
            </div>

            <div class="line"></div>

            <div class="center">
                <small>*** This serves as your official receipt ***</small>
            </div>

        </div>
    </div>
</div>

<script>
window.print();
</script>

</body>
</html>