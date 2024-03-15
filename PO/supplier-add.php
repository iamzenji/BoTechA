
<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();


if (isset($_POST["submit"])) {
    // Retrieve form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];

    // Prepare SQL query
    $sql = "INSERT INTO supplier_list (name, address, contact_person, email, contact, status) 
            VALUES ('$name', '$address', '$contact_person', '$email', '$contact', '$status')";

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Inserted Successfully";
        header("Location: supplier-add.php");
        exit();
    } else {
        $_SESSION['message'] = "Not Inserted Successfully";
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="design/style.css">
    <link rel="stylesheet" href="design/body.css">
    
    <title>Document</title>
</head>
<body>
<?php include ('nav/sidenav.php');?>   
    <section class="home">
    <div class="text1">Add a Supplier   </div>
   
    <?php if(isset($_SESSION['message'])) : ?>
                    <h5 class="alert alert-success"><?= $_SESSION['message']; ?></h5>
                <?php 
                    unset($_SESSION['message']);
                    endif; 
                ?>
    <div class="container1">
      
            <ul class="list">
    <li>
        <h2>Supplier </h2>
        <a href="supplier.php" class="backbtn"><i class='bx bx-x' ></i></a>
    </li>
</ul>



<form action="" method="post">
 
     <input type="hidden" name="id" >
    <div class="container-fluid">
        <div class="form-group">
            <label for="name" class="control-label">Supplier  Name</label>
            <input type="text" name="name" id="name" class="form-control rounded-0"  required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Address</label>
            <input type="text" name="address" id="address" class="form-control rounded-0"required>
        </div>
        <div class="form-group">
            <label for="name" class="control-label">Contact Person</label>
            <input type="text" name="contact_person" id="contact_person" class="form-control rounded-0"  required>
        </div>
         
        <div class="form-group">
            <label for="email" class="control-label">Email </label>
            <input type="text" name="email" id="email" class="form-control rounded-0"  required>
        </div>
        <div class="form-group">
            <label for="name" class="control-label">Contact </label>
            <input type="text" name="contact" id="contact" class="form-control rounded-0"  required>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="1" <?php echo isset($status) && $status =="" ? "selected": "1" ?> >Active</option>
                <option value="0" <?php echo isset($status) && $status =="" ? "selected": "0" ?>>Inactive</option>
            </select>
        </div>
       
    </div>

<button type="submit" class="end-button" name="submit" style="float: right;">Add</button>
            </form>
        </div>

    </section>
       <script src="script.js"></script>

</body>
</html>