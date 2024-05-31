<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

?>
    <div class="wrapper">

        <div class="main p-3">
            <h2 class="text-center pb-2">New Purchase Order</h2>
            <div class="row">
                <div class="col-md-6">
                    <form action="orderdb.php" method="post">
                        <div class="form-group">
                            <input type="hidden" name="tracking_number" id="tracking_number" class="form-control">
                            <label for="supplier" class="text-left mb-2">Supplier</label>
                            <select class="form-control custom-select custom-select-sm rounded-0 select2" name="supplier_id" id="supplier_id">
                                <option value="" disabled selected>--Select Supplier--</option>
                                <?php
                                $query = "SELECT * FROM supplier";
                                $result = mysqli_query($connection, $query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = isset($_POST['supplier_id']) && $_POST['supplier_id'] == $row['supplier_id'] ? "selected" : "";
                                        echo "<option value='{$row['supplier_id']}' $selected>{$row['name']}</option>";
                                    }
                                } else {
                                    echo '<option value="" disabled>No suppliers found</option>';
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category" class="text-left mb-2">Category</label>
                            <table class="table">
                                <tbody id="category_table_body">
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <table class="table" id="brand_table_body">
                                <tbody id="brand_table_body">
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8">
                            <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                            <button type="button" class="btn btn-success" id="purchaseBtn" disabled>Purchase</button>
                        </div>
                        <button type="button" class="btn btn-success d-none" id="purchaseModalBtn" data-toggle="modal" data-target="#purchaseConfirmationModal">Purchase</button>
                </div>
                <div class="col-md-6">
                    <div class="container text-center mt-3">
                        <h2 class="mt-3">Purchase Medicines</h2>
                        <table class="table" id="cartTable">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Type</th>
                                    <th>Wholesale Price</th>
                                    <th>Unit Cost</th>
                                    <th>Unit/Size</th>
                                    <th>Box</th>
                                    <th>Pieces</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['brand'])) {
                                    foreach ($_POST['brand'] as $index => $brand) {
                                        $wholesaleprice = $_POST['wholesaleprice'][$index];
                                        $unit = $_POST['unit'][$index];
                                        $unit_qty = $_POST['unit_qty'][$index];

                                        // Fetch type_id information from database based on brand
                                        $query_type = "SELECT type_id FROM medicinetype WHERE brand = '$brand'";
                                        $statement = mysqli_prepare($connection, $query_type);
                                        mysqli_stmt_bind_param($statement, "s", $brand);
                                        mysqli_stmt_execute($statement);
                                        $result_type = mysqli_stmt_get_result($statement);

                                        // Check if query executed successfully and fetch type_id
                                        if ($result_type && mysqli_num_rows($result_type) > 0) {
                                            $row_type = mysqli_fetch_assoc($result_type);
                                            $type_id = $row_type['type_id'];

                                            // Output hidden inputs for each item
                                            echo "<input type='hidden' name='brand[]' value='$brand'>";
                                            echo "<input type='hidden' name='wholesaleprice[]' value='$wholesaleprice'>";
                                            echo "<input type='hidden' name='unit[]' value='$unit'>";
                                            echo "<input type='hidden' name='unit_qty[]' value='$unit_qty'>";
                                            echo "<input type='hidden' name='type_id[]' value='$type_id'>"; // Add type_id information here
                                        } else {
                                            // Handle case where no type_id found
                                            echo "Type information not found for brand: $brand<br>";
                                        }
                                    }
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="price-container mt-3">
                        <div class="container pt-10">
                            <div class="row">
                                <div class="col-md-6 text-align-left">
                                    <div class="mt-7 ">
                                        <label for="payment">Mode of Payment:</label><br>
                                        <input type="radio" id="cash" name="payment" value="Cash on Delivery" checked>
                                        <label for="cash">Cash on Delivery</label><br>
                                        <input type="radio" id="cash" name="payment" value="Credit card" disabled>
                                        <label for="cash" class="text-secondary">Credit Card</label><br>
                                        <input type="radio" id="cash" name="payment" value="Debit card" disabled>
                                        <label for="cash" class="text-secondary">Debit Card</label><br>
                                        <input type="radio" id="cash" name="payment" value="Online Banking" disabled>
                                        <label for="cash" class="text-secondary">Online Banking</label><br>
                                    </div>
                                </div>
                                <div class="col-md-6 text-align-righ">
                                    <table class="price">
                                        <tr>
                                            <td colspan="3" class="boldtd text-right">Subtotal:</td>
                                            <td colspan="2"><input type="text" name="subtotal" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="boldtd text-right">Tax(12%):</td>
                                            <td colspan="2"><input type="text" name="tax" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="boldtd text-right">Shipping fee:</td>
                                            <td colspan="2"><input type="text" id="shippingFee" name="shippingFee" readonly></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="discount-notification" style="display: none;"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="boldtd text-right">Total:</td>
                                            <td colspan="2"><input type="text" name="grandtotal" readonly></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <div class="col-md-6 mt-10">
                        <h3 class="mt-10">Fast Selling Items</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Sales</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'includes/connection.php';
                                $query = "SELECT brand, SUM(unit_qty) AS total_sales
          FROM purchase_table
          GROUP BY brand
          HAVING total_sales >= 500
          ORDER BY total_sales DESC";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    echo "<tbody>";
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['brand'] . "</td>";
                                        echo "<td>" . $row['total_sales'] . "</td>";
                                        echo "<td>Fast Selling</td>";
                                        echo "</tr>";
                                    }
                                    echo "</tbody>";
                                } else {
                                    echo "Error: " . mysqli_error($connection);
                                }
                                mysqli_close($connection);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="purchaseConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm Purchase</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to proceed with this purchase?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="confirmPurchaseBtn" id="confirmPurchaseBtn">Yes, Purchase</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var confirmationShown = false;

            function showPurchaseModal(selectedMedicines) {
                $('#selectedMedicinesInput').val(JSON.stringify(selectedMedicines));
                $('#purchaseConfirmationModal').modal('show');
                confirmationShown = true;
            }
            $('#purchaseBtn').on('click', function() {
                var selectedMedicines = getSelectedMedicines();
                showPurchaseModal(selectedMedicines);
            });
            $('#confirmPurchaseBtn').on('click', function() {
                if (confirmationShown) {
                    $('form').submit();
                    confirmationShown = false;
                }
            });
            $('#cancelPurchaseBtn').on('click', function() {
                $('#purchaseConfirmationModal').modal('hide');
            });
        });

        function getSelectedMedicines() {
            var selectedMedicines = [];
            $('input[name="selected_medicines[]"]:checked').each(function() {
                var category_name = $(this).closest('tr').find('td:eq(1)').text();
                var brand = $(this).closest('tr').find('td:eq(2)').text();
                var wholesalePrice = parseFloat($(this).closest('tr').find('td:eq(4)').text());
                var Unitcost = parseFloat($(this).closest('tr').find('td:eq(5)').text());
                var unit = $(this).closest('tr').find('td:eq(3)').text();
                var unitQty = parseFloat($(this).closest('tr').find('td:eq(6)').text());
                var quantity = parseFloat($(this).closest('tr').find('.quantity').val()) || 1;
                var totalPrice = wholesalePrice * quantity;
                var hiddenInputs = '<input type="hidden" name="category_name[]" value="' + category_name + '">' +
                    '<input type="hidden" name="brand[]" value="' + brand + '">' +
                    '<input type="hidden" name="wholesaleprice[]" value="' + wholesalePrice + '">' +
                    '<input type="hidden" name="unitcost[]" value="' + Unitcost + '">' +
                    '<input type="hidden" name="unit[]" value="' + unit + '">' +
                    '<input type="hidden" name="unit_qty[]" value="' + unitQty + '">' +
                    '<input type="hidden" name="quantity[]" value="' + quantity + '">';
                selectedMedicines.push({
                    category_name: category_name,
                    brand: brand,
                    wholesalePrice: wholesalePrice,
                    Unitcost: Unitcost,
                    unit: unit,
                    unitQty: unitQty,
                    quantity: quantity,
                    totalPrice: totalPrice
                });
            });
            return selectedMedicines;
        }
    </script>
    <script>
        $(document).ready(function() {
            function updatePurchaseButton() {
                var isEmpty = $('#brand_table_body').is(':empty');
                $('#purchaseBtn').prop('disabled', isEmpty);
            }
            $('#supplier_id').change(function() {
                fetchBrands();
            });

            function fetchBrands() {
                var supplierId = $('#supplier_id').val();
                $.ajax({
                    type: 'GET',
                    url: 'fetch-brands.php',
                    data: {
                        supplier_id: supplierId
                    },
                    success: function(response) {
                        $('#brand_table_body').html(response);
                        updatePurchaseButton();
                    },
                    error: function() {
                        $('#brand_table_body').html('<tr><td colspan="4">Error loading brands</td></tr>');
                        updatePurchaseButton();
                    }
                });
            }
        });
    </script>
    <script>
        function removeMedicine(button) {
            $(button).closest('tr').remove();
            updateTotalPrice();
            updatePriceTable(parseFloat($('#shippingFee').text()));
        }
        $(document).ready(function() {
            $('#supplier_id').change(function() {
                var supplierId = $(this).val();
                $.ajax({
                    url: 'get_shipping_fee.php',
                    type: 'GET',
                    data: {
                        supplier_id: supplierId
                    },
                    success: function(response) {
                        $('#shippingFee').text(response);
                        updatePriceTable(parseFloat(response));
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            updateTotalPrice();
        });

        function addToCart() {
            var selectedMedicines = [];
            var supplierId = $('#supplier_id').val();
            $.ajax({
                url: 'get_shipping_fee.php',
                type: 'GET',
                data: {
                    supplier_id: supplierId
                },
                success: function(response) {
                    $('#shippingFee').text(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
            $('input[name="selected_medicines[]"]:checked').each(function() {
                var category_name = $(this).closest('tr').find('td:eq(1)').text();
                var brand = $(this).closest('tr').find('td:eq(2)').text();
                var wholesalePrice = parseFloat($(this).closest('tr').find('td:eq(4)').text());
                var Unitcost = parseFloat($(this).closest('tr').find('td:eq(5)').text());
                var unit = $(this).closest('tr').find('td:eq(6)').text();
                var quantity = parseFloat($(this).closest('tr').find('.quantity').val()) || 1;
                var unitQty = parseFloat($(this).closest('tr').find('td:eq(7)').text()) * quantity;
                var totalPrice = wholesalePrice * quantity;
                var type = $(this).closest('tr').find('td:eq(3)').text(); // Fetching the type information
                var hiddenInputs = '<input type="hidden" name="category_name[]" value="' + category_name + '">' +
                    '<input type="hidden" name="brand[]" value="' + brand + '">' +
                    '<input type="hidden" name="type[]" value="' + type + '">' +
                    '<input type="hidden" name="wholesaleprice[]" value="' + wholesalePrice + '">' +
                    '<input type="hidden" name="unitcost[]" value="' + Unitcost + '">' +
                    '<input type="hidden" name="unit[]" value="' + unit + '">' +
                    '<input type="hidden" name="unit_qty[]" value="' + unitQty + '">' +
                    '<input type="hidden" name="quantity[]" value="' + quantity + '">'; // Adding type as a hidden input
                $('#brand_table_body').append(hiddenInputs);
                selectedMedicines.push({
                    category_name: category_name,
                    brand: brand,
                    wholesalePrice: wholesalePrice,
                    Unitcost: Unitcost,
                    unit: unit,
                    unitQty: unitQty,
                    quantity: quantity,
                    totalPrice: totalPrice,
                    type: type // Including type in the selected medicines array
                });
            });
            $('#cartTable tbody').empty();
            selectedMedicines.forEach(function(medicine) {
                $('#cartTable tbody').append(
                    '<tr>' +
                    '<td>' + medicine.category_name + '</td>' +
                    '<td>' + medicine.brand + '</td>' +
                    '<td>' + medicine.type + '</td>' +
                    '<td>' + medicine.Unitcost.toFixed(2) + '</td>' +
                    '<td>' + medicine.wholesalePrice.toFixed(2) + '</td>' +
                    '<td>' + medicine.unit + '</td>' +
                    '<td>' + medicine.quantity + '</td>' +
                    '<td>' + medicine.unitQty + '</td>' + // Displaying type in the cart table
                    '<td class="total">' + medicine.totalPrice.toFixed(2) + '</td>' +
                    '<td><button type="button" class="btn btn-danger btn-sm remove-btn" onclick="removeMedicine(this)"><i class="bi bi-x-square-fill"></i></button></td>' +
                    '</tr>'
                );
            });
            $('#purchaseBtn').prop('disabled', false);
            updateTotalPrice();
            updatePriceTable(parseFloat($('#shippingFee').text()));
        }

        function updateTotalPrice() {
            var totalPrice = 0;
            $('#cartTable tbody tr').each(function() {
                totalPrice += parseFloat($(this).find('.total').text());
            });
            $('#totalPrice').text(totalPrice.toFixed(2));
        }

        function updatePriceTable(shippingFee) {
            var subtotal = 0;
            $('#cartTable tbody tr').each(function() {
                subtotal += parseFloat($(this).find('.total').text());
            });
            var discount = 0;
            var discountPercent = 0;
            if (subtotal >= 30000) {
                discount = 1;
                discountPercent = 100;
            } else if (subtotal >= 25000) {
                discount = 0.8;
                discountPercent = 80;
            } else if (subtotal >= 20000) {
                discount = 0.6;
                discountPercent = 60;
            } else if (subtotal >= 15000) {
                discount = 0.4;
                discountPercent = 40;
            } else if (subtotal >= 10000) {
                discount = 0.2;
                discountPercent = 20;
            } else if (subtotal >= 5000) {
                discount = 0.1;
                discountPercent = 10;
            }
            var discountedShippingFee = shippingFee * (1 - discount);
            if (discount > 0) {
                $('#shippingFee').next('.discount-notification').remove();
                $('#shippingFee').after('<div class="discount-notification"> You have received a ' + discountPercent + '% discount on shipping fee.</div>');
            } else {
                $('#shippingFee').next('.discount-notification').remove();
            }
            $('input[name="shippingFee"]').val(discountedShippingFee.toFixed(2));
            if ($('#cartTable tbody tr').length === 0) {
                subtotal = 0;
                var tax = 0;
                var grandTotal = 0;
            } else {
                var tax = subtotal * 0.12;
                var grandTotal = subtotal + discountedShippingFee;
            }
            $('input[name="subtotal"]').val(subtotal.toFixed(2));
            $('input[name="tax"]').val(tax.toFixed(2));
            $('input[name="shippingFee"]').val(discountedShippingFee.toFixed(2));
            $('input[name="grandtotal"]').val(grandTotal.toFixed(2));
        }
    </script>
<?php } ?>