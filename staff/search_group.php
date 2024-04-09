<?php
include('dbConfig.php');

if(isset($_POST['searchGroup'])) {
    $search = $_POST['searchGroup'];

    $query = "SELECT * FROM groups WHERE group_name LIKE '%$search%' OR registration_number LIKE '%$search%'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // Display search results
        echo "<h2>Search Results</h2>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>Name</th>";
        echo "<th>Region</th>";
        echo "<th>District</th>";
        echo "<th>Division</th>";
        echo "<th>Ward</th>";
        echo "<th>Village</th>";
        echo "<th>Reg No</th>";
        echo "<th>Activity</th>";
        echo "<th>Category</th>";
        echo "<th>Total Member</th>";
        echo "<th>Leader</th>";
        echo "<th>Loan Info.</th>";
        echo "<th>Capital</th>";
        echo "<th>Action</th>";
        echo "</tr>";

        $i = 1;
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$row['group_name']."</td>";

            // Fetch region details
            $region_query = mysqli_query($conn, "SELECT * FROM region WHERE region_id='".$row['region']."'");
            $region_row = mysqli_fetch_assoc($region_query);
            echo "<td>".$region_row['region_name']."</td>";

            // Fetch district details
            $district_query = mysqli_query($conn, "SELECT * FROM district WHERE district_id='".$row['district']."'");
            $district_row = mysqli_fetch_assoc($district_query);
            echo "<td>".$district_row['district_name']."</td>";

            // Fetch division details
            $division_query = mysqli_query($conn, "SELECT * FROM division WHERE division_id='".$row['division']."'");
            $division_row = mysqli_fetch_assoc($division_query);
            echo "<td>".$division_row['division_name']."</td>";

            // Fetch ward details
            $ward_query = mysqli_query($conn, "SELECT * FROM ward WHERE ward_id='".$row['ward']."'");
            $ward_row = mysqli_fetch_assoc($ward_query);
            echo "<td>".$ward_row['ward_name']."</td>";

            // Fetch village details
            $village_query = mysqli_query($conn, "SELECT * FROM village WHERE village_id='".$row['village']."'");
            $village_row = mysqli_fetch_assoc($village_query);
            echo "<td>".$village_row['village_name']."</td>";

            echo "<td>".$row['registration_number']."</td>";
            echo "<td>".$row['group_activity']."</td>";
            echo "<td>".$row['group_category']."</td>";
            echo "<td>".$row['group_total_members']."</td>";
            echo "<td>".$row['group_leader']."</td>";
            echo "<td>".$row['loan_information']."</td>";
            echo "<td>Ksh ".$row['group_capital']."</td>";
            echo "<td><a href='javascript:DeleteGroup(".$row['group_id'].")' style='color: red;'><span class='glyphicon glyphicon-trash'></span>Delete</a></td>";
            echo "</tr>";
            $i++;
        }

        echo "</table>";
    } else {
        echo "<div class='alert alert-danger'><h2>No records found!</h2></div>";
    }
}
?>
