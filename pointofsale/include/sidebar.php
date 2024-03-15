<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="include/side.css">
</head>
<body>

    <div class="sidebar">
        <div class="top">
       
        <div class="logo">  
            <span style="  font-size: 40px;">BoTecha</span>
        </div>
        <i class="bx bx-menu" id="btn"></i>
        </div>
      
        <div class="user">
            <img src="include/logo.png" alt="" class="user-img">
          
            <div>
                <p class="bold">profile <br>User</p>
                
            </div>
        </div >
        <ul id="uls">
            <li>
                <a href="dashboard.php">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="pos.php">
                    <i class='bx bx-cart' ></i>
                    <span class="nav-item">POS</span>
                </a>
                <span class="tooltip">POS</span>
            </li>
            <li>
                <a href="records.php">
                    <i class="bx bx-history"></i>
                    <span class="nav-item">Record</span>
                </a>
                <span class="tooltip">Record</span>
            </li>
            <li>
                <a href="reports.php">
                    <i class='bx bx-error-circle' ></i>
                    <span class="nav-item">Reports</span>
                </a>
                <span class="tooltip">Reports</span>
            </li>
            <li>
                <a href="mapping.php">
                  <i class='bx bx-map-pin' ></i>
                    <span class="nav-item">Item Mapping</span>
                </a>
                <span class="tooltip">Item Mapping</span>
            </li>

            <br><br><br><br><br><br>
            <li>
                <a href="login.php">
                  <i class='bx bx-log-out' ></i>
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

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>
</html>
