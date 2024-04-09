<?php 
include('dbConfig.php');
if(isset($_POST['save'])) {
    $op = mysqli_real_escape_string($conn, $_POST['op']);
    $np = mysqli_real_escape_string($conn, $_POST['np']);
    $cp = mysqli_real_escape_string($conn, $_POST['cp']);

    if(empty($np) || empty($cp) || empty($op)) {
        $err="<font color='red'>Fill all the fields first</font>";
    } else {
        $op_hash = sha1($op); // Hash the old password (assuming it's hashed in the database)
        $sql=mysqli_query($conn,"SELECT * FROM admin WHERE pass='$op_hash'");
        $r=mysqli_num_rows($sql);
        
        if($r) {
            if($np==$cp) {
                $np_hash = sha1($np); // Hash the new password before storing
                $sql=mysqli_query($conn,"UPDATE admin SET pass='$np_hash' WHERE user='$admin'");
                $err="<font color='blue'>Password updated</font>";
            } else {
                $err="<font color='red'>New password does not match with Confirm Password</font>";
            }
        } else {
            $err="<font color='red'>Wrong Old Password</font>";
        }
    }
}
?>
<h2>Update Password</h2>
<form method="post">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4"><?php echo @$err;?></div>
    </div>
    <div class="row">
        <div class="col-sm-4">Enter Your Old Password</div>
        <div class="col-sm-5">
            <input type="password" name="op" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">Enter New Password</div>
        <div class="col-sm-5">
            <input type="password" name="np" class="form-control"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">Confirm Password</div>
        <div class="col-sm-5">
            <input type="password" name="cp" class="form-control"/>
        </div>
    </div>
    <div class="row" style="margin-top:10px">
        <div class="col-sm-2"></div>
        <div class="col-sm-8">
            <input type="submit" value="Update Password" name="save" class="btn btn-success"/>
            <input type="reset" class="btn btn-danger"/>
        </div>
    </div>
</form>
