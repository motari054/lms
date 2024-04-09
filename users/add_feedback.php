<?php
session_start();
include('database.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "You need to be logged in to submit feedback";
    header("Location: login_signup.php");
    exit();
}

// Handle feedback submission
if (isset($_POST['submit'])) {
    // Get the current user's username
    $username = $_SESSION['user'];

    // Validate and sanitize input
    $feedback = mysqli_real_escape_string($con, $_POST['feedback']);

    // Check if the feedback is not empty
    if (empty($feedback)) {
        $_SESSION['message'] = "Feedback cannot be empty";
        header("Location: add_feedback.php");
        exit();
    }

    // Execute the SQL query to insert the feedback into the database
    $sql = "INSERT INTO feedback (username, message) VALUES ('$username', '$feedback')";
    $result = $con->query($sql);

    // Check if execution was successful
    if ($result) {
        $_SESSION['message'] = "Feedback submitted successfully";
        header("Location: index.php?page=feedback"); // Redirect to the homepage or appropriate page
        exit();
    } else {
        $_SESSION['message'] = "Error submitting feedback";
        header("Location: add_feedback.php");
        exit();
    }
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

    <style>
        /* Custom CSS to reduce the width of the textarea */
        .narrow-textarea {
            width: 900px; /* Adjust as needed */
        }
    </style>
</head>

<body>
    <h1>Add Feedback</h1>
    <form method="POST" action="add_feedback.php">
        <div class="form-group">
            <textarea class="form-control narrow-textarea" id="exampleFormControlTextarea1" rows="9" cols="3"
                required name="feedback"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</body>

</html>
