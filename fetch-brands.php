<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine List</title>
    <style>
        .table-container {
            max-height: 600px;
            overflow-y: auto;
            width: 100%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table thead {
            display: block;
            width: 100%;
        }
        .table tbody {
            display: block;
            max-height: 330px;
            overflow-y: auto;
            width: 100%;
        }
        .table th, .table td {
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        .table th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table th, .table td {
            width: 10%;
        }
        .table th:nth-child(1), .table td:nth-child(1) {
            width: 5%;
        }
        .table th:nth-child(5), .table td:nth-child(5),
        .table th:nth-child(6), .table td:nth-child(6),
        .table th:nth-child(7), .table td:nth-child(7),
        .table th:nth-child(8), .table td:nth-child(8),
        .table th:nth-child(9), .table td:nth-child(9) {
            width: 10%;
        }
        .form-control {
            width: 100%;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<div class="table-container">
    <?php
    include 'includes/connection.php';

    if (isset($_GET['supplier_id'])) {
        $supplierId = mysqli_real_escape_string($connection, $_GET['supplier_id']);

        $query = "SELECT ml.brand, mt.type_name AS type, ml.unit, ml.wholesaleprice, ml.unitcost, ml.unit_qty, c.category_name
        FROM medicine_list ml
        JOIN category c ON ml.category_id = c.category_id
        JOIN MedicineType mt ON ml.type_id = mt.type_id
        WHERE ml.supplier_id = $supplierId
        ORDER BY ml.brand ASC";

        $result = mysqli_query($connection, $query);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $output = '<div style="max-height: 600px; overflow-y: auto; width: 100%;"><table class="table">';
                $output .= '<thead>
                <tr>
                <th></th>
                <th>Category</th>
                <th>Brand</th>
                <th>Type</th>
                <th>Wholesale Price</th>
                <th>Unit Cost</th>
                <th>Unit</th>
                <th>Pieces</th>
                <th>Quantity</th>
                </tr>
                </thead>';
                $output .= '<tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= '<tr>';
                    $output .= '<td><input type="checkbox" name="selected_medicines[]" value="' . $row['brand'] . '"></td>';
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
                $output .= '</tbody></table></div>';
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
</div>

</body>
</html>
