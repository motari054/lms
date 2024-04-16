<?php 
session_start();
include('database.php');
$user= $_SESSION['user'];
if($user=="")
{
header('location:index.php');
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
    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <script src="../js/ie-emulation-modes-warning.js"></script>
    <title>Users</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <span class="logo_name">User Panel</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.php?page=dashboard">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <li><a href="index.php?page=apply_loan">
                    <i><ion-icon name="add-circle"></ion-icon></i>
                    <span class="link-name">Apply Loan</span>
                </a></li>
                <li><a href="index.php?page=current_loan">
                    <i><ion-icon name="hourglass"></ion-icon></i>
                    <span class="link-name">Current Loan</span>
                </a></li>
                <li><a href="index.php?page=repay_loan">
                    <i><ion-icon name="return-right"></ion-icon></i>
                    <span class="link-name">Repay Loan</span>
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
        </div>
    
    <div class="main">
    <!-- container-->
<?php
@$page = $_GET['page'];
if ($page!=""){
  if($page=="dashboard"){
    include('dashboard.php');
  }
  if($page=="apply_loan"){
    include('apply_loan.php');
  }
  if($page=="current_loan"){
    include('current_loan.php');
  }
  if($page=="repay_loan"){
    include('repay_loan.php');
  }
  if($page=="feedback"){
    include('feedback.php');
  }
  if($page=="add_payment"){
    include('add_payment.php');
  }
  
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
</body>
</html>