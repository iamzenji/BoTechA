<?php 
include 'connect.php';

if(isset($_POST['add_piece'])){
    $product_id = $_POST['product_id'];
    $product_qty = 1;
   

    $select_cart = $connection->query("SELECT * FROM cart WHERE item_id = $product_id AND scale = 'piece'");

 
    if(mysqli_num_rows($select_cart) == 0) {
        $insert = mysqli_query($connection,"INSERT INTO cart (item_id, qty,scale) 
        VALUES('$product_id','$product_qty','piece')");
    };

}
if(isset($_POST['add_box'])){
    $product_id = $_POST['product_id'];
    $product_qty = 1;
   

    $select_cart = $connection->query("SELECT * FROM cart WHERE item_id = $product_id AND scale = 'box'");


    if(mysqli_num_rows($select_cart) == 0) {
        $insert = mysqli_query($connection,"INSERT INTO cart (item_id, qty,scale) 
        VALUES('$product_id','$product_qty','box')");
    };

}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
   
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
        <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>




    <?php include('include/sidebar.php');?>
   
    <div class="main-content">
  
        <div class="container">
        <?php include 'cart.php'?>
            <div class="header">
                <h1><i class='bx bxs-basket bx-tada bx-rotate-270'></i> POS</h1>
            </div>
            <div class="wrap">
                <div class="row">
                    <table id="laman" class="table table-striped table-hover" style="width:100%">
                        <thead class="buntuk">
                            <tr>
                                <th>Generic</th>
                                <th>Type</th>
                                <th>Dosage</th> 
                                <th>Item Map</th>   
                                <th>price-piece</th>
                                <th>price-pack</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                     $sql= "SELECT * from item CROSS JOIN info
                     WHERE item.id = info.item_id;";
                     $result = $connection->query($sql);

                     if (!$result) {
                        die("Invalid query: ". $connection->error);
                     }
                    while($row = $result->fetch_assoc()){
                        ?>
                            <tr>
                                <td><?php echo "$row[generic_name] $row[brand_name]";?></td> 
                                <td><?php echo "$row[medicine_type]";?></td>
                                <td><?php echo "$row[dosage]";?></td>
                                <td>alapa</td>
                                <td><?php echo "$row[price_piece]";?> <form action="" method="post">
                                <input type="hidden" name="product_id"
                                            value="<?php echo $row['id']; ?>">
                                      

                                        <input  button class="btn btn-primary btn-sm" class="bg-dark-subtle" type="Submit" value="Piece" name="add_piece">
                                </form></td>
                                <td><?php echo "$row[price_pack]";?>
                                    <form action="" method="post">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo $row['id']; ?>">
                                        
                                        <input class="bg-success"type="Submit" value="Pack" name="add_box">

                                        <!-- <button type="button" class="btn btn-outline-primary">Primary</button> -->
                                    </form>

                                </td>


                            </tr>

                            <?php   }?>



                        </tbody>
                    </table>

                </div>
            </div>


        </div>
       
    </div>
  
 

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
    <script>
    new DataTable('#laman');
    </script>







</body>

</html>