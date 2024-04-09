<?php
// Establish connection to the database
include('../admin/connection.php');
$q = mysqli_query($conn, "SELECT * FROM loan");
$rr = mysqli_num_rows($q);

if (!$rr) {
    echo "<h2 style='color:red'>No any Payment Records found !!!</h2>";
    echo "<a style='text-decoration:underline' href='index.php?page=add_loan'>Add New Payment Record?</a>";
} else {
?>
    <h2 align="center">All Payment Records</h2>

    <table class="table table-bordered table-hover table-striped">
        <tr>
            <td colspan="3">
                <form method="post" action="index.php?page=search_loan">
                    <select name="seachLoan" class="form-control" required>
                        <option value="">---Select Group---</option>
                        <?php
                        $q1 = mysqli_query($conn, "SELECT * FROM groups");
                        while ($r1 = mysqli_fetch_assoc($q1)) {
                            echo "<option value='" . $r1['group_id'] . "'>" . $r1['group_name'] . "</option>";
                        }
                        ?>
                    </select>
            </td>
            <td colspan="3">
                <input type="submit" value="Search Loan" name="sub" class="btn btn-warning" />
            </td>
            </form>
        </tr>
        <tr>
            <td colspan="6">

                <a title="Add New Payment Records" href="index.php?page=add_payment_history"><button class="btn btn-success btn-sm">Add Payment Details <span class='glyphicon glyphicon-plus'></span></button></a>
                &nbsp; &nbsp;

                <a title="Print all Loan Records" href="print_loan_record.php" target="_blank"><button class="btn btn-primary btn-sm">Print <span class='glyphicon glyphicon-print'></span></button></a>

            </td>
        </tr>
        <!-- Your existing table structure here -->
        <tr class="active">
            <th>#</th>
            <th>Group</th>
            <th>Amount Allocated</th>
            <th>Amount Paid</th>
            <th>Balance</th>
            <th>Payment Date</th>
        </tr>
        <?php
        error_reporting(1);
        $rec_limit = 10;

        // Get total number of records
        $sql = "SELECT count(payment_id) FROM payment_history ";
        $retval = mysqli_query($conn, $sql);

        if (!$retval) {
            die('Could not get data: ' . mysqli_error());
        }
        $row = mysqli_fetch_array($retval, MYSQLI_NUM);
        $rec_count = $row[0];

        if (isset($_GET['pagi'])) {
            $pagi = $_GET['pagi'] + 1;
            $offset = $rec_limit * $pagi;
        } else {
            $pagi = 0;
            $offset = 0;
        }

        $left_rec = $rec_count - ($pagi * $rec_limit);
        $sql = "SELECT * FROM payment_history LIMIT $offset, $rec_limit";
        $retval = mysqli_query($conn, $sql);

        if (!$retval) {
            die('Could not get data: ' . mysqli_error());
        }

        $inc = 1;
        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $inc . "</td>";

            // Fetch group name from groups table based on group_id
            $q1 = mysqli_query($conn, "SELECT group_name FROM groups WHERE group_id = '" . $row['group_id'] . "'");
            $r1 = mysqli_fetch_assoc($q1);
            echo "<td>" . $r1['group_name'] . "</td>";
            
            // Retrieve "Amount Allocated" from loan table based on group_id
            $q_loan = mysqli_query($conn, "SELECT loan_amount FROM loan WHERE group_id = '" . $row['group_id'] . "'");
            $r_loan = mysqli_fetch_assoc($q_loan);
            echo "<td>" . 'Ksh ' . $r_loan['loan_amount'] . "</td>";
            
            echo "<td>" . 'Ksh ' . $row['amount_paid'] . "</td>";
            
            // Calculate balance
            $balance = $r_loan['loan_amount'] - $row['amount_paid'];
            echo "<td>" . 'Ksh ' . $balance . "</td>";
            
            echo "<td>" . $row['payment_date'] . "</td>";

            echo "</tr>";
            $inc++;
        }

        // Display pagination links
        echo "<tr><td colspan='6'>";
        if ($pagi > 0) {
            $last = $pagi - 2;
            echo "<a href='index.php?page=display_payment_history&pagi=$last'>Last 10 Records</a> |";
            echo "<a href='index.php?page=display_payment_history&pagi=$pagi'>Next 10 Records</a>";
        } else if ($pagi == 0) {
            echo "<a href='index.php?page=display_payment_history&pagi=$pagi'>Next 10 Records</a>";
        } else if ($left_rec < $rec_limit) {
            $last = $pagi - 2;
            echo "<a href='index.php?page=display_payment_history&pagi=$last'>Last 10 Records</a>";
        }
        echo "</td></tr>";
        ?>
    </table>
<?php } ?>
