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
if ($result->num_rows > 0) {
    echo '<table border="1.5" cellpadding="10">
            <tr>
                <th>Title</th>
                <th>Starts</th>
                <th>Ends</th>
                <th>Description</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {

        echo "<tr>
                <td>{$row['Title']}</td>
                <td>{$row['StartDate']}</td>
                <td>{$row['EndDate']}</td>
                <td>{$row['Description']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No exhibitions in the database.</p>";
}
?>

<p><a href="home.html">Back to Home</a></p>

</body>
</html>

<?php
$conn->close();
?>
