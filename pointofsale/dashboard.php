<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include('include/sidebar.php'); ?>
    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1><i class='bx bxs-dashboard bx-rotate-270 bx-tada' undefined></i>Dashboard</h1>
            </div>

            <div class="row  text-center">
                <a href="pos.php" class="col btn btn-primary  w-25 p-5 m-5" role="button"><i class='bx bxs-basket bx-tada bx-rotate-270' style=font-size:60px class=></i> POS</a>
                <a href="mapping.php" class="col btn btn-secondary w-25 p-5 m-5" role="button"><i class='bx bxs-map-alt bx-tada bx-rotate-270' style=font-size:60px></i> Item Mapping</a>
                <a href="sales.php" class="col btn btn-success  w-25 p-5 m-5" role="button"><i class='bx bx-dollar bx-tada bx-rotate-270' style=font-size:60px></i> Sales</a>

            </div>
            <div class="row">
                <a href="records.php" class="col btn btn-danger w-25 p-5 m-5" role="button"><i class='bx bx-history bx-tada bx-flip-horizontal' style='color:#f1f0f0;  font-size:60px '></i></i> Record</a>
                <a href="reports.php" style=' color:#f1f0f0;' class="col btn btn-warning  w-25 p-5 m-5" role="button"><i class='bx bxs-report bx-tada' style='font-size:60px;'> </i> Reports</a>

                <button type="button" class="col btn btn-bs-light w-25 p-5 m-5"></button>
                <i class='bx bx-history' style='color:#fffbfb'></i>


            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>