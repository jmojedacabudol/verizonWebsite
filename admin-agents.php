<?php
require_once 'admin-header.php';
?>
<div class="main">
    <table id="Agents" class="display" style="width:100%">
        <thead>
            <tr>
            <tr>
                <th>User No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Position</th>
                <th class="notexport"> Actions</th>
            </tr>
            </tr>
        </thead>
        <tbody>
            <?php
$sql = "SELECT * FROM users WHERE approval!=3;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>";
        echo $row['usersId'];
        echo "</td>";
        echo "<td>";
        echo $row['usersFirstName'];
        echo "</td>";
        echo "<td>";
        echo $row['userLastName'];
        echo "</td>";
        echo "<td>";
        echo $row['usersMobileNumber'];
        echo "</td>";

        echo "<td>";
        echo $row['usersEmail'];
        echo "</td>";

        echo "<td>";
        echo $row['usersPosition'];
        echo "</td>";
        echo "<td>";
        echo " <button class='btn btn-success' id='approveBtn' type='text' aria-label='Approve'><i
                                        class='far fa-check-circle'></i></button>";
        echo " <button class='btn btn-danger' id='denyBtn'type='text' aria-label='Deny'><i
                                        class='far fa-times-circle'></i></button>";

        echo " <button class='btn btn-info' id='viewBtn' type='text' aria-label='View'><i
                                        class='far fa-eye'></i></button>";

        echo "</td>";

        echo "</tr>";
    }
} else {
    echo "No Data";
}
?>
        </tbody>
    </table>
</div>

<div class="properties-modal modal fade" id="propertiesModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg" id="propertyContainer">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id='approvelisting' class="btn btn-success">Approve</button>
                <button type="button" id='denylisting' class="btn btn-danger">Deny</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- Datatables plugins -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script src="js/adminAgents.js"></script>
<script>
</script>
</body>

</html>