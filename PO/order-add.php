
<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <?php include('nav/sidenav.php'); ?>
    <style>
        
        .container {
            max-width: 90%;
            margin: 50px auto;
            padding: 60px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .text {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            bottom: 10px;
            text-align: center;
        }
        
        form {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        table {
            width: 99.3%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        
        table th,
        table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        
        button {
            padding: 10px 20px;
            margin-left: 1px;
            margin-right: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #0056b3;
        }

    .delete-button {
        background-color: red;
        height: inherit;
        display: inline;
        justify-content: center;
        align-items: center;
       
    }
    .delete-button:hover {
        display: inline;
        align-items: center;
    }

    .action{
        width: 30px;
    }
    .price-container {
        overflow: hidden; /* Clear float */
    }
    .textarea-container {
        float: left; /* Float the textarea to the left */
        margin-right: 10px; /* Add some space between the textarea and the table */
    }
    .textarea-container textarea {
        width: 600px; /* Set the width of the textarea */
        height: 150px; /* Set the height of the textarea */
        resize: none; /* Prevent the user from resizing the textarea */
    }
    .select-container {
        float: left; /* Float the select to the left */
        margin-right: 10px; /* Add some space between the select and the table */
    }
    .select-container label{
        margin-top: 5px;
    }
    .select-container select {
        width: 500px; /* Set the width of the textarea */
        height: 50px; /* Set the height of the textarea */
        resize: none; /* Prevent the user from resizing the textarea */
    }
    .price {
        border-collapse: collapse;
        width: auto; /* Adjust width as needed */
        float: right;
    }

    .price td {
        border: none;
        padding: 5px;
        
    }

    .price input[type="text"] {
        width: 100%;
        max-width: 200px; /* Adjust max-width as needed */
        box-sizing: border-box;
    }
    .price td[colspan="3"] {
        font-weight: bold; /* Make cells with colspan=3 bold */
    }



        
    </style>
</head>
<body>

    <section class="home">
        <div class="text">Add Order</div>
        
        <div class="container">
            <form action="" method="Post">
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
                            <td class="action"><button type="button"  class="delete-button" onclick="deleteRow(this)"><i class="fas fa-trash-alt"></i> </button></td>
                        </tr>
                    </tbody>
                </table>
                
                
<div class="price-container">
<div class="textarea-container">
        <label for="">Notes</label>
        <textarea rows="4" cols="50">Enter text here...</textarea>
    </div>
    <div class="select-container">
        <label for="">Status</label>
        <select name="status">
            <option value="pending">Pending</option>
            <option value="approve">Approve</option>
            <option value="denied">Denied</option>
        </select>
    </div>
    <table class="price">
        <tr>
            <td colspan="3" class="boldtd">Subtotal:</td>
            <td colspan="2"><input type="text" name="subtotal" readonly></td>
        </tr>
        <tr>
            <td colspan="3" class="boldtd">Discount:</td>
            <td colspan="2"><input type="text" name="discount"></td>
        </tr>
        <tr>
            <td colspan="3"class="boldtd">Total:</td>
            <td colspan="2"><input type="text" name="grandtotal" readonly></td>
        </tr>
    </table>

</div>
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

</body>
</html>