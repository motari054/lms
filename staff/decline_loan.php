<?php
include('database.php');

// Check if loan ID is provided
if(isset($_GET['decline_loan_id'])) {
    // Sanitize the input to prevent SQL injection
    $loan_id = mysqli_real_escape_string($con, $_GET['decline_loan_id']);
    
    // Update query to set the status to "declined"
    $update_query = "UPDATE user_loan SET status = 'declined' WHERE loan_id = '$loan_id'";
    
    // Execute the update query
    $update_result = mysqli_query($con, $update_query);

    // Check if the update was successful
    if($update_result) {
        echo "Loan declined successfully.";
    } else {
        echo "Failed to decline loan.";
    }
} else {
    echo "Loan ID not provided.";
}
?>
