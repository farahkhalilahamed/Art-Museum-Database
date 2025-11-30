<?php

$host = "localhost";
$user = "root";
$pass = "databasedarlings";
$dbname = "art_museum";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error){
    die("Connection fail: " . $conn->connect_error);
}

$lname = $_GET["lname"];

$sql = "SELECT DonorID, DFName, DMInitial, DLName, Amount, Message
        FROM donor
        WHERE DLName LIKE ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$search = "%{$lname}%";

$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

echo "<h1>Donor Search Results</h1>";

if ($result->num_rows > 0) {

    echo '<table border="1.5" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Message</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {

        $fullName = $row["DFName"] . " " . $row["DMInitial"] . " " . $row["DLName"];

        echo "<tr>
                <td>{$row['DonorID']}</td>
                <td>{$fullName}</td>
                <td>\${$row['Amount']}</td>
                <td>{$row['Message']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No donors found.</p>";
}

echo "<p><a href='searchDonor.html'>Search Again</a></p>";
echo "<p><a href='home.html'>Go Home</a></p>";

$stmt->close();
$conn->close();
?>
