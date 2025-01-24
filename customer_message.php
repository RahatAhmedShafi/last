<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in customer's ID
$customer_id = $_SESSION['customer_id'];
$admin_id = 1; // Assuming admin's ID is 1

// Handle message sending
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);

    if (!empty($message)) {
        // Insert the message into the database
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, is_admin_reply) VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $customer_id, $admin_id, $message);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch messages between the customer and admin
$sql = "SELECT 
            sender_id, 
            message, 
            timestamp, 
            is_admin_reply 
        FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) 
           OR (sender_id = ? AND receiver_id = ?) 
        ORDER BY timestamp ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $customer_id, $admin_id, $admin_id, $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}
$stmt->close();

// Fetch documents uploaded by the admin for the customer
// Fetch documents
$user_id = $_SESSION['customer_id']; // Assuming user_id is stored in session
$sql = "SELECT document_name, file_path, uploaded_at FROM documents WHERE customer_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$documents = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .chat-container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .chat-header {
            background-color: #007BFF;
            color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8f9fa;
        }
        .chat-messages .message {
            margin-bottom: 15px;
        }
        .chat-messages .message.customer {
            text-align: right;
        }
        .chat-messages .message.admin {
            text-align: left;
        }
        .chat-messages .message .text {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 12px;
            max-width: 70%;
            font-size: 14px;
            line-height: 1.4;
        }
        .chat-messages .message.customer .text {
            background-color: #007BFF;
            color: #ffffff;
        }
        .chat-messages .message.admin .text {
            background-color: #e9ecef;
            color: #333333;
        }
        .documents {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #ffffff;
        }
        .documents h3 {
            margin-bottom: 10px;
        }
        .documents ul {
            list-style: none;
            padding: 0;
        }
        .documents ul li {
            margin-bottom: 10px;
        }
        .documents ul li a {
            color: #007BFF;
            text-decoration: none;
        }
        .documents ul li a:hover {
            text-decoration: underline;
        }
        .chat-form {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #ffffff;
        }
        .chat-form input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .chat-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .chat-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            Chat with Admin
        </div>
        <div class="chat-messages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?= $message['is_admin_reply'] ? 'admin' : 'customer' ?>">
                    <div class="text">
                        <?= htmlspecialchars($message['message']) ?>
                    </div>
                    <div style="font-size: 12px; color: #999; margin-top: 5px;">
                        <?= htmlspecialchars($message['timestamp']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="documents">
            <h3>Uploaded Documents</h3>
            <ul>
                <?php foreach ($documents as $doc): ?>
                    <li>
                        <a href="<?= htmlspecialchars($doc['file_path']); ?>" download><?= htmlspecialchars($doc['document_name']); ?></a>
                        <span style="font-size: 12px; color: #999;">(Uploaded: <?= htmlspecialchars($doc['uploaded_at']); ?>)</span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <form method="POST" action="" class="chat-form">
            <input type="text" name="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
