<?php include 'includes/connection.php';
include 'includes/header.php'; ?>

<div class="main-content">
    <div class="container">
        <div class="header">
            <h1><i class='bx bx-dollar bx-tada bx-rotate-270'></i> Sales</h1>
        </div>
        <div>
            <form class="sircing" action="" method="post">
                <input type="text" placeholder="Search data" name="search">
                <button class="btn" name="submit">Search</button>
            </form>
        </div>
        <table class="items">
            <?php
            if (isset($_POST['submit'])) {
                $search = $_POST['search'];

                $sql = "SELECT * from item where brand_name = '$search' or generic_name = '$search'";
                $result = $connection->query($sql);

                if (!$result) {
                    die("invalid query: " . $connection->error);
                }
                if (mysqli_num_rows($result) > 0) {
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