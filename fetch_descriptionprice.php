<?php
include 'includes/connection.php';
if (isset($_GET['supplier_id'], $_GET['category_id'], $_GET['brand'], $_GET['type'])) {
    $supplier_id = mysqli_real_escape_string($connection, $_GET['supplier_id']);
    $category_id = mysqli_real_escape_string($connection, $_GET['category_id']);
    $brand = mysqli_real_escape_string($connection, $_GET['brand']);
    $type = mysqli_real_escape_string($connection, $_GET['type']);

    // Query to fetch description, price, and unit based on category, brand, and type
    $query = "SELECT description, price, unit FROM medicine_list WHERE supplier_id = '$supplier_id' AND category_id = '$category_id' AND brand = '$brand' AND type_id = '$type'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = array(
            'success' => true,
            'description' => $row['description'],
            'price' => $row['price'],
            'unit' => $row['unit']
        );
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
} else {
    $response = array('success' => false);
    echo json_encode($response);
}
