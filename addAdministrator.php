<?php

$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
    die("Connection fail: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname = $_POST["fname"];
    $minit = $_POST["minit"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    $sql = "INSERT INTO employee (EFName, EMInitial, ELName, Phone, Email)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssis", $fname, $minit, $lname, $phone, $email);
    
if ($stmt->execute()) {
    $employeeID = $stmt->insert_id;
    $stmt->close();

    $exhibitionID = intval($_POST["ExhibitionID"]);
    $role = $_POST["Role"];
    $sql2 = "INSERT INTO Administrator (EmployeeID, ExhibitionID, Role)
            VALUES (?,?,?)";

    $stmt2 = $conn->prepare($sql2);

    if (!$stmt2) {
      die("Prepare failed: " . $conn->error);
    }
    $stmt2->bind_param("iis", $employeeID, $exhibitionID, $role);
      if ($stmt2->execute()) {
        echo "<h2>Administrator added successfully!</h2>";
        echo "<p><a href='addAdministrator.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error adding administrator: " . $stmt2->error;
    }

    $stmt2->close();
    }else {
        echo "Error adding employee: " . $stmt->error;
    }
$conn->close();
?>
