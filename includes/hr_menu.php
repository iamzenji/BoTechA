<?php include 'connection.php'; ?>
<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button class="toggle-btn" type="button">
                <i class="lni lni-grid-alt"></i>
            </button>
            <div class="sidebar-logo">
                <a href="employees.php">Human Resources</a>
            </div>
        </div>
        <div class="icon-logo">
            <a href="employees.php">
                <img src="src/img/botecha.png" alt="Logo">
            </a>
            <div class="brand-info">
                <div class="brand-name">Bo-Tech-A</div>
            </div>
        </div>

        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="employeees.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Employees
                    </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="dtr_newpage.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>DTR new page
                    </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="request_leave.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Request Leave
                    </span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="generate_payroll_all.php" class="sidebar-link">
                    <i class="lni lni-users"></i>
                    <span>Payroll all
                    </span>
                </a>
            </li>
            <!-- <li class="sidebar-item">
                <a href="salary.php" class="sidebar-link">
                    <i class="lni lni-coin"></i>
                    <span>Payroll</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="" class="sidebar-link">
                    <i class="lni lni-invest-monitor"></i>
                    <span>Records</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-popup"></i>
                    <span>Warning Tab</span>
                </a>
            </li> -->
            <li class="sidebar-item">
                <a href="" class="sidebar-link">
                    <i class="lni lni-cog"></i>
                    <span>Settings</span>
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