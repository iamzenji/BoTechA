<?php
include 'includes/connection.php';
include 'includes/header.php';
?>
<div class="main">
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
                                    <th class="text-center" style="width: 10%;"> Photo</th>
                                    <th class="text-center" style="width: 10%;">Category</th>
                                    <th class="text-center" style="width: 10%;"> Porduct</th>
                                    <th class="text-center" style="width: 10%;"> Brand name </th>
                                    <th class="text-center" style="width: 10%;"> Quantity on Hand</th>
                                    <th class="text-center" style="width: 10%;"> Reorder Quantity</th>
                                    <th class="text-center" style="width: 10%;"> Notify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src='' alt='Image' style='width: 50px; height: 50px;'></td>
                                    <td>Dasdasd</td>
                                    <td class='text-center'>asdas</td>
                                    <td class='text-center'>asd</td>
                                    <td class='text-center'>100</td>
                                    <td class='text-center'>20</td>
                                    <td class="text-center"><button class="text-center btn btn-primary">Notify</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>