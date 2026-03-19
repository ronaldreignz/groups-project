<?php
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);

$host = "dpg-d6u1c1i4d50c73ck19eg-a.frankfurt-postgres.render.com";
$port = "5432";
$dbname = "groups_db_awm4";
$user = "groups_db_awm4_user";
$password = "zgCCRjPp6mK7E02ZuuP6rLPnJfYhacZO";

 $conn = pg_connect("host=$host port=5432 dbname=$dbname user=$user password=$password");

 if (!$conn) {
     die("Connection failed: " . pg_last_error());
}

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $name = isset($_POST['name']) ? $_POST['name'] : null;
      $course = isset($_POST['course']) ? $_POST['course'] : null;

      if ($name && $course) {
            $sql = "INSERT INTO students (name, course) VALUES ('$name', 'course')";

            $result = pg_query($conn, $sql);

           if ($result) {
               header("Location: db_connect.php");
               exit();
            }else{
         echo "Error: " . $pg_last_error($conn);
     }
   }
 }


   if (isset($_GET['delete'])) {
       $id = $_GET['delete'];
       pg_quey($conn, "DELETE FROM students WHERE id=$id");
       header("Location: db_connect.php");
       exit();
}
  
 $result = pg_query($conn,"SELECT * FROM students ORDER BY id");
 if (!$result) {
     die("Query failed: " . pg_last_error($conn));
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
    if (pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {

         echo "<tr>";
         echo "<td>" . $row['id'] . "</td>";
         echo  "<td>" . $row['name'] . "</td>";
         echo "<td>" . $row['course'] . "</td>";
         echo "<td>";

         echo "<a href='?delete=" . $row['id'] . "'
               class='delete-btn'
               onclick=\"return confirm('DELETE " . $row['name'] . "?')\">Delete</a>";
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
pg_close($conn);
?>


</body>
</html>

