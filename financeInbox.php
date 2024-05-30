<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    // Select data from table to global variables
    $query = "SELECT * FROM finance_inbox ORDER BY date DESC";
    $result = mysqli_query($connection, $query);
?>

    <body>
        <section class="finance-container">
            <div class="right-window">
                <section class="right-window-container">
                    <!-- Inbox -->
                    <div class="box">
                        <div class="box-title">
                            <div class="box-title-buttons">
                                <button class="btn btn-outline-primary" data-bs-placement="top" title="Click to Expand">Inbox</button>
                            </div>
                            <!-- Inbox Kebab Button -->
                            <?php if (mysqli_num_rows($result) > 0) { ?>
                                <div class="dropdown kebab-button">
                                    <svg class="dropdown-toggle" id="dropdownInbox" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_111_105)">
                                            <path d="M12 4C13.1046 4 14 3.10457 14 2C14 0.89543 13.1046 0 12 0C10.8954 0 10 0.89543 10 2C10 3.10457 10.8954 4 12 4Z" />
                                            <path d="M12 14.0002C13.1046 14.0002 14 13.1048 14 12.0002C14 10.8957 13.1046 10.0002 12 10.0002C10.8954 10.0002 10 10.8957 10 12.0002C10 13.1048 10.8954 14.0002 12 14.0002Z" />
                                            <path d="M12 23.9998C13.1046 23.9998 14 23.1043 14 21.9998C14 20.8952 13.1046 19.9998 12 19.9998C10.8954 19.9998 10 20.8952 10 21.9998C10 23.1043 10.8954 23.9998 12 23.9998Z" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_111_105">
                                                <rect width="24" height="24" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    <!-- Inbox Kebab Dropdown -->
                                    <ul class="dropdown-menu dropdown-menu-end" tabindex="-1" aria-labelledby="dropdownInbox">
                                        <li><a class="dropdown-item" href="#">Pending</a></li>
                                        <li><a class="dropdown-item" href="#">Approved</a></li>
                                        <li><a class="dropdown-item" href="#">Denied</a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- Inbox Messages -->
                        <div class="box-content">
                            <table class="finances-inbox">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Company Name</th>
                                        <th scope="col">Message Info</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" style="text-align: right;">Date</th>
                                    </tr>
                                    <?php
                                    if (mysqli_num_rows($result) <= 0) {
                                        echo "<tr>";
                                        echo "<td colspan='6' style='width: 100%;'>No Results found</td>";
                                        echo "<tr>";
                                    }
                                    ?>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr class="mailInfo" id="mailInfo-<?= $row['id']; ?>" data-toggle="modal" data-target="#mailInfoModal-<?= $row['id']; ?>">
                                            <td data-bs-toggle="none"><input class="form-check-input" type="checkbox" id="mailCheckbox"></td>
                                            <td id="companyName"> <?= $row['company'] ?> </td>
                                            <td id="messageInfo"> <?= $row['msginfo'] ?> </td>
                                            <td id="penCost"> ₱<?= number_format($row['cost']) ?> </td>
                                            <td id="penStatus"> <?= $row['status'] ?> </td>
                                            <td id="messageDate"> <?= $row['date'] ?> </td>
                                        </tr>

                                        <!-- Inbox Modal -->
                                        <form action="<?php echo "financeConfigApproval.php" ?>" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="company" value="<?php echo $row['company']; ?>">
                                            <input type="hidden" name="cost" value="<?php echo $row['cost']; ?>">
                                            <div class="modal fade" id="mailInfoModal-<?= $row['id']; ?>" tabindex="-1" aria-labelledby="mailModalLabel-<?= $row['id']; ?>" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog mailinfo modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="mailModalLabel-<?= $row['id']; ?>">
                                                                Message
                                                                Info</h5>
                                                            <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3><?= $row['company']; ?></h3>
                                                            <h5><?= $row['date']; ?></h5>
                                                            <h6>Approval Message:</h6>
                                                            <p><?= $row['approvalmsg']; ?></p>
                                                            <br>
                                                            <p>Message: <input type="text" name="approvalmsg" required <?php echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="Approved" <?php echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>>Approve</button>
                                                            <button type="submit" class="btn btn-danger" name="Denied" <?php echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>>Deny</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </section>

    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/67c4787375.js" crossorigin="anonymous"></script>

<?php }

mysqli_close($connection); ?>