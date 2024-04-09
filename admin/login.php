<?php
session_start();

	include('connection.php');
		extract($_POST);
	if(isset($login))
	{
        $pass=sha1($pass);
		$que=mysqli_query($conn,"select * from admin where user='$email' and pass='$pass'");
		$row=mysqli_num_rows($que);
		if($row)
			{	
				$_SESSION['admin']=$email;
				header('location:index.php');
			}
		else
			{
				$err="<font color='red'>Wrong Email or Password!</font>";
			}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../styling/loginPage.css">
    <title>Admim Login</title>
</head>

<body style="background:#CCCCCC">

<div class="container" id="container">
        <div class="form-container sign-in">
            <form method="post">
                <h1>Sign In</h1>
                <input class="form-control" name="email" type="email" placeholder="E-mail" required>
                <input class="form-control" placeholder="Password" name="pass" type="password" required>
                <button name="login" type="submit">Sign In</button>
                <?php echo @$err;?>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello Admin</h1>
                    <p>Enter admin email and password to sign in</p>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
