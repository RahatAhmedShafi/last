<?php
session_start();

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // If the admin is already logged in, redirect to depts.php
    header("Location: depts.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Admin Login</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            require_once "database.php";

            // Check if username and password are set in the POST request
            $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
            $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

            if (!empty($username) && !empty($password)) {
                // Use prepared statement to prevent SQL injection
                $sql = "SELECT * FROM admin_users WHERE username = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $admin = mysqli_fetch_array($result, MYSQLI_ASSOC);

                if ($admin) {
                    // Verify the password
                    if (password_verify($password, $admin["password"])) {
                        // Set session variables
                        $_SESSION["admin_logged_in"] = true;
                        $_SESSION["admin_id"] = $admin["admin_id"];
                        $_SESSION["admin_role"] = $admin["role"];

                        // Redirect to depts.php
                        header("Location: depts.php");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Invalid password.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>No admin found with the given username.</div>";
                }

                mysqli_stmt_close($stmt);
            } else {
                echo "<div class='alert alert-danger'>Please fill in all fields.</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <div class="form-group mb-3">
                <input type="text" name="username" placeholder="Enter Username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
