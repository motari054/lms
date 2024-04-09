<?php
session_start();

include 'connection.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a delete statement
    $sql = "DELETE FROM staff WHERE id = ?";

    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("i", $param_id);
        
        // Set parameters
        $param_id = $id;
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to staff table page
            header("location: index.php?page=staff");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    $stmt->close();
    
    // Close connection
    $conn->close();
} else {
    // ID parameter is missing, redirect back to staff table
    header("location: staff_table.php");
    exit();
}
?>
