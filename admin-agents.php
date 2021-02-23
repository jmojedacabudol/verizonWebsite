<?php
require_once 'admin-header.php';
if (!isset($_SESSION['adminUser'])) {
    header("location: admin.php");
}

?>
<div class="main">
    <h5>All Accounts</h5>
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
        echo " <button class='btn btn-warning' id='featureBtn' type='text' aria-label='Approve'><i class='fas fa-medal'></i></button>";

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
    <br>
    <h5>Featured Agent/s</h5>
    <br>
    <table id="featured" class="display" style="width:100%">
        <thead>
            <tr>
            <tr>
                <th>User No.</th>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Position</th>
                <th class="notexport"> Actions</th>
            </tr>
            </tr>
        </thead>
        <tbody>
            <?php
$sql = "SELECT * FROM featuredAgent;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>";
        echo $row['featId'];
        echo "</td>";
        echo "<td>";
        echo $row['usersName'];
        echo "</td>";
        echo "<td>";
        echo $row['usersNumber'];
        echo "</td>";
        echo "<td>";
        echo $row['usersEmail'];
        echo "</td>";

        echo "<td>";
        echo $row['usersPosition'];
        echo "</td>";
        echo "<td>";
        echo " <button class='btn btn-info' id='viewFeatured' type='text' aria-label='View'><i
                                        class='far fa-eye'></i></button>";

        echo " <button class='btn btn-danger' id='deleteFeatured'type='text' aria-label='Deny'><i
                                        class='far fa-times-circle'></i></button>";
        echo "</td>";

        echo "</tr>";
    }
}
?>
        </tbody>
    </table>
</div>

<div class="properties-modal modal fade" id="agentModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49
;">Agent Information</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>

                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div id='agentProfileImg'></div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id='agentInfo'></div>
                        </div>

                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" id='approvelisting' class="btn btn-success">Approve</button>
                <button type="button" id='featureUserBtn' class="btn btn-warning">Feature</button>
                <button type="button" id='denylisting' class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
        </div>
    </div>
</div>



<div class="properties-modal modal fade" id="featureModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49
;">Feature Agent</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>

                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-6 col-lg-7">
                            <div id='featureImg'></div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id='featureAgentInfo'></div>
                            <br>
                            <textarea class="form-control" style="height: 150px;" id='listing-desc'
                                name='listing-desc'></textarea>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" id="featBtn" class="btn btn-success">Feature Agent</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
        </div>
    </div>
</div>




<div class="properties-modal modal fade" id="editFeatureModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49
;">Feature Agent</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>

                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-6 col-lg-7">
                            <div id='editFeatureImg'></div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id='editFeatureAgentInfo'></div>
                            <br>

                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" id="editFeatBtn" class="btn btn-success">Edit Feature Agent</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br>
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