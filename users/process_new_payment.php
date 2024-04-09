<?php
include('database.php'); // Include your database connection file

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page if not authenticated
    header("Location: login.php");
    exit; // Stop further execution
}

// Retrieve the username from the session
$username = $_SESSION['user'];

// Get the EMI payment amount from the form
$emiPaymentAmount = $_POST['emiPaymentAmount'];

// Insert the EMI payment amount into the database
$sql = "UPDATE user_loan SET amount_paid = amount_paid + ? WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("ds", $emiPaymentAmount, $username);

if ($stmt->execute()) {
    // Redirect the user to the payment form with a success message
    header("Location: add_payment.php?success=1");
    exit;
} else {
    // Redirect the user back to the payment form with an error message
    header("Location: add_payment.php?error=1");
    exit;
}
?>
