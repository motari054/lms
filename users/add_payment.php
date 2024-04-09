<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


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

// Query to fetch loan application data for the user
$sql = "SELECT loan_amount, loan_interest, payment_term, emi_per_month, amount_paid FROM user_loan WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user has an existing loan application
if ($result->num_rows > 0) {
    // Fetch the loan application data
    $row = $result->fetch_assoc();
    $loan_amount = $row['loan_amount'];
    $loan_interest = $row['loan_interest'];
    $payment_term = $row['payment_term'];
    $emi_per_month = $row['emi_per_month'];
    $amount_paid = $row['amount_paid'];
    
    // Calculate loan balance
    $loan_balance = $loan_amount - $amount_paid;
    
    // Check if the loan balance is less than or equal to 0
    if ($loan_balance <= 0) {
      echo "<div class=\"alert alert-success\" role=\"alert\">
              Congratulations! You completed your loan payment!
            </div>";
      exit; // Stop further execution
  }
  
  
} else {
    // If no existing loan application, handle as needed
    // For example, redirect the user back to the loan application page
    header("Location: apply_loan.php");
    exit; // Stop further execution
}

// Check for success message
$successMessage = "";
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $successMessage = "Payment added successfully!";
    // Redirect to index page after displaying the success message
    header("refresh:3;url=index.php?page=dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Add New Payment</h1>
        <hr>
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>
        <form action="process_new_payment.php" method="POST">
            <div class="form-group row">
                <label for="originalAmount" class="col-sm-2 col-form-label">Original Amount</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="originalAmount" value="<?php echo $loan_amount; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="loanInterest" class="col-sm-2 col-form-label">Loan Interest</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="loanInterest" value="<?php echo $loan_interest; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="totalPayment" class="col-sm-2 col-form-label">Total Payment with Interest</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="totalPayment" value="<?php echo $loan_amount + ($loan_amount * $loan_interest / 100); ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="emiPerMonth" class="col-sm-2 col-form-label">EMI per Month</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="emiPerMonth" value="<?php echo $emi_per_month; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="emiPaymentAmount" class="col-sm-2 col-form-label">Enter EMI Payment Amount</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="emiPaymentAmount" name="emiPaymentAmount" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-primary">Add Payment</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
