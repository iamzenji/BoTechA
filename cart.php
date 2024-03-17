<?php
$total = 0;
$grand_total = 0;
$dis = 0;
$price = 0;
$pera = 0;

session_start();

include 'includes/connection.php';

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];

    $update_quantity_query = mysqli_query($connection, " UPDATE cart SET qty = $update_value WHERE cart_id = $update_id");
    if ($update_quantity_query) {
        header('location:pos.php');
    };
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($connection, "DELETE FROM cart WHERE cart_id = $remove_id");
    header('location:pos.php');
};

if (isset($_GET['delete_all'])) {
    mysqli_query($connection, "DELETE FROM cart");
    header('location:pos.php');
};

if (isset($_POST['cash'])) {
    $pera = $_POST['pera'];
};
?>

<section class="cart">
    <div class="table-responsive">
        <table class="table table-striped" style="width:100%" id="laman_cart">
            <thead class="table-secondary">
                <th>Name</th>
                <th>Price</th>
                <th colspan="2">Quantity</th>
                <th>Total-Price</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php

                $select_cart = mysqli_query($connection, "SELECT * FROM cart CROSS JOIN item on cart.item_id = item.id  CROSS JOIN info on item.id = info.item_id;");

                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                        <tr>
                            <td><?php echo $fetch_cart['generic_name'] . " " .  $fetch_cart['brand_name'] . " " .  $fetch_cart['medicine_type'] . " " .  $fetch_cart['dosage']; ?>
                            </td>
                            <td> ₱ <?php if ($fetch_cart['scale'] == "piece") {
                                        $price = $fetch_cart['price_piece'];
                                        echo number_format($fetch_cart['price_piece']);
                                    } else if ($fetch_cart['scale'] == "box") {
                                        $price = $fetch_cart['price_pack'];
                                        echo number_format($fetch_cart['price_pack']);
                                    }
                                    ?>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['cart_id']; ?>">
                                    <input style=" width:40px;" type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['qty']; ?>">

                                    <input button class="btn btn-outline-primary sm" type="submit" value="Update" name="update_update_btn" class="bg-dark-subtle">

                                </form>
                            </td>
                            <td><?php echo "$fetch_cart[scale]"; ?></td>

                            <td> ₱ <?php echo $sub_total = $price * $fetch_cart['qty']; ?></td>

                            <td><a href="pos.php?remove=<?php echo $fetch_cart['cart_id']; ?>" onclick="return confirm ('remove item ?')" class="delete-btn"><i class="fa fa-remove" style="font-size:20px;color:red"></i></a></td>
                        </tr>
                <?php
                        $total += $sub_total;
                        $grand_total = $total;
                    };
                };
                ?>
                <!-- total row  -->

                <tr class="table-info">
                    <td colspan="5">Total</td>
                    <td><?php echo $total; ?></td>
                </tr>
                <!-- discount row  -->
                <tr>
                    <td colspan="5">
                        <?php
                        if (isset($_POST['dis'])) {
                            if ($_POST['presyu'] == 'n') {
                                $dis = 0;
                            } else if ($_POST['presyu'] == 's') {
                                $dis = $total * .15;
                                $grand_total = $total;
                                $_POST['presyu'] = 's';
                            };
                        };  ?>

                        <span>Discount</span>
                        <form action="" method="post">
                            <select name="presyu">

                                <option value="n">none</option>
                                <option value="s">senior</option>
                                <option value="p">pwd</option>
                            </select>
                            <input type="submit" name="dis" value="Discount">
                        </form>
                    </td>
                    <td><input disabled style=" width:60px;" type="number with decimal" name="dis" value="<?= $dis ?>"></td>
                </tr>
                <!-- grand total row  -->
                <tr>
                    <td colspan="5">grand_total</td>
                    <td><input disabled style=" width:60px;" type="number with decimal" name="grand_total" value="<?= $grand_total ?>"></td>
                </tr>
                <!-- cash -->
                <tr>
                    <td colspan="5">Cash</td>
                    <td>
                        <form action="" method="post">
                            <input style=" width:60px;" type="number with decimal" name="pera" value="<?= $pera ?>">
                            <?php
                            if (isset($_POST['cash'])) {

                                $change = $pera - $grand_total;
                            };
                            ?>
                            <input button class="btn btn-outline-success sm" type="submit" value="done" name="cash">
                        </form>
                    </td>
                </tr>
                <tr class=>
                    <td colspan="5">Change</td>
                    <td><input type="number" name="sukli" disabled value="<?= $change ?>"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <a href="pos.php" class="btn btn-success <?= ($grand_total > 1) ? '' : 'disabled'; ?>">checkout</a>
                    </td>
                    <td colspan="3"><a href="pos.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="btn btn-outline-danger"> Delete all </a></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php } ?>