<!DOCTYPE html>
<html>
<head>
<title>Transaction Receipt</title>
<style>
body { font-family: Arial; padding: 40px; }
.receipt-box {
    border: 1px solid #333;
    padding: 20px;
    width: 400px;
    margin: auto;
}
</style>
</head>
<body>

<div class="receipt-box">
    <h2>Payment Receipt</h2>
    <p><strong>Transaction No:</strong> <?= $transaction['tx_no']; ?></p>
    <p><strong>Patient:</strong> <?= $transaction['patient_name']; ?></p>
    <p><strong>Description:</strong> <?= $transaction['description']; ?></p>
    <p><strong>Amount:</strong> ₱<?= number_format($transaction['amount'], 2); ?></p>
    <p><strong>Status:</strong> <?= ucfirst($transaction['status']); ?></p>
    <hr>
    <p><small>Date: <?= $transaction['created_at']; ?></small></p>
</div>

<script>
window.print();
</script>

</body>
</html>
