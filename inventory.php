<?php

include 'includes/header.php';
include 'includes/connection.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {
?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Manage Inventory</h2>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="inv-color-table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center bg-info" style="width: 10%;">Category</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Brand name </th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Quantity Stock</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Storage Location</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Expiration Date</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Showroom Quantity Stock</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Showroom Location</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Quantity to Reorder</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class='align-middle text-center'>Paracetamol</td>
                                    <td class='align-middle text-center'>Biogesic</td>
                                    <td class='align-middle text-center'>1000</td>
                                    <td class='align-middle text-center'>IS 1</td>
                                    <td class='align-middle text-center'>Feb 20, 2029</td>
                                    <td class='align-middle text-center'>100</td>
                                    <td class='align-middle text-center'>SR 1</td>
                                    <td class='align-middle text-center'>100</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // $mydate = '17/02/2011';
    // $mydate_parts = explode('/', $mydate);
    // $mydate_timestamp = mktime(0, 0, 0, $mydate_parts[1], $mydate_parts[0], $mydate_parts[2]);

    // if($mydate == date('d/m/Y'))
    // {
    // echo 'last day to reply';
    // }
    // elseif($mydate_timestamp < time())
    // {
    // echo 'post has expired and you cannot reply';
    // }

    ?>
<?php } ?>