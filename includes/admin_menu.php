<?php include 'connection.php'; ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="admin.php">Admin</a>
            </div>
        </div>
        <div class="icon-logo">
            <a href="admin.php">
                <img src="src/img/botecha.png" alt="Logo">
            </a>
            <div class="brand-info">
                <div class="brand-name">Bo-Tech-A</div>
            </div>
        </div>


        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="admin.php" class="sidebar-link">
                    <i class="lni lni-home"></i>
                    <span>Dashboard
                    </span>
                </a>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#user" aria-expanded="false" aria-controls="user">
                    <i class="lni lni-user"></i>
                    <span>User Management</span>
                </a>
                <ul id="user" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Manage User</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Register</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#PO" aria-expanded="false" aria-controls="PO">
                    <i class="lni lni-weight"></i>
                    <span>Purcahse Order</span>
                </a>
                <ul id="PO" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Supplier List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Item List</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Orders</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#invent" aria-expanded="false" aria-controls="invent">
                    <i class="lni lni-list"></i>
                    <span>Inventory</span>
                </a>
                <ul id="invent" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Manage Stocks</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Logs</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#sales" aria-expanded="false" aria-controls="sales">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Sales</span>
                </a>
                <ul id="sales" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Records</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Reports</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Item Mapping</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#fin" aria-expanded="false" aria-controls="fin">
                    <i class="lni lni-money-protection"></i>
                    <span>Account and Finance</span>
                </a>
                <ul id="fin" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Transactions</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Expenses and Utilities</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#hum" aria-expanded="false" aria-controls="hum">
                    <i class="lni lni-customer"></i>
                    <span>Human Resources</span>
                </a>
                <ul id="hum" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Payroll</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">Employee</a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="sidebar-footer">
            <a href="" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>