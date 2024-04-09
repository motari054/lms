<?php
include('database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["loan_id"])) {
    $loanId = $_POST["loan_id"];

    //DELETE query
    $sql = "DELETE FROM user_loan WHERE loan_id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $loanId);
    if ($stmt->execute()) {
        echo "Loan canceled successfully";
    } else {
        echo "Error canceling loan";
    }
}
?>
