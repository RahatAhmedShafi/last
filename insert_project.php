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
if (isset($_POST['submit_project'])) {
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];

    $insert_query = "INSERT INTO projects (project_name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ss", $project_name, $description);

    if ($stmt->execute()) {
        echo "<script>alert('Project added successfully!'); window.location.href='depts.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error adding project: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Project</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 50px auto; padding: 30px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h1 style="font-size: 24px; margin-bottom: 20px; text-align: center;">Insert New Project</h1>
        <form method="POST" action="" style="display: flex; flex-direction: column; gap: 15px;">
            <label for="project_name" style="font-size: 16px; font-weight: bold;">Project Name:</label>
            <input type="text" name="project_name" id="project_name" required style="padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px;">

            <label for="description" style="font-size: 16px; font-weight: bold;">Description:</label>
            <textarea name="description" id="description" required style="padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; min-height: 100px;"></textarea>

            <button type="submit" name="submit_project" style="padding: 10px; font-size: 16px; color: #fff; background-color: #4CAF50; border: none; border-radius: 4px; cursor: pointer;">
                Submit
            </button>
        </form>
    </div>
</body>
</html>
