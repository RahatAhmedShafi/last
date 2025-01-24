<?php
// Start session to handle session variables if needed
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the form data
    $fullName = htmlspecialchars(strip_tags(trim($_POST['fullName'])));
    $email = htmlspecialchars(strip_tags(trim($_POST['email'])));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));
    $additionalInfo = htmlspecialchars(strip_tags(trim($_POST['additionalInfo'])));

    // Initialize an array to store errors
    $errors = [];

    // Validate the form fields
    if (empty($fullName)) {
        $errors[] = "Full name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }
    if (empty($message)) {
        $errors[] = "Message cannot be empty.";
    }

    // If there are no errors, proceed to store the response in the database
    if (empty($errors)) {
        // Database connection
        $servername = "localhost";  // Change this to your database server
        $username = "root";         // Change this to your database username
        $password = "";             // Change this to your database password
        $dbname = "projmr1"; // Change this to your database name

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query to insert the form data into the database
        $sql = "INSERT INTO contact_form_responses (full_name, email, phone, message, additional_info) 
                VALUES (?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = $conn->prepare($sql);

        // Bind the form data to the SQL query
        $stmt->bind_param("sssss", $fullName, $email, $phone, $message, $additionalInfo);

        // Execute the query
        if ($stmt->execute()) {
            // Success message
            $_SESSION['success'] = "Thank you for contacting us! We will get back to you soon.";
            header("Location: index.php#contact");
        } else {
            // Failure message
            $_SESSION['error'] = "There was an error submitting your form. Please try again.";
            header("Location: index.php#contact");
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Store errors in session
        $_SESSION['errors'] = $errors;
        header("Location: index.php#contact");
    }
} else {
    // Invalid request
    $_SESSION['error'] = "Invalid request.";
    header("Location: index.php#contact");
}
?>
