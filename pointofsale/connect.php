<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "botecha";
// iconnect me database
$connection = new mysqli($server, $user, $pass, $db);

// check me nung miconnect ne database
if ($connection->connect_error) {
    die("Connection Failed: " . $connection->connect_error);
}
