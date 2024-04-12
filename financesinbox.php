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
                                <div class="modal-dialog modal-dialog-scrollable">
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
                </section>
            </div>
        </section>
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>
<?php } ?>