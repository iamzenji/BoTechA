<?php
include('db_conn.php');

if (isset($_POST['itemupdate'])) {
    // Retrieve form data
    $id = $_POST['id'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $supplier_id = $_POST['supplier_id']; // Assuming you're passing the supplier ID through POST

    // Update query
    $query = "UPDATE medicine_list 
              SET category_id = '$category', brand = '$brand', type_id = '$type', description = '$description', unit = '$unit', price = '$price' 
              WHERE medicine_id = '$id'";

    // Execute the update query
    $query_run = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($query_run) {
        echo '<script>alert("Item updated successfully.");</script>';
        if (isset($supplier_id)) {
            echo '<script>window.location.href = "supplier-list.php?supplier_id=' . $supplier_id . '";</script>'; // Redirect to the supplier list page based on supplier ID
        } else {
            echo '<script>alert("No supplier selected.");</script>';
            echo '<script>window.location.href = "supplier-list.php";</script>'; // Redirect to a default supplier list page if no supplier is selected
        }
    } else {
        echo '<script>alert("Failed to update item. Please try again.");</script>';
        echo '<script>window.location.href = "item.php";</script>'; // Redirect back to the edit modal page
    }
}
