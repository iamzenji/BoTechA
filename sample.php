<?php

include 'includes/connection.php';
include 'includes/header.php';

if (isset($_POST['update_update_btn'])) {
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];

    $update_quantity_query = mysqli_query($connection, " UPDATE cart SET qty = $update_value WHERE cart_id = $update_id");
    if ($update_quantity_query) {
        header('location:sample.php');
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <section class="cart">

        <table class="table table-striped table-hover" style="width:100%" id="laman_cart">


            <thead class="table-secondary">
                <th>Name</th>
                <th>Price</th>
                <th colspan="2">Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </thead>

            <tbody>

                <?php

                $select_cart = mysqli_query($connection, "SELECT * FROM cart CROSS JOIN item WHERE cart.item_id = item.id;");

                $total = 0;
                $grand_total = 0;
                $dis = 0;

                if (mysqli_num_rows($select_cart) > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                        <tr>
                            <td><?php echo $fetch_cart['generic_name'] . " " .  $fetch_cart['brand_name'] . " " .  $fetch_cart['medicine_type'] . " " .  $fetch_cart['dosage']; ?>
                            </td>
                            <td> ₱ <?php echo number_format($fetch_cart['price']); ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['cart_id']; ?>">
                                    <input style=" width:40px;" type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['qty']; ?>">
                                    <input button class="btn btn-outline-primary" type="submit" value="Update" name="update_update_btn" class="bg-dark-subtle">
                                </form>
                            </td>
                            <td><?php echo "$fetch_cart[scale]"; ?></td>
                            <td> ₱ <?php echo $sub_total = $fetch_cart['price'] * $fetch_cart['qty']; ?></td>
                            <td><a href="pos.php?remove=<?php echo $fetch_cart['cart_id']; ?>" onclick="return confirm ('remove item ?')" class="delete-btn"><i class="fa fa-remove" style="font-size:20px;color:red"></i></a></td>
                        </tr>
                <?php

                        $total += $sub_total;
                        $grand_total = $total;
                    };
                };
                ?>

                <!-- total row  -->

                <tr>
                    <td colspan="5">Total</td>
                    <td><?php echo number_format($total, 2); ?></td>
                </tr>

                <!-- discount row  -->

                <tr>
                    <td colspan="5">
                        <select id="discount" onclick="presyu()">
                            <option value="n">none</option>
                            <option value="s">senior</option>
                            <option value="p">pwd</option>
                        </select>
                        <script>
                            function presyu() {
                                var x = document.getElementById('discount').value;
                                if (x == "n") {
                                    document.getElementById("dis").innerHTML = <?php echo number_format($dis, 2); ?>;
                                    document.getElementById("grand_total").innerHTML = <?php echo number_format($total, 2); ?>;
                                } else if (x == "s") {

                                    document.getElementById("dis").innerHTML = <?php $dis = $total * .15;
                                                                                echo number_format($dis, 2); ?>;
                                    document.getElementById("grand_total").innerHTML = <?php $grand_total = $total - $dis;
                                                                                        echo number_format($grand_total, 4); ?>;

                                } else if (x == "p") {

                                    document.getElementById("dis").innerHTML = <?php $dis = $total * .2;
                                                                                echo number_format($dis, 2); ?>;
                                    document.getElementById("grand_total").innerHTML = <?php
                                                                                        $grand_total = $total - $dis;
                                                                                        echo number_format($grand_total, 4);
                                                                                        ?>;

                                }

                            }
                        </script>
                    </td>
                    <td id="dis">0</td>
                </tr>

                <!-- grand total row  -->
                <tr>
                    <td colspan="5">grand_total</td>
                    <td id="grand_total"><?php echo $total; ?></td>
                </tr>
                <td><a href="pos.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> Delete all </a></td>
            </tbody>
        </table>
        <div class="check-btn">
            <a href="pos.php" class="btn <?= ($total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>

</html>