<?php

$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
  die("Connection fail:". $conn->connect_error);
}

if (isset($_POST['submit']))
{
  $exhibitionName=$_POST["exhibitionName"];
  $location=$_POST["location"];
  $start=$_POST["start"];
  $formattedStart = date("Ymd", strtotime($start));
  $end=$_POST["end"];
  $formattedend = date("Ymd", strtotime($end));
  $artwork=$_POST["artwork"];
  $description=$_POST["description"];

  $sql = "INSERT INTO exhibition (Title, LocationID, StartDate, EndDate, Description)
          VALUES (?,?,?,?,?)";
  $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
  $stmt->bind_param("sisss", $exhibitionName, $location, $formattedStart, $formattedend, $description);
  if ($stmt->execute()) {
        echo "<h2>Exhibition added successfully!</h2>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $exhibitionID = $stmt->insert_id;

    $stmt->close();
}
if (!empty($artwork) && is_array($artwork)){
  foreach ($artwork as $artworkTitle) {
    $artworkTitle = trim($artworkTitle);
    
    if ($artworkTitle == "") continue;
    $search = "%{$artworkTitle}%";
    $stmt = $conn->prepare("SELECT ArtworkID, ArtistID
                            FROM artwork 
                            WHERE Title Like ?");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();



    if ($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) 
      {
        $artworkID= $row['ArtworkID'];
        $artistID= $row['ArtistID'];
        $stmt2 = $conn->prepare("INSERT INTO ExhibitedArtwork (ExhibitionID, ArtworkID, ArtistID) 
                                VALUES (?,?,?)");
        $stmt2->bind_param("iii", $exhibitionID, $artworkID, $artistID);
        $stmt2->execute();
        $stmt2->close();
      }
      echo "<h2>Artwork added successfully!</h2>"; 
    }else
    {echo "<h2>No artwork found :( </h2>";}
    $stmt->close();
}}
echo "<p><a href='addExhibition.html'>Add Another</a></p>";
echo "<p><a href='home.html'>Go Home</a></p>";
$conn->close();
?>

  
