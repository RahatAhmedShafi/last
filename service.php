<?php

session_start(); // Start the session to access session variables

// Enable error reporting for debugging
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

//-----------

//-----------
// Fetch all services with their department names
$sql = "SELECT 
            s.service_id, 
            s.service_name, 
            s.description, 
            s.cost, 
            d.department_name 
        FROM services s
        LEFT JOIN departments d ON s.department_id = d.department_id";

$result = $conn->query($sql);

// Fetch department-wise service count for stats
$stats_sql = "SELECT 
                d.department_name, 
                COUNT(s.service_id) as service_count 
              FROM services s
              LEFT JOIN departments d ON s.department_id = d.department_id
              GROUP BY d.department_name";
$stats_result = $conn->query($stats_sql);

// Prepare department statistics
$department_stats = [];
while ($row = $stats_result->fetch_assoc()) {
    $department_stats[] = $row;
}

$total_services = $result->num_rows;

// Fetch purchased services for the logged-in customer
$purchased_services = [];
if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $purchase_sql = "SELECT 
                        s.service_name, 
                        s.description, 
                        s.cost, 
                        t.transaction_date 
                     FROM transactions1 t
                     JOIN services s ON t.service_id = s.service_id
                     WHERE t.customer_id = ?";
    $stmt = $conn->prepare($purchase_sql);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $purchase_result = $stmt->get_result();
    while ($row = $purchase_result->fetch_assoc()) {
        $purchased_services[] = $row;
    }
    $stmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color:rgb(0, 0, 0);
            padding: 10px 20px;
            flex-wrap: wrap;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
        }
        .navbar a:hover {
            background-color: #0056b3;
        }
        .navbar .menu {
            display: flex;
            gap: 10px;
        }
        .menu-toggle {
            display: none;
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .menu-toggle:hover {
            background-color: #003f8c;
        }
        @media (max-width: 768px) {
            .menu {
                display: none;
                flex-direction: column;
                width: 100%;
                background-color: #007bff;
                margin-top: 10px;
            }
            .menu.show {
                display: flex;
            }
            .menu a {
                padding: 10px;
                border-top: 1px solid #0056b3;
            }
            .menu a:first-child {
                border-top: none;
            }
            .menu-toggle {
                display: block;
            }
        }
        .card {
            border-radius: 10px;
            background: #ffffff;
        }
        .table {
            background-color: #ffffff;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    
<div class="navbar">
        <h1 style="color: white; margin: 0;"></h1>
        <button class="menu-toggle" onclick="toggleMenu()">Menu</button>
        <div class="menu">
            <a href="index.php">Home</a>
            <a href="index.php#contact">Contact</a>
            <a href="customer_message.php?customer_id=2" 
   style="display: inline-block; background-color: #007BFF; color: white; text-decoration: none; 
          padding: 10px 20px; border-radius: 5px; font-size: 14px; font-weight: bold; 
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
    Chat with Service Provider
</a>
        </div>
    </div>

    <div class="container">
    

        <!-- Header -->
        <div class="row bg-primary text-white py-3">
            <div class="col-md-6">
                <h1 class="ms-3">Service Dashboard</h1>
                
            </div>
        </div>

        <!-- Purchased Services Section -->
        <div class="row mt-4">
            <div class="col-12">
                <h3>Purchased Services</h3>
                <table class="table table-striped table-bordered shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($purchased_services)): ?>
                            <?php foreach ($purchased_services as $service): ?>
                                <tr>
                                    <td><?= htmlspecialchars($service['service_name']) ?></td>
                                    <td><?= htmlspecialchars($service['description']) ?></td>
                                    <td>$<?= number_format($service['cost'], 2) ?></td>
                                    <td><?= htmlspecialchars($service['transaction_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">No purchased services found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Service List Table -->
        <div class="row mt-4">
            <div class="col-12">
                <h3>Service List</h3>
                <table class="table table-striped table-bordered shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Service ID</th>
                            <th>Service Name</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['service_id']) ?></td>
                                    <td><?= htmlspecialchars($row['service_name']) ?></td>
                                    <td><?= htmlspecialchars($row['description']) ?></td>
                                    <td>$<?= number_format($row['cost'], 2) ?></td>
                                    <td><a href="customer_input.php?service_id=<?= $row['service_id'] ?>" class="btn btn-success">Pay</a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No services found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <?php
    // Close the database connection
    $conn->close();
    ?>
   
</body>
</html>