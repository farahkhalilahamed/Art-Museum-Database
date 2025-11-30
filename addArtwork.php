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
  $Title=$_POST["Title"];
  $Year =$_POST["Year"];
  $Medium=$_POST["Medium"];
  $text=$_POST["text"];
  $ArtistID = $_POST["ArtistID"];

	
  $country=$_POST["country"];
  $bio=$_POST["bio"];

  $sql = "INSERT INTO artwork (Title, YearCreated, ArtMedium, Details, ArtistID)
          VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
  $stmt->bind_param("sssss", $Title, $Year, $Medium, $text, $ArtistID);
  if ($stmt->execute()) {
        echo "<h2>Artwork added successfully :)!</h2>";
        echo "<p><a href='addArtwork.html'>Add Another</a></p>";
        echo "<p><a href='home.html'>Go Home</a></p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

  