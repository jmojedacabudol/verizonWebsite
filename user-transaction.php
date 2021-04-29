<?php
require 'header.php'
?>
<?php
require 'sidenav.php'
?>
<div class="main">
    <section id="ViewList">
        <div class="card container-fluid">
            <div class="card-body">
                <h5 class="card-title">Your Transaction/s</h5>
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <table id="transaction" class="display table-responsive" style="width:100%">
                            <thead>
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
                                    <th>Contact Info</th>
                                    <th>Status</th>
                                    <th>Date of Transaction</th>
                                    <th>Final TCP</th>
                                    <th>Commission</th>
                                    <th>Receivable</th>
                                    <th>Agent`s Commission</th>
                                    <th>AR`s Commision</th>
                                    <th>Buyer`s Commission</th>
                                    <th>Final Receivable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql = "SELECT * FROM transactions WHERE agentId=?;";
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
        echo $row['propertyid'];
        echo "</td>";
        echo "<td class='w-20'>";
        echo $row['propertyname'];
        echo "</td>";
        echo "<td><i class='fas fa-building'></i>&nbsp;&nbsp;";
        echo $row['propertytype'];
        echo "</td>";
        echo "<td><i class='fas fa-flag'></i>&nbsp;&nbsp;";
        echo $row['offertype'];
        echo "</td>";
        echo "<td><i class='fas fa-map-marker-alt'></i>&nbsp;&nbsp;";
        echo $row['propertylocation'];
        echo "</td>";
        echo "<td>₱&nbsp;&nbsp;";
        echo number_format((int) $row['propertyamount']);
        echo "</td>";
        if ($row['approval'] === 0) {
            echo "<td style='color:orange;'><i class='fas fa-clock'></i>&nbsp;&nbsp;";
            echo "Pending";
            echo "</td>";
        } else if ($row['approval'] === 1) {
            echo "<td style='color:green;'><i class='fas fa-check'></i>&nbsp;&nbsp;";
            echo "Posted";
            echo "</td>";
        } else if ($row['approval'] === 2) {
            echo "<td style='color:red;'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo "Denied";
            echo "</td>";
        }

        echo "<td>";
        echo "<button type='button' id='editProperty' class='btn btn-secondary w-50'>
                                        <i class='far fa-edit'></i>Edit</button>";
        echo "<button type='button' id='viewProperty' class='btn btn-info w-50'>
                                        <i class='far fa-edit'></i>View</button>";

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



<br>
<br>
<br>





<!--Add Property List Modal -->

<div class="modal fade bd-example-modal" id="addTransaction" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" id="allPropertyHolder" name="agentProperties" style="width: 100%">
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Property Type *"
                        name="property-type" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Unit No *" name="unit-no" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="TCP *" name="tcp" />
                    <br>
                </div>
                <div class="form-group">
                    <select class="form-control transform" name="terms">
                        <option>Select Terms of Payment</option>
                        <option>Cash</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control transform" id="buyersName" name="buyersName" style="width: 100%">
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Address*" name="Address" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Contact Info" name="contact-info" />
                    <br>
                </div>
                <div class="form-group">
                    <select class="form-control transform" name="status">
                        <option>Select Status</option>
                        <option>Posted</option>
                        <option>On-Going</option>
                        <option>Closed</option>
                        <option>Cancelled</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" placeholder="Date of trasaction*" name="transaction-date" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Final TCP*" name="final-Tcp" />
                    <br>
                </div>

                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Commission *" name="commission" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Receivable *" name="receivable" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Agents Commission*"
                        name="agents-commission" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="AR Verizon Commission*"
                        name="ar-commission" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Buyer's Commission*"
                        name="buyers-commision" />
                    <br>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control transform" placeholder="Final Receivable*"
                        name="final-receivable" />
                    <br>
                </div>



            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" name="submit" id="listing-submit">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

            </div>
            </form>
        </div>
    </div>
</div>
</div>



<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="assets/mail/contact_me.js"></script>
<!-- Core theme JS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Select2 Plugin -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/imageLoading.js"></script>
<script src="js/dashboard-listing.js"></script>
<script src="js/dashboard-transaction.js"></script>
<script src="js/propertyupload.js"></script>

<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

</body>

</html>