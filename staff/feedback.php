<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Feedback id</th>
      <th scope="col">User</th>
      <th scope="col">Message</th>
      <th scope="col">Your response</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    include 'database.php';
    
    // Fetch data from feedback table
    $query = "SELECT id, username, message, response FROM feedback";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<th scope='row'>" . $row['id'] . "</th>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['message'] . "</td>";
            echo "<td>" . $row['response'] . "</td>";
            echo "<td><a href='add_response.php?id=". $row['id'] ."'><button type='button' class='btn btn-primary'>Respond</button></a></td>";
            echo "</tr>";
        }
    } else{
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
    ?>
  </tbody>
</table>
</body>
</html>
