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

// Function to record transaction and fetch customer details
function recordTransaction($admin_id, $customer_id, $amount) {
    global $conn;
    
    // Prepare the SQL query to insert the transaction into the database
    $sql = "INSERT INTO transactions (admin_id, customer_id, transaction_amount) 
            VALUES (?, ?, ?)";
    
    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters
        $stmt->bind_param("iid", $admin_id, $customer_id, $amount);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Transaction successful!<br>";

            // Fetch customer details
            $customer_sql = "SELECT customer_id, customer_name, contact_info FROM customers WHERE customer_id = ?";
            if ($customer_stmt = $conn->prepare($customer_sql)) {
                // Bind the customer_id parameter
                $customer_stmt->bind_param("i", $customer_id);
                
                // Execute the customer query
                $customer_stmt->execute();
                
                // Bind result variables
                $customer_stmt->bind_result($cust_id, $cust_name);
                
                // Fetch customer details
                while ($customer_stmt->fetch()) {
                    echo "Customer ID: " . $cust_id . "<br>";
                    echo "Customer Name: " . $cust_name . "<br>";
                    // echo "Customer Info: " . $cust_info . "<br>";
                }
                
                // Close the customer statement
                $customer_stmt->close();
            } else {
                echo "Error fetching customer details: " . $conn->error;
            }
        } else {
            echo "Error: " . $stmt->error;
        }
        
        // Close the transaction statement
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Example usage
$admin_id = 1;  // Admin ID
$customer_id = 1;  // Customer ID
$amount = 100.50;  // Transaction amount

// Call the function to record the transaction
recordTransaction($admin_id, $customer_id, $amount);

// Close the connection
$conn->close();
?>
