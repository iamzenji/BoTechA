<?php
include 'includes/connection.php';
include 'includes/header.php';
?>
<div class="wrapper">
    <div class="main p-3">
        <div class="text-center">
            <ul class="list">
                <li class="d-flex justify-content-between align-items-center">
                    <h2 class="me-3">Supplier's medicine List</h2>
                </li>
            </ul>
            <form action="">
                <div class="input-group d-flex mt-4">
                    <span class="input-group-text"><i class="lni lni-search-alt"></i></span>
                    <input type="search" class="form-control" placeholder="Search">
                </div>
            </form>
            <table class="table table-boarded table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Brand Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                if (isset($_GET['supplier_id'])) {
                    // Fetch supplier ID from the GET parameters
                    $supplier_id = $_GET['supplier_id'];

                    // Fetch medicine list for the selected suppliers
                    $query = "SELECT ml.*, c.category_name, mt.type_name
                            FROM medicine_list ml
                            JOIN Category c ON ml.category_id = c.category_id
                            JOIN MedicineType mt ON ml.type_id = mt.type_id
                            WHERE ml.supplier_id = $supplier_id";
                    $query_run = mysqli_query($connection, $query);

                    // Check if query executed successfully
                    if ($query_run && mysqli_num_rows($query_run) > 0) {
                        // Output data of each rows
                        while ($row = mysqli_fetch_assoc($query_run)) {
                            // Output medicine details as desired
                            // For example:
                            echo "<tr>";
                            echo "<td>" . $row["medicine_id"] . "</td>";
                            echo "<td>" . $row["category_name"] . "</td>";
                            echo "<td>" . $row["brand"] . "</td>";
                            echo "<td>" . $row["description"] . "</td>";
                            echo "<td>" . $row["type_name"] . "</td>";
                            echo "<td>" . $row["unit"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td> 
                                        <a href='edit_medicine.php?id=" . $row["medicine_id"] . "' class='btn btn-primary'>Edit</a>
                                        <a href='delete_medicine.php?id=" . $row["medicine_id"] . "' class='btn btn-danger'>Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no medicines found for the selected supplier
                        echo "<tr><td colspan='8'>No medicines found for this supplier.</td></tr>";
                    }
                } else {
                    // If supplier_id parameter is not set, show all medicines
                    echo "<tr><td colspan='8'>Please select a supplier.</td></tr>";
                }
                ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>
</div>