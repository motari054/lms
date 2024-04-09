<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Loan</title>
    <script>
        function loanamount() {
            var original = document.getElementById("original").value;
            var interest = document.getElementById("interest").value;
            var year = document.getElementById("payment_term").value;

            var interest1 = (Number(original) * Number(interest) * Number(year)) / 100;
            var total = Number(original) + Number(interest1);

            var emi = total / (year * 12);
            document.getElementById("total_paid").value = total;
            document.getElementById("emi_per_month").value = Math.round(emi); // Make EMI per month an integer
        }

        function resetForm() {
            document.getElementById("loanForm").reset();
        }
    </script>
</head>
<body>
    <h1>Apply loan</h1>
    <hr>
    <form id="loanForm" action="" method="POST" enctype="multipart/form-data">
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4">Amount</div>
            <div class="col-sm-5">
                <input type="number" id="original" name="amount" class="form-control" required/>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4">Loan Interest (%)</div>
            <div class="col-sm-5">
                <input type="text" name="interest" id="interest" value="10" readonly="true" class="form-control" required/>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4">Term of Payment (In Year)</div>
            <div class="col-sm-5">
                <select onchange="loanamount()" name="payment_term" id="payment_term" class="form-control" required>
                    <option value="">---Select Term of Payment---</option>
                    <?php
                        for($i=1;$i<=10;$i++) {
                            echo "<option value='".$i."'>".$i."</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4">Pay Every Month (EMI Per Month)</div>
            <div class="col-sm-5">
                <input type="text" id="emi_per_month" name="emi_per_month" class="form-control" readonly/>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4">Total Paid (With Interest)</div>
            <div class="col-sm-5">
                <input type="text" id="total_paid" name="total_paid" class="form-control" readonly/>
            </div>
        </div>
        <div class="row" style="margin-top:10px">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <input type="submit" value="Process New Loan" name="save" class="btn btn-primary"/>
                <input type="button" value="Reset" class="btn btn-danger" onclick="resetForm()"/>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </form>
</body>
</html>


<?php
include('database.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['save'])) {
    // Retrieve user inputs and sanitize them
    $username = $_SESSION['user'] ?? ''; // Use a default value if $_SESSION['user'] is not set
    $amount = $_POST['amount'] ?? '';
    $interest = $_POST['interest'] ?? '';
    $payment_term = $_POST['payment_term'] ?? '';
    $emi_per_month = $_POST['emi_per_month'] ?? '';
    $total_paid = $_POST['total_paid'] ?? '';

    // Validate user inputs (you can add more validation as per your requirements)
    if (empty($amount) || empty($payment_term) || empty($emi_per_month) || empty($total_paid)) {
        echo '<div class="alert alert-danger" role="alert">Please fill in all the fields.</div>';
        exit; // Stop further execution
    }

    // Check for existing loan application
    $checkSql = "SELECT * FROM user_loan WHERE username = ?";
    $checkStmt = $con->prepare($checkSql);
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if ($result->num_rows > 0) {
        // If a loan application already exists for the user, show a warning message
        echo '<div class="alert alert-warning" role="alert">You have already applied for a loan.</div>';
    } else {
        // No existing loan application, proceed with inserting the new application
        $sql = "INSERT INTO user_loan (username, loan_amount, loan_interest, payment_term, emi_per_month, total_payment) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssss", $username, $amount, $interest, $payment_term, $emi_per_month, $total_paid);
        if ($stmt->execute()) {
            // If the insertion is successful, show a success message and redirect
            echo '<div class="alert alert-success" role="alert">Loan applied successfully</div>';
            echo '<script type="text/javascript">
                    setTimeout(function() {
                        window.location.href = "index.php?page=dashboard";
                    }, 2000); // Redirect after 2 seconds
                  </script>';
        } else {
            // If the insertion fails, show an error message
            echo '<div class="alert alert-danger" role="alert">Loan processing failed.</div>';
        }
    }
}
?>
