<?php include 'connect.php';?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    <?php include('include/sidebar.php');?>


    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1><i class='bx bx-dollar bx-tada bx-rotate-270' ></i>     Sales</h1>
            </div>
          
        <div> <form class="sircing" action="" method="post">
            <input type="text" placeholder="Search data" name="search">
            <button class="btn" name="submit">Search</button>
        </form>
</div>


        <table class="items">
                
                <?php
            if(isset($_POST['submit'])){
                $search=$_POST['search'];

                $sql= "SELECT * from item where brand_name = '$search' or generic_name = '$search'";
                $result = $connection->query($sql);

                if (!$result) {
                    die("invalid query: " . $connection->error);
                }
                if(mysqli_num_rows($result)>0){
                    echo "
                    <thead>
                    <tr>
                        <th>Generic</th>
                        <th>Brand</th>
                        <th>Type</th>
                        <th>Dosage</th>
                        <th>Item Map</th>
                        <th>Action</th>
                        
                    </tr>
                </thead>
                    ";
                }

                // basan nala kada row
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <tbody>
                    <tr>
                            <td>$row[generic_name]</td>
                            <td>$row[brand_name]</td>
                            <td>$row[medicine_type]</td>
                            <td>$row[dosage]</td>
                            <td></td>
                            <td></td>
                        
                    </tr>
                    </tbody>
                  
                    ";
                }
            }
            ?>
       
            </table>

        </div>
    </div>
</body>

</html>