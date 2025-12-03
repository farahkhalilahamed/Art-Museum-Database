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

    $stmt->bind_param("ssssss", $fname, $minit, $lname, $phone, $email);

    if ($stmt->execute()) {
        echo "<h2>Employee added successfully!</h2>";
        echo "<p><a href='addEmployee.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>
