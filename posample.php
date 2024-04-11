<?php
$total = 0;
$dis = 0;
$cash = 0;
$grand_total = 0;

include 'includes/connection.php';
include 'includes/header.php';

if (isset($_POST['discount'])) {
    $cash = $_POST['cash'];
};

// if (isset($_POST['done'])) {

//     $cart = "SELECT * FROM `basket`; ";
//     $result = $connection->query($cart);

//     while ($row = $result->fetch_assoc()) {
//         $mesali = mysqli_query($connection,"INSERT INTO `mesali`(`transact_no`, `item-id`, `qty`, `scale`) VALUES ('$t','$row[item_id]','$row[qty]','$row[scale]')");
//     }
//     $del = mysqli_query($connection,"DELETE FROM `basket`");
// };

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <style>
        @media print {
            body * {
                visibility: hidden;

            }

            .modal1,
            .modal1 * {
                visibility: visible;
                margin-top: auto;

            }

            .modal1 .table {
                font-size: 14px;
                margin-left: 3rem;
                width: 35rem;
                page-break-inside: auto;
            }

            .modal1 #haha table {
                margin-right: 4rem;
                font-size: 17px;
                width: 35rem;
                margin-left: 0rem;
            }

            @page {
                size: A5 portrait;

            }

        }
    </style>
</head>

<body>
    <div class="main-content">

        <div class="">

            <div class="header">
                <h1><i class='bx bxs-basket bx-tada bx-rotate-270'></i> POS</h1>

            </div>
            <div class="wrap" id="wrap">
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
                            $query =  "SELECT * from item CROSS JOIN info WHERE item.id = info.item_id;";
                            $query_run = mysqli_query($connection, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <tr>
                                        <td> <?= $row['generic_name'] . " " . $row['brand_name'] ?></td>
                                        <td><?= $row['medicine_type'] ?> </td>
                                        <td><?= $row['dosage'] ?> </td>
                                        <td>alapa</td>
                                        <td> ₱ <?php echo "$row[price_piece]"; ?>
                                            <button type="button" value="<?= $row['id'] ?>" class="addPiece btn btn-warning btn-sm">+</button>
                                        </td>

                                        <td> ₱ <?php echo "$row[price_pack]"; ?>
                                            <button type="button" value="<?= $row['id'] ?>" class="addPack btn btn-success btn-sm">+</button>
                                        </td>
                                    </tr>

                            <?php }
                            } ?>

                        </tbody>
                    </table>

                </div>
            </div>

            <section class="cart">
                <div class="table-responsive">

                    <table class="table table-striped" style="width:100%" id="laman_cart">

                        <thead class="table-secondary">
                            <th>Name</th>
                            <th>Price</th>
                            <th colspan="2">Quantity</th>
                            <th>Total-Price</th>
                            <td>Action</td>

                        </thead>

                        <tbody>

                            <?php
                            $query =  "SELECT * FROM basket CROSS JOIN item on basket.item_id = item.id  CROSS JOIN info on item.id = info.item_id;";
                            $query_run = mysqli_query($connection, $query);

                            if (mysqli_num_rows($query_run) > 0) { ?>
                                <?php foreach ($query_run as $row) : ?>
                                    <tr id="<?php echo $row["cart_id"]; ?>">

                                        <td><?php echo $row['generic_name'] . " " .  $row['brand_name'] . " " .  $row['medicine_type'] . " " .  $row['dosage']; ?></td>
                                        <td> ₱ <?php if ($row['scale'] == "piece") {
                                                    $price = $row['price_piece'];
                                                    echo number_format($row['price_piece']);
                                                } else if ($row['scale'] == "pack") {
                                                    $price = $row['price_pack'];
                                                    echo number_format($row['price_pack']);
                                                } ?></td>
                                        <td><?php echo $row["scale"]; ?></td>
                                        <td>
                                            <form autocomplete="off" action="" method="post">
                                                <input type="number" data-role=update data-id="<?php echo $row['cart_id']; ?>" value="<?= $row['qty']; ?>" onchange="submitData(<?php echo $row['cart_id']; ?>);" min="1" style=" width:60px;">

                                            </form>
                                        <td> ₱ <?php echo $sub_total = $price * $row['qty']; ?></td>
                                        <td></td>
                                        <?php $id = $row['cart_id']; ?>
                                    </tr>
                                <?php $total = $total + $sub_total;
                                    $grand_total = $total;
                                    $change = 0;

                                endforeach; ?>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="checkout">

                <div class="card" style="text-align:center; width: 20rem; ">
                    <div class="card-body">
                        <form id="myForm" action="" method="post" onsubmit="return validateForm()">

                            <input type="radio" class="btn-check" onclick="hide(1)" name="options-outlined" id="success-outlined" autocomplete="off" checked>
                            <label class="btn btn-outline-success" for="success-outlined">Cash</label>

                            <input type="radio" class="btn-check" onclick="hide(2)" name="options-outlined" id="danger-outlined" autocomplete="off" onch>
                            <label class="btn btn-outline-info" for="danger-outlined">G-Cash</label>
                            <br><br>
                            <label for="dis">Discount : </label>
                            <select name="discounted" id="dis">
                                <option selected value="0">--- select discount ---</option>
                                <option value="0">None</option>
                                <option value=".15">Senior</option>
                                <option value="2">PWD</option>

                            </select>

                            <div id="inputcash" style="display: flex; margin:1rem;">

                                <label for="cash">Cash :</label>
                                <input type="number" placeholder="please input cash" name="cash" value="<?= $cash ?>" min="0" style="margin-left:.2rem;">
                            </div>

                            <button type="submit" name="discount" class="btn btn-primary" name="done" style="margin-top: .5rem;">Done</button>
                        </form>
                        <?php
                        if (isset($_POST['discount'])) {
                            if ($_POST['discounted'] == 0) {
                                $dis = 0;
                            } elseif ($_POST['discounted'] == .15) {
                                $dis = .15 * $total;
                                $grand_total = $total - $dis;
                            } elseif ($_POST['discounted'] == 2) {
                                $dis = .2 * $total;
                                $grand_total = $total - $dis;
                            }
                        }

                        $change = $cash - $grand_total;

                        ?>
                    </div>
                </div>
                <div id="con">
                    <div id="total">Total : <?php echo $total; ?></div><br>
                    <button type="button" class="btn btn-lg btn-primary <?= ($cash > 1) ? '' : 'disabled'; ?>" data-bs-toggle="modal" data-bs-target="#myModal">CheckOut</button>
                    <button type="submit" class="btn btn-danger btn-lg">Remove all</button>
                </div>


            </section>


        </div>

    </div>




    <!-- The Modal -->
    <div class=" modal modal-sm" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">



                <!-- Modal body -->
                <div class="modal1 modal-body text-center" style="font-family: Helvetica;  font-size: 9px;">
                    <img src="include/logo.png" class="rounded-circle img-thumbnail" style="width: 50px;border: 1px solid black;">
                    <h6>Bo-Tech-A</h6>
                    <h6><?php date_default_timezone_set('Asia/Manila');
                        echo date("Y-F-d h:i a"); ?></h6>
                    <h6>Cashier : </h6>
                    <h6>Transact# : </h6>
                    <h6>Payment Method : </h6>
                    <br>
                    <table class="table table-sm table-borderless" style="text-align: left;">
                        <thead>
                            <th>Name</th>
                            <th colspan="2">Quantity</th>
                            <th colspan="2">Amount</th>

                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php

                            $select_cart = mysqli_query($connection, "SELECT * FROM basket CROSS JOIN item on basket.item_id = item.id  CROSS JOIN info on item.id = info.item_id;");

                            if (mysqli_num_rows($select_cart) > 0) {
                                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                            ?>

                                    <tr>
                                        <td><?php echo $fetch_cart['generic_name'] . " " .  $fetch_cart['brand_name'] . " " .  $fetch_cart['medicine_type'] . " " .  $fetch_cart['dosage']; ?>
                                        </td>
                                        <?php if ($fetch_cart['scale'] == "piece") {
                                            $price = $fetch_cart['price_piece'];
                                        } else if ($fetch_cart['scale'] == "pack") {
                                            $price = $fetch_cart['price_pack'];
                                        } ?> </td>

                                        <td colspan="2"><?php echo "$fetch_cart[qty]" . '/' . "$fetch_cart[scale]"; ?> </td>


                                        <td colspan="2">₱ <?php echo $sub_total = $price * $fetch_cart['qty']; ?></td>


                                    </tr>
                            <?php

                                    $total += $sub_total;
                                };
                            };
                            ?>

                        </tbody>
                    </table>
                    <div id="haha" style="font-size: 12px;text-align: right; font-weight: bold; width: 15rem ">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Sub-Total</td>
                                <td colspan="2">---------</td>
                                <td>₱ <?php echo $total; ?></td>
                            </tr>
                            <tr>
                                <td>Total-Discount</td>
                                <td colspan="2">---------</td>
                                <td>₱ <?php echo $dis; ?></td>
                            </tr>

                            <tr>
                                <td>Total-Amount</td>
                                <td colspan="2">---------</td>
                                <td>₱ <?php echo $grand_total; ?></td>
                            </tr>
                            <tr>
                                <td>Cash</td>
                                <td colspan="2">---------</td>
                                <td>₱ <?php echo $cash; ?></td>
                            </tr>
                            <tr>
                                <td>Change</td>
                                <td colspan="2">---------</td>
                                <td>₱ <?php echo $change; ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php $t = "BTA-" . "1"; ?>
                    <input type="hidden" id="tr" value="<?php echo $t; ?>">
                    <input type="hidden" id="cashier" value="1">
                    <input type="hidden" id="sub" value="<?php echo $total; ?>">
                    <input type="hidden" id="disc" value="<?php echo $dis; ?>">
                    <input type="hidden" id="tot" value="<?php echo $grand_total; ?>">
                    <input type="hidden" id="cash" value="<?php echo $cash; ?>">
                    <input type="hidden" id="change" value="<?php echo $change; ?>">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                    <button id="print">print</button>
                    <!-- <a href="#" id="save" class="btn btn-primary">Update</a> -->
                    <button type="button" id="save" class="btn btn-success">done</button>
                </div>

            </div>
        </div>
    </div>

</body>






<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#laman');
</script>

<script>
    // for print
    const printbtn = document.getElementById('print');

    printbtn.addEventListener('click', function() {
        window.print();
    })

    // save transact

    $(document).ready(function() {
        $('#save').click(function() {
            var tr = $('#tr').val();
            var cashier = $('#cashier').val();
            var sub = $('#sub').val();
            var dis = $('#disc').val();
            var tot = $('#tot').val();
            var cash = $('#cash').val();
            var change = $('#change').val();
            $.ajax({
                type: "POST",
                url: "code.php",
                data: {
                    cashier: cashier,
                    sub: sub,
                    dis: dis,
                    tot: tot,
                    tr: tr,
                    cash: cash,
                    change: change
                },
                success: function(response) {
                    console.log(response);
                    $('#laman_cart').load(location.href + " #laman_cart");
                    $('#total').load(location.href + " #total");
                    $('#myForm').load(location.href + " #myForm");
                    $('#con').load(location.href + " #con");

                    $('#myModal').modal('toggle');

                }
            });
        });
    });


    // g-cah or cash

    function hide(val) {
        if (val == 2) {
            document.getElementById('inputcash').style.display = 'none';
        } else {
            document.getElementById('inputcash').style.display = 'flex';
        }
    }

    function validateForm() {
        let x = document.forms["myForm"]["cash"].value;
        if (x == "") {
            alert("Please input Cash");
            return false;
        } else if (x < <?php echo $grand_total; ?>) {
            alert("Please input Sufficient Cash");
            return false;
        }
    }


    // add piece
    $(document).on('click', '.addPiece', function() {
        var adding = $(this).val();
        //alert(adding);
        $.ajax({
            type: "GET",
            url: "code.php?adding=" + adding,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#laman_cart').load(location.href + " #laman_cart");
                    $('#total').load(location.href + " #total");

                } else if (res.status == 200) {
                    $('#laman_cart').load(location.href + " #laman_cart");
                    $('#total').load(location.href + " #total");

                    alert(res.message);
                }
            }
        });
    });


    // add pack
    $(document).on('click', '.addPack', function() {
        var adding_pack = $(this).val();
        //alert(adding);
        $.ajax({
            type: "GET",
            url: "code.php?adding_pack=" + adding_pack,
            success: function(response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 422) {
                    $('#laman_cart').load(location.href + " #laman_cart");
                    $('#total').load(location.href + " #total");;
                } else if (res.status == 200) {
                    $('#laman_cart').load(location.href + " #laman_cart");
                    $('#total').load(location.href + " #total");

                    alert(res.message);
                }
            }
        });
    });

    // update qty

    function submitData(action) {
        $(document).ready(function() {

            $(document).on('change', 'input[data-role=update]', function() {

                const id = $(this).data('id');
                const q = $(this).val();
                const data = {
                    action: action,
                    id: id,
                    upt: q
                }

                $.ajax({
                    url: 'code.php',
                    type: 'post',
                    data: data,
                    success: function(response) {

                        $('#laman_cart').load(location.href + " #laman_cart");
                        $('#total').load(location.href + " #total");
                    }
                });
            });
        });

    }
</script>