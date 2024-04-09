<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Information</title>
</head>
<body>
    <a href="print_user_loan_record.php" target="_blank"><button type="button" class="btn btn-primary">Print <span class="glyphicon glyphicon-print"></button></a>
    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">User</th>
                <th scope="col">Loan id</th>
                <th scope="col">Loan applied</th>
                <th scope="col">Amount Paid</th>
                <th scope="col">Loan balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the database connection file
            include('database.php');

            // Check if the connection is successful
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // SQL query to fetch data from your database table
            $sql = "SELECT * FROM user_loan";
            $result = $conn->query($sql);

            // If data exists, populate the table rows dynamically
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Calculate the balance
                    $balance = $row['loan_amount'] - $row['amount_paid'];

                    echo "<tr>";
                    echo "<th>" . $row['username'] . "</td>";
                    echo "<td>" . $row['loan_id'] . "</th>";
                    echo "<td>" . $row['loan_amount'] . "</td>";
                    echo "<td>" . $row['amount_paid'] . "</td>";
                    echo "<td>" . $balance . "</td>"; // Output the calculated balance
                    echo "</tr>";
                }
            } else {
                // If no data found, display a message in a single row
                echo "<tr><td colspan='5'>No data found</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
