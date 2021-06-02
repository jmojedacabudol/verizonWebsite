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
                <h5 class="card-title textToGreen">Your Messages</h5>
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <table id="messages" class="display table-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Client Name</th>
                                    <th>Client Number</th>
                                    <th>Property Id</th>
                                    <th>Property Name</th>
                                    <th>Date</th>
                                    <th class='notexport'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql = "SELECT * FROM messages WHERE agentId=?;";
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
        echo $row['messageId'];
        echo "</td>";
        echo "<td class='w-20'>";
        echo $row['userName'];
        echo "</td>";
        echo "<td>";
        echo $row['usersMobileNumber'];
        echo "</td>";
        echo "<td>";
        echo $row['propertyId'];
        echo "</td>";
        echo "<td>";
        echo $row['propertyName'];
        echo "</td>";
        echo "<td>";
        echo $row['date'];
        echo "</td>";
        echo "<td>";
        echo "<button type='button' id='btn-delete' class='btn btn-danger w-100'>Delete</button>";
        echo "</td>";
    }
}
?>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Client Name</th>
                                    <th>Client Number</th>
                                    <th>Property Id</th>
                                    <th>Property Name</th>
                                    <th>Date</th>
                                    <th class='notexport'>Action</th>
                                </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="js/dashboard-messages.js"></script>

</body>

</html>