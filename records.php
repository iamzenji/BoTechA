<?php
include 'includes/connection.php';
include 'includes/header.php';
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php $_SESSION['name'] = "mark";
    $_SESSION['id'] = 1; ?>

    <div class="main-content">
        <div class="container">
            <div class="header">
                <h1><i class='bx bx-history bx-tada'></i>Records</h1>

            </div>

            <h2><?php echo $_SESSION['name']; ?></h2>
            <p>Your Transact Info :</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Transact # </th>
                        <th>Method</th>
                        <th>Total Amount</th>
                        <th>Total Discount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cashier = $_SESSION['id'];
                    $sql = "SELECT * FROM `transact` WHERE cashier_id = $cashier;";
                    $result = $connection->query($sql);

                    if (!$result) {
                        die("Invalid query: " . $connection->error);
                    }
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo "$row[transact_no]"; ?></td>
                            <td><?php echo "$row[pay_method]"; ?></td>
                            <td><?php echo "$row[total_amount]"; ?></td>
                            <td><?php echo "$row[total_dis]"; ?></td>
                            <td><?php echo "$row[date]"; ?></td>
                        </tr>
                    <?php   } ?>
                </tbody>
            </table>
            </tbody>
            </table>
        </div>
    </div>
</body>