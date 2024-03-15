<?php include 'connection.php'; ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="inventory.php">Purcahse Order</a>
            </div>
        </div>
        <div class="icon-logo">
            <a href="inventory.php">
                <img src="src/img/botecha.png" alt="Logo">
            </a>
            <div class="brand-info">
                <div class="brand-name">Bo-Tech-A</div>
            </div>
        </div>


        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="inventory.php" class="sidebar-link">
                    <i class="lni lni-home"></i>
                    <span>Dashboard
                    </span>
                </a>
            <li class="sidebar-item">
                <a href="logs.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Supplier List</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="logs.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Item List</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="logs.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Purchase Orders</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>