<?php 
session_start();
include('../admin/connection.php');
$admin= $_SESSION['admin'];
if($admin=="")
{
header('location:../index.php');
}
?>

<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../styling/style.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script src="../js/ie-emulation-modes-warning.js"></script>
    <title>Staff</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">Staff Panel</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <!-- <li><a href="index.php?page=update_password">
                    <i class="uil uil-lock"></i>
                    <span class="link-name">Update Password</span>
                </a></li> -->
                <li><a href="index.php?page=display_group">
                    <i><ion-icon name="people"></ion-icon></i>
                    <span class="link-name">Groups</span>
                </a></li>
                <li><a href="index.php?page=display_member">
                    <i><ion-icon name="person"></ion-icon></i>
                    <span class="link-name">Members</span>
                </a></li>
                <li><a href="index.php?page=display_loan">
                    <i><ion-icon name="cash"></ion-icon></i>
                    <span class="link-name">Group Loan</span>
                </a></li>
                <li><a href="index.php?page=user_loan">
                    <i><ion-icon name="cash"></ion-icon></i>
                    <span class="link-name">User Loan</span>
                </a></li>
                <li><a href="index.php?page=user_payment">
                    <i><ion-icon name="contact"></ion-icon></i>
                    <span class="link-name">User Payment</span>
                </a></li>
                <li><a href="index.php?page=display_payment_history">
                    <i><ion-icon name="contacts"></ion-icon></i>
                    <span class="link-name">Group Payment</span>
                </a></li>
                <li><a href="index.php?page=feedback">
                    <i><ion-icon name="text"></ion-icon></i>
                    <span class="link-name">Feedback</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
    
    <div class="main">
          <!-- container-->
		  <?php 
		@$page=  $_GET['page'];
		  if($page!="")
          {
            if($page=="add_group")
			{
				include('add_group.php');
			
			}
            if($page=="display_group")
			{
				include('display_group.php');
			
			}
			if($page=="search_group")
			{
				include('search_group.php');
			
			}
			
			if($page=="update_group")
			{
				include('update_group.php');
			
			}
			if($page=="display_member")
			{
				include('display_member.php');
			
			}
			if($page=="search_member")
			{
				include('search_member.php');
			
			}
			
			if($page=="add_group_member")
			{
				include('add_group_member.php');
			
			}
			
			if($page=="update_group_member")
			{
				include('update_group_member.php');
			
			}
			
			if($page=="add_loan")
			{
				include('add_loan.php');
			
			}
			
			if($page=="display_loan")
			{
				include('display_loan.php');
			
			}
			
			if($page=="search_loan")
			{
				include('search_loan.php');
			
			}
			
			if($page=="update_loan_record")
			{
				include('update_loan_record.php');
			
			}
			if($page=="loan_actions")
			{
				include('loan_actions.php');
			
			}
			
			if($page=="display_payment_history")
			{
				include('display_payment_history.php');
			
			}
			
			if($page=="add_payment_history")
			{
				include('add_payment_history.php');
			
			}
			
			if($page=="update_password")
			{
				include('update_password.php');
			
			}
            if($page=="feedback")
			{
				include('feedback.php');
			
			}	
            if($page=="user_loan")
			{
				include('user_loan.php');
			}
            if($page=="user_payment")
			{
				include('user_payment.php');
			}
            if($page=="search_user_loan")
			{
				include('search_user_loan.php');
			}
		}
		else
		{
		include('dashboard.php');
		}
		?>
        </div>
        </section>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <script src="../styling/script.js"></script>
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>
</html>