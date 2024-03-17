<?php
include 'includes/connection.php';
include 'includes/header.php';

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{

?>
<section class="home">
    <div class="text2">Add Order</div>

    <div class="container2">
        <form class="add-form" action="" method="Post">
            <h2>New Purchase Order</h2>

            <label for="supplier">Supplier</label>
            <input type="text" name="supplier" id="supplier">

            <label for="po_number">PO#</label>
            <input type="text" name="po_number" id="po_number">

            <table class="table table-boarded table-striped">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Items</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="qty[]"></td>
                        <td><input type="text" name="unit[]"></td>
                        <td><input type="text" name="item[]"></td>
                        <td><input type="text" name="description[]"></td>
                        <td><input type="text" name="price[]" value="0"></td>
                        <td><input type="text" name="total[]" readonly></td>
                        <td class="action"><button type="button" class="delete-button" onclick="deleteRow(this)"><i class="lni lni-trash-can"></i></button></td>
                    </tr>
                </tbody>
            </table>

            <button type="button" id="addRow">Add Row</button>
            <button type="submit">Submit</button>
        </form>
    </div>
</section>


<script scr="script.js"></script>

<script>
    document.getElementById('addRow').addEventListener('click', function() {
        var table = document.querySelector('.table tbody');
        var newRow = table.insertRow();
        var cells = [];

        // Create cells for the new row
        for (var i = 0; i < 6; i++) {
            cells[i] = newRow.insertCell(i);
            cells[i].innerHTML = '<input type="text" name="newRow[]">';
        }

        // Add delete button to the new row
        var deleteCell = newRow.insertCell(6);
        deleteCell.innerHTML = '<button type="button"  class="delete-button" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i> </button>';
    });

    function deleteRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

<?php } ?>