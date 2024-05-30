<?php
session_start();
include 'includes/connection.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
}
?>

<div class="wrapper">
    <div class="main p-3">
        <div class="text-center">

            <div class="table-responsive">
                <table class="table table-boarded table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="category" id="category" class="form-control select-tag" required disabled>
                                    <option value="" disabled selected>--Select Supplier First--</option>
                                </select>

                                </select>
                            </td>
                            <td>
                                <select name="brand" id="brand" class="form-control select-tag" required disabled>
                                    <option value="" disabled selected>--Select Category First--</option>
                                </select>
                            </td>
                            <td>
                                <select name="medicinetype" id="medicinetype" class="form-control select-tag" required disabled>
                                    <option value="" disabled selected>--Select Brand First--</option>
                                </select>
                            </td>

                            <td><input type="text" class="form-control" name="description[]" readonly></td>
                            <td><input type="text" class="form-control" name="unit[]" readonly></td>
                            <td><input type="text" class="form-control" name="price[]" value="0" readonly></td>
                            <td><input type="text" class="form-control" name="qty[]" onchange="calculateTotal(this)"></td>
                            <td><input type="text" class="form-control" name="total[]" readonly></td>
                            <td class="action"><button type="button" class="delete-button" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>