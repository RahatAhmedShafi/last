<?php
// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If the transaction was successful, show the success message
$transaction_successful = isset($_GET['success']) && $_GET['success'] == 'true';

if ($transaction_successful):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h4 class="alert-heading">Transaction Successful!</h4>
            <p>Your payment has been processed successfully. Thank you for your business!</p>
            <hr>
            <a href="index.php" class="btn btn-primary">Go to Home</a>
        </div>
    </div>
</body>
</html>
<?php else: ?>
    <p>Something went wrong. Please try again later.</p>
<?php endif; ?>
