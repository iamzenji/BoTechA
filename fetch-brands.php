<?php
include 'includes/connection.php';

if(isset($_GET['supplier_id'])) {
    $supplierId = mysqli_real_escape_string($connection, $_GET['supplier_id']);
    
    $query = "SELECT ml.brand, mt.type_name AS type, ml.unit, ml.wholesaleprice, ml.unitcost, ml.unit_qty, c.category_name
    FROM medicine_list ml
    JOIN category c ON ml.category_id = c.category_id
    JOIN MedicineType mt ON ml.type_id = mt.type_id
    WHERE ml.supplier_id = $supplierId
    ORDER BY ml.brand ASC";

    $result = mysqli_query($connection, $query);
    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $output = '<table class="table">';
            $output .= '<tr>
            <th> </th>
            <th>Category</th>
            <th>Brand</th>
            <th>Type</th>
            <th>Wholesale Price</th>
            <th>Unit Cost</th>
            <th>Unit</th>
            <th>Pieces</th>
            <th>Quantity</th>
            </tr>'; 
            while($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>';
                $output .= '<td><input type="checkbox" name="selected_medicines[]"  value="' . $row['brand'] .  '"></td>';
                $output .= '<td>' . $row['category_name'] . '</td>';
                $output .= '<td>' . $row['brand'] . '</td>';
                $output .= '<td>' . $row['type'] . '</td>';
                $output .= '<td>' . $row['wholesaleprice'] . '</td>';
                $output .= '<td>' . $row['unitcost'] . '</td>';
                $output .= '<td>' . $row['unit'] . '</td>';
                $output .= '<td>' . $row['unit_qty'] . '</td>';
                $output .= '<td><input type="number" class="form-control quantity" name="quantity[]" value="1" min="1"></td>';
                $output .= '</tr>';
            }
            $output .= '</table>'; 
            echo $output; 
        } else {
            echo '<p>No brands found for the selected categories.</p>';
        }
    } else {
        echo '<p>Error executing query: ' . mysqli_error($connection) . '</p>';
    }
} else {
    echo '<p>Supplier ID or Category IDs are not provided.</p>';
}
?>