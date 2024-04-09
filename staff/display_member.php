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

    <table class="table table-bordered table-hover table-striped">
        <tr>
            <form method="post" action="index.php?page=search_member">
                <td colspan="4">
                    <input type="text" placeholder="Search Member" name="searchMember" class="form-control" required />
                </td>
                <td colspan="4">
                    <input type="submit" value="Search Member" name="sub" class="btn btn-warning" />
                </td>
            </form>
        </tr>
        <tr>
            <td colspan="8"><a href="index.php?page=add_group_member"><button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Add New Member</button></a></td>
        </tr>
        <tr class="active">
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Group</th>
            <th>Date</th>
            <th>Actions</th>
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

                // Retrieve group information from the 'accounts' table's 'group' column
                echo "<td>".$row['group']."</td>"; // Assuming 'group' is the column name

                echo "<td>".date('Y-m-d')."</td>"; // Change made here
                echo "<td>
                        <a href='javascript:DeleteMember(".$row['id'].")' style='color:Red'><span class='glyphicon glyphicon-trash'></span></a>
                        <a href='index.php?page=update_group_member&member_id=".$row['id']."' style='color:green'><span class='glyphicon glyphicon-edit'></span></a>
                      </td>";

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
