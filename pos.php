<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    if (isset($_POST['add_piece'])) {
        $product_id = $_POST['product_id'];
        $product_qty = 1;

        $select_cart = $connection->query("SELECT * FROM cart WHERE item_id = $product_id AND scale = 'piece'");

        if (mysqli_num_rows($select_cart) == 0) {
            $insert = mysqli_query($connection, "INSERT INTO cart (item_id, qty,scale) 
        VALUES('$product_id','$product_qty','piece')");
        };
    }
    if (isset($_POST['add_box'])) {
        $product_id = $_POST['product_id'];
        $product_qty = 1;

        $select_cart = $connection->query("SELECT * FROM cart WHERE item_id = $product_id AND scale = 'box'");
        if (mysqli_num_rows($select_cart) == 0) {
            $insert = mysqli_query($connection, "INSERT INTO cart (item_id, qty,scale) 
        VALUES('$product_id','$product_qty','box')");
        };
    }

?>
    <div class="main-content">

        <div class="container">

            <div class="header">
                <h1><i class='bx bxs-basket bx-tada bx-rotate-270'></i> POS</h1>
            </div>
            <div class="wrap">
                <div class="row">
                    <table id="laman" class="table table-striped table-hover" style="width:100%">
                        <thead class="buntuk">
                            <tr>
                                <th>Generic</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Item Map</th>
                                <th>price-piece</th>
                                <th>price-pack</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * from item CROSS JOIN info
                     WHERE item.id = info.item_id;";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo "$row[generic_name] $row[brand_name]"; ?></td>
                                    <td><?php echo "$row[medicine_type]"; ?></td>
                                    <td><?php echo "$row[dosage]"; ?></td>
                                    <td>alapa</td>
                                    <td><?php echo "$row[price_piece]"; ?> <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                            <input button class="btn btn-primary btn-sm" class="bg-dark-subtle" type="Submit" value="Piece" name="add_piece">
                                        </form>
                                    </td>
                                    <td><?php echo "$row[price_pack]"; ?>
                                        <form action="" method="post">
                                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">

                                            <input class="bg-success" type="Submit" value="Pack" name="add_box">

                                            <!-- <button type="button" class="btn btn-outline-primary">Primary</button> -->
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // new DataTable('#laman');
    </script>

<?php } ?>