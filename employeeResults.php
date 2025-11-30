<?php

$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
    die("Connection fail: " . $conn->connect_error);
}

$fname = $_GET["fname"];
$lname = $_GET["lname"];
$position = $_GET["position"];

$sql = "SELECT EFName, EMInitial, ELName, Phone, Email, Position
        FROM employee
        WHERE EFName LIKE ? AND ELName LIKE ? AND Position LIKE ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$searchF = "%{$fname}%";
$searchL = "%{$lname}%";
$searchP = "%{$position}%";

$stmt->bind_param("sss", $searchF, $searchL, $searchP);

$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Employee Search Results</h1>";

if ($result->num_rows > 0) {
    echo '<table border="1.5" cellpadding="10">
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        $fullName = $row["EFName"] . " " . $row["EMInitial"] . " " . $row["ELName"];
        echo "<tr>
                <td>{$fullName}</td>
                <td>{$row['Position']}</td>
                <td>{$row['Phone']}</td>
                <td>{$row['Email']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No employees found.</p>";
}

echo "<p><a href='searchEmployee.html'>Search Again</a></p>";
echo "<p><a href='home.html'>Home</a></p>";

$stmt->close();
$conn->close();
?>
