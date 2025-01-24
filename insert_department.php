<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projmr1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['submit_department'])) {
    $department_name = $_POST['department_name'];
    $manager_id = $_POST['manager_id'];

    $insert_query = "INSERT INTO departments (department_name, manager_id) VALUES ('$department_name', '$manager_id')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Department added successfully!'); window.location.href='depts.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error adding department: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Department</title>
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Insert New Department</h1>
    <form method="POST" action="">
        <label for="department_name">Department Name:</label>
        <input type="text" name="department_name" id="department_name" required>
        
        <label for="manager_id">Manager ID:</label>
        <input type="text" name="manager_id" id="manager_id">

        <button type="submit" name="submit_department">Submit</button>
    </form>
</body>
</html>
