<?php
include 'includes/connectin.php';
include 'includes/header.php';
// Retrieve form data
$supplier = $_POST['supplier'];
$category = $_POST['category'];
$brand = $_POST['brand'];
$description = $_POST['description'];
$type = $_POST['type'];
$unit = $_POST['unit'];
$price = $_POST['price'];

// Prepare insert query
$sql = "INSERT INTO medicineList (brand, unit, price, description, supplier_id, category_id) 
VALUES ('$brand', '$unit' , '$price', '$description', '$supplier', '$category'  )";

// Execute insert query
if (mysqli_query($connection, $sql)) {
    // Item added successfully
    echo "Item added successfully";
} else {
    // Error handling
    echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}

mysqli_close($connection);
