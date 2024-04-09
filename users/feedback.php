<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('database.php');

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "You need to be logged in to view feedback";
    header("Location: login_signup.php");
    exit();
}

// Get the current user's username
$username = $_SESSION['user'];

// Query to fetch feedback only for the current user
$sql = "SELECT id, message, response FROM feedback WHERE username = '$username'";
$result = $con->query($sql);
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
</head>
<body style="font-size: 15px;">
    <h1>Feedback Page</h1><hr>
    <a href="add_feedback.php"><button type="button" class="btn btn-success" style="font-size: 14px;">Add Feedback</button></a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">feedback id</th>
                <th scope="col">Your Message</th>
                <th scope="col">Response</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row['id'] . "</th>";
                    echo "<td>" . $row['message'] . "</td>";
                    echo "<td>" . $row['response'] . "</td>";
                    echo "<td><button onclick='deleteFeedback(" . $row['id'] . ")' type='button' class='btn btn-danger' data-feedback-id='" . $row['id'] . "'><span class='glyphicon glyphicon-trash'></span></button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No feedback available</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function deleteFeedback(id) {
            if (confirm("Are you sure you want to delete this feedback?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_feedback.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Reload the page to reflect the changes
                            window.location.reload();
                        } else {
                            console.error("Error deleting feedback. Status: " + xhr.status);
                        }
                    }
                };
                xhr.onerror = function() {
                    console.error("An error occurred during the request.");
                };
                xhr.send("id=" + id);
            }
        }
    </script>
</body>
</html>
