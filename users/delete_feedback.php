<?php
// Include the database connection file
include('database.php');

// Check if ID parameter is set
if (isset($_POST['id'])) {
    // Sanitize the ID input to prevent SQL injection
    $id = mysqli_real_escape_string($con, $_POST['id']);

    // Prepare and execute the delete query
    $sql = "DELETE FROM feedback WHERE id = $id";

    if ($con->query($sql) === TRUE) {
        // Deletion successful
        echo "Feedback deleted successfully.";
    } else {
        // Error in deletion
        echo "Error deleting feedback: " . $con->error;
    }
} else {
    // ID parameter not provided
    echo "No ID provided for deletion.";
}

// Close connection
$con->close();
?>
