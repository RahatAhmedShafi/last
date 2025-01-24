<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$database = "projmr1"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transaction details
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];
    $result = $conn->query("SELECT * FROM transactions1 WHERE transaction_id = $transaction_id");
    $transaction = $result->fetch_assoc();
} else {
    die("No transaction selected.");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
        }
        .btn-primary {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Purchase Details</h2>
        <p><strong>Transaction ID:</strong> <?= htmlspecialchars($transaction['transaction_id']) ?></p>
        <p><strong>Customer Name:</strong> <?= htmlspecialchars($transaction['customer_name']) ?></p>
        <p><strong>Contact Information:</strong> <?= htmlspecialchars($transaction['contact_info']) ?></p>
        <p><strong>Service ID:</strong> <?= htmlspecialchars($transaction['service_id']) ?></p>
        <p><strong>Amount:</strong> $<?= number_format($transaction['amount'], 2) ?></p>
        <a href="index.php" class="btn btn-primary">Go to Home</a>
        <a href="service.php" class="btn btn-primary">Services</a>
    </div>
</body>
</html>