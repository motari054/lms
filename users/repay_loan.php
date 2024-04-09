<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Details</title>
    <!-- Include your CSS and JavaScript links here -->
    <!-- Example: <link rel="stylesheet" href="styles.css"> -->
</head>
<body>
    <h1>Loan Details</h1>
    <a href="add_payment.php" class="btn btn-success">Add Payment</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Loan id</th>
                <th scope="col">Amount Approved</th>
                <th>Amount Paid</th>
                <th scope="col">Loan Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include('database.php'); // Include your database connection file

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (!isset($_SESSION['user'])) {
                // Redirect the user to the login page if not authenticated
                header("Location: login.php");
                exit; // Stop further execution
            }

            // Retrieve the username from the session
            $username = $_SESSION['user'];

            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            $sql = "SELECT loan_id, loan_amount, amount_paid FROM user_loan WHERE username = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die("Error executing query: " . $con->error);
            }

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Calculate loan balance
                    $loan_balance = $row['loan_amount'] - $row['amount_paid'];
                    echo "<tr>";
                    echo "<td>" . $row['loan_id'] . "</td>";
                    echo "<td>" . $row['loan_amount'] . "</td>";
                    echo "<td>" . $row['amount_paid'] . "</td>";
                    echo "<td>" . $loan_balance . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No loans found</td></tr>";
            }
            $con->close();
            ?>
        </tbody>
    </table>
</body>
</html>
