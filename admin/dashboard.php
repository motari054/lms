<?php 
include('connection.php');
$q=mysqli_query($conn,"select * from accounts ");
$r=mysqli_num_rows($q);



$q2=mysqli_query($conn,"select * from accounts where gender='male'");
$r2=mysqli_num_rows($q2);


$q3=mysqli_query($conn,"select * from accounts where gender='female'");
$r3=mysqli_num_rows($q3);




$q1=mysqli_query($conn,"select * from groups ");
$r1=mysqli_num_rows($q1);

$q7=mysqli_query($conn,"select * from user_loan");
$r4=mysqli_num_rows($q7);

$q8=mysqli_query($conn,"select * from staff");
$r8=mysqli_num_rows($q8);



?>
<h1 class="page-header">Dashboard</h1>
<div class="dash-content">
            <div class="boxes"> 
                <div class="box box4">
                    <i><ion-icon name="person"></ion-icon></i>
                    <span class="text">Total Members</span>
                    <span class="number"><?php echo $r; ?></span>
                </div>
                <div class="box box5">
                    <i><ion-icon name="man"></ion-icon></i>
                    <span class="text">Total Male</span>
                    <span class="number"><?php echo $r2; ?></span>
                </div>
                <div class="box box6">
                    <i><ion-icon name="woman"></ion-icon></i>
                    <span class="text">Total Female</span>
                    <span class="number" id="loan-status"><?php echo $r3; ?></span> <!-- Initially display "Loading..." -->
                </div>
                <div class="box box3">
                    <i><ion-icon name="teme"></ion-icon></i>
                    <span class="text">Staff Accounts</span>
                    <span class="number"><?php echo $r8; ?></span>
                </div>
                <div class="box box1">
                    <i><ion-icon name="people"></ion-icon></i>
                    <span class="text">Total Groups</span>
                    <span class="number"><?php echo $r1; ?></span>
                </div>
                <div class="box box2">
                    <i><ion-icon name="cash"></ion-icon></i>
                    <span class="text">Member Loans Alloted</span>
                    <span class="number"><?php echo $r4; ?></span>
                </div>
                
            </div>
        </div>