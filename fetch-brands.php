<?php
include 'includes/connection.php';
// Check if supplier_id and category_id are set
if (isset($_GET['supplier_id']) && isset($_GET['category_id'])) {
    $supplier_id = $_GET['supplier_id'];
    $category_id = $_GET['category_id'];

    // Query to fetch brands associated with the selected category and supplier
    $query = "SELECT DISTINCT ml.brand FROM medicine_list ml
              WHERE ml.supplier_id = $supplier_id AND ml.category_id = $category_id";

    $result = mysqli_query($connection, $query);

    // Check if query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        // Output option tags for each brand
        echo '<option value="" disabled selected>--Select Brand--</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['brand']}'>{$row['brand']}</option>";
        }
    } else {
        echo '<option value="" disabled selected>No brands found</option>';
    }
} else {
    echo '<option value="" disabled selected>Invalid request</option>';
}
