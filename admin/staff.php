<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
include 'connection.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
  <h1>Staff Accounts</h1> <hr>
 <a href="add_staff_member.php"><button type="button" class="btn btn-success" style="font-size: 14px;">Add Staff</button></a>
<table class="table table-striped" style="font-size: 14px;">
  <thead>
    <tr>
      <th scope="col">Staff id</th>
      <th scope="col">Email</th>
      <th scope="col">Password</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT id, email, password FROM staff";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th scope='row'>" . $row["id"] . "</th>";
            echo "<td>" . $row["email"] . "</td>";
            // Masking the password for security purposes
            echo "<td>*********</td>";
            echo "<td><a href='delete_staff_member.php?id=" . $row["id"] . "'><button type='button' class='btn btn-danger'><i class='fas fa-trash'></i><span class='glyphicon glyphicon-trash'></span></button></a></td>";
            echo "</tr>";
        }
    } else { 
        echo "<tr><td colspan='3'>No staff data found</td></tr>";
    }
    $conn->close();
    ?>
  </tbody>
</table>
</body>
</html>
