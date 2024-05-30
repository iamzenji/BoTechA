<?php
include 'includes/connection.php';
include 'includes/header.php';
// Call the session check function
// check_session();

if(strlen($_SESSION['employee_id'])===0)
	{	
header('location:login.php');
session_destroy();

}
else{


$id = $name = $description = $status = '';

// Check if the ID parameter is set in the URL
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    $qry = $connection->query("SELECT * FROM `item_list` WHERE id = '$id'");
    if ($qry->num_rows > 0) {
        $row = $qry->fetch_assoc();
        // Assign item details to variables
        $name = $row['name'];
        $description = $row['description'];
        $status = $row['status'];
    } else {
        header("Location: items.php");
        exit();
    }
} else {
    header("Location: items.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $status = $_POST['status']; // Assuming status is already sanitized (it's a select dropdown)

    $sql = "UPDATE `item_list` SET name='$name', description='$description', status='$status' WHERE id='$id'";

    if ($connection->query($sql) === TRUE) {
        header("Location: items.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connection->error;
    }
}

// Close connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>

<body>
    <h1>Edit Item</h1>
    <form action="" method="post">
        <label for="name">Item Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required><?php echo $description; ?></textarea><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="1" <?php if ($status == 1) echo "selected"; ?>>Active</option>
            <option value="0" <?php if ($status == 0) echo "selected"; ?>>Inactive</option>
        </select><br><br>

        <input type="submit" value="Update">
    </form>
</body>

</html>

<?php } ?>