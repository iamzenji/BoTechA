
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="design/style.css">
    <title>Document</title>
    <style>
        :root {
  /* =========COLORS========= */
  --body-color:rgba(41, 98, 255, 0.04);
  --sidebar-color:#007bff ;
  --primary-color: #000;
  --primary-color-light: #F6F5FF;
  --toggle-color: #DDD;
  --text-color: #000;

  /* ======== TRANSITION ======= */
  --tran-02: all 0.2s ease ;
  --tran-03: all 0.3s ease ;
  --tran-04: all 0.4s ease ;
  --tran-05: all 0.5s ease ;
}
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 15.625rem;
  padding: 0.625rem 0.875rem;
  background: var(--sidebar-color);
  transition: var(--tran-05);
  z-index: 100;
  border-bottom-right-radius: 30px;
  border-top-right-radius: 30px;
}

.sidebar li .icon,
.sidebar li .text {
  color: #fff;
  transition: var(--tran-02);
}


.sidebar li a:hover {
  color: #0d47a1 ;
  background-color: #fff;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
}

.sidebar li a:hover .icon,
.sidebar li a:hover .text {
  color: var(--sidebar-color);
}


header .image-text .header-text {
  display: flex;
  flex-direction: column;
  color: #fff;
}
    </style>
    
</head>
<body>
<nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                   <a href="index.php"> <img src="icon2.png" alt=""></a>
                </span>
                <div class="text header-text">
                    <span class="name">Allen</span>
                    <span class="profession">Manager</span>
                </div>
            </div>

            <i class="bx bx-chevron-right toggle"></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                <li class="nav-link">
                        <a href="index.php" onclick="handleSidebarLinkClick(event)">
                        <span class="material-symbols-outlined icon">dashboard</span>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="supplier.php" onclick="handleSidebarLinkClick(event)">
                        <span class="icon material-symbols-outlined">local_shipping</span>
                            <span class="text nav-text">Supplier List</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="items.php" onclick="handleSidebarLinkClick(event)">
                        <span class="material-symbols-outlined icon">box_add</span>
                            <span class="text nav-text">Item List</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="orders.php" onclick="handleSidebarLinkClick(event)">
                        <span class="material-symbols-outlined icon">add_shopping_cart</span>
                            <span class="text nav-text">Purchase Orders</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#" onclick="handleSidebarLinkClick(event)">
                        <span class="icon material-symbols-outlined">inventory</span>
                            <span class="text nav-text">Inventory</span>
                        </a>
                    </li>
                </ul>
     
            </div>
            
            <div class="bottom-content">
                <li class="nav=link">
                  <a href="logout.php"><i class="bx bx-log-out icon"></i>
                        <span class="text nav-text">Logout</span></a>  
                </li>
            </div>
        </div>
    </nav>
       <script src="script.js"></script>
       <script>
        const body = document.querySelector("body"),
            sidebar = body.querySelector(".sidebar"),
            toggle = body.querySelector(".toggle");

        toggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });
    </script>

</body>
</html>