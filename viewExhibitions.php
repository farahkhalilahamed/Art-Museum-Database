<?php
$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT Title, StartDate, EndDate, Description FROM Exhibition";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Employees</title>
</head>
<body>

<h1>Employees</h1>

<?php
if ($result && $result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['location']) . "</td>";
        echo "<td>" . htmlspecialchars($row['dates']) . "</td>";
        echo "<td>" . htmlspecialchars($row['artworks_displayed']) . "</td>";
        echo "</tr>";
    }

} else {
    echo "<tr><td colspan='4'>No exhibitions found.</td></tr>";
}
?>

<p><a href="home.html">Back to Home</a></p>

</body>
</html>

<?php
$conn->close();
?>
