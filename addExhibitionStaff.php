
<?php

$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
  die("Connection fail:". $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"]=="POST")
{
  $exhibitionID=$_POST["ExhibitionID"];
  $employeeID=$_POST["EmployeeID"];

  $sql = "INSERT INTO ExhibitionStaff (EmployeeID, ExhibitionID)
          VALUES (?,?)";
  $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
  $stmt->bind_param("ii", $employeeID, $exhibitionID);
  if ($stmt->execute()) {
        echo "<h2>Exhibition Staff added successfully!</h2>";
        echo "<p><a href='addExhibitionStaff.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

  
