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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the customer_id and customer_name from the form input
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];

    // Query to get customer information
    $customer_sql = "SELECT customer_id, customer_name, contact_info FROM customers WHERE customer_id = ? AND customer_name = ?";
    if ($stmt = $conn->prepare($customer_sql)) {
        // Bind parameters to the prepared statement
        $stmt->bind_param("is", $customer_id, $customer_name);
        
        // Execute the query
        $stmt->execute();
        
        // Bind result variables
        $stmt->bind_result($cust_id, $cust_name, $cust_info);
        
        // Display results with responsive inline CSS
        echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>";
        
        if ($stmt->fetch()) {
            // Customer found, display their details
            echo "<h2 style='text-align: center; color: #333;'>Customer Information</h2>";
            echo "<p><strong>Customer ID:</strong> " . htmlspecialchars($cust_id) . "</p>";
            echo "<p><strong>Customer Name:</strong> " . htmlspecialchars($cust_name) . "</p>";
           
            
            echo "<p style='color: green; font-weight: bold; text-align: center;'>Transaction Successful!</p>";
            
            // Add a Home button after successful transaction
            echo "<div style='text-align: center; margin-top: 20px;'>
                    <a href='index.php' style='padding: 10px 20px; background-color: #007BFF; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;'>Go to Home</a>
                  </div>";
        } else {
            // No customer found
            echo "<p style='color: red; text-align: center;'>No customer found with this ID and Name.</p>";
        }
        
        echo "</div>";

        // Close the customer statement
        $stmt->close();
    } else {
        echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 20px auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>";
        echo "<p style='color: red; text-align: center;'>Error fetching customer: " . htmlspecialchars($conn->error) . "</p>";
        echo "</div>";
    }
}

// Close the connection
$conn->close();
?>
