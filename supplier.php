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
    <div class="text1">Supplier List </div>
    <?php if (isset($_SESSION['message'])) : ?>
        <div id="alert" class="delete alert alert-success alert-dismissible fade show" role="alert">
            <h5><?= $_SESSION['message']; ?></h5>
            <button id="close-alert" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php
        unset($_SESSION['message']);
    endif;
    ?>
    <div class="container1">
        <form action="" method="Post">


            <ul class="list">
                <li>
                    <h2>Supplier List</h2>
                    <a href="supplier-add.php" class="createnew"><i class="fas fa-plus"></i> Add Supplier</a>

                </li>
            </ul>

            <form action="">
                <div class="search">
                    <i class='bx bx-search'></i>
                    <input type="search" class="search-input" placeholder="Search">
                </div>
            </form>
            <table class="table table-boarded table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Created</th>
                        <th>Supplier</th>
                        <th>Contact Person</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $connection->query("SELECT * from `supplier_list` order by (`name`) asc ");
                    while ($row = $qry->fetch_assoc()) :
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id']; ?></td>
                            <td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td>
                                <p class="m-0">
                                    <?php echo $row['contact_person'] ?><br>
                                    <?php echo $row['contact'] ?>
                                </p>
                            </td>
                            <td class='truncate-3' title="<?php echo $row['address'] ?>"><?php echo $row['address'] ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 1) : ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else : ?>
                                    <span class="badge badge-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="col d-flex">
                                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="material-symbols-outlined view_icon">visibility</span></a>
                                    <a class="dropdown-item edit_data" href="supplier-update.php?id=<?php echo $row["id"] ?>" data-id="<?php echo $row['id'] ?>"><span class="material-symbols-outlined edit_icon">edit </a>
                                    <a class="dropdown-item delete_data" href="supplier-delete.php?id=<?php echo $row["id"] ?>" data-id="<?php echo $row['id'] ?>"><span class="material-symbols-outlined delete_icon">delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </form>
    </div>

</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get reference to the close button
        var closeButton = document.getElementById('close-alert');
        // Get reference to the alert
        var alertBox = document.getElementById('alert');

        // Function to close the alert
        function closeAlert() {
            // Hide the alert
            alertBox.style.display = 'none';
        }

        // Add click event listener to close button
        closeButton.addEventListener('click', function() {
            // Call the function to close the alert
            closeAlert();
        });

        // Automatically close the alert after 10 seconds
        setTimeout(function() {
            closeAlert();
        }, 10000); // 10000 milliseconds = 10 seconds
    });
</script>

<?php } ?>