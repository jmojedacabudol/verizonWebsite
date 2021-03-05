<?php
require_once 'header.php';
?>


<?php
require_once 'sidenav.php'
?>
<div class="main">
    <section id="ViewList">
        <div class="card container-fluid">
            <div class="card-body">
                <h5 class="card-title">Your Team Member/s</h5>
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <table id="members" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Agent Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th class='notexport'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql = "SELECT * FROM users WHERE managerid=(SELECT managerId from managers WHERE usersId=?);";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "<tr>";
    echo "SQL ERROR";
    echo "</tr>";
    exit();
}
mysqli_stmt_bind_param($stmt, 's', $_SESSION['userid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td class='w-20'>";
        echo $row['usersId'];
        echo "</td>";
        echo "<td>";
        echo $row['usersFirstName'];
        echo "</td>";
        echo "<td>";
        echo $row['userLastName'];
        echo "</td>";
        echo "<td>";
        echo $row['usersEmail'];
        echo "</td>";
        echo "<td>";
        echo " <button class='btn btn-info' id='viewMessagesBtn' type='text' aria-label='View'>Messages</button>";
        echo " <button class='btn btn-warning' id='viewSchedulesBtn'type='text' aria-label='Deny'>Schedules</button>";
        echo " <button class='btn btn-success' id='viewPropertiesBtn'type='text' aria-label='Deny'>Properties</button>";

        echo "</td>";
    }
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>



<div class="properties-modal modal fade" id="viewMessages" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49;">Messages</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table id="messages" class="display" style="width:100%">
                        <thead>
                            <tr>
                            <tr>
                                <th>Id</th>
                                <th>Client</th>
                                <th>Number</th>
                                <th>Property</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
        </div>
    </div>
</div>

<div class="properties-modal modal fade" id="viewSchedules" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49;">Schedules</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table id="schedules" class="display" style="width:100%">
                        <thead>
                            <tr>
                            <tr>
                                <th>Id</th>
                                <th>Client</th>
                                <th>Number</th>
                                <th>Property</th>
                                <th>Date</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
        </div>
    </div>
</div>

<div class="properties-modal modal fade" id="viewProperties" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49;">Properties</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table id="properties" class="display" style="width:100%">
                        <thead>
                            <tr>
                            <tr>
                                <th>Id</th>
                                <th>Property</th>
                                <th>OfferType</th>
                                <th>Location</th>
                                <th>Price</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
        </div>
    </div>
</div>




<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="assets/mail/contact_me.js"></script>
<script src="js/dashboard-members.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>

</html>