<?php
include('database.php');

// Perform database query
$query = "SELECT * FROM user_loan";
$result = mysqli_query($con, $query);

// Check for query errors
if (!$result) {
    die("Database query failed.");
}

// Approve loan if requested
if(isset($_GET['approve_loan_id'])) {
    $loan_id = $_GET['approve_loan_id'];
    $update_query = "UPDATE user_loan SET status = 'approve' WHERE loan_id = $loan_id";
    $update_result = mysqli_query($con, $update_query);
    if(!$update_result) {
        die("Approve loan failed.");
    }
    // Output success message
    echo "Loan approved successfully.";
    exit; // Stop further execution
}

// Decline loan if requested
if(isset($_GET['decline_loan_id'])) {
    $loan_id = $_GET['decline_loan_id'];
    $update_query = "UPDATE user_loan SET status = 'decline' WHERE loan_id = $loan_id";
    $update_result = mysqli_query($con, $update_query);
    if(!$update_result) {
        die("Decline loan failed.");
    }
    // Output success message
    echo "Loan declined successfully.";
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Loans</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h2 style="font-size: 25px;">User Loans</h2>
        <table class="table table-bordered table-hover table-striped">        
            <thead>
                <tr>
                    <th colspan="10">
                        <form method="post" action="index.php?page=search_user_loan" class="row g-3">
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="search" placeholder="Search">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-warning btn-block" type="submit">
                                    Search
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <a href="../print/print_user_loan_records.php" target="_blank"><button type="button" class="btn btn-primary">Print <span class="glyphicon glyphicon-print"></button></a>
                    </th>
                </tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Loan Amount</th>
                    <th scope="col">Interest</th>
                    <th scope="col">Payment Term</th>
                    <th scope="col">EMI (Per month)</th>
                    <th scope="col">Total Payment</th> 
                    <th scope="col">Actions</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo $row['loan_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['loan_amount']; ?></td>
                        <td><?php echo $row['loan_interest']; ?></td>
                        <td><?php echo $row['payment_term']; ?></td>
                        <td><?php echo $row['emi_per_month']; ?></td>
                        <td><?php echo $row['total_payment']; ?></td>
                        <td>
                            <button class="btn btn-success btn-sm approve-btn" data-loan-id="<?php echo $row['loan_id']; ?>">Approve</button>
                            <button class="btn btn-danger btn-sm decline-btn" data-loan-id="<?php echo $row['loan_id']; ?>">Decline</button>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'approve') : ?>
                                <span class="badge badge-success">Approved</span>
                            <?php elseif ($row['status'] == 'decline') : ?>
                                <span class="badge badge-danger">Declined</span>
                            <?php else : ?>
                                <span class="badge badge-secondary">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready(function(){
            $('.approve-btn').click(function(){
                var loan_id = $(this).data('loan-id');
                $.get('user_loan.php?approve_loan_id=' + loan_id, function(response){
                    alert(response); // Display success message
                    // Optionally, you can reload the loan data after approval
                    // location.reload();
                });
            });

            $('.decline-btn').click(function(){
                var loan_id = $(this).data('loan-id');
                $.get('user_loan.php?decline_loan_id=' + loan_id, function(response){
                    alert(response); // Display success message
                    // Optionally, you can reload the loan data after decline
                    // location.reload();
                });
            });
        });
    </script>
</body>
</html>
