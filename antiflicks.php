<?php
include 'includes/connection.php';

// if(isset($_GET["doned"])){
//     mysqli_query($connection, "DELETE FROM cart");header('location:pos.php');
// }
// update qty

if (isset($_POST["action"])) {

    update();
}

function update()
{
    global $connection;
    $id = $_POST["action"];
    $upt =  $_POST["upt"];
    $id2 = $_POST["id"];

    if ($id == $id2) {

        if ($upt == 0 || $upt == "") {
            $upt = 1;

            $query = "UPDATE cart SET  qty = '$upt' WHERE cart_id = $id";
            mysqli_query($connection, $query);
            echo "Updated Successfully";
        } else {
            $query = "UPDATE cart SET  qty = '$upt' WHERE cart_id = $id";
            mysqli_query($connection, $query);
            echo "Updated Successfully";
        }
    }
}
// add piece
if (isset($_GET['adding'])) {
    $adding = mysqli_real_escape_string($connection, $_GET['adding']);

    $product_qty = 1;
    $select_cart = $connection->query("SELECT * FROM basket WHERE item_id = $adding AND scale = 'piece'");


    if (mysqli_num_rows($select_cart) == 0) {
        $query = "INSERT INTO basket (item_id, qty,scale) VALUES('$adding','$product_qty','piece')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $res = [
                'status' => 422,
                'message' => 'Item Not Added'
            ];
            echo json_encode($res);
            return false;
        }
    } else {
        $res = [
            'status' => 200,
            'message' => 'Item Added'
        ];
        echo json_encode($res);
        return false;
    }
}
// add pack
if (isset($_GET['adding_pack'])) {
    $adding = mysqli_real_escape_string($connection, $_GET['adding_pack']);

    $product_qty = 1;
    $select_cart = $connection->query("SELECT * FROM basket WHERE item_id = $adding AND scale = 'pack'");


    if (mysqli_num_rows($select_cart) == 0) {
        $query = "INSERT INTO basket (item_id, qty,scale) VALUES('$adding','$product_qty','pack')";
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $res = [
                'status' => 422,
                'message' => 'Item Not Added'
            ];
            echo json_encode($res);
            return false;
        }
    } else {
        $res = [
            'status' => 200,
            'message' => 'Item Added'
        ];
        echo json_encode($res);
        return false;
    }
}

// save to mesali datbase

if (isset($_POST['tr'])) {
    $i = 1;
    $tr = $_POST['tr'] . "/00" . $i;
    $transact = "SELECT * FROM `transact`; ";
    $result = $connection->query($transact);

    while ($row = $result->fetch_assoc()) {
        if ($row['transact_no'] == $tr) {
            $i++;
            $tr = $_POST['tr'] . "/00" . $i;
        } else {
            $tr = $_POST['tr'] . "/00" . $i;
            $i++;
        }
    }


    $cashier = $_POST['cashier'];
    $sub = $_POST['sub'];
    $dis = $_POST['dis'];
    $tot = $_POST['tot'];
    $cash = $_POST['cash'];
    $change = $_POST['change'];

    mysqli_query($connection, "INSERT INTO `transact`(`transact_no`, `cashier_id`, `sub_total`, `total_dis`, `total_amount`, `bayad`, `sukli`) VALUES ('$tr','$cashier',' $sub','$dis','$tot','$cash','$change')");


    $cart = "SELECT * FROM `basket`; ";
    $result = $connection->query($cart);

    while ($row = $result->fetch_assoc()) {
        mysqli_query($connection, "INSERT INTO `mesali`(`transact_no`, `item-id`, `qty`, `scale`) VALUES ('$tr','$row[item_id]','$row[qty]','$row[scale]')");
    }

    mysqli_query($connection, "DELETE FROM `basket`");
    return 'data saved';
}


// update mapping

if (isset($_POST['id'])) {

    // $section = $_POST['section'];
    $column = $_POST['column'];
    $row = $_POST['row'];
    $id = $_POST['id'];

    // quert to update data

    $result = mysqli_query($connection, "UPDATE `item_mapping` SET `section`='$section',`colum`='$column',`row`='$row' WHERE item_id = $id");
    if ($result) {
        return 'data updated';
    }
}
