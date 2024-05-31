    <?php

    // session_start();
    include 'includes/connection.php';
    include 'includes/header.php';

    if (strlen($_SESSION['employee_id']) === 0) {
        header('location:login.php');
        session_destroy();
    } else {

    ?>
      <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar With Bootstrap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
    .biicons {
        font-size: 45px; 
        margin-right: 30px; 
        margin-left: 30px; 
        color: #17a2b8;
    }
    .order-count {
        font-size: 32px; 
        font-weight: bold;
    }
    .gap{
        margin-top: 30px;
    }
</style>
</head>

<body>
    <div class="wrapper">
      
        <div class="main p-3">
            <div class="text-left">
                <h1 class="head"> Welcome to Purchase Order Management</h1>
                <hr>
                <div class="container gap">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div><i class="bi bi-truck biicons"></i></div>
                        <div class="ms-2">
                            <h3 class="mb-0">Supplier</h3>
                            <?php
                            include 'includes/connection.php';

                            $query = "SELECT COUNT(*) AS order_count FROM supplier"; 

                            $result = mysqli_query($connection, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $supplierCount = $row['order_count'];
                                echo "<p class='mb-0 order-count'>$supplierCount</p>"; 
                            } else {
                                echo "Error: " . mysqli_error($connection);
                            }

                            mysqli_close($connection);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div><i class="bi bi-cart-fill biicons"></i></div>
                        <div class="ms-2">
                            <h4 class="mb-0">Purchase Orders</h4>
                            <?php
                           include 'includes/connection.php';

                            $query = "SELECT COUNT(*) AS order_count FROM cart_table"; 

                            $result = mysqli_query($connection, $query);

                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $orderCount = $row['order_count'];
                                echo "<p class='mb-0 order-count'>$orderCount</p>";
                            } else {
                                echo "Error: " . mysqli_error($connection);
                            }

                            mysqli_close($connection);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div><i class="bi bi-cart-check-fill biicons"></i></div>
                        <div class="ms-2">
                            <h4 class="mb-0">Completed Orders</h4>
                                     <?php
                                    include 'includes/connection.php';

                                    $query = "SELECT COUNT(*) AS completed_order_count FROM cart_table 
                                            JOIN order_table ON cart_table.order_id = order_table.id 
                                            JOIN delivery_status ON cart_table.delivery_status_id = delivery_status.id 
                                            WHERE delivery_status.status_name = 'Completed'";

                                    $result = mysqli_query($connection, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        $completedOrderCount = $row['completed_order_count'];
                                        echo "<p class='mb-0 order-count'> $completedOrderCount</p>";
                                    } else {
                                        echo "Error: " . mysqli_error($connection);
                                    }

                                    mysqli_close($connection);
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
            <div class=" gap">

    <div class="row p-4">
        <div class="col-md-6">
        
                <h3>Inventory</h3>
                <?php
include 'includes/connection.php';

$query = "SELECT supplier, brand, type, qty_stock
          FROM inventory";

$result = mysqli_query($connection, $query);

if ($result) {
    echo "<table class='table'>";
    echo "<thead><tr>
    <th>Supplier</th>
    <th>Brand</th>
    <th>Type</th>
    <th>Qty Stock</th>
    <th>Stock Level</th>
    </tr></thead>";
    echo "<tbody>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['supplier'] . "</td>";
        echo "<td>" . $row['brand'] . "</td>";
        echo "<td>" . $row['type'] . "</td>";
        echo "<td>" . $row['qty_stock'] . "</td>";
        
        $stockLevel = '';
        if ($row['qty_stock'] <= 200) {
            $stockLevel = 'Low Stock';
        } elseif ($row['qty_stock'] > 200 && $row['qty_stock'] <= 500) {
            $stockLevel = 'Minimum Low Stock';
        } else {
            $stockLevel = 'High Stock';
        }
        
        echo "<td>" . $stockLevel . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>

 
        </div>
        <div class="col-md-6">
        <h3>Fast Selling Items</h3>
            <table class="table">
                
                <tbody>
                <?php
 include 'includes/connection.php';
 
 
 $query = "SELECT inventory.brand, inventory.type, 
                  SUM(mesali.qty) AS total_sales,
                  inventory.qty_stock AS total_inventory,
                  CASE
                      WHEN SUM(mesali.qty) / inventory.qty_stock >= 0.8 THEN 'Fast Selling'
                      WHEN SUM(mesali.qty) / inventory.qty_stock >= 0.75 THEN 'Slow Selling'
                      ELSE 'Non-Moving'
                  END AS sales_category
           FROM mesali
           JOIN inventory ON mesali.item_id = inventory.inventory_id
           GROUP BY inventory.brand, inventory.type
           ORDER BY total_sales DESC";
 
 $result = mysqli_query($connection, $query);
 
 if ($result) {
     echo "<table class='table'>";
     echo "<thead><tr>
     <th>Brand</th>
     <th>Type</th>
     <th>Total Sales</th>
     <th>Total Inventory</th>
     <th>Sales Category</th>
     </tr></thead>";
     echo "<tbody>";
     while ($row = mysqli_fetch_assoc($result)) {
         echo "<tr>";
         echo "<td>" . $row['brand'] . "</td>"; 
         echo "<td>" . $row['type'] . "</td>";
         echo "<td>" . $row['total_sales'] . "</td>"; 
         echo "<td>" . $row['total_inventory'] . "</td>"; 
         echo "<td>" . $row['sales_category'] . "</td>";
         echo "</tr>";
     }
     echo "</tbody>";
     echo "</table>";
 } else {
     echo "Error: " . mysqli_error($connection);
 }
 mysqli_close($connection);
 ?>
 
 

                </tbody>
            </table>
        </div>
    </div>
            </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script type="text/javascript">
        const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
});
    </script>
</body>

</html>

    <?php } ?>