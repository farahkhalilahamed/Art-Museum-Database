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

    $fname = $_POST["dfname"];
    $minit = $_POST["dminitial"];
    $lname = $_POST["dlname"];
    $amount = $_POST["amount"];
    $message = $_POST["text"];

    $sql = "INSERT INTO donor (DFName, DMInitial, DLName, Amount, Message)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssds", $fname, $minit, $lname, $amount, $message);

    if ($stmt->execute()) {
        echo "<h2>Donor added successfully!</h2>";
        echo "<p><a href='addDonor.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
