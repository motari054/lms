<?php
include('database.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];

    $query = "SELECT status FROM user_loan WHERE username = ?";
    
    // Prepare and execute the query
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($loan_status);
        $stmt->fetch();
        $stmt->close();

        // Map the loan status to a more reader-friendly version
        switch ($loan_status) {
            case 'approve':
                $loan_status = 'Approved';
                break;
            case 'decline':
                $loan_status = 'Declined';
                break;
        }

        // Output the loan status
        echo htmlspecialchars($loan_status);
    } else {
        echo "Error: " . htmlspecialchars($con->error);
    }
} else {
    echo "Guest";
}

?>
