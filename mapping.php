<?php
include 'includes/connection.php';
include 'includes/header.php';

if (isset($_POST['add_map'])) {
    $id = $_POST['item'];
    $section = $_POST['section'];
    $column = $_POST['column'];
    $rows = $_POST['row'];

    $map = mysqli_query($connection, "INSERT INTO `item_mapping`( `item_id`, `section`, `colum`, `row`) VALUES ('$id','$section','$column','$rows')");
    header('location:mapping.php');
};

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($connection, "DELETE FROM item_mapping WHERE item_id = $remove_id");
    header('location:mapping.php');
};
?>

<head>
    <!-- <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

    <div class="main-content">
        <div class="container">

            <div class="header">
                <h1><i class='bx bxs-basket bx-tada bx-rotate-270'></i>Item Mapping</h1>
            </div>

            <div class="mb-3 mt-3 p-3 bg-info bg-gradient rounded">
                <form method="post">

                    <label style="margin-left: 60px;"> Item : </label>
                    <select name="item" id="">
                        <option selected disabled>-- select Item --</option>
                        <?php
                        $categories = mysqli_query($connection, "SELECT * FROM item WHERE NOT EXISTS (SELECT * FROM item_mapping WHERE item_mapping.item_id = item.id)");
                        while ($row = mysqli_fetch_array($categories)) { ?>

                            <option value="<?php echo $row['id']; ?>"> <?php echo $row['generic_name'] . "_" . $row['brand_name'] . "_" . $row['medicine_type']; ?></option>

                        <?php } ?>

                    </select>

                    <label style="margin-left: 50px;"> Section :</label>
                    <select name="section">
                        <option selected disabled>--select section--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>

                    </select>

                    <label style="margin-left: 50px;"> Column :</label>
                    <select name="column">
                        <option selected disabled>--select row--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <label style="margin-left: 50px;"> Row :</label>
                    <select name="row">
                        <option selected disabled>--select column--</option>
                        <option value="a">a</option>
                        <option value="b">b</option>
                        <option value="c">c</option>
                        <option value="d">d</option>
                        <option value="e">e</option>
                    </select>
                    <input button class="btn btn-success btn-lg ms-3" type="submit" value="Add" name="add_map">
                </form>
            </div>


            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Section 1</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Section 2 </button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Section 3 </button>

                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">

                    <table class="table table-striped table-hover mapping table-sm text-center" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Column-Row</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $sql = "SELECT * FROM item_mapping
CROSS JOIN item
WHERE item.id = item_mapping.item_id AND item_mapping.section = 1;";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo "$row[generic_name]  $row[brand_name]"; ?></td>
                                    <td><?php echo "$row[medicine_type]"; ?></td>
                                    <td><?php echo "$row[dosage]"; ?></td>
                                    <td><?php echo "$row[colum]-$row[row]"; ?></td>
                                    <td>
                                        <a href="mapping.php?remove=<?php echo $row['item_id']; ?>" onclick="return confirm ('remove item ?')" class="link-danger"><i class='bx bxs-trash'></i></a>
                                    </td>
                                </tr>

                            <?php   } ?>

                        </tbody>
                    </table>

                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

                    <table class="table table-striped table-hover mapping table-sm text-center" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Column-Row</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php

                            $sql = "SELECT * FROM item_mapping
CROSS JOIN item
WHERE item.id = item_mapping.item_id AND item_mapping.section = 2;";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo "$row[generic_name]  $row[brand_name]"; ?></td>
                                    <td><?php echo "$row[medicine_type]"; ?></td>
                                    <td><?php echo "$row[dosage]"; ?></td>
                                    <td><?php echo "$row[colum]-$row[row]"; ?></td>
                                    <td>
                                        <a href="mapping.php?remove=<?php echo $row['id']; ?>" onclick="return confirm ('remove item ?')" class="link-danger"><i class='bx bxs-trash'></i></a>
                                    </td>
                                </tr>
                            <?php   } ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
                    <table class="table table-striped table-hover mapping table-sm text-center" style="width:100%">
                        <thead class="table-secondary">
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Column-Row</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "SELECT * FROM item_mapping
CROSS JOIN item
WHERE item.id = item_mapping.item_id AND item_mapping.section = 3;";
                            $result = $connection->query($sql);

                            if (!$result) {
                                die("Invalid query: " . $connection->error);
                            }
                            while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo "$row[generic_name]  $row[brand_name]"; ?></td>
                                    <td><?php echo "$row[medicine_type]"; ?></td>
                                    <td><?php echo "$row[dosage]"; ?></td>
                                    <td><?php echo "$row[colum]-$row[row]"; ?></td>
                                    <td>
                                        <a href="mapping.php?remove=<?php echo $row['id']; ?>" onclick="return confirm ('remove item ?')" class="link-danger"><i class='bx bxs-trash'></i></a>
                                    </td>
                                </tr>
                            <?php   } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> -->
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <!-- <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script> -->
    <script>
        new DataTable('.mapping');
    </script>
</body>