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
if (isset($_POST['submit_task'])) {
    $task_name = $_POST['task_name'];
    $project_id = $_POST['project_id'];

    $insert_query = "INSERT INTO tasks (task_name, project_id) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("si", $task_name, $project_id);

    if ($stmt->execute()) {
        echo "<script>alert('Task added successfully!'); window.location.href='depts.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error adding task: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Fetch projects for dropdown
$projects_query = "SELECT project_id, project_name FROM projects";
$projects_result = mysqli_query($conn, $projects_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Task</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">

    <h1 style="text-align: center; margin-top: 50px; color: #333;">Insert New Task</h1>

    <div style="width: 40%; margin: 50px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <form method="POST" action="">
            <label for="task_name" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Task Name:</label>
            <input type="text" name="task_name" id="task_name" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">

            <label for="project_id" style="font-size: 16px; margin-bottom: 5px; display: block; color: #333;">Project:</label>
            <select name="project_id" id="project_id" required style="width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #ccc;">
                <option value="">Select Project</option>
                <?php
                while ($row = mysqli_fetch_assoc($projects_result)) {
                    echo "<option value='{$row['project_id']}'>{$row['project_name']}</option>";
                }
                ?>
            </select>

            <button type="submit" name="submit_task" style="width: 100%; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Submit</button>
        </form>
    </div>

</body>
</html>
