
<?php
include('db_conn.php');
include('session_check.php');
// Call the session check function
check_session();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Lexend">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="design/body.css">
    <title>Document</title>
       
</head>
<body>
<?php include ('nav/sidenav.php'); ?>
    <section class="home">
    <div class="text1">Item List  </div>
    <?php if(isset($_SESSION['message'])) : ?>
    <div id="alert" class="delete alert alert-success alert-dismissible fade show" role="alert">
        <h5><?= $_SESSION['message']; ?></h5>
        <button id="close-alert" type="button" class="closed" aria-label="Close">
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
        <h2>Item List</h2>
        <a href="item-add.php" class="createnew"><i class="fas fa-plus"></i> Add Item</a>
    </li>
</ul>
<form action="">
                <div class="search">
                <i class='bx bx-search' ></i>
                <input type="search" class="search-input" placeholder="Search">
                </div>
            </form>
                <table class="table table-boarded table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					$qry = $conn->query("SELECT * from `item_list` order by (`name`) asc ");
					while($row = $qry->fetch_assoc()):
						$row['description'] = html_entity_decode($row['description']);
					?>
						<tr>
							<td class="text-center"><?php echo $row['id']?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['name'] ?></td>
							<td class='truncate-3' title="<?php echo $row['description'] ?>"><?php echo $row['description'] ?></td>
							<td class="text-center">
								<?php if($row['status'] == 1): ?>
                                    
									<span class="badge badge-success">Active</span>
								<?php else: ?>
									<span class="badge badge-secondary">Inactive</span>
								<?php endif; ?>
							</td>
							<td style = "align: center;">
								 
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="item.php" data-id = "<?php echo $row['id'] ?>"><span class="material-symbols-outlined view_icon">visibility</span></a>
				                    <a class="dropdown-item edit_data" href="item-update.php?id=<?php echo $row["id"] ?>" data-id = "<?php echo $row['id'] ?>"><span class="material-symbols-outlined edit_icon">edit</span></a>
				                    <a class="dropdown-item delete_data" href="item-delete.php?id=<?php echo $row["id"] ?>" data-id="<?php echo $row['id'] ?>"><span class="material-symbols-outlined delete_icon">delete</span></a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
                    </tbody>
                </table>
                
            </form>
        </div>

    </section>
       <script src="script.js"></script>
       <script>
    document.addEventListener('DOMContentLoaded', function () {
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
        closeButton.addEventListener('click', function () {
            // Call the function to close the alert
            closeAlert();
        });

        // Automatically close the alert after 10 seconds
        setTimeout(function() {
            closeAlert();
        }, 10000); // 10000 milliseconds = 10 seconds
    });
</script>


     
</body>
</html>