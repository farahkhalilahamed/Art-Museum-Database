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
  $fname = $_POST["fname"];
  $minit = $_POST["minit"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $employeeID = $_POST["eid"];
  $sql = "UPDATE employee
          SET EFName = ?,
            EMInitial = ?,
            ELName = ?,
            Phone = ?, 
            Email = ? 
          WHERE EmployeeID = ?";

  $stmt = $conn->prepare($sql);

  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param("sssisi", $fname, $minit, $lname, $phone, $email, $employeeID);

  if ($stmt->execute()) {
    $stmt->close();
  }

    $exhibitionID = intval($_POST["ExhibitionID"]);
    $role = $_POST["Role"];
    $sql2 = "UPDATE AdministratorStaff
             SET EmployeeID = ?,
             ExhibitionID = ?,
             Role = ?
             WHERE EmployeeID = ?";
    $stmt2 = $conn->prepare($sql2);
    if (!$stmt2) {
      die("Prepare failed: " . $conn->error);
    }
    $stmt2->bind_param("iisi", $employeeID, $exhibitionID, $role, $employeeID);
      if ($stmt2->execute()) {
        echo "<h2>Administrator Staff updated successfully!</h2>";
        echo "<p><a href='updateAdministrator.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error updating Administrator staff: " . $stmt2->error;
    }

    $stmt2->close();
    }else {
        echo "Error updating administrator: " . $stmt->error;
    }
$conn->close();
?>
