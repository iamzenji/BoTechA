 <?php
    require 'connect.php';



    // update qty from cart

    if (isset($_POST["id"])) {
        global $connection;
        $id = $_POST["id"];
        $upt =  $_POST["upt"];
        if ($upt == 0 || $upt == "") {
            $upt = 1;
        }
        $query = "UPDATE cart_sales SET  qty = '$upt' WHERE cart_id = $id";
        mysqli_query($connection, $query);
        echo "Updated Successfully";
    }


    // add piece
    if (isset($_GET['adding'])) {
        $adding = mysqli_real_escape_string($connection, $_GET['adding']);

        $product_qty = 1;
        $select_cart = $connection->query("SELECT * FROM cart_sales WHERE item_id = $adding AND scale = 'piece'");


        if (mysqli_num_rows($select_cart) == 0) {
            $query = "INSERT INTO cart_sales (item_id, qty,scale) VALUES('$adding','$product_qty','piece')";
            $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                $res = [
                    'status' => 422,
                    'message' => 'Item Added'
                ];
                echo json_encode($res);
                return false;
            }
        } else {
            $res = [
                'status' => 200,
                'message' => 'Item already added'
            ];
            echo json_encode($res);
            return false;
        }
    }
    // add pack
    if (isset($_GET['adding_pack'])) {
        $adding = mysqli_real_escape_string($connection, $_GET['adding_pack']);

        $product_qty = 1;
        $select_cart = $connection->query("SELECT * FROM cart_sales WHERE item_id = $adding AND scale = 'pack'");


        if (mysqli_num_rows($select_cart) == 0) {
            $query = "INSERT INTO cart_sales (item_id, qty,scale) VALUES('$adding','$product_qty','pack')";
            $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                $res = [
                    'status' => 422,
                    'message' => 'Item Added'
                ];
                echo json_encode($res);
                return false;
            }
        } else {
            $res = [
                'status' => 200,
                'message' => 'Item already added'
            ];
            echo json_encode($res);
            return false;
        }
    }

    // delete item on cart

    if (isset($_POST['del'])) {
        $del = $_POST['del'];
        $tr = $_POST['tr'];
        $cashier = $_POST['cashier'];
        $value = $_POST['values'];
        $ris = "";
        if ($value == "aa") {
            $ris = "Costumer change of mind ";
        } elseif ($value == "bb") {
            $ris = "Wrong Items";
        } elseif ($value == "cc") {
            $ris = "Dont want to buy anymore";
        }

        $cart = "SELECT * FROM `cart_sales` WHERE cart_id = $del ";
        $result = $connection->query($cart);

        while ($row = $result->fetch_assoc()) {
            mysqli_query($connection, "INSERT INTO `meremove`(`cashier_id`, `item_id`, `qty`, `scale`, `reasons`, `stat`) VALUES ( '$cashier','$row[item_id]','$row[qty]','$row[scale]','$ris','single')");
        }
        mysqli_query($connection, "DELETE FROM `cart_sales` WHERE cart_id = $del");
    }


    // delete all data in cart

    if (isset($_POST['value'])) {
        $tr = $_POST['tr'];
        $cashier = $_POST['cashier'];
        $value = $_POST['value'];
        $ris = "";
        if ($value == "aa") {
            $ris = "Costumer change of mind ";
        } elseif ($value == "bb") {
            $ris = "Wrong Items";
        } elseif ($value == "cc") {
            $ris = "Dont want to buy anymore";
        }

        $cart = "SELECT * FROM `cart_sales` ";
        $result = $connection->query($cart);

        while ($row = $result->fetch_assoc()) {
            mysqli_query($connection, "INSERT INTO `meremove`( `cashier_id`, `item_id`, `qty`, `scale`, `reasons`, `stat`) VALUES ( '$cashier','$row[item_id]','$row[qty]','$row[scale]','$ris','all')");
        }

        mysqli_query($connection, "DELETE FROM `cart_sales`");
    }



    // save to mesali database

    if (isset($_POST['tr'])) {
        $tr = $_POST['tr'];
        $cashier = $_POST['cashier'];
        $paym = $_POST['paym'];
        $sub = $_POST['sub'];
        $dist = $_POST['dist'];
        $dis = $_POST['dis'];
        $tot = $_POST['tot'];
        $cash = $_POST['cas'];
        $change = $_POST['change'];

        $name = $_POST['lagyu'];

        mysqli_query($connection, "INSERT INTO `transact`(`transact_no`, `cashier_id`, `pay_method`, `sub_total`, `type`, `total_dis`, `total_amount`, `bayad`, `sukli`) VALUES ('$tr', $cashier,'$paym',$sub ,'$dist', $dis,$tot,$cash,$change);");

        // Added by Finance
        $selectsales = mysqli_query($connection, "SELECT * FROM `finance_daily_sales`");
        $sales = mysqli_fetch_assoc($selectsales);
        $totalsales = $sales['totalsales'] + $tot;

        mysqli_query($connection, "UPDATE finance_daily_sales SET totalsales = $totalsales");

        $cart = "SELECT * FROM cart_sales CROSS JOIN inventory on cart_sales.item_id = inventory_id";
        $result = $connection->query($cart);

        while ($row = $result->fetch_assoc()) {
            mysqli_query($connection, "INSERT INTO `mesali`(`transact_no`, `item_id`, `qty`, `scale`) VALUES ('$tr', '$row[item_id]', '$row[qty]', '$row[scale]')");

            if ($row['scale'] == "piece") {

                $new_stock = $row['showroom_quantity_stock'] - $row['qty'];
                mysqli_query($connection, "UPDATE `inventory` SET `showroom_quantity_stock`= $new_stock WHERE inventory_id = $row[item_id]");
                // inventory logs
                mysqli_query($connection, "INSERT INTO `inventory_logs`(`brand_name`, `type`, `unit`, `employee`, `quantity`, `stock_after`, `reason`) VALUES ('$row[brand]', '$row[type]', '$row[unit]', '$name', '$row[qty]', $new_stock, 'Sell Item')");
            } elseif ($row['scale'] == "pack") {

                $new_stock = $row['stock_pack'] - $row['qty'];
                mysqli_query($connection, "UPDATE `inventory` SET `stock_pack`= $new_stock WHERE inventory_id = $row[item_id]");
                // inventory logs
                mysqli_query($connection, "INSERT INTO `inventory_logs`(`brand_name`, `type`, `unit`, `employee`, `quantity`, `stock_after`, `reason`) VALUES ('$row[brand]', '$row[type]', '$row[unit]' '$name', '$row[qty]', $new_stock, 'Sell Item')");
            }
        }

        mysqli_query($connection, "DELETE FROM `cart_sales`");
        return 'data saved';
    }


    // add mapping

    if (isset($_POST['item'])) {

        $id = $_POST['item'];
        $sec = $_POST['sec'];
        $row = $_POST['row'];
        $column = $_POST['column'];


        mysqli_query($connection, "INSERT INTO `item_mapping`(`item_id`, `shelves`, `colum`, `row`) VALUES ($id, '$sec', $column, '$row')");
    }

    // update item shelves

    if (isset($_POST['upt'])) {

        $id = $_POST['upt'];
        $sec = $_POST['sec'];
        $row = $_POST['row'];
        $column = $_POST['column'];

        mysqli_query($connection, "UPDATE `item_mapping` SET `shelves` = '$sec', `colum` = $column, `row` = '$row' WHERE item_id = $id");
    }



    //  remove item to the shelves

    if (isset($_GET['rem'])) {
        $rem = mysqli_real_escape_string($connection, $_GET['rem']);
        mysqli_query($connection, "DELETE FROM `item_mapping` WHERE item_id = '$rem' ");
    }

    // view data transact

    if (isset($_POST['view_id'])) {
        $id = $_POST['view_id'];
        $output = '';

        $sql = "SELECT * FROM `mesali` CROSS JOIN item on mesali.item_id = item.id AND transact_no = '$id' CROSS JOIN info on item.id = info.item_id;";
        $result = $connection->query($sql);

        if (!$result) {
            die("Invalid query: " . $connection->error);
        }
        $output .= '
    <table class="table caption-top table-bordered table-sm">
    <caption>List of Item in transact ' . $id . '</caption>
    <thead>
        <tr>

            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>';

        $price = 0;
        $scaler = "";
        while ($row = $result->fetch_assoc()) {
            if ($row["scale"] == "piece") {
                $price = $row["price_piece"];
                $scaler = number_format($row["price_piece"]);
            } else if ($row["scale"] == "pack") {
                $price = $row["price_pack"];
                $scaler = number_format($row["price_pack"]);
            }
            $sub_total = $price * $row["qty"];
            $output .= '
            <tr>
                
                
                <td>' . $row["generic_name"] . ' ' . $row["brand_name"] . '_' . $row["medicine_type"] . '/' . $row["dosage"] . '</td>
                <td>' . $row["qty"] . '  ' . $row["scale"] . '</td>
                <td> ₱ ' . $scaler . '</td>
                <td> ₱ ' . $sub_total . '</td>
                
            </tr>';
        }
        $output .= '
    </tbody>
</table>';

        echo $output;
    }


    ?>