<?php
include 'includes/connection.php';
include 'includes/header.php';

?>
<div class="wrapper">
   
<div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-lg"></i>Add Supplier </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="supplier-add.php" method="POST">

                    <div class="modal-body">
                    <div class="form-group">
                            <label> Supplier </label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Address </label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label> Contact Person </label>
                            <input type="text" name="contact_person" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" id="emailInput" class="form-control" required>
                            <small id="emailWarning" class="text-danger" style="display: none;">Please enter a valid email address.</small>
                        </div>
                        <div class="form-group">
                            <label for="name" class="control-label">Contact </label>
                                <input type="text" name="contact"   id="contactInput" id="" class="form-control"  required>
                                <small id="contactWarning" class="text-danger" style="display: none;">Please enter a valid contact number.</small>
                        </div>
                        <div class="form-group">
                        <label for="modeofpayment" class="control-label">Mode of Payment </label>
                        <select name="modeofpayment" id="modeofpayment" class="form-control" required>
                            <option value="" disabled selected>-Select Mode of Payment-</option>
                            <option name="modeofpayment" value="Cash on Delivery">Cash on Delivery</option>
                            <option name="modeofpayment"value="Credit Card" disabled>Credit Card (not supported by supplier)</option>
                            <option name="modeofpayment" value="Debit Card" disabled>Debit Card (not supported by supplier)</option>
                            <option name="modeofpayment" value="Bank Transfer" disabled>Bank Transfer (not supported by supplier)</option>
                     </select>
                    </div>
                    <div class="form-group">
                    <label for="shippingfee" class="control-label"> Shipping fee</label>
                    <input type="number" name="shippingfee" id="shippingfee" class="form-control" required>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addSupplierButton" class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">
    <i class="bi bi-plus-lg"></i>Add Supplier
</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<p> <span id="supplierName"></span></p>
<p> <span id="supplierAddress"></span></p>
<p> <span id="supplierEmail"></span></p>
<p>
<h4>TERMS AND CONDITIONS</h4>
<h5>1. Refund Policy:</h5>
No refunds will be provided for any purchases made. Once an order is confirmed and processed, it cannot be refunded.<br><br>
<h5>2. Return Policy:</h5>
Returns are accepted only in the case of damaged, defective or expired products upon delivery.
To initiate a return, the store should report it in the supplier. Returned items must be in their original packaging and condition.
We reserve the right to refuse returns if the products show signs of misuse, damage, or tampering.
<br><br><h5>3.Order Completion:</h5>
Once an order is confirmed and completed, no changes or cancellations can be made. Customers are responsible for reviewing their orders carefully before confirming orders completed.
<br><br><h5>4.Shipping Cost:</h5>
Shipping costs are calculated based on the company. 
We may offer discounts on shipping for bulk orders. Any such discounts will be applied automatically at checkout.
<br><br><h5>5. Mode of Payment:</h5>
The only accepted mode of payment is cash on delivery (COD). Payment must be made in full at the time of delivery.
Customers are advised to prepare the exact amount for their order to facilitate smooth transactions.
<br><br>These terms and conditions constitute a legally binding agreement between the supplier and the customer. And you acknowledge that you have read, understood, and agreed to abide by these terms and conditions. We reserve the right to update or modify these terms at any time without prior notice.
</p>
        <p></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Decline</button>
        <button type="button" name="accept"id="addSupplierButton" class="btn btn-primary">Accept
</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Supplier Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="supplier-update.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group">
                        <label> Supplier </label>
                        <input type="text" name="name" id="name"class="form-control"  pattern="[A-Za-z]+" title="Please enter letters only"required>
                    </div>
                    <div class="form-group">
                        <label> Address </label>
                        <input type="text" name="address" id="address" class="form-control"required>
                    </div>
                    <div class="form-group">
                        <label> Contact Person </label>
                        <input type="text" name="contact_person" id="contact_person" class="form-control"required >
                    </div>
                    <div class="form-group">
                        <label> Email </label>
                        <input type="email" name="email"  id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Contact </label>
                            <input type="text" name="contact" id="contacts" class="form-control" pattern="[0-9]+(\.[0-9]+)?" title="Please enter numbers only"  required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updatedata" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Supplier Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="supplier-delete.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="delete_id" id="delete_id">
                    <h4>Do you want to delete this supplier?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" name="deletedata" class="btn btn-danger"><i class="bi bi-trash3-fill mr-2"></i>Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <?php
if(isset($_SESSION['message'])) {
    $auto_hide_duration = 3000; 
?>
    <div id="alert_message" class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-4" role="alert" style="z-index: 9999;">
        <strong><?= $_SESSION['message']; ?></strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
    unset($_SESSION['message']);
?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var alertMessage = document.getElementById('alert_message');
            setTimeout(function() {
                alertMessage.classList.add('d-none'); 
            }, <?= $auto_hide_duration ?>); 
        });
    </script>
<?php
}
?>
        <div class="jumbotron p-0 mt-3">

            <div class="container  border-0">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2> Supplier List </h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">
                    <i class="bi bi-plus-lg"></i>Add Supplier
                    </button>
                </div>
            </div>
            <div class="container border-0">
                <div class="card-body">
                    <?php
                        $connection = mysqli_connect("localhost","root","");
                        $db = mysqli_select_db($connection, 'botecha');
                        $query = "SELECT * FROM supplier";
                        $query_run = mysqli_query($connection, $query);
                    ?>
                    <table id="datatableid" class="table table-boarded table-striped">
                        <thead >
                            <tr>
                                <th>#</th>
                            <th>Supplier</th>
                            <th>Contact Person</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                        <tbody>
                            <tr>
                            <td class="text-center"><?php echo $row['supplier_id']; ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['contact_person'] ?></td>
                            <td> <?php echo $row['contact'] ?></td>
                            <td> <?php echo $row['email'] ?></td>
                            <td class='truncate-3' title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></td>
                                <td class = "d-flex ">
                                <a href="supplier-list.php?supplier_id=<?php echo $row['supplier_id']; ?>" class="btn btn-success viewbtn"><i class="bi bi-eye"></i></a>
                                    <button type="button" class="btn btn-success editbtn"> <i class="bi bi-pencil-fill"></i> </button>
                                    <button type="button" class="btn btn-danger deletebtn"> <i class="bi bi-trash3-fill"></i> </button>
                                </td>
                            </tr>
                        </tbody>
                        <?php           
                    }
                }
                else 
                {
                    echo "No Record Found";
                }
            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function () {
        $('#datatableid').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Your Data",
            }
        });
        $('.editbtn').on('click', function () {
            $('#editmodal').modal('show');
            var $tr = $(this).closest('tr');
            var data = $tr.find("td").map(function () {
                return $(this).text().trim();
            }).get();
            $('#update_id').val(data[0]);
            $('#name').val(data[1]);
            $('#address').val(data[5]);
            $('#contact_person').val(data[2]);
            $('#email').val(data[4]);
            $('#contacts').val(data[3]);
        });
        $('.deletebtn').on('click', function () {
            $('#deletemodal').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();
            $('#delete_id').val(data[0]);
        });
        $('#editmodal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
        $('#deletemodal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
        });
    });
</script>
    <script>
        document.getElementById("numberInput").addEventListener("input", function() {
            var input = this.value;
            var errorElement = document.getElementById("error");
            if (!/^\d+(\.\d+)?$/.test(input)) {
                errorElement.textContent = "Please enter numbers only.";
            } else {
                errorElement.textContent = ""; 
            }
        });
    </script>
<script>
  $(document).ready(function() {
    $('#termsModal').on('click', '[data-dismiss="modal"]', function() {
      $('#termsModal').modal('hide');
    });
  });
</script>
<script>
 $(document).ready(function() {
    $('#addSupplierButton').click(function() {
        var supplierName = $('input[name="name"]').val();
        var supplierAddress = $('input[name="address"]').val();
        var supplierEmail = $('input[name="email"]').val();
        var supplierContact = $('input[name="contact"]').val();
        var shippingFee = $('#shippingfee').val(); 
        var modeOfPayment = $('#modeofpayment').val();
        if (!isValidEmail(supplierEmail)) {
            $('#emailWarning').show();
            return; 
        } else {
            $('#emailWarning').hide();
        }
        if (!isValidContact(supplierContact)) {
            $('#contactWarning').show();
            return; 
        } else {
            $('#contactWarning').hide();
        }
        $('#supplierName').text(supplierName);
        $('#supplierAddress').text(supplierAddress);
        $('#supplierEmail').text(supplierEmail);
        $('#supplierContact').text(supplierContact);
        $('#termsModal').modal('show');
    });
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    function isValidContact(contact) {
        var contactRegex = /^\d+$/; 
        return contactRegex.test(contact);
    }
    $('#termsModal').on('click', '[name="accept"]', function() {
        var formData = {
            name: $('input[name="name"]').val(),
            address: $('input[name="address"]').val(),
            contact_person: $('input[name="contact_person"]').val(),
            email: $('input[name="email"]').val(),
            contact: $('input[name="contact"]').val(),
            shippingfee: $('#shippingfee').val(), 
            modeofpayment: $('#modeofpayment').val() 
        };
        $.ajax({
            url: 'supplier-add.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response); 
                window.location.reload(); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert('Error adding supplier! Please try again.');
            }
        });
    });
});
</script>