<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {


    ?>

    <body>
        <section class="finance-container">
            <div class="right-window">
                <section class="right-window-container">
                    <!-- Inbox -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inboxTableModal"
                                data-bs-placement="top" title="Click to Expand">Inbox</button>
                            <!-- Inbox Modal -->
                            <div class="modal fade" id="inboxTableModal" tabindex="-1" aria-labelledby="inboxModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="inboxModalLabel">Inbox Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="finances-inbox">
                                                <tbody>
                                                    <tr class="mailInfo" id="mailInfo">
                                                        <td><input class="form-check-input" type="checkbox"
                                                                id="mailCheckbox"></td>
                                                        <td id="companyName">Compani</td>
                                                        <td id="messageInfo">Message Info</td>
                                                        <td id="messageDate">Feb 31</td>
                                                    </tr>
                                                    <tr class="mailInfo" id="mailInfo">
                                                        <td><input class="form-check-input" type="checkbox"
                                                                id="mailCheckbox"></td>
                                                        <td id="companyName">Company Name</td>
                                                        <td id="messageInfo">Message Info</td>
                                                        <td id="messageDate">Feb 32</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Back</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inbox Kebab Button -->
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownInbox" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Inbox Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownInbox">
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Approved</a></li>
                                    <li><a class="dropdown-item" href="#">Denied</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Inbox Messages -->
                        <div class="box-content">
                            <table class="finances-inbox">
                                <tbody>
                                    <tr class="mailInfo" id="mailInfo" data-bs-toggle="collapse" data-bs-target="#expand1"
                                        aria-expanded="false" aria-controls="expand1">
                                        <td><input class="form-check-input" type="checkbox" id="mailCheckbox"></td>
                                        <td id="companyName">Compani</td>
                                        <td id="messageInfo">Message Info</td>
                                        <td id="messageDate">Feb 31</td>
                                    </tr>
                                    <tr class="mailInfo" id="mailInfo">
                                        <td><input class="form-check-input" type="checkbox" id="mailCheckbox"></td>
                                        <td id="companyName">Company Name</td>
                                        <td id="messageInfo">Message Info</td>
                                        <td id="messageDate">Feb 32</td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Inbox Modal -->
                            <div class="modal modal-xl fade" id="mailInfoModal" tabindex="-1"
                                aria-labelledby="mailModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mailModalLabel">Message Info</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>From: Company Name</h3>
                                            <h5>Date: Feb 600</h5>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi, labore ut.
                                                Reprehenderit possimus officiis quo excepturi in hic perspiciatis aut fuga,
                                                eum itaque est aliquam, debitis eveniet quam voluptatum aliquid modi ab
                                                deserunt iste assumenda qui, voluptates inventore doloremque ducimus.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payroll -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#payrollTableModal" data-bs-placement="top"
                                title="Click to Expand">Payroll</button>
                            <!-- Payroll Table Modal -->
                            <div class="modal fade" id="payrollTableModal" tabindex="-1" aria-labelledby="payrollModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="payrollModalLabel">Payroll Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="finances-color-table payroll-table">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Position</th>
                                                        <th>Date</th>
                                                        <th>Salary</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jorge</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>marco</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Payroll Kebab Button -->
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownPayroll" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Payroll Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownPayroll">
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                    <li><a class="dropdown-item" href="#">undefined</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Payroll Table -->
                        <table class="finances-color-table payroll-table">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                    <th>Date</th>
                                    <th>Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>marco</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Expenses and Utilities -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#expensesTableModal" data-bs-placement="top"
                                title="Click to Expand">Expenses and Utilities</button>
                            <!-- Expenses and Utilities Modal -->
                            <div class="modal fade" id="expensesTableModal" tabindex="-1"
                                aria-labelledby="expensesModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="expensesModalLabel">Expenses Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="finances-color-table">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Rent</th>
                                                        <th>Electricity</th>
                                                        <th>Water</th>
                                                        <th>Supplies</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>march</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success">Add</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownExpAndUti" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Expenses and Utilities Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownInbox">
                                    <li><a class="dropdown-item" href="#">Pending</a></li>
                                    <li><a class="dropdown-item" href="#">Paid</a></li>
                                    <li><a class="dropdown-item" href="#">test</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Expenses and Utilities Table -->
                        <table class="finances-color-table">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Rent</th>
                                    <th>Electricity</th>
                                    <th>Water</th>
                                    <th>Supplies</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>march</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Inventory -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#inventoryTableModal" data-bs-placement="top"
                                title="Click to Expand">Inventory</button>
                            <!-- Inventory Modal -->
                            <div class="modal fade" id="inventoryTableModal" tabindex="-1"
                                aria-labelledby="inventoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="inventoryModalLabel">Inventory Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="finances-color-table">
                                                <thead>
                                                    <tr>
                                                        <th>Product ID</th>
                                                        <th>Product</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Date Bought</th>
                                                        <th>Expiry Date</th>
                                                        <th>Total Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success">Add</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownInventory" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- Inventory Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownInventory">
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                    <li><a class="dropdown-item" href="#">?</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Inventory Table -->
                        <table class="finances-color-table">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Date Bought</th>
                                    <th>Expiry Date</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- TOR -->
                    <div class="box">
                        <div class="box-title">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#TORTableModal"
                                data-bs-placement="top" title="Click to Expand">Transaction and Overall Revenue</button>
                            <!-- Payroll Table Modal -->
                            <div class="modal fade" id="TORTableModal" tabindex="-1" aria-labelledby="TORModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="TORModalLabel">TOR Table</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Expanded Table using Modal -->
                                            <table class="finances-color-table">
                                                <thead>
                                                    <tr>
                                                        <th>Transaction Id</th>
                                                        <th>Type</th>
                                                        <th>Date</th>
                                                        <th>Transaction</th>
                                                        <th>Employee</th>
                                                        <th>Total Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>001</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>002</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>003</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>004</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>005</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>006</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>007</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success">Add</button>
                                            <button type="button" class="btn btn-danger">Remove</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown kebab-button">
                                <svg class="dropdown-toggle" id="dropdownTOR" role="button" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_111_105)">
                                        <path
                                            d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                        <path
                                            d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                        <path
                                            d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_111_105">
                                            <rect width="24" height="24" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <!-- TOR Kebab Dropdown -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownTOR">
                                    <li><a class="dropdown-item" href="#">hahahahahahahahahaha</a></li>
                                    <li><a class="dropdown-item" href="#">hahahahahahahahahaha</a></li>
                                    <li><a class="dropdown-item" href="#">hahahahahahahahahaha</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- TOR Table -->
                        <table class="finances-color-table">
                            <thead>
                                <tr>
                                    <th>Transaction Id</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Transaction</th>
                                    <th>Employee</th>
                                    <th>Total Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>003</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>004</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>005</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>006</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>007</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box">
                        <div class="box-title">
                            <!-- Total Money -->
                            <p>Financial blahblahblah</p>
                        </div>
                        <div class="container">
                        </div>
                    </div>
                </section>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
                    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
                    crossorigin="anonymous"></script>
                <script src="script.js"></script>
                <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>
            <?php } ?>