<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Document</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>

        <div class="sidebar" onmouseleave="out()">
            <div class="top">

                <div class="logo">
                    <span style="  font-size: 40px;">BoTecha</span>
                </div>
                <i class='bx bx-grid-alt' id="btn" style="font-size: xx-large;"></i>
                <!-- <i class="bx bx-menu" ></i> -->
            </div>

            <div class="user">
                <img src="logo.png" alt="" class="user-img">

                <div>
                    <p class="bold"><?php echo $_SESSION['name']; ?></p>

                </div>
            </div>
            <ul id="uls">
                <li>
                    <a href="dashboard.php">
                    <i class='bx bx-home-alt'></i>
                        <span class="nav-item">Dashboard</span>
                    </a>
                    <span class="tooltip">Dashboard</span>
                </li>
                <li>
                    <a href="posample.php">
                        <i class='bx bx-cart'></i>
                        <span class="nav-item">POS</span>
                    </a>
                    <span class="tooltip">POS</span>
                </li>
                <li>
                    <a href="map.php">
                        <i class='bx bx-map-pin'></i>
                        <span class="nav-item">Item Mapping</span>
                    </a>
                    <span class="tooltip">Mapping</span>
                </li>
                <li>
                    <a href="records.php">
                        <i class="bx bxs-report"></i>
                        <span class="nav-item">Record</span>
                    </a>
                    <span class="tooltip">Record</span>
                </li>

                <div style="height: 40vh;"></div>
                <li>
                    <a href="logout.php">
                        <i class='bx bx-log-out'></i>
                        <span class="nav-item">Log Out</span>
                    </a>
                    <span class="tooltip">LogOut</span>
                </li>

            </ul>
        </div>


        <!-- <div class="main-content">
        <div class="container">
          
            <img src="image/logo.png" alt=""  class="user-imgs">
        </div>
    </div> -->


    </body>
    <script>
        let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')
        var n = 0;
        btn.onclick = function() {
            if (n == 1) {
                sidebar.classList.toggle('active');
                n = 0;
            } else {
                sidebar.classList.toggle('active');
                n = 1;
            }

        };

        function out() {
            if (n == 1) {
                sidebar.classList.toggle('active');
                n = 0;
            }

        }
        // sidebar.onmouseout = function () {
        //     sidebar.classList.toggle('active') = false;
        // };
    </script>

    </html>
<?php
} else {
    header("Location: ../index.php");
    exit();
}
?>