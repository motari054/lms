<?php
include('../admin/connection.php'); 
$q = mysqli_query($conn, "SELECT * FROM user_loan");
?>
<link rel="stylesheet" href="../css/bootstrap.min.css"/>
<table class="table table-bordered">
    <tr height="30" class="info">
        <th colspan="7" align="center"><center>User Loan Records</center></th>
    </tr>   
    <tr class="active">
        <th>User</th>
        <th>Loan id</th>
        <th>Loan Applied</th>
        <th>Amount Paid</th>
        <th>Loan Balance</th>
    </tr>
    <?php 
    while($row = mysqli_fetch_assoc($q)) {
        // Calculate the loan balance
        $loan_balance = $row['loan_amount'] - $row['amount_paid'];

        echo "<tr>";
        echo "<td>".$row['username']."</td>";
        echo "<td>".$row['loan_id']."</td>";
        echo "<td>Ksh ".$row['loan_amount']."</td>";
        echo "<td>".$row['amount_paid']."</td>";
        echo "<td>".$loan_balance."</td>"; // Display the loan balance
        echo "</tr>";
    }
    ?>
    <tr>
        <td colspan="7" align="center">
            <button id="printpagebutton" class="btn btn-primary" onClick="printpage()">
                <span class="glyphicon glyphicon-print"></span> &nbsp;Print
            </button>
        </td>
    </tr>
</table>

<script>
    function printpage() {
        var printButton = document.getElementById("printpagebutton");
        printButton.style.visibility = 'hidden';
        window.print();
        printButton.style.visibility = 'visible';
    }
</script>
