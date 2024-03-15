<?php
include 'includes/connection.php';
include 'includes/header.php';
// Call the session check function

$id = isset($_GET["id"]) ? $_GET["id"] : null;

if (isset($_POST["submit-ud"])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];

    // Ensure that the ID is not null and is a numeric value
    if ($id !== null && is_numeric($id)) {
        $sql = "UPDATE supplier_list SET name='$name', address='$address', contact_person='$contact_person', email='$email', contact='$contact', status=$status WHERE id = $id";

        $result = mysqli_query($connection, $sql);

        if ($result) {
            header("Location: supplier.php?msg=Data updated successfully");
            exit(); // Terminate script after redirect
        } else {
            echo "Failed: " . mysqli_error($connection);
        }
    } else {
        echo "Invalid ID";
    }
}

?>

<section class="home">
    <div class="text1">Add a Supplier </div>
    <div class="container1">
        <form action="" method="Post">

            <ul class="list">
                <li>
                    <h2>Supplier </h2>
                    <a href="supplier.php" class="backbtn"><i class='bx bx-x'></i></a>

                </li>
            </ul>

            <form action="" method="post">


                <input type="hidden" name="id">
                <div class="container-fluid">
                    <?php
                    $sql = "SELECT * FROM item_list WHERE $id = id LIMIT 1";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="form-group">
                        <label for="name" class="control-label">Supplier Name</label>
                        <input type="text" name="name" id="name" class="form-control rounded-0" required value="<?php echo $row['name'];  ?>">
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
                        <input type="text" name="email" id="email" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Contact </label>
                        <input type="text" name="contact" id="contact" class="form-control rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="form-control rounded-0" required>
                            <option value="1" <?php echo isset($status) && $status == "" ? "selected" : "1" ?>>Active</option>
                            <option value="0" <?php echo isset($status) && $status == "" ? "selected" : "0" ?>>Inactive</option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="end-button" name="submit-ud" style="float: right;">Update</button>
            </form>
    </div>

</section>