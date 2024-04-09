<?php
// Check if a session is already active before starting a new one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('database.php');

$gender = 'Guest';
$group_name = '';
$userID = '';
$applied_amount = 0;

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];

    $query = "SELECT accounts.id, accounts.gender, groups.group_name, SUM(user_loan.loan_amount) AS applied_amount FROM accounts 
              INNER JOIN groups ON accounts.group = groups.group_id 
              LEFT JOIN user_loan ON accounts.username = user_loan.username 
              WHERE accounts.username = ?";

    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            if ($row) {
                $userID = $row['id'];
                $gender = $row['gender'];
                $group_name = $row['group_name'];
                $applied_amount = $row['applied_amount'];
            }
        } else {
            echo "Query execution failed: " . htmlspecialchars($con->error);
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . htmlspecialchars($con->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>User Dashboard</h2>
        <div class="dash-content">
            <div class="boxes"> 
                <div class="box box1">
                    <i><ion-icon name="person"></ion-icon></i>
                    <span class="text">Username</span>
                    <span class="number"><?php echo htmlspecialchars(isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest'); ?></span>
                </div>
                <div class="box box4">
                    <i><ion-icon name="albums"></ion-icon></i>
                    <span class="text">User ID</span>
                    <span class="number"><?php echo htmlspecialchars($userID); ?></span>
                </div>
                <div class="box box2">
                    <i><ion-icon name="transgender"></ion-icon></i>
                    <span class="text">Gender</span>
                    <span class="number"><?php echo htmlspecialchars($gender); ?></span>
                </div>
                <div class="box box3">
                    <i><ion-icon name="contacts"></ion-icon></i>
                    <span class="text">Group</span>
                    <span class="number"><?php echo htmlspecialchars($group_name); ?></span>
                </div>
                <div class="box box5">
                    <i><ion-icon name="cash"></ion-icon></i>
                    <span class="text">Loans Applied</span>
                    <span class="number">Ksh <?php echo htmlspecialchars($applied_amount); ?></span>
                </div>
                <div class="box box6">
                    <i><ion-icon name="information-circle-outline"></ion-icon></i>
                    <span class="text">Loan Status</span>
                    <span class="number" id="loan-status">Loading...</span> <!-- Initially display "Loading..." -->
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Function to fetch loan status using AJAX
        function getLoanStatus() {
            $.ajax({
                url: 'get_loan_status.php',
                type: 'GET',
                success: function(response) {
                    $('#loan-status').text(response); // Update loan status in the span tag
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        getLoanStatus();
        setInterval(getLoanStatus, 30000);
    });
    </script>
</body>
</html>
