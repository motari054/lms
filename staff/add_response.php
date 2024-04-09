<?php
session_start();
include('database.php');

// Handle feedback submission
if (isset($_POST['submit'])) {
    // Get the current user's username
    $username = $_SESSION['staff'];

    // Validate and sanitize input
    $feedback_id = mysqli_real_escape_string($con, $_GET['id']);
    $response = mysqli_real_escape_string($con, $_POST['feedback']);

    // Execute the SQL query to update the feedback in the database
    $sql = "UPDATE feedback SET response='$response' WHERE id=$feedback_id";
    $result = $con->query($sql);

    // Check if execution was successful
    if ($result) {
        $_SESSION['response'] = "Response added successfully";
        header("Location: index.php?page=feedback"); // Redirect to the homepage or appropriate page
        exit();
    } else {
        $_SESSION['response'] = "Error adding response";
        header("Location: add_response.php?id=$feedback_id");
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
    <title>Response</title>
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
    <h1>Add Response</h1>
    <form method="POST" action="add_response.php?id=<?php echo $_GET['id']; ?>">
        <div class="form-group">
            <textarea class="form-control narrow-textarea" id="exampleFormControlTextarea1" rows="9" cols="3"
                required name="feedback"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</body>

</html>
