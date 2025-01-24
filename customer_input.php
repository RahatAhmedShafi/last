<?php
session_start(); // Start the session

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

$transaction_successful = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $customer_id = $_SESSION['customer_id']; // Get the customer ID from the session
    $customer_name = $_POST['customer_name'];
    $contact_info = $_POST['contact_info'];
    $service_id = $_POST['service_id'];
    $amount = $_POST['amount'];

    // Insert into transactions table
    $stmt = $conn->prepare("INSERT INTO transactions1 (customer_id, customer_name, contact_info, service_id, amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issii", $customer_id, $customer_name, $contact_info, $service_id, $amount);

    if ($stmt->execute()) {
        $transaction_successful = true;
        $transaction_id = $stmt->insert_id; // Get the last inserted transaction ID
        header("Location: purchase_details.php?transaction_id=$transaction_id");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch service details
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
    $result = $conn->query("SELECT * FROM services WHERE service_id = $service_id");
    $service = $result->fetch_assoc();
} else {
    die("No service selected.");
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Input</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Pay for Service: <?= htmlspecialchars($service['service_name']) ?></h2>
        <form method="POST">
            <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
            <input type="hidden" name="amount" value="<?= $service['cost'] ?>">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="contact_info" class="form-label">Contact Information</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" required>
            </div>
            <button type="submit" class="btn btn-primary">Pay</button>
            <a href="service.php" class="btn btn-primary" style="color: white; background-color: red;"><b>Cancel</b></a>
        </form>
    </div>
</body>
</html>