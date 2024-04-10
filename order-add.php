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
            <div class="">
                <div class="container">
                    <form action="orderdb.php" method="post">

                        <!-- Rest of your form -->

                        <div class="container text-center">
                            <div class="table-responsive">
                                <table class="table table-boarded table-striped text-left" id="myTable">
                                    <h2 class="text-center pb-2">New Purchase Order</h2>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="supplier" class="text-left mb-2">Supplier</label>
                                            <select class="form-control custom-select custom-select-sm rounded-0 select2" name="supplier_id" id="supplier_id">
                                                <option value="" disabled selected>--Select Supplier--</option>
                                                <?php
                                                // Query to fetch supplier list
                                                $query = "SELECT * FROM supplier";
                                                $result = mysqli_query($connection, $query);

                                                // Check if query executed successfully
                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    // Output option tags for each supplier
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $selected = isset($_POST['supplier_id']) && $_POST['supplier_id'] == $row['supplier_id'] ? "selected" : "";
                                                        echo "<option value='{$row['supplier_id']}' $selected>{$row['name']}</option>";
                                                    }
                                                } else {
                                                    // Output a default option in case no suppliers are found
                                                    echo '<option value="" disabled>No suppliers found</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-6 text-left">
                                            <label for="tracking_number" class="text-left mb-2">Tracking Number</label>
                                            <input type="text" name="tracking_number" id="tracking_number" class="form-control">
                                            <small class="form-text text-muted">Leave it blank</small>
                                        </div>
                                    </div>


                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Unit Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="category" id="category" class="form-control select-tag" disabled>
                                                    <option value="" disabled selected>--Select Supplier First--</option>
                                                </select>

                                            </td>
                                            <td>
                                                <select name="brand" id="brand" class="form-control select-tag" disabled>
                                                    <option value="" disabled selected>--Select Category First--</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="medicinetype" id="medicinetype" class="form-control select-tag" disabled>
                                                    <option value="" disabled selected>--Select Brand First--</option>
                                                </select>
                                            </td>

                                            <td><input type="text" class="form-control" name="description[]" readonly></td>
                                            <!-- Inside the table body -->
                                            <td><input type="text" class="form-control" name="unit[]" readonly></td>
                                            <td><input type="text" class="form-control" name="price[]" value="0" readonly></td>
                                            <td><input type="number" class="form-control" name="qty[]" onchange="calculateTotal(this)"></td>
                                            <td><input type="text" class="form-control" name="unit_qty[]" onchange></td>
                                            <td><input type="text" class="form-control" name="total[]" readonly></td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="container  text-center">
                            <h2>Selected Medicines</h2>
                            <table class="table" id="cartTable">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th>Unit Qty</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Selected medicines will be added here dynamically -->

                                </tbody>
                            </table>
                        </div>

                        <div class="price-container mt-3 text-right">

                            <table class="price ">
                                <tr>
                                    <td colspan="3" class="boldtd text-right">Subtotal:</td>
                                    <td colspan="2"><input type="text" name="subtotal" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="boldtd  text-right">Tax(12%):</td>
                                    <td colspan="2"><input type="text" name="tax"></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="boldtd  text-right">Shipping fee:</td>
                                    <td colspan="2"><input type="text" name="shippingfee"></td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="boldtd">Total:</td>
                                    <td colspan="2"><input type="text" name="grandtotal" readonly></td>
                                </tr>
                            </table>

                        </div>

                        <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                        <button type="submit" class="btn btn-success" name="placeorder">Place Order</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        function addToCart() {
            var table = document.getElementById("myTable");
            var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
            var cartTable = document.getElementById("cartTable").getElementsByTagName("tbody")[0];

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var categorySelect = cells[0].getElementsByTagName("select")[0];
                var brandSelect = cells[1].getElementsByTagName("select")[0];
                var typeSelect = cells[2].getElementsByTagName("select")[0];
                var descriptionInput = cells[3].getElementsByTagName("input")[0]; // Get description input
                var unitInput = cells[4].getElementsByTagName("input")[0];
                var priceInput = cells[5].getElementsByTagName("input")[0];
                var quantityInput = cells[6].getElementsByTagName("input")[0];
                var unitQtyInput = cells[7].getElementsByTagName("input")[0]; // Get unitqty input
                var totalInput = cells[8].getElementsByTagName("input")[0];

                var category = categorySelect.options[categorySelect.selectedIndex].text;
                var brand = brandSelect.options[brandSelect.selectedIndex].text;
                var type = typeSelect.options[typeSelect.selectedIndex].text;
                var unit = unitInput.value;
                var price = parseFloat(priceInput.value);
                var quantity = quantityInput.value;
                var unitQty = unitQtyInput.value; // Get unitqty value
                var total = parseFloat(totalInput.value);

                if (category && brand && type && unit && price && quantity && unitQty && total) {
                    var newRow = cartTable.insertRow(cartTable.rows.length);
                    var cell1 = newRow.insertCell(0);
                    var cell2 = newRow.insertCell(1);
                    var cell3 = newRow.insertCell(2);
                    var cell4 = newRow.insertCell(3);
                    var cell5 = newRow.insertCell(4);
                    var cell6 = newRow.insertCell(5);
                    var cell7 = newRow.insertCell(6);
                    var cell8 = newRow.insertCell(7); // Add cell for unit quantity

                    cell1.innerHTML = category;
                    cell2.innerHTML = brand;
                    cell3.innerHTML = type;
                    cell4.innerHTML = price; // Show price instead of description
                    cell5.innerHTML = unit;
                    cell6.innerHTML = quantity;
                    cell7.innerHTML = unitQty; // Show unit quantity

                    // Calculate and show total price
                    var totalPrice = parseFloat(quantity) * parseFloat(price);
                    cell8.innerHTML = totalPrice.toFixed(2); // Show total price with 2 decimal places

                    // Reset select elements
                    categorySelect.selectedIndex = 0;
                    brandSelect.selectedIndex = 0;
                    typeSelect.selectedIndex = 0;

                    // Create hidden input fields for each cart item
                    createHiddenInputField('category[]', category, newRow);
                    createHiddenInputField('brand[]', brand, newRow);
                    createHiddenInputField('type[]', type, newRow);
                    createHiddenInputField('unit[]', unit, newRow);
                    createHiddenInputField('price[]', price, newRow);
                    createHiddenInputField('quantity[]', quantity, newRow);
                    createHiddenInputField('unitqty[]', unitQty, newRow); // Add hidden input for unit quantity
                    createHiddenInputField('total[]', totalPrice, newRow); // Add hidden input for total price

                    // Clear input values
                    descriptionInput.value = ''; // Reset description input
                    unitInput.value = '';
                    priceInput.value = '';
                    quantityInput.value = '';
                    unitQtyInput.value = ''; // Reset unit quantity input
                    totalInput.value = '';
                }

            }
            // Compute cart totals after adding items to the cart
            computeCartTotals();
        }


        function createHiddenInputField(name, value, row) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            row.appendChild(input);
        }

        function computeCartTotals() {
            var cartTable = document.getElementById("cartTable").getElementsByTagName("tbody")[0];
            var subtotal = 0;

            // Iterate through each row in the cart table
            for (var i = 0; i < cartTable.rows.length; i++) {
                var row = cartTable.rows[i];
                var cells = row.cells;
                var totalPrice = parseFloat(cells[7].innerText); // Total price is in the 8th cell (index 7)

                // Add the total price of eac5h item to the subtotal
                subtotal += totalPrice;
            }

            // Calculate tax (assuming 12% tax rate)
            var tax = 0.12 * subtotal;

            // Fixed shipping fee
            var shippingFee = 600.00;

            // Set subtotal, tax, shipping fee, and grand total values
            document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
            document.querySelector('input[name="tax"]').value = tax.toFixed(2);
            document.querySelector('input[name="shippingfee"]').value = shippingFee.toFixed(2);
            document.querySelector('input[name="grandtotal"]').value = (subtotal + tax + shippingFee).toFixed(2);
        }
    </script>


    <script>
        // Function to fetch categories for the selected supplier
        function fetchCategories(categorySelect) {
            var supplierId = document.getElementById('supplier_id').value;

            // Reset previous options
            categorySelect.innerHTML = '<option value="" disabled selected>Loading categories...</option>';

            // Fetch categories via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_categories.php?supplier_id=' + supplierId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    categorySelect.innerHTML = xhr.responseText;
                    categorySelect.disabled = false; // Enable category select
                } else {
                    categorySelect.innerHTML = '<option value="" disabled selected>Error loading categories</option>';
                }
            };
            xhr.send();
        }

        function fetchBrands(brandSelect, categoryId) {
            var supplierId = document.getElementById('supplier_id').value;

            // Reset previous options
            brandSelect.innerHTML = '<option value="" disabled selected>Loading brands...</option>';

            // Fetch brands via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch-brands.php?supplier_id=' + supplierId + '&category_id=' + categoryId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    brandSelect.innerHTML = xhr.responseText;
                    brandSelect.disabled = false; // Enable brand select
                } else {
                    brandSelect.innerHTML = '<option value="" disabled selected>Error loading brands</option>';
                }
            };
            xhr.send();
        }

        function fetchTypes(typeSelect, categoryId, brand) {
            var supplierId = document.getElementById('supplier_id').value;

            // Fetch types via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch-types.php?supplier_id=' + supplierId + '&category_id=' + categoryId + '&brand=' + brand, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    typeSelect.innerHTML = xhr.responseText;
                    typeSelect.disabled = false; // Enable type select
                } else {
                    typeSelect.innerHTML = '<option value="" disabled selected>Error loading types</option>';
                }
            };
            xhr.send();
        }

        // Event listener for brand select
        document.getElementById('brand').addEventListener('change', function() {
            var categoryId = document.getElementById('category').value;
            var brand = this.value;
            var typeSelect = document.getElementById('medicinetype');
            fetchTypes(typeSelect, categoryId, brand);
        });




        // Event listener for supplier select
        document.getElementById('supplier_id').addEventListener('change', function() {
            // Fetch categories for the selected supplier
            var categorySelects = document.querySelectorAll('select[name="category"]');
            categorySelects.forEach(function(select) {
                fetchCategories(select);
            });
        });
        // Event listener for category select
        document.getElementById('category').addEventListener('change', function() {
            var categoryId = this.value;
            var brandSelect = document.getElementById('brand');
            fetchBrands(brandSelect, categoryId);

        });



        document.getElementById('medicinetype').addEventListener('change', function() {
            var typeId = this.value;
            if (typeId !== '') {
                fetchDescriptionAndPrice(typeId);
            } else {
                // Clear description and price fields if no type is selected
                document.querySelector('input[name="description[]"]').value = '';
                document.querySelector('input[name="price[]"]').value = '';
            }
        });

        function fetchDescriptionAndPrice(typeId) {
            var supplierId = document.getElementById('supplier_id').value;
            var categoryId = document.getElementById('category').value;
            var brand = document.getElementById('brand').value;

            // Fetch description and price via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_descriptionprice.php?supplier_id=' + supplierId + '&category_id=' + categoryId + '&brand=' + brand + '&type=' + typeId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Populate description and price fields
                        document.querySelector('input[name="description[]"]').value = response.description;
                        document.querySelector('input[name="price[]"]').value = response.price;
                        document.querySelector('input[name="unit[]"]').value = response.unit;
                        document.querySelector('input[name="unit_qty[]"]').value = response.unit_qty;
                    } else {
                        // Handle the case where description and price could not be fetched
                    }
                } else {
                    // Handle the case where the request failed
                }
            };
            xhr.send();
        }



        function calculateTotal(input) {
            // Get the corresponding row of the input field
            var row = input.closest('tr');

            // Get the price and unit values
            var price = parseFloat(row.querySelector('input[name="price[]"]').value);
            var unit = parseFloat(input.value);

            // Calculate the total
            var total = price * unit;

            // Update the total field in the same row
            row.querySelector('input[name="total[]"]').value = isNaN(total) ? '' : total.toFixed(2);
        }
        // Event listener for quantity input
        document.querySelectorAll('input[name="qty[]"]').forEach(function(input) {
            input.addEventListener('input', function() {
                // Get the corresponding row of the input field
                var row = this.closest('tr');

                // Get the quantity value
                var quantity = parseFloat(this.value);

                // If quantity is valid, update unit_qty
                if (!isNaN(quantity)) {
                    // Get the unit_qty value
                    var unitQty = parseFloat(row.querySelector('input[name="unit_qty[]"]').value);

                    // If unit_qty is valid, calculate and update unit_qty
                    if (!isNaN(unitQty)) {
                        row.querySelector('input[name="unit_qty[]"]').value = (unitQty * quantity);

                        // Calculate and fill total
                        calculate(row.querySelector('input[name="qty[]"]'));
                    }
                }
            });
        });
    </script>
<?php } ?>