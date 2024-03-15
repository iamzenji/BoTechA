<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();




if (isset($_POST["submit"])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Assuming $conn is your MySQL connection object
    $sql = "INSERT INTO item_list (name, description, status) 
            VALUES ('$name', '$description', '$status')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['message'] = "Inserted Successfully";
        header("Location: item-add.php");
        exit(); // Add an exit after header redirect to prevent further execution
    } else {
        $_SESSION['message'] = "Not Inserted Successfully";
        echo "Failed: " . mysqli_error($conn);
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
    <div class="text1">Add an item   </div>
   
   <?php if(isset($_SESSION['message'])) : ?>
                   <h5 class="alert alert-success"><?= $_SESSION['message']; ?></h5>
               <?php 
                   unset($_SESSION['message']);
                   endif; 
               ?>
    <div class="container1">
            <form action="" method="Post">
          
       
            <ul class="list">
    <li>
        <h2>Add an items </h2>
        <a href="items.php" class="backbtn"><i class='bx bx-x' ></i></a>
    </li>
</ul>

<form action="" id="item-form">
     <input type="hidden" name="id" >
    <div class="container-fluid">
        <div class="form-group">
            <label for="name" class="control-label">Item Name</label>
            <input type="text" name="name" id="name" class="form-control rounded-0"required>
        </div>
        <div class="form-group">
            <label for="description" class="control-label">Description</label>
            <textarea rows="6" width="70%" name="description" id="description" class="form-control rounded-0" required></textarea>
        </div>
        <div class="form-group">
            <label for="status" class="control-label">Status</label>
            <select name="status" id="status" class="form-control rounded-0" required>
                <option value="1"  >Active</option>
                <option value="0" >Inactive</option>

                
            </select>
        </div>
        
    </div>
    <button type="submit" name="submit" class="addbtn">Add</button>
</form>
              
            </form>
        </div>

    </section>
       <script src="script.js"></script>
</body>
</html>