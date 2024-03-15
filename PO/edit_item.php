<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();

$id = $name = $description = $status = '';

// Check if the ID parameter is set in the URL
if(isset($_GET['id']) && $_GET['id'] > 0) {
    // Retrieve and sanitize the item ID
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the item details from the database
    $qry = $conn->query("SELECT * FROM `item_list` WHERE id = '$id'");
    if($qry->num_rows > 0) {
        $row = $qry->fetch_assoc();
        // Assign item details to variables
        $name = $row['name'];
        $description = $row['description'];
        $status = $row['status'];
    } else {
        // Redirect to item list if item with the specified ID is not found
        header("Location: items.php");
        exit();
    }
} else {
    // Redirect to item list if ID parameter is not set or invalid
    header("Location: items.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = $_POST['status']; // Assuming status is already sanitized (it's a select dropdown)

    // SQL query to update item in the database
    $sql = "UPDATE `item_list` SET name='$name', description='$description', status='$status' WHERE id='$id'";
    
    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Redirect to items.php after successful update
        header("Location: items.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
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
            <option value="1" <?php if($status == 1) echo "selected"; ?>>Active</option>
            <option value="0" <?php if($status == 0) echo "selected"; ?>>Inactive</option>
        </select><br><br>
        
        <input type="submit" value="Update">
    </form>
</body>
</html>
