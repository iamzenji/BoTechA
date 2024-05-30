<?php include 'connection.php'; ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="inventory_dashboard.php">Inventory</a>
            </div>
        </div>
        <div class="icon-logo">
            <a href="inventory_dashboard.php">
                <img src="src/img/botecha.png" alt="Logo">
            </a>
            <div class="brand-info">
                <div class="brand-name">Bo-Tech-A</div>
            </div>
        </div>


        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="inventory_dashboard.php" class="sidebar-link">
                    <i class="lni lni-home"></i>
                    <span>Dashboard
                    </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="inventory.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Manage Stocks
                    </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="inventory_logs.php" class="sidebar-link">
                    <i class="lni lni-files"></i>
                    <span>Inventory Logs</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="inventory_discount.php" class="sidebar-link">
                    <i class="lni lni-graph"></i>
                    <span>Discounted Product</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="inventory_return.php" class="sidebar-link">
                    <i class="lni lni-reply"></i>
                    <span>Return Product</span>
                </a>
            </li>

        </ul>
        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>