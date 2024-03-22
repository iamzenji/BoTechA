<?php
include 'includes/connection.php';
include 'includes/header.php';

?>
<div class="wrapper">
    <!-- Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label> Address </label>
                            <input type="text" name="address" class="form-control">
                        </div>

                        <div class="form-group">
                            <label> Contact Person </label>
                            <input type="text" name="contact_person" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input type="text" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label">Contact </label>
                            <input type="text" name="contact" id="contact" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Student Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="supplier-update.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Supplier </label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label> Address </label>
                            <input type="text" name="address" id="address" class="form-control">
                        </div>

                        <div class="form-group">
                            <label> Contact Person </label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control">
                        </div>
                        <div class="form-group">
                            <label> Email </label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label">Contact </label>
                            <input type="text" name="contact" id="contacts" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="jumbotron p-0 mt-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2> Supplier List </h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSupplierModal">
                        <i class="bi bi-plus-lg"></i>Add Supplier
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <?php
                    $connection = mysqli_connect("localhost", "root", "");
                    $db = mysqli_select_db($connection, 'botecha');

                    $query = "SELECT * FROM supplier";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                    <table id="datatableid" class="table table-strippped  custom-datatable table-bordered text-center balanced-table">
                        <thead class="bg-primary text-white">
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
                        if ($query_run) {
                            foreach ($query_run as $row) {
                        ?>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?php echo $row['supplier_id']; ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <td><?php echo $row['contact_person'] ?></td>
                                        <td> <?php echo $row['contact'] ?></td>
                                        <td> <?php echo $row['email'] ?></td>
                                        <td class='truncate-3' title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></td>
                                        <td class="d-flex ">
                                            <a href="supplier-list.php?supplier_id=<?php echo $row['supplier_id']; ?>" class="btn btn-success viewbtn"><i class="bi bi-eye"></i></a>
                                            <button type="button" class="btn btn-success editbtn"> <i class="bi bi-pencil-fill"></i> </button>
                                            <button type="button" class="btn btn-danger deletebtn"> <i class="bi bi-trash3-fill"></i> </button>
                                        </td>
                                    </tr>
                                </tbody>
                        <?php
                            }
                        } else {
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
<script>
    $(document).ready(function() {

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


    });
</script>
<!-- JavaScript for Editing Supplier -->
<script>
    $(document).ready(function() {

        $('.editbtn').on('click', function() {

            $('#editmodal').modal('show');

            var $tr = $(this).closest('tr');

            var data = $tr.find("td").map(function() {
                return $(this).text().trim(); // Trim the text to remove extra whitespace
            }).get();

            console.log(data);
            // Assuming the data contains ID, name, contact person, contact, and address
            $('#update_id').val(data[0]);
            $('#name').val(data[1]);
            $('#address').val(data[5]);
            $('#contact_person').val(data[2]);
            $('#email').val(data[4]);
            $('#contacts').val(data[3]);

        });

    });
</script>