<?php include 'connection.php'; ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="inventory.php">Sales</a>
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
                <a href="pos_dashboard.php" class="sidebar-link">
                    <i class="lni lni-home"></i>
                    <span>Dashboard
                    </span>
                </a>
            <li class="sidebar-item">
                <a href="pos.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>POS</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="records.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Record</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="sales.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Sales</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="reports.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Reports</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="mapping.php" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Item Mapping</span>
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