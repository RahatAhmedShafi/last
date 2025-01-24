<?php
// signup.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $contact_info = $_POST['contact_info']; // Collect contact info
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security

    // Check if the customer ID already exists
    $check_sql = "SELECT customer_id FROM customers WHERE customer_id = ?";
    if ($stmt = $conn->prepare($check_sql)) {
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_message = "Customer ID already exists. Please choose a different ID.";
        } else {
            // Insert the new customer into the database
            $insert_sql = "INSERT INTO customers (customer_id, customer_name, contact_info, password) VALUES (?, ?, ?, ?)";
            if ($insert_stmt = $conn->prepare($insert_sql)) {
                $insert_stmt->bind_param("isss", $customer_id, $customer_name, $contact_info, $password);

                if ($insert_stmt->execute()) {
                    header("Location: loginCustomer.php"); // Redirect to login page after successful signup
                    exit();
                } else {
                    $error_message = "Error: " . $conn->error;
                }
                $insert_stmt->close();
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .signup-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .signup-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .signup-container input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        .signup-container input[type="submit"]:hover {
            background: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
        }
        .btn-container a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Signup</h2>
        <?php if (isset($error_message)) echo "<div class='error'>$error_message</div>"; ?>
        <form method="POST">
            <input type="text" name="customer_id" placeholder="Customer ID" required>
            <input type="text" name="customer_name" placeholder="Customer Name" required>
            <input type="text" name="contact_info" placeholder="Contact Information" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Signup">
        </form>
        <div class="btn-container">
            <a href="loginCustomer.php">Already have an account? Login here</a>
        </div>
    </div>
</body>
</html>
