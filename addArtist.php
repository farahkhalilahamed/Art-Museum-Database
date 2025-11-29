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
  $fname=$_POST["afname"];
  $minit=$_POST["aminitial"];
  $lname=$_POST["alname"];
  $dob=$_POST["dob"];
  $formattedDOB = date("Ymd", strtotime($dob));

	
  $country=$_POST["country"];
  $bio=$_POST["bio"];

  $sql = "INSERT INTO artist (AFName, AMInitial, ALName, DOB, Country, Bio)
          VALUES (?,?,?,?,?,?)";
  $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
  $stmt->bind_param("ssssss", $fname, $minit, $lname, $formattedDOB, $country, $bio);
  if ($stmt->execute()) {
        echo "<h2>Artist added successfully!</h2>";
        echo "<p><a href='add_artist.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

  
