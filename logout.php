<?php
session_start();
// Unset all session variables
session_unset();
// Destroy the session
session_destroy();
// Redirect to the home or login page
header("Location: index.php");
exit();
?>
