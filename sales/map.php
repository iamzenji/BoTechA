<?php include 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Mapping</title>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: var(--bs-nav-pills-link-active-color);
            background-color: green;
        }

        table.dataTable thead>tr>th.dt-orderable-asc,
        table.dataTable thead>tr>th.dt-orderable-desc,
        table.dataTable thead>tr>td.dt-orderable-asc,
        table.dataTable thead>tr>td.dt-orderable-desc {
            text-align: center;
        }

        table.table.dataTable> :not(caption)>*>* {
            text-align: center;
        }
    </style>
    <script>
        function displayTimeAndDate() {
            const now = new Date();
            let hours = now.getHours();
            const meridiem = hours >= 12 ? 'PM' : 'AM';
            hours = (hours % 12) || 12; // Convert to 12-hour format
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds} ${meridiem}`;

            const month = (now.getMonth() + 1).toString().padStart(2, '0');
            const day = now.getDate().toString().padStart(2, '0');
            const year = now.getFullYear();
            const dateString = `${month}/${day}/${year}`;

            
            var date =  document.getElementById('date');
            var time = document.getElementById('time');
            if (time !== null && date !== null) {
                time.textContent = timeString;
                date.textContent = dateString;
            }

        }

        // Update time and date every second
        setInterval(displayTimeAndDate, 1000);

        // Initial display
        displayTimeAndDate();
    </script>
</head>
</head>

<body>
    <div class="main-content"><?php include('sidebar.php'); ?>
    <div class="header">
                <div class="timer">
                    <div id="time"></div>
                    <div id="date"></div>
                </div>
                <div class="dropdown position-absolute top-0 end-0" style="margin: 12px 7px 0 0;">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-user'></i> 
                    </button>
                    <ul class="dropdown-menu" style="width: 12vw;">
                    
                        <li><span class="dropdown-item-text"><i class='bx bxs-user-circle' ></i> <?php echo $_SESSION['name'] ?></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <h1 style="margin-left: 1rem;"><i style="margin: 1rem;" class='bx bxs-map-pin bx-tada'></i></i>Item Mapping</h1>
            </div>
        <div class="me-5 ms-3">

           

            <div style="box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);width: 85vw; padding: 1rem 1rem 1rem 0; margin: 2vh 2rem 0 3rem;">


                <ul class="nav nav-pills nav-tabs justify-content-center" id="pills-tab nav-tab" role="tablist">
                    <!-- <p class="bg-info h-25 d-inline-block p-2 text-center" style="width: 120px; margin-right: 2rem;"> <i class='bx bxs-cabinet bx-tada' ></i>Shelves</p> -->
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="true">All</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-north-tab" data-bs-toggle="pill" data-bs-target="#pills-north" type="button" role="tab" aria-controls="pills-north" aria-selected="false">MedNorth</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-east-tab" data-bs-toggle="pill" data-bs-target="#pills-east" type="button" role="tab" aria-controls="pills-east" aria-selected="false">MedEast</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-center-tab" data-bs-toggle="pill" data-bs-target="#pills-center" type="button" role="tab" aria-controls="pills-center" aria-selected="false">MedCenter</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-west-tab" data-bs-toggle="pill" data-bs-target="#pills-west" type="button" role="tab" aria-controls="pills-west" aria-selected="false">MedWest</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-south-tab" data-bs-toggle="pill" data-bs-target="#pills-south" type="button" role="tab" aria-controls="pills-south" aria-selected="false">MedSouth</button>
                    </li>

                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <!-- all -->
                    <div class="tab-pane fade show active" id="pills-all" role="tabpanel" aria-labelledby="pills-home-all" tabindex="0">

                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                    <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id ";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- north -->

                    <div class="tab-pane fade" id="pills-north" role="tabpanel" aria-labelledby="pills-north-tab" tabindex="0">
                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id AND shelves ='MedNorth';";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- east -->
                    <div class="tab-pane fade" id="pills-east" role="tabpanel" aria-labelledby="pills-east-tab" tabindex="0">
                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id AND shelves ='MedEast';";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- center -->
                    <div class="tab-pane fade" id="pills-center" role="tabpanel" aria-labelledby="pills-center-tab" tabindex="0">
                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id AND shelves ='MedCenter';";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- west -->
                    <div class="tab-pane fade" id="pills-west" role="tabpanel" aria-labelledby="pills-west-tab" tabindex="0">
                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id AND shelves ='MedWest';";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- south -->
                    <div class="tab-pane fade" id="pills-south" role="tabpanel" aria-labelledby="pills-south-tab" tabindex="0">
                        <div style="padding: 1rem 2rem 1rem 3rem; ">
                            <div class="item-map">
                                <table class="table table-striped table-hover mapping" style="width: 100%;">
                                <thead class="bg-success sticky-top" style="z-index: 0;">
                                        <tr>
                                            <th>Place</th>
                                            <th>Item Name</th>
                                            <th>Type</th>
                                            <th>Dosage</th>
                                            <th>Stock/Piece</th>
                                            <th>Stock/Pack</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        <?php

                                        $sql = "SELECT * FROM item_mapping CROSS JOIN inventory on inventory_id  = item_mapping.item_id AND shelves ='MedSouth'; ";
                                        $result = $connection->query($sql);

                                        if (!$result) {
                                            die("Invalid query: " . $connection->error);
                                        }
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <tr id="<?php echo $row['inventory_id']; ?>">
                                                <td><?php echo "$row[shelves]-$row[row]$row[colum]"; ?></td>
                                                <td data-target="name"><?php echo "$row[category]  $row[brand]"; ?></td>
                                                <td data-target="type"><?php echo "$row[type]"; ?></td>
                                                <td data-target="dosage"><?php echo "$row[unit]"; ?></td>
                                                <td><?php echo "$row[showroom_quantity_stock]" ?></td>
                                                <td><?php echo "$row[stock_pack]" ?></td>
                                                <td><button type="button" id="upt" value="<?= $row['inventory_id'] ?>" class="upt btn btn-warning btn-sm"><i class='bx bxs-edit' data-bs-toggle="modal" data-bs-target="#staticBackdrop"></i></button>
                                                    <button type="button" value="<?= $row['inventory_id'] ?>" class="rem btn btn-danger btn-sm"><i class='bx bxs-trash'></i></button>
                                                    <input type="hidden" id="detail" value="<?php echo "$row[category]  $row[brand] - $row[type] / $row[unit]"; ?>">
                                                </td>
                                            </tr>

                                        <?php   } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid col-2 mt-5" style="margin-left: 70vw;">
                    <button class="btn btn-outline-success p-3" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Item To Shelves</button>

                </div>

            </div>
        </div>
    </div>


    <!-- Modal for adding item to shelves -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Item to the Shelves</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 15rem; display:grid;">

                    <label> Item : </label>
                    <select name="item" id="item">
                        <option selected disabled>-- Select Item --</option>
                        <?php
                        $categories = mysqli_query($connection, "SELECT * FROM inventory WHERE NOT EXISTS (SELECT * FROM item_mapping WHERE item_mapping.item_id = inventory_id)");
                        while ($row = mysqli_fetch_array($categories)) { ?>

                            <option value="<?php echo $row['inventory_id']; ?>"> <?php echo $row['category'] . "_" . $row['brand'] . "_" . $row['type']; ?></option>

                        <?php } ?>

                    </select>
                    <label> Shelves :</label>
                    <select name="section" id="sect">
                        <option selected disabled>-- Select Shelve's --</option>
                        <option value="MedNorth">MedNorth</option>
                        <option value="MedEast">MedEast</option>
                        <option value="MedCenter">MedCenter</option>
                        <option value="MedWest">MedWest</option>
                        <option value="MedSouth">MedSouth</option>

                    </select>

                    <label> Row :</label>
                    <select name="row" id="row">
                        <option selected disabled>-- Select Row's --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>

                    <label> Column :</label>
                    <select name="column" id="column">
                        <option selected disabled>-- Select Column's --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="add">Save</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for update iten on shelves -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Item Shelves</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="height: 15rem; display:grid;">

                    <div>
                        <input type="text" id="getDetail" disabled style="width: -webkit-fill-available; text-align:center;">
                        <input type="hidden" id="getid">
                    </div>

                    <label> Shelves :</label>
                    <select name="upt_section" id="upt_sect">
                        <option selected disabled>-- Select Shelve's --</option>
                        <option value="MedNorth">MedNorth</option>
                        <option value="MedEast">MedEast</option>
                        <option value="MedCenter">MedCenter</option>
                        <option value="MedWest">MedWest</option>
                        <option value="MedSouth">MedSouth</option>

                    </select>

                    <label> Row :</label>
                    <select name="upt_row" id="upt_row">
                        <option selected disabled>-- Select Row's --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                    </select>

                    <label> Column :</label>
                    <select name="upt_column" id="upt_column">
                        <option selected disabled>-- Select Column's --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update">Update</button>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('.mapping', {
        paging: false,
        info: false,
    });
</script>


<script>
    // add item to the shelves
    $('#add').click(function() {
        let item = $("#item").val();
        let sec = $('#sect').val();
        let row = $('#row').val();
        let column = $('#column').val();


        if (item == null || sec == null || row == null || column == null) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,

            });
            Toast.fire({
                background: "#ffe6e6",
                icon: "warning",
                title: "Please Complete all the Fields"
            });

            // alert('Please Complete all the Fields')
        } else {
            $.ajax({
                type: "POST",
                url: "code.php",
                data: {
                    item: item,
                    sec: sec,
                    row: row,
                    column: column
                },
                success: function(response) {
                    $('#exampleModal').modal('toggle');
                    window.location.reload();
                }
            });
        }
    });

    // remove item to the shelves

    $(document).on('click', '.rem', function() {
        let rem = $(this).val();

        Swal.fire({
            title: "are you sure you to remove item to the shelves?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00DFA2",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "GET",
                    url: "code.php?rem=" + rem,
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });

    });


    //  update item on Shelves

    $(document).on('click', '.upt', function() {
        let upt = $(this).val();
        var detail = $('#' + upt).children('td[data-target="name"]').text();
        var type = $('#' + upt).children('td[ data-target="type"]').text();
        var dosage = $('#' + upt).children('td[ data-target="dosage"]').text();
        document.getElementById('getDetail').value = detail + "-" + type + "/" + dosage;
        document.getElementById('getid').value = upt;
    });

    $('#update').click(function() {
        let upt = $('#getid').val();
        let sec = $('#upt_sect').val();
        let row = $('#upt_row').val();
        let column = $('#upt_column').val();


        if (sec == null || row == null || column == null) {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1000,

            });
            Toast.fire({
                background: "#ffe6e6",
                icon: "warning",
                title: "Please Complete all the Fields"
            });
        } else {

            $.ajax({
                type: "POST",
                url: "code.php",
                data: {
                    upt: upt,
                    sec: sec,
                    row: row,
                    column: column
                },
                success: function(response) {
                    window.location.reload();

                }
            });
        }
    });
</script>

</html>