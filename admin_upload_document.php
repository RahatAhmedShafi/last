<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_id = 1; // Assuming admin ID is 1
    $customer_id = intval($_POST['customer_id']);
    $document_name = $_POST['document_name'];
    $file = $_FILES['document'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $upload_dir = "uploads/"; // Directory to store uploaded files

        // Create uploads directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Save file to the upload directory
        $file_path = $upload_dir . basename($file_name);
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Insert file info into the database
            $sql = "INSERT INTO documents (admin_id, customer_id, document_name, file_path) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiss", $admin_id, $customer_id, $document_name, $file_path);

            if ($stmt->execute()) {
                $success_message = "Document uploaded successfully!";
            } else {
                $error_message = "Failed to upload document.";
            }

            $stmt->close();
        } else {
            $error_message = "Failed to move uploaded file.";
        }
    } else {
        $error_message = "Error during file upload.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input, .form-container textarea, .form-container select {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #0056b3;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Upload Document</h2>
        <?php if (!empty($error_message)): ?>
            <div class="message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="message" style="color: green;"><?= htmlspecialchars($success_message) ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="customer_id" placeholder="Customer ID" required>
            <input type="text" name="document_name" placeholder="Document Name" required>
            <input type="file" name="document" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
