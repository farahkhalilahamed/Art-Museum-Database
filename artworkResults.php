<?php


$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
	die("Connection fail:". $conn->connect_error);
}

$Title =$_GET['Title'];


$sql = "SELECT ArtworkID, Title, YearCreated, ArtMedium, Details
        FROM artwork
	WHERE Title LIKE ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
	die("Prepare failed: " . $conn->error);
    }
$search = "%{$Title}%";

$stmt->bind_param("s", $search);

if ($stmt->execute()) {
	echo "<h2>Artwork Results :)!</h2>";
	$result = $stmt->get_result();
	if ($result->num_rows > 0) {
		echo '<table border="1.5" cellpadding="10">
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>YearCreated</th>
				<th>ArtMedium</th>
				<th>Details</th>
			</tr>';
		while ( $row = $result->fetch_assoc()) {
			echo "<tr>
				<td>{$row['ArtworkID']}</td>
				<td>{$row['Title']}</td>
				<td>{$row['YearCreated']}</td>
				<td>{$row['ArtMedium']}</td>
				<td>{$row['Details']}</td>
				</tr>";
	}

	echo"</table>";

}
else {
	echo "<p>No artwork found with that title: '{$Title}'.</p>";
}
		
echo "<p><a href='searchArtwork.html'>Go Back</a></p>";
echo "<p><a href='home.html'>Go Home</a></p>";

$stmt->close();
}

$conn->close();
?>

  
