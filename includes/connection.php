<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "botecha";

$connection = new mysqli($server, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
