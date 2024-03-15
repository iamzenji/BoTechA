<?php include 'connect.php'; ?>

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
    <?php include('include/sidebar.php'); ?>

    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1><i class='bx bxs-basket bx-tada bx-rotate-270'></i> POS</h1>
            </div>
            <div class="wrap">
                <div class="row">
                    <table id="laman" class="table table-striped table-hover" style="width:100%">
                        <thead id="buntuk">
                            <tr>
                                <th>Item Name</th>
                                <th>Type</th>
                                <th>Dosage</th>
                                <th>Item Map</th>


                            </tr>
                        </thead>
                        <tbody>


                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home-tab-pane" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">Section 1</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-tab-pane" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="false">Section 2</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#contact-tab-pane" type="button" role="tab"
                                        aria-controls="contact-tab-pane" aria-selected="false">Section 3</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button> -->
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                    aria-labelledby="home-tab" tabindex="0"> 
                                    <?php

                                        $sql = "SELECT * FROM item
                                        CROSS JOIN item_mapping
                                        WHERE item.id = item_mapping.item_id;";
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
                                        <td><?php echo "$row[section] $row[colum] $row[row]"; ?></td>


                                    </tr>

                                    <?php   } ?>

                                </div>
                                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                    aria-labelledby="profile-tab" tabindex="0">
                                
                                </div>
                                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel"
                                    aria-labelledby="contact-tab" tabindex="0">...</div>
                                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel"
                                    aria-labelledby="disabled-tab" tabindex="0">...</div>
                            </div>





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