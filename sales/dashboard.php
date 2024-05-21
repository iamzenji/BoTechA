<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">

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


            // document.getElementById('time').textContent = timeString;
            // document.getElementById('date').textContent = dateString;
        }

        // Update time and date every second
        setInterval(displayTimeAndDate, 1000);

        // Initial display
        displayTimeAndDate();
    </script>

</head>

<body>

    <div class="main-content"><?php include('sidebar.php'); ?>
        <div class="">
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
                <h1 style="margin-left: 2rem;" class=" pt-2"><i class='bx bx-home bx-tada' ></i>Dashboard</h1>

            </div>
            <div style="margin: 1rem; justify-content: space-evenly;" class="row">
                <button onclick="location.href='posample.php'" type="button" class="rep btn btn-warning m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <h3><i class='bx bxs-basket bx-tada bx-rotate-270' style=font-size:60px></i> POS</h3>
                    </div>
                </button>
                <button onclick="location.href='map.php'" type="button" class="rep btn btn-primary m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <h3><i class='bx bxs-map-alt bx-tada bx-rotate-270' style=font-size:60px></i> Item Mapping</h3>
                    </div>
                </button>
                <button onclick="location.href='records.php'" type="button" class="rep btn btn-info m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <h3><i class='bx bx-history bx-tada bx-flip-horizontal' style='font-size:60px;'></i> Records</h3>
                    </div>
                </button>

                <!-- sales -->
                <button onclick="location.href='sales.php'" type="button" class="rep btn btn-success m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <?php
                        $cashier = $_SESSION['id'];
                        $sql = "SELECT SUM(total_amount) AS total FROM transact WHERE cashier_id = $cashier;";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <h3><i class='bx bx-trending-up bx-tada' style='font-size:60px;'></i> Sales</h3>
                            <h4 class="card-title"> ₱ <?php echo number_format($row['total'], 2); ?></h4>
                        <?php   } ?>
                    </div>
                </button>

                <!-- discounts -->
                <button onclick="location.href='disc.php'" type="button" class="rep btn btn-danger m-4 " style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <?php
                        $cashier = $_SESSION['id'];
                        $sql = "SELECT SUM(total_dis) AS total FROM transact WHERE cashier_id = $cashier;";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <h3><i class='bx bxs-discount bx-tada' style='font-size:60px;'></i> Discount's</h3>
                            <h4 class="card-title"> ₱ <?php echo number_format($row['total'], 2); ?></h4>


                        <?php   } ?>
                    </div>
                </button>

                <!-- item sales -->
                <button onclick="location.href='item.php'" type="button" class="rep btn btn-secondary m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <?php
                        $cashier = $_SESSION['id'];
                        $sql = "SELECT SUM(qty) AS total FROM mesali CROSS JOIN transact WHERE cashier_id = $cashier AND transact.transact_no = mesali.transact_no;";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <h3><i class='bx bxs-purchase-tag bx-tada' style='font-size:60px;'></i> Item Sales</h3>
                            <h2 class="card-title"><?php echo number_format($row['total']); ?></h2>
                        <?php   } ?>
                    </div>
                </button>

                <!-- cancel item -->
                <button onclick="location.href='discard.php'" type="button" class="rep btn btn-outline-primary m-4" style="width: 20vw; height: 20vh;">
                    <div class="card-body">
                        <?php
                        $cashier = $_SESSION['id'];
                        $sql = "SELECT SUM(qty) AS total FROM meremove WHERE cashier_id = $cashier;";
                        $result = $connection->query($sql);

                        if (!$result) {
                            die("Invalid query: " . $connection->error);
                        }
                        while ($row = $result->fetch_assoc()) {
                        ?>

                            <h3><i class='bx bx-cart-download bx-tada' style='font-size:60px;'></i>Canceled Item</h3>
                            <h2 class="card-title"><?php echo number_format($row['total']); ?></h2>


                        <?php   } ?>
                    </div>
                </button>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>