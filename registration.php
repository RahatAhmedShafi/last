<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "database.php";

    // Collect and sanitize input
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';
    $role = isset($_POST["role"]) ? $_POST["role"] : 'Moderator'; // Default role is 'Moderator'

    // Validate input
    if (!empty($username) && !empty($password)) {
        // Check if the username already exists
        $sql = "SELECT * FROM admin_users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Username already exists
            echo "<div class='alert alert-danger'>Username already taken. Please choose another.</div>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user
            $sql = "INSERT INTO admin_users (username, password, role) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sss", $username, $hashed_password, $role);

            if (mysqli_stmt_execute($stmt)) {
                // Registration successful
                echo "<div class='alert alert-success'>Registration successful! You can now <a href='login.php'>login</a>.</div>";
            } else {
                // Database insertion error
                echo "<div class='alert alert-danger'>Error: Could not register user. Please try again later.</div>";
            }
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<div class='alert alert-danger'>All fields are required. Please fill out the form completely.</div>";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Registration</h2>
        <form action="registration.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="Super Admin">Super Admin</option>
                    <option value="Moderator" selected>Moderator</option>
                    <option value="Support">Support</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Already registered? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
