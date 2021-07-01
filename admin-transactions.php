<?php
require_once 'admin-header.php';
?>
<div class="main">


    <div class="card">
        <h5 class="card-header textToGreen">Transactions</h5>
        <div class="card-body">
            <table id="admiTransactions" class="display table-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Propery Name</th>
                        <th>Property Type</th>
                        <th>Category</th>
                        <th>Unit No</th>
                        <th>TCP</th>
                        <th>Terms Of Payment</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Date of Transaction</th>
                        <th>Date of Reservation</th>
                        <th>Final TCP</th>
                        <th>Commission</th>
                        <th>Receivable</th>
                        <th>Agent`s Commission</th>
                        <th>AR`s Commision</th>
                        <th>Buyer`s Commission</th>
                        <th>Final Receivable</th>
                        <th class='notexport'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sql = "SELECT * FROM transactions;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if ($row['offertype'] === "Preselling") {
            echo "<tr>";
            echo "<td class='w-20'>";
            echo $row['transactionId'];
            echo "</td>";
            echo "<td class='w-20'>";
            echo $row['propertyName'];
            echo "</td>";
            echo "<td><i class='fas fa-building'></i>&nbsp;&nbsp;";
            echo $row['propertyType'];
            echo "</td>";
            echo "<td>";
            echo $row['category'];
            echo "</td>";
            if ($row['propertyType'] === "Condominium") {
                echo "<td>";
                echo $row['unitNo'];
                echo "</td>";

            } else {
                echo "<td>";
                echo "None";
                echo "</td>";

            }
            echo "<td>₱&nbsp;&nbsp;";
            echo $row['TCP'];
            echo "</td>";
            echo "<td>";
            echo $row['termsOfPayment'];
            echo "</td>";
            echo "<td>";
            echo $row['address'];
            echo "</td>";
            echo "<td>";
            echo $row['status'];
            echo "</td>";
            echo "<td>";
            echo $row['dateOfTransaction'];
            echo "</td>";
            //get date of reservation if preselling is selected
            echo "<td>";
            echo $row['dataOfReservation'];
            echo "</td>";

            echo "<td>₱&nbsp;&nbsp;";
            echo $row['finalTCP'];
            echo "</td>";
            echo "<td>";
            echo $row['commission'];
            echo "</td>";
//if the transaction is preselling I will not have receivable down to final receivable
            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>";
            echo "<button type='button' id='editTransactionBtn' class='btn btn-secondary w-100'>
                                        <i class='far fa-edit'></i>Edit</button>";
            echo "<button type='button' id='deleteTransactionBtn' class='btn btn-danger w-100'>
                                        <i class='far fa-edit'></i>Delete</button>";

            echo "</td>";

        } else {
            echo "<tr>";
            echo "<td class='w-20'>";
            echo $row['transactionId'];
            echo "</td>";
            echo "<td class='w-20'>";
            echo $row['propertyName'];
            echo "</td>";
            echo "<td><i class='fas fa-building'></i>&nbsp;&nbsp;";
            echo $row['propertyType'];
            echo "</td>";
            echo "<td>";
            echo $row['offertype'];
            echo "</td>";
            if ($row['propertyType'] === "Condominium") {
                echo "<td>";
                echo $row['unitNo'];
                echo "</td>";

            } else {
                echo "<td>";
                echo "None";
                echo "</td>";

            }
            echo "<td>₱&nbsp;&nbsp;";
            echo $row['TCP'];
            echo "</td>";
            echo "<td>";
            echo $row['termsOfPayment'];
            echo "</td>";
            echo "<td>";
            echo $row['address'];
            echo "</td>";
            echo "<td>";
            echo $row['status'];
            echo "</td>";
            echo "<td>";
            echo $row['dateOfTransaction'];
            echo "</td>";
            //display no date of reservation if not Preselling
            echo "<td>";
            echo "None";
            echo "</td>";

            echo "<td>₱&nbsp;&nbsp;";
            echo $row['finalTCP'];
            echo "</td>";
            echo "<td>";
            echo $row['commission'];
            echo "</td>";

            echo "<td>₱&nbsp;&nbsp;";
            echo $row['receivable'];
            echo "</td>";

            echo "<td>";
            echo $row['commissionAgent'];
            echo "</td>";

            echo "<td>";
            echo $row['commissionAR'];
            echo "</td>";

            echo "<td>";
            echo $row['commissionBuyer'];
            echo "</td>";
            echo "<td>₱&nbsp;&nbsp;";
            echo $row['receivable2'];
            echo "</td>";
            echo "<td>";
            echo "<button type='button' id='editTransactionBtn' class='btn btn-secondary w-100'>
                                        <i class='far fa-edit'></i>Edit</button>";
            echo "<button type='button' id='deleteTransactionBtn' class='btn btn-danger w-100'>
                                        <i class='far fa-edit'></i>Delete</button>";

            echo "</td>";

        }

    }
}
?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Propery Name</th>
                        <th>Property Type</th>
                        <th>Category</th>
                        <th>Unit No</th>
                        <th>TCP</th>
                        <th>Terms Of Payment</th>
                        <th>Buyer Name</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Date of Transaction</th>
                        <th>Date of Reservation</th>
                        <th>Final TCP</th>
                        <th>Commission</th>
                        <th>Receivable</th>
                        <th>Agent`s Commission</th>
                        <th>AR`s Commision</th>
                        <th>Final Receivable</th>
                        <th class='notexport'>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

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

<script src="js/adminTransactions.js"></script>
<script>
</script>
</body>

</html>