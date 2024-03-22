<?php
include 'includes/connection.php';
if (isset($_GET['supplier_id'])) {
    $supplier_id = $_GET['supplier_id'];

    // Query to fetch category IDs associated with the selected supplier in the medicine_list table
    $query = "SELECT DISTINCT ml.category_id, c.category_name FROM medicine_list ml
              JOIN category c ON ml.category_id = c.category_id
              WHERE ml.supplier_id = $supplier_id";

    $result = mysqli_query($connection, $query);

    // Check if query executed successfully
    if ($result && mysqli_num_rows($result) > 0) {
        // Output the disabled selected option
        echo '<option value="" name="category" disabled selected>--Select Category--</option>';

        // Output option tags for each category
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
        }
    } else {
        echo '<option value="" disabled selected>No categories found</option>';
    }
} else {
    echo '<option value="" disabled selected>Invalid request</option>';
}
