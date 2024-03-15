<?php

$host = "localhost"; // e.g., "localhost"
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$database = "botecha"; // your MySQL database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8 (optional, adjust based on your needs)
$conn->set_charset("utf8");
