<?php
include('database.php');

// Check if the search form is submitted
if(isset($_POST['search'])) {
    $search = $_POST['search'];
    // Perform database query with search condition
    $query = "SELECT * FROM user_loan WHERE username LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    // Check for query errors
    if (!$result) {
        die("Database query failed.");
    }
} else {
    // If search form is not submitted, retrieve all data
    $query = "SELECT * FROM user_loan";
    $result = mysqli_query($con, $query);

    // Check for query errors
    if (!$result) {
        die("Database query failed.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Loans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <table class="table table-bordered table-hover table-striped" style="font-size: 13px;">        
            <thead>
                <tr>
                    <th colspan="10">
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
