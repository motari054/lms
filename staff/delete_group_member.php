<?php 
include('database.php');


$q=mysqli_query($con,"delete from accounts where id='".$_GET['id']."'");

header('location:index.php?page=display_member');

?>