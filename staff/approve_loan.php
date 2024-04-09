<?php
include('database.php');

// Check if loan ID is provided
if(isset($_GET['approve_loan_id'])) {
    // Sanitize the input to prevent SQL injection
    $loan_id = mysqli_real_escape_string($con, $_GET['approve_loan_id']);
    
    // Update query to set the status to "approve"
    $update_query = "UPDATE user_loan SET status = 'approve' WHERE loan_id = '$loan_id'";
    
    // Execute the update query
    $update_result = mysqli_query($con, $update_query);

    // Check if the update was successful
    if($update_result) {
        echo "Loan approved successfully.";
    } else {
        echo "Failed to approve loan.";
    }
} else {
    echo "Loan ID not provided.";
}
?>
