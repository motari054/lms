<?php
include 'connection.php';

$message = ""; // Initialize an empty message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['inputEmail']) && isset($_POST['inputPassword']) && isset($_POST['confirmPassword'])) {
        $email = $_POST['inputEmail'];
        $password = $_POST['inputPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if($password != $confirmPassword) {
            $message = "<div id='alert' class='alert alert-danger' role='alert'>
            Passwords do not match!
          </div>";
        } else {
            $check_query = "SELECT * FROM staff WHERE email='$email'";
            $check_result = $conn->query($check_query);

            if ($check_result->num_rows > 0) {
                $message = "<div id='alert' class='alert alert-danger' role='alert'>
                Email already exists!
              </div>";
            } else {
                // Hash the password using SHA-1
                $hashed_password = sha1($password);

                $insert_query = "INSERT INTO staff (email, password) VALUES ('$email', '$hashed_password')";
                if ($conn->query($insert_query) === TRUE) {
                    $message = "<div id='alert' class='alert alert-success' role='alert'>
                New Staff Account Added Successfully!
              </div>";
                } else {
                    $message = "Error: " . $insert_query . "<br>" . $conn->error;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff Member</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Add Staff Member</h1>
    <?php echo $message; ?> <!-- Display the message here -->
  <div class="form-group row">
    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail" name="inputEmail">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword" name="inputPassword">
    </div>
  </div>
  <div class="form-group row">
    <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>

<script>
    // Check if the message is a success message, then hide it after 2 seconds and redirect after hiding
    <?php if(strpos($message, "success") !== false): ?>
        setTimeout(function() { 
            document.getElementById('alert').style.display = 'none'; 
            setTimeout(function() { window.location.href = 'index.php'; }, 2000);
        }, 2000);
    <?php endif; ?>
</script>
</body>
</html>
