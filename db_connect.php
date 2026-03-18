<?php
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "webuser";
$password = "password123";
$dbname = "groups_db";

 $conn = new mysqli($servername, $username, $password, $dbname);

 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
}

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $name = isset($_POST['name']) ? $_POST['name'] : null;
      $course = isset($_POST['course']) ? $_POST['course'] : null;

      if ($name && $course) {
            $sql = "INSERT INTO students (name, course) VALUES ('$name', 'course')";

          if ($conn->query($sql) === TRUE) {
             echo "New record created successfully";
     }else{
         echo "Error: " . $conn->error;
     }
   }
 }


   if (isset($_GET['delete'])) {
       $id = $_GET['delete'];
       $conn->query("DELETE FROM students WHERE id=$id");
       header("Location: index.php");
       exit();
}
  
 $result = $conn->query("SELECT * FROM students");
 if (!$result) {
     die("Query failed: " . $conn->error);
}
?>


<html>
<head>
  <title> Group Memberinfo </title>
</head>
<body> 

 <h1>Group Members</h1>
    
 <table border="3">
     <tr>
         <th>ID</th>
         <th>NAME</th>
         <th>COURSE</th>
         <th>Action</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {

         echo "<tr>";
         echo "<td>" . $row['id'] . "</td>";
         echo  "<td>" . $row['NAME'] . "</td>";
         echo "<td>" . $row['COURSE'] . "</td>";
         echo "<td>";

         echo "<a href='?delete=" . $row['id'] . "'
               class='delete-btn'
               onclick=\"return confirm('DELETE " . $row['NAME'] . "?')\">Delete</a>";
         echo "</td>";
         echo "</tr>";

      }
     }else{
        echo "No students found";
     }
     ?>

</table>

 <p><a href="index.php">BACK TO FORM</a></p>
<?php
$conn->close();
?>


</body>
</html>

