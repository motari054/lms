<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../styling/loginPage.css">
    <title>Users Login-sign up</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST" action="login_signup.php">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>

                <div class="form-group">
                    <label>Gender: </label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="Male" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="Female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Group</label><br>
                    <select name="group" class="form-control" required>
                        <option selected disabled>--Select Group--</option>
                        <?php 
                        include ('database.php');
                        $q1=mysqli_query($con,"select * from groups");
                        while($r1=mysqli_fetch_assoc($q1)) {
                            echo "<option value='".$r1['group_id']."'>".$r1['group_name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button name="signup">Sign Up</button>
            </form>
        </div> 

        <div class="form-container sign-in">
            <form method="POST">
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" id="pass" required>
                <i class="fas fa-eye" onclick="show()"></i>
                <button name="login">Sign In</button>
                <a href="#">Forget Your Password?</a>
                <!-- Display Error Message -->
                <?php if(isset($_SESSION['message'])) echo $_SESSION['message']; ?>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Already have an account?</h1>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Don't have an account?</h1>
                    
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
    <script>
      function show(){
        var password = document.getElementById("pass");
        var icon = document.querySelector(".fas")
  
        // ========== Checking type of password ===========
        if(password.type === "password"){
          password.type = "text";
        }
        else {
          password.type = "password";
        }
      };
    </script>
</body>

</html>

<?php

include('database.php');

// Handle login form submission
if (isset($_POST["login"])) {
    // Validate and sanitize input
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Check if username exists in the database
    $sql = "SELECT * FROM accounts WHERE email = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify password
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["username"]; // Set the session variable with the username
            header("Location: index.php?page=dashboard");
            exit(); // Exit to prevent further execution
        } else {
            $_SESSION['message'] = "<div class='alert alert-warning' role='alert'>
            Wrong Email or Password!
          </div>";
            header("Location: login_signup.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "<div class='alert alert-warning' role='alert'>
        Wrong Email or Password!
      </div>";
        header("Location: login_signup.php");
        exit();
    }
}

// Handle registration form submission
if (isset($_POST['signup'])) {
    // Validate and sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $group = $_POST['group'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password == $confirm_password) {
        // Check if username is already taken
        $checkusername = "SELECT username FROM accounts WHERE username = '$username' LIMIT 1";
        $checkusername_run = mysqli_query($con, $checkusername);
 
        if (mysqli_num_rows($checkusername_run) > 0) {
            $_SESSION['message'] = "This username already exists!";
            header("Location: login_signup.php");
            exit();
        } else {
            // Hash the password before storing it in the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user data into the database
            $user_query = "INSERT INTO accounts (first_name, last_name, gender, `group`, username, email, password)
                           VALUES ('$first_name', '$last_name', '$gender', '$group', '$username', '$email', '$hashed_password')";
            $user_query_run = mysqli_query($con, $user_query);

            if ($user_query_run) {
                $_SESSION['message'] = "Sign up successful. Log in to continue";
                header("Location: login_signup.php"); // Redirect to login/signup page
                exit();
            } else {
                $_SESSION['message'] = "Error encountered";
                header("Location: login_signup.php");
                exit();
            }
        }
    } else {
        $_SESSION['message'] = "Passwords do not match";
        header("Location: login_signup.php");
        exit();
    }
}



$con->close();
?>
