<?php
include 'includes/connection.php';
include 'includes/header.php';

if (strlen($_SESSION['employee_id']) === 0) {
    header('location:login.php');
    session_destroy();
} else {

    // Select data from table to global variables
    $query = "SELECT * FROM finance_inbox_hr ORDER BY id DESC";
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
                                <p>Inbox</p>
                            </div>
                            <button class="btn btn-success" id="mailAdd" data-toggle="modal"
                                data-target="#mailAddModal">+</button>
                            <!-- Add Message Modal -->
                            <div class="modal fade" id="mailAddModal" tabindex="-1" aria-labelledby="mailAddModalLabel"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <form action="financeConfigAdd.php" method="post">
                                            <input type="hidden" name="user"
                                                value="<?php echo $_SESSION['employee_position']; ?>">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="mailAddModalLabel">Add Message</h5>
                                                <button type="button" class="close btn-close" data-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body" style="margin: 2em;">

                                                <h3>To:<select name="pick-add" id="pick-add" class="form-select">
                                                        <option>Purchase Order</option>
                                                        <option>Finances</option>
                                                        <option>Sales</option>
                                                        <option>Inventory</option>
                                                    </select>
                                                </h3>
                                                <h4>From: <span style="color: red;">Finance</span></h4>

                                                <div class="finance-add-text">
                                                    <h5>Message:</h5>
                                                    <input type="text" name="msginfo">
                                                </div>
                                                <!-- <p>Message: <input type="text" name="approvalmsg" required <?php //echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>></p> -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="send-mail">Send</button>
                                                <!-- <button type="submit" class="btn btn-danger" name="Denied" <?php //echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>>Deny</button> -->
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                                    aria-label="Close">Close</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <?php ?>
                        <!-- Inbox Messages -->
                        <div class="box-content">
                            <table class="finances-inbox">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Sent by:</th>
                                        <th scope="col">To:</th>
                                        <th scope="col">Message Info</th>
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
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        ?>
                                        <tr class="mailInfo" id="mailInfo-<?= $row['id']; ?>" data-toggle="modal"
                                            data-target="#mailInfoModal-<?= $row['id']; ?>">
                                            <td data-bs-toggle="none"><?= $i; ?></td>
                                            <td id="sender"> <?= $row['sender'] ?> </td>
                                            <td id="receiver"> <?= $row['receiver'] ?> </td>
                                            <td id="messageInfo"> <?= $row['msginfo'] ?> </td>
                                            <td id="messageDate"> <?= date("M d, Y g:i A", strtotime($row['date'])); ?> </td>
                                        </tr>

                                        <!-- Inbox Modal -->
                                        <form action="<?php echo "financeConfigApproval.php" ?>" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="modal fade" id="mailInfoModal-<?= $row['id']; ?>" tabindex="-1"
                                                aria-labelledby="mailModalLabel-<?= $row['id']; ?>" role="dialog"
                                                aria-hidden="true">
                                                <div
                                                    class="modal-dialog mailinfo modal-dialog-centered modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="mailModalLabel-<?= $row['id']; ?>">
                                                                Message Info</h5>
                                                            <button type="button" class="close btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h3 style="color: var(--primary-blue);">Sent by:
                                                                <b><?= $row['sender']; ?></b></h3>
                                                            <h3 style="color: red;">From: <b><?= $row['receiver']; ?></b></h3>
                                                            <h5>Time: <b
                                                                    style="color: var(--blue);"><?= date("M d, Y, g:i A", strtotime($row['date'])); ?></b>
                                                            </h5>
                                                            <br>
                                                            <h6>Message:</h6>
                                                            <p><?= $row['msginfo']; ?></p>
                                                            <div class="modal-footer">
                                                                <!-- <button type="submit" class="btn btn-success" name="Reply" <?php //echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>>Approve</button> -->
                                                                <button type="submit" class="btn btn-danger" name="deletemsg"
                                                                    onclick="return confirm('Are you sure?')" <?php //echo $row['approvalmsg'] !== '----------' ? " hidden" : ""; ?>>Delete</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal" aria-label="Close">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </form>
                                        <?php $i++;
                                    } ?>
                                    </tr>
                                </tbody>
                            </table>
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

<?php }

mysqli_close($connection); ?>