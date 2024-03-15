<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();

// Extract the ID from the URL parameter
$id = isset($_GET["id"]) ? $_GET["id"] : null;

if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Ensure that the ID is not null and is a numeric value
    if ($id !== null && is_numeric($id)) {
        $sql = "UPDATE item_list SET name='$name', description='$description', status=$status WHERE id = $id";

        $result = mysqli_query($connection, $sql);

        if ($result) {
            header("Location: items.php?msg=Data updated successfully");
            exit(); // Terminate script after redirect
        } else {
            echo "Failed: " . mysqli_error($connection);
        }
    } else {
        echo "Invalid ID";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="design/body.css">
    <title>Document</title>
</head>

<body>
    <?php include('nav/sidenav.php'); ?>


    <section class="home">
        <div class="container2">
            <form action="" method="Post">


                <ul class="list">
                    <li>
                        <h2>Update an item </h2>
                        <a href="items.php" class="backbtn"><i class='bx bx-x'></i></a>
                    </li>
                </ul>
                <?php
                $sql = "SELECT * FROM item_list WHERE $id = id LIMIT 1";
                $result = mysqli_query($connection, $sql);
                $row = mysqli_fetch_assoc($result);
                ?>


                <div class="form-group">
                    <label for="name" class="control-label">Item Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-0" value="<?php echo $row['name'] ?>">
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Description</label>
                    <textarea rows="6" width="70%" name="description" id="description" class="form-control rounded-0" required><?php echo $row['description'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="status" class="control-label">Status</label>
                    <select name="status" id="status" class="form-control rounded-0" required>
                        <option name="status" value="1" <?php echo $row['status'] && $status == "" ? "selected" : "1" ?>>Active</option>
                        <option name="status" value="0" <?php echo $row['status'] && $status == "" ? "selected" : "0" ?>>Inactive</option>


                    </select>

                </div>
                <button type="submit" name="submit" class="updatebtn">Update</button>
        </div>

        </form>

        </form>
        </div>

    </section>
    <script src="script.js"></script>
</body>

</html>