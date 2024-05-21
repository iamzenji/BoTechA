<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RECORDS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.min.css" rel="stylesheet">

    <style>
        table.dataTable thead>tr>th.dt-orderable-asc,
        table.dataTable thead>tr>th.dt-orderable-desc,
        table.dataTable thead>tr>td.dt-orderable-asc,
        table.dataTable thead>tr>td.dt-orderable-desc {
            text-align: center;
            background: #4B71FE;
        }

        table.table.dataTable> :not(caption)>*>* {
            text-align: center;
        }

        .rep {
            text-align: left;
            font-family: 'Times New Roman', Times, serif;
            height: 17vh;
        }

        .catchy-text {
            font-size: 24px;
            font-weight: bold;
            color: #FFF;
            text-transform: uppercase;
            letter-spacing: 2px;
            background-color: #007BFF;
            padding: 10px 40px 10px 40px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: absolute;
            right: 20px; 
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


            var date = document.getElementById('date');
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

<body>
    <div class="main-content"><?php include('sidebar.php'); ?>
        <div class="header">
            <div class="timer">
                <div id="time"></div>
                <div id="date"></div>
            </div>
            <h1><i style="margin: 1rem;" class='bx bxs-report bx-tada'></i>Records</h1>
        </div>
        <div class="dropdown position-absolute top-0 end-0" style="margin: 12px 7px 0 0;">
            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-user'></i>
            </button>
            <ul class="dropdown-menu" style="width: 12vw;">

                <li><span class="dropdown-item-text"><i class='bx bxs-user-circle'></i> <?php echo $_SESSION['name'] ?></span></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="" style="margin-left: 2vw;width:90vw;">

            <div style="box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);width: 85vw; height: 74vh; padding: 2rem 1vh 4rem 0; margin: 3vh 2rem 0 1rem;">
           
                <div style="position: absolute; margin-left: 2rem;">
                <div style="margin-left: 80vw;"> <p  class="catchy-text">Today Transact</p></div>
                    <button onclick="location.href='sales.php'" type="button" class="btn btn-success"><i class='bx bx-trending-up bx-tada'></i> Sales</button>
                    <button onclick="location.href='disc.php'" type="button" class="btn btn-danger"><i class='bx bxs-discount bx-tada'></i> Discount's</button>
                    <button onclick="location.href='item.php'" type="button" class="btn btn-warning"><i class='bx bxs-purchase-tag bx-tada'></i> Item Sales</button>
                    <button onclick="location.href='discard.php'" type="button" class="btn btn-secondary"><i class='bx bx-cart-download bx-tada'></i>Canceled Item's</button>
                    
                </div>

              
                <div>
                    <div style="padding: 5rem 2rem 1rem 3rem;">
                        <table id="r" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Transact # </th>
                                    <th>Method</th>
                                    <th>Discount Type</th>
                                    <th>Total Discount</th>
                                    <th>Sub-Total</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>

                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $cashier = $_SESSION['id'];
                                $sql = "SELECT * FROM `transact` WHERE year(date) = year(now()) AND month(date) = month(now()) AND day(date) = day(now()) AND cashier_id = $cashier;";
                                $result = $connection->query($sql);

                                if (!$result) {
                                    die("Invalid query: " . $connection->error);
                                }
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo "$row[transact_no]"; ?></td>
                                        <td><?php echo "$row[pay_method]"; ?></td>
                                        <td><?php echo "$row[type]"; ?></td>
                                        <td> ₱ <?php echo number_format("$row[total_dis]", 2); ?></td>
                                        <td> ₱ <?php echo number_format("$row[sub_total]", 2); ?></td>
                                        <td> ₱ <?php echo number_format("$row[total_amount]", 2); ?></td>
                                        <td><?php echo "$row[date]"; ?></td>
                                        <!-- <td><button id="view" value="<?php echo "$row[transact_no]"; ?>" class="btn btn-sm bg-primary-subtle"><i class="bi bi-eye-fill"></i></button></td> -->
                                    </tr>

                                <?php   } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Other Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 10px;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.5/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/datatables.min.js"></script>

<script>
    new DataTable('#r', {
        scrollCollapse: true,
        scrollY: '40vh',
        paging: false,
        info: false,
        layout: {
            topStart: 'buttons'
        },
        buttons: ['excel', 'pdf', 'print']
    });
</script>
<!-- 
<script>
    $(document).on('click', '#view', function() {
        let view_id = $(this).val();

        $.ajax({
            type: "POST",
            url: "code.php",
            data: {
                view_id: view_id
            },
            success: function(result) {
                $('.modal-body').html(result);
            }
        });
        $('#exampleModal').modal("show");
    })
</script> -->

</html>