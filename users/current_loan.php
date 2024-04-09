<?php
include('database.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect the user to the login page or handle the authentication flow
    // Example: header("Location: login.php");
    exit; // Stop further execution if the user is not logged in
}

// Get the currently logged-in user
$username = $_SESSION['user'];

// Retrieve loans for the current user
$sql = "SELECT loan_id, loan_amount, status FROM user_loan WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display the table with loans for the current user
    // Your HTML and PHP code for displaying the table goes here
} else {
    // If no loans are found for the current user, display a message
    echo "";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Loans</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../styling/custom.css">
</head>
<body>
    <h1>Current Loan</h1><hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Loan ID</th>
                <th scope="col">Loan Amount</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['loan_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['loan_amount']) . "</td>";
                    echo "<td>";
                    if ($row['status'] == 'approve') {
                        echo "<span class='badge badge-success'>Approved</span>";
                    } elseif ($row['status'] == 'decline') {
                        echo "<span class='badge badge-danger'>Declined</span>";
                    } else {
                        echo "<span class='badge badge-secondary'>Pending</span>";
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($row['status'] !== 'approve') {
                        echo "<button type='button' class='btn btn-danger cancel-btn' data-loan-id='" . htmlspecialchars($row['loan_id']) . "'>Cancel Loan</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No loans found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.cancel-btn').click(function() {
            var loanId = $(this).data('loan-id');
            if (confirm("Are you sure you want to cancel this loan?")) {
                // Send AJAX request to cancel_loan.php
                $.ajax({
                    url: 'cancel_loan.php',
                    type: 'POST',
                    data: { loan_id: loanId },
                    success: function(response) {
                        alert(response); // Display server response
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr, status, error) {
                        console.error("Error: " + xhr.responseText);
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
