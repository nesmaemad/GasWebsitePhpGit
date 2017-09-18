<?php
$servername = "localhost";
$username   = "nesma";
$password   = "0184463565";
$dbname     = "gas";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

?>