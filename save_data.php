<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor_data";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters (validate as floats)
$ph = isset($_GET['ph']) ? floatval($_GET['ph']) : null;
$temp = isset($_GET['temp']) ? floatval($_GET['temp']) : null;

if ($ph === null || $temp === null) {
    echo "Error: Missing ph or temp parameters";
    $conn->close();
    exit();
}

// Prepared statement
$stmt = $conn->prepare("INSERT INTO readings (ph, temperature) VALUES (?, ?)");
$stmt->bind_param("dd", $ph, $temp);  // d = double/float

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>