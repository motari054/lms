<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $q = mysqli_query($conn, "SELECT * FROM accounts");
    $rr = mysqli_num_rows($q);
    
    if(!$rr) {
        echo "<h2 style='color:red'>No group members exist!</h2>";
        echo "<a style='text-decoration:underline' href='index.php?pagi=add_group_member'>Add New Member?</a>";
    } else {
?>
    <script>
        function DeleteMember(id) {
            if(confirm("Are you sure you want to delete this member?")) {
                window.location.href = "delete_group_member.php?id=" + id;
            }
        }
    </script>
    <h2>All Group Members</h2>

    <table class="table table-striped">
        <tr class="active">
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Date</th>
        </tr>
        <?php
            error_reporting(1);
            $rec_limit = 10;

            $sql = "SELECT count(id) FROM accounts";
            $retval = mysqli_query($conn, $sql);

            if(!$retval) {
                die('Could not get data: ' . mysqli_error($conn));
            }
            $row = mysqli_fetch_array($retval, MYSQLI_NUM);
            $rec_count = $row[0];

            if(isset($_GET['pagi'])) {
                $pagi = $_GET['pagi'] + 1;
                $offset = $rec_limit * $pagi;
            } else {
                $pagi = 0;
                $offset = 0;
            }

            $left_rec = $rec_count - ($pagi * $rec_limit);
            $sql = "SELECT * FROM accounts LIMIT $offset, $rec_limit";
            $retval = mysqli_query($conn, $sql);

            if(!$retval) {
                die('Could not get data: ' . mysqli_error($conn));
            }

            $inc = 1;
            while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                echo "<tr>";
                echo "<td>".$inc."</td>";
                echo "<td>".$row['first_name']."</td>";
                echo "<td>".$row['last_name']."</td>";
                echo "<td>".$row['gender']."</td>";
                echo "<td>".date('Y-m-d')."</td>";
                echo "</tr>";
                $inc++;
            }

            // Pagination
            echo "<tr><td colspan='8'>";
            if($pagi > 0) {
                $last = $pagi - 2;
                echo "<a href='index.php?page=display_member&pagi=$last'>Last 10 Records</a> |";
                echo "<a href='index.php?page=display_member&pagi=$pagi'>Next 10 Records</a>";
            } else if($pagi == 0) {
                echo "<a href='index.php?page=display_member&pagi=$pagi'>Next 10 Records</a>";
            } else if($left_rec < $rec_limit) {
                $last = $pagi - 2;
                echo "<a href='index.php?page=display_member&pagi=$last'>Last 10 Records</a>";
            }
            echo "</td></tr>"; 
        ?>
    </table>
<?php } ?>