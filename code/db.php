<?php

$host = "localhost";
$dbname = "campusconnect";
$username = "campususer";
$password = "Campus@123";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>

