<?php
include 'includes/connection.php';
include 'includes/header.php';
// Retrieve form data
if (isset($_POST['addItemBtn'])) {
    // Retrieve form data
    $supplier = $_POST['supplier'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];

    // Prepare insert query
    $query = "INSERT INTO medicine_list (brand, unit, price, type_id,  description, supplier_id, category_id) 
VALUES ('$brand', '$unit' , '$price', '$type' , '$description', '$supplier', '$category'  )";




    $query_run = mysqli_query($connection, $query);
    // Execute insert query
    if ($query_run) {
        // Data is successfully inserted
        echo '<script> alert("Data Saved"); </script>';
        // Redirecting to another page
        echo '<script>window.location.href = "item.php";</script>';
    } else {
        // Error handling
        echo '<script> alert("Data not  Saved"); </script>';
        // Redirecting to another page
        echo '<script>window.location.href = "item.php";</script>';
    }
}
// Close database connection
mysqli_close($connection);
