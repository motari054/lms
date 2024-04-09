<?php
$err = "";
if(isset($_POST['save'])) {
    // Extract POST data
    $fn = mysqli_real_escape_string($conn, $_POST['fn']);
    $ln = mysqli_real_escape_string($conn, $_POST['ln']);
    $group = mysqli_real_escape_string($conn, $_POST['group']);
    $gen = mysqli_real_escape_string($conn, $_POST['gen']);

    // Check if all fields are filled
    if(empty($fn) || empty($ln) || empty($group) || empty($gen)) {
        $err = "<div class='alert alert-danger'>Fill all the fields first</div>";
    } else {
        // Check if member already exists
        $sql = mysqli_query($conn, "SELECT * FROM accounts WHERE first_name='$fn' AND group_id='$group'");
        $r = mysqli_num_rows($sql);
        
        if($r == 0) {
            // Insert new member
            $query = "INSERT INTO accounts (first_name, last_name, gender, group_id, created_at) VALUES ('$fn', '$ln', '$gen', '$group', NOW())";
            if(mysqli_query($conn, $query)) {
                $err = "<div class='alert alert-success'>New member has been added successfully</div>";
            } else {
                $err = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $err = "<div class='alert alert-danger'>This member and Group already exist</div>";
        }
    }
}
?>

<h2 class="text-center">Add New Member</h2>
<form method="post">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><?php echo $err; ?></div>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Member's First Name</div>
        <div class="col-sm-5"><input type="text" name="fn" class="form-control" required/></div>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Member's Last Name</div>
        <div class="col-sm-5"><input type="text" name="ln" class="form-control" required /></div>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Select Group</div>
        <div class="col-sm-5">
            <select name="group" class="form-control" required>
                <option value="">Select Group</option>
                <?php
                // Fetch groups from database
                $q1 = mysqli_query($conn, "SELECT * FROM groups");
                while($r1 = mysqli_fetch_assoc($q1)) {
                    echo "<option value='".$r1['group_id']."'>".$r1['group_name']."</option>";
                }
                ?>
            </select>
        </div>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-sm-4">Gender</div>
        <div class="col-sm-5">
            Male <input type="radio" name="gen" value="m" required/>
            Female <input type="radio" name="gen" value="f" />
        </div>
    </div>

    <div class="row" style="margin-top:10px">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <input type="submit" value="Add New Member" name="save" class="btn btn-success"/>
            <input type="reset" class="btn btn-danger"/>
        </div>
        <div class="col-sm-4"></div>
    </div>
</form>
