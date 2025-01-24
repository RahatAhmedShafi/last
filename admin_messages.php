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

// Fetch all messages
$messages = [];
$sql = "SELECT m.message_id, m.message, m.timestamp, m.is_admin_reply, 
               c.customer_id AS sender_id
        FROM messages m
        LEFT JOIN customers c ON m.sender_id = c.customer_id
        ORDER BY m.timestamp DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

// Handle admin replies
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reply = trim($_POST['reply']);
    $message_id = $_POST['message_id'];
    $admin_id = 1; // Assume admin ID is 1

    if (!empty($reply)) {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, is_admin_reply) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $admin_id, $message_id, $reply);

        if ($stmt->execute()) {
            $success_message = "Reply sent successfully.";
        } else {
            $error_message = "Failed to send the reply.";
        }
        $stmt->close();
    } else {
        $error_message = "Reply cannot be empty.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Messages</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa;">
    <div style="max-width: 800px; margin: 20px auto; background: #fff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); padding: 20px;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Admin Messages</h2>
        
        <!-- Error and Success Messages -->
        <?php if (!empty($error_message)): ?>
            <div style="color: red; text-align: center; margin-bottom: 10px;"><?= $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div style="color: green; text-align: center; margin-bottom: 10px;"><?= $success_message; ?></div>
        <?php endif; ?>

        <ul style="list-style: none; padding: 0; margin: 0;">
            <?php foreach ($messages as $message): ?>
                <li style="margin-bottom: 20px; padding: 15px; background-color: #f1f1f1; border-radius: 8px;">
                    <strong style="display: block; margin-bottom: 10px; color: #555;">Customer <?= $message['sender_id']; ?>:</strong>
                    <p style="margin: 0; padding: 0 0 10px; color: #333;"><?= htmlspecialchars($message['message']); ?></p>
                    
                    <form method="POST" style="display: flex; flex-direction: column;">
                        <input type="hidden" name="message_id" value="<?= $message['sender_id']; ?>">
                        <textarea name="reply" placeholder="Type your reply..." required 
                                  style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; resize: none;"></textarea>
                        <button type="submit" 
                                style="background-color: #007BFF; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                            Reply
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
