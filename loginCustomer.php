<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Handle the case where 'user_id' is not set, e.g., redirect or display an error message.
}

// Initialize variables for error message
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data
    $customer_id = trim($_POST['customer_id']);
    $password = trim($_POST['password']);
    
    // Validate input
    if (empty($customer_id) || empty($password)) {
        $error_message = "Both fields are required.";
    } else {
        // Query to fetch customer data
        $sql = "SELECT password FROM customers WHERE customer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            // Bind the result
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashed_password)) {
                // Login successful, redirect to dashboard
                session_start();
                $_SESSION['customer_id'] = $customer_id;
                header("Location: service.php");
                exit();
            } else {
                $error_message = "Invalid Customer ID or Password.";
            }
        } else {
            $error_message = "Invalid Customer ID or Password.";
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
    <title>Login</title>
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
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .login-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .login-container input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .login-container input[type="submit"]:hover {
            background: #0056b3;
        }
        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <!-- Display error message if any -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?= $error_message; ?></div>
        <?php endif; ?>
        
        <!-- Login form -->
        <form method="POST" action="">
            <input type="text" name="customer_id" placeholder="Customer ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
