<?php


$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
	die("Connection fail:". $conn->connect_error);
}

$lname =$_GET['lname'];


$sql = "SELECT ArtistID, AFName, AMInitial, ALName, DOB, Country, Bio
        FROM artist
	WHERE ALName LIKE '$lname'";

#$stmt = $conn->prepare($sql);

$search = "%{$lname}%";

#$stmt->bind_param("s", $search);
$result = $conn->query($sql);
if ($result) {
	echo "<h2>Artist Results :)!</h2>";
	if ($result->num_rows > 0) {
		echo '<table border="1.5" cellpadding="10">
			<tr>
				<th>ID</th>
				<th>First Name</th>
				<th>Middle initial</th>
				<th>Last name</th>
				<th>DOB</th>
				<th>Country</th>
				<th>Bio</th>
			</tr>';
		while ( $row = $result->fetch_assoc()) {
			echo "<tr>
				<td>{$row['ArtistID']}</td>
				<td>{$row['AFName']}</td>
				<td>{$row['AMInitial']}</td>
				<td>{$row['ALName']}</td>
				<td>{$row['DOB']}</td>
				<td>{$row['Country']}</td>
				<td>{$row['Bio']}</td>
				</tr>";
	}

	echo"</table>";

}
else {
	echo "<p>No artist found with last name: '{$lname}'.</p>";
}
		
echo "<p><a href='searchArtistBad.html'>Go Back</a></p>";
echo "<p><a href='homeBad.html'>Go Home</a></p>";

#$stmt->close();
}

$conn->close();
?>

  
