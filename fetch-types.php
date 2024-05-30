<?php
include 'includes/connection.php';
// Check if supplier_id, category_id, and brand are set
if (isset($_GET['supplier_id'], $_GET['category_id'], $_GET['brand'])) {
    // Sanitize inputs to prevent SQL injection
    $supplier_id = mysqli_real_escape_string($connection, $_GET['supplier_id']);
    $category_id = mysqli_real_escape_string($connection, $_GET['category_id']);
    $brand = mysqli_real_escape_string($connection, $_GET['brand']);

    // Query to fetch types associated with the selected category, brand, and supplier
    $query = "SELECT DISTINCT mt.type_id, mt.type_name FROM medicinetype mt
              INNER JOIN medicine_list ml ON mt.type_id = ml.type_id
              WHERE ml.supplier_id = '$supplier_id' AND ml.category_id = '$category_id' AND ml.brand = '$brand'";

    $result = mysqli_query($connection, $query);

    // Check if query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        // Output option tags for each type
        echo '<option value="" disabled selected>--Select Type--</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['type_id']}'>{$row['type_name']}</option>";
        }
    } else {
        echo '<option value="" disabled selected>No types found</option>';
    }
} else {
    echo '<option value="" disabled selected>Invalid request</option>';
}
