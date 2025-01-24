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
if (isset($_POST['submit_employee'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $department_id = $_POST['department_id'];

    $insert_query = "INSERT INTO employees (full_name, email, phone_number, department_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sssi", $full_name, $email, $phone_number, $department_id);

    if ($stmt->execute()) {
        echo "<script>alert('Employee added successfully!'); window.location.href='depts.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error adding employee: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch departments for dropdown
$departments_query = "SELECT department_id, department_name FROM departments";
$departments_result = mysqli_query($conn, $departments_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Employee</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <h1 style="text-align: center; margin-top: 50px; color: #333;">Insert New Employee</h1>

    <div style="width: 40%; margin: 50px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="">
            <label for="full_name" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Full Name:</label>
            <input type="text" name="full_name" id="full_name" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">

            <label for="email" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Email:</label>
            <input type="email" name="email" id="email" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">

            <label for="phone_number" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">

            <label for="department_id" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Department:</label>
            <select name="department_id" id="department_id" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">Select Department</option>
                <?php
                while ($row = mysqli_fetch_assoc($departments_result)) {
                    echo "<option value='{$row['department_id']}'>{$row['department_name']}</option>";
                }
                ?>
            </select>

            <button type="submit" name="submit_employee" style="width: 100%; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
        </form>
    </div>

</body>
</html>
