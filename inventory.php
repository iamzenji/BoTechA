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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center bg-info" style="width: 10%;">Category</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Porduct</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Brand name </th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Quantity Stock</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Storage Location</th>
                                    <th class="align-middle text-center bg-info" style="width: 10%;"> Date Added</th>
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
                                    <td class='align-middle text-center'>Ritemed</td>
                                    <td class='align-middle text-center'>1000</td>
                                    <td class='align-middle text-center'>IS 1</td>
                                    <td class='align-middle text-center'>Mar 13, 2024, 5:50pm</td>
                                    <td class='align-middle text-center'>Feb 20, 2029</td>
                                    <td class='align-middle text-center'>100</td>
                                    <td class='align-middle text-center'>SR 1</td>
                                    <td class='align-middle text-center'>100</td>
                                </tr>
                                <tr>
                                    <td class='align-middle text-center'>Loperamide</td>
                                    <td class='align-middle text-center'>Diatabs</td>
                                    <td class='align-middle text-center'>UNILAB</td>
                                    <td class='align-middle text-center'>1000</td>
                                    <td class='align-middle text-center'>IS 2</td>
                                    <td class='align-middle text-center'>Mar 18, 2024, 5:50pm</td>
                                    <td class='align-middle text-center'>Dec 10, 2031</td>
                                    <td class='align-middle text-center'>100</td>
                                    <td class='align-middle text-center'>SR 2</td>
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