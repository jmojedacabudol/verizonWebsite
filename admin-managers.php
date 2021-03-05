<?php
require_once 'admin-header.php';

?>
<div class="main">
    <h5>All MANAGERS</h5>
    <br>
    <table id="managers" class="display" style="width:100%">
        <thead>
            <tr>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Status</th>
                <th class="notexport"> Actions</th>
            </tr>
            </tr>
        </thead>
        <tbody>
            <?php

$sql = "SELECT * FROM managers;";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userId = $row['usersId'];

        echo "<tr>";
        echo "<td>";
        echo $row['managerId'];
        echo "</td>";
        echo "<td>";
        echo $row['name'];
        echo "</td>";
        if ($row['approval'] == 0) {
            echo "<td style='color:orange;'><i class='fas fa-clock'></i>&nbsp;&nbsp;";
            echo "Pending";
            echo "</td>";

        } else if ($row['approval'] == 1) {
            echo "<td style='color:green;'><i class='fas fa-check'></i>&nbsp;&nbsp;";
            echo "Approved";
            echo "</td>";
        } else if ($row['approval'] == 2) {
            echo "<td style='color:red;'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo "Denied";
            echo "</td>";

        }
        echo "<td>";
        echo " <button class='btn btn-success' id='approveBtn' type='text' aria-label='Approve'>Approve</button>";
        echo " <button class='btn btn-danger' id='denyBtn'type='text' aria-label='Deny'>Deny</button>";
        echo " <button class='btn btn-warning' id='viewBtn' type='text' aria-label='Approve'>View Agents</button>";
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



<div class="properties-modal modal fade" id="viewManagerAgents" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title" style="color:#5C7B49
;">Agent/s</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>

                <br>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <table id="managerAgents" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
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

<script src="js/adminManagers.js"></script>
<script>
</script>
</body>

</html>