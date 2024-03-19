<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {
    if (isset($_POST["submit"])) {
        // Retrieve form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $contact_person = $_POST['contact_person'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];

        // Prepare SQL query
        $sql = "INSERT INTO supplier (name, address, contact_person, email, contact ) 
                VALUES ('$name', '$address', '$contact_person', '$email', '$contact' )";

        // Execute SQL query
        if (mysqli_query($connection, $sql)) {
            $_SESSION['messages'] = "Inserted Successfully";
            header("Location: supplier-add.php");
            exit();
        } else {
            $_SESSION['messages'] = "Not Inserted Successfully";
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
    }
?>

    <div class="main p-3 pt-5">
        <div class="text-Left">
            <div class="container">
                <ul class="list">
                    <li class="d-flex justify-content-between align-items-center">
                        <h2 class="me-3">Supplier List</h2>
                        <button class="btn btn-primary btn-rounded" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                            <i class="fas fa-plus"></i> Add Supplier
                        </button>
                    </li>
                </ul>

                <form action="">
                    <div class="input-group d-flex mt-4">
                        <span class="input-group-text"><i class="lni lni-search-alt"></i></span>
                        <input type="search" class="form-control" placeholder="Search">
                    </div>
                </form>


                <table class="table table-boarded table-striped text-center custom-table">
                    <thead class="bg-secondary text-white">
                        <tr>
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Supplier</th>
                            <th>Contact Person</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $qry = $connection->query("SELECT * from `supplier` order by (`date_created`) desc");
                        while ($row = $qry->fetch_assoc()) :
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $row['supplier_id']; ?></td>
                                <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td>
                                    <p class="m-0">
                                        <?php echo $row['contact_person'] ?><br>
                                        <?php echo $row['contact'] ?>
                                    </p>
                                </td>
                                <td class='truncate-3' title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></td>
                                <td>

                                    <div class="d-flex  justify-content-center p-2 align-items-center">
                                        <a class="btn icon-view" href="suppliers-item.php?supplier_id=<?php echo $row["supplier_id"] ?>" data-id="<?php echo $row['supplier_id'] ?>"><span class="material-symbols-outlined view_icon">visibility</span></a>
                                        <button type="button" class="btn btn-primary icon-ud" onclick="openEditSupplierModal(2)"><span class="material-symbols-outlined ">edit</span></button>
                                        <a class="btn icon-del " href="supplier-delete.php?supplier_id=<?php echo $row["supplier_id"] ?>" data-id="<?php echo $row['supplier_id'] ?>"><span class="material-symbols-outlined delete_icon">delete</span></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addSupplierForm" action="supplier-add.php" method="post">

                        <input type="hidden" name="id">
                        <div class="container-fluid">
                            <div class="form-group">
                                <label for="name" class="control-label">Supplier Name</label>
                                <input type="text" name="name" id="name" class="form-control rounded-0" required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">Address</label>
                                <input type="text" name="address" id="address" class="form-control rounded-0" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Contact Person</label>
                                <input type="text" name="contact_person" id="contact_person" class="form-control rounded-0" required>
                            </div>

                            <div class="form-group">
                                <label for="email" class="control-label">Email </label>
                                <input type="email" name="email" id="email" class="form-control rounded-0" required>
                            </div>
                            <div class="form-group">
                                <label for="name" class="control-label">Contact </label>
                                <input type="text" name="contact" id="contact" class="form-control rounded-0" required>
                            </div>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="addSupplierBtn">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSupplierModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for editing supplier details -->
                    <form id="editSupplierForm" action="supplier-update.php" method="POST">
                        <input type="hidden" name="supplier_id" id="editSupplierId">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="editName" name="name" value="<?php echo $row['name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address">
                        </div>
                        <div class="mb-3">
                            <label for="editcontactperson" class="form-label">Contact Person</label>
                            <input type="text" class="form-control" id="editcontactperson" name="contactperson">
                        </div>
                        <div class="mb-3">
                            <label for="edit" class="form-label">Email</label>
                            <input type="text" class="form-control" id="editcontactperson" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="editcontact" class="form-label">Contact </label>
                            <input type="text" class="form-control" id="editcontact" name="contact">
                        </div>

                        <!-- Add more fields as needed -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="editSupplierForm">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and other necessary JS files -->
    <!-- Example: -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script>
        document.getElementById('addSupplierBtn').addEventListener('click', function() {

        });
        // Function to open edit supplier modal with specific supplier ID
        function openEditSupplierModal(supplierId) {

            var editModal = new bootstrap.Modal(document.getElementById('editSupplierModal'));
            editModal.show();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // JavaScript to handle form submission using AJAX
        $(document).ready(function() {
            $('#addSupplierBtn').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                var formData = $('#addSupplierForm').serialize();

                // Send AJAX request to insert_item.php
                $.ajax({
                    type: 'POST',
                    url: 'supplier-add.php',
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        console.log('Item added successfully');
                        // Optionally, close the modal
                        $('#addSupplierModal').modal('hide');
                        // Reload the page to update the item list
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

<?php } ?>