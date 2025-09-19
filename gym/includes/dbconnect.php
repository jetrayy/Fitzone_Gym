<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "gym"; // Replace with your actual DB name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set charset and enable FK checks
$conn->set_charset("utf8mb4");
$conn->query("SET FOREIGN_KEY_CHECKS=1");
?>
