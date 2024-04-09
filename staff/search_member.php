<?php
include('dbConfig.php');

if(isset($_POST['searchMember'])) {
    $search = $_POST['searchMember'];

    $query = "SELECT * FROM accounts WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR gender LIKE '%$search%'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // Display search results
        echo "<h2>Search Results</h2>";
        echo "<table class='table table-bordered table-hover table-striped'>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Gender</th>";
        //echo "<th>Group</th>";
        echo "<th>Date</th>";
        echo "<th>Actions</th>";
        echo "</tr>";

        $i = 1;
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$row['first_name']."</td>";
            echo "<td>".$row['last_name']."</td>";
            echo "<td>".$row['gender']."</td>";

            // Fetch group details
            $group_query = mysqli_query($conn, "SELECT * FROM groups WHERE group_id='".$row['group_id']."'");
            $group_row = mysqli_fetch_assoc($group_query);
            //echo "<td>".$group_row['group']."</td>";

            echo "<td>".date('Y-m-d')."</td>"; // Change made here
            echo "<td>
                    <a href='javascript:DeleteMember(".$row['id'].")' style='color: red;'><span class='glyphicon glyphicon-trash'></span>Delete</a>
                    <a href='index.php?page=update_group_member&member_id=".$row['id']."' style='color: green;'><span class='glyphicon glyphicon-edit'></span>Edit</a>
                  </td>";

            echo "</tr>";
            $i++;
        }

        echo "</table>";
    } else {
        echo "<div class='alert alert-danger'><h2>No records found!</h2></div>";
    }
}
?>
