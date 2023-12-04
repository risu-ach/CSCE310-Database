<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "310_project";

//$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$conn = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>