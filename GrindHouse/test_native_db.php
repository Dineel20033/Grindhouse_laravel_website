<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$port = 3307;
$conn = new mysqli($servername, $username, $password, "", $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
$conn->close();
?>