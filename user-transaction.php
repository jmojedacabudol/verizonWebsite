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
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!--Add transaction Modal -->

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
                <form id='addTransactionForm' method="post">
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Name</label>
                        <div class="col-8">
                            <select class="form-control" id="allPropertyHolder" name="agentProperties"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Type</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Property Type *"
                                name="property-type" id="propertyType" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Offer Type</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important"
                                placeholder="Property Offer Type *" name="property-offer-type" id="offertType"
                                readonly />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Unit Number</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Unit No *"
                                name="unit-no" id="unitNo" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">TCP</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                    aria-label=" Amount (to the nearest peso)" id="propertyTcp" name="tcp" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Address</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Address*"
                                name="Address" id="propertyAddress" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Terms of Payment</label>
                        <div class="col-8">
                            <select class="form-control transform" name="terms">
                                <option value="default">Select Terms of Payment</option>
                                <option>Cash</option>
                                <option>In-house Financing</option>
                                <option>Bank Financing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Client's Details</label>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-4">
                                    <button class="btn btn-primary" id="addClientBtn" type="button"
                                        onclick="addClientInfo()">+</button>
                                </div>
                                <div id="client0" class="col-4"></div>
                                <div id="client1" class="col-4"></div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Status</label>
                        <div class="col-8">
                            <select class="form-control transform" name="status" id="status">
                                <option value="default">Select Status</option>
                                <option value="Posted">Posted</option>
                                <option value="On-Going">On-Going</option>
                                <option value="Closed">Closed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Transaction Date</label>
                        <div class="col-8">
                            <input type="date" class="form-control" placeholder="Date of trasaction*"
                                name="transaction-date" />
                        </div>
                    </div>

                    <div class="form-group row hidden" id="dateOf">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Date of
                            Reservation</label>
                        <div class="col-8">
                            <input type="date" class="form-control" placeholder="Date of sale*" name="sale-date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Final TCP</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control CurrencyInput"
                                    aria-label=" Amount (to the nearest peso)" onblur="calculateReceivable()"
                                    name="finalTcp" id="finalTcp" placeholder="Final TCP *"
                                    onkeypress="return isNumberKey(event)" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control transform" onkeyup="calculateReceivable()"
                                    onchange="calculateReceivable()" placeholder="Commission *" name="commission"
                                    id="commission" min="1" step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Receivable</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" id="receivable" placeholder="Receivable *"
                                    onkeypress="return isNumberKey(event)" name="receivable"
                                    onkeyup="calculateFinalReceivable()" />

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Agent's Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control" id="agentCommission"
                                    placeholder="Agents Commission*" name="agents-commission"
                                    onchange="calculateFinalReceivable()" onkeyup="calculateFinalReceivable()" min="1"
                                    step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="ar-commission" class="col-4 col-form-label">AR Verizon Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control " id="arCommission"
                                    placeholder="AR Verizon Commission*" name="ar-commission"
                                    onkeypress="return isFloatKey(event)" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="buyers-commision" class="col-4 col-form-label">Buyer`s Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control " id="buyersCommssion"
                                    placeholder="Buyer's Commission*" name="buyers-commision"
                                    onkeypress="return isFloatKey(event)" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Final Receivable (Agent)</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                    aria-label=" Amount (to the nearest peso)" name="final-receivable"
                                    id="finalReceivable" placeholder="Final Receivable *">

                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="submit" id="listing-submit">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>






<!-- Add Client -->
<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Client Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='addClientForm' method="post">
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Client`s Name</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control transform" aria-label="first-name" name="fName"
                                    id="fName" title="First name should only contain letters. e.g. Juan"
                                    placeholder="First Name *" onkeypress="return allowOnlyLetters(event);">
                                <input type="text" class="form-control transform" aria-label="middle-name" name="mName"
                                    id="mName" title="Middle name should only contain letters. e.g. Mendoza"
                                    placeholder="Middle Name *" onkeypress="return allowOnlyLetters(event);">
                                <input type="text" class="form-control transform" aria-label="last-name" name="lName"
                                    id="lName" title="Last name should only contain letters. e.g. Dela Cruz"
                                    placeholder="Last Name *" onkeypress="return allowOnlyLetters(event);">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Mobile Number</label>
                        <div class="col-8">
                            <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                aria-label="mobile-number" name="clientMobileNumber" id="clientMobileNumber"
                                placeholder="Mobile Number *" maxlength="11">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Landline Number</label>
                        <div class="col-8">
                            <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                aria-label="landline-number" name="clientLandlineNumber" id="clientLandlineNumber"
                                placeholder="Landline Number *" maxlength="10">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Email Address</label>
                        <div class="col-8">
                            <input type="email" class="form-control" aria-label="email-address" name="emailAddress"
                                id="emailAddress" placeholder="email *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Birthdate</label>
                        <div class="col-8">
                            <input type="date" class="form-control" name="birthday" id="birthday" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-4 col-form-label">Gender</label>
                        <div class="col-8">
                            <select class="form-control transform" name="gender" id="gender">
                                <option value="default" hidden>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Femail">Female</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Age</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Age*"
                                name="clientAge" id="clientAge" onkeypress="return isNumberKey(event)" maxlength="2" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-4 col-form-label">Civil Status</label>
                        <div class="col-8">
                            <select class="form-control transform" name="civilStatus" id="civilStatus">
                                <option value="default" hidden>Select Civil Status</option>
                                <option value="Male">Single</option>
                                <option value="Femail">Married</option>
                                <option value="Femail">Window</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        <small class="text-muted">Documents</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Upload 2 images of your valid Ids
                            (Permanent and
                            Secondary) </label>
                        <div class="col-8">

                            <div class="row">
                                <div class="col-6">
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="firstValidId"
                                        alt="Select 1st Valid Id" title="First Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="firstValidIdHolder" id="firstValidIdHolder"
                                        class="hidden" />
                                </div>
                                <div class=col-6>
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="secondValidId"
                                        alt="Select 2nd Valid Id" title="Second Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="secondValidIdHolder" id="secondValidIdHolder"
                                        class="hidden" />
                                </div>
                            </div>
                            <br>
                            <p>Click the images above to add/change your Valid Id Image</p>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        <small class="text-muted">Complete Address</small>
                    </h3>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Room/Floor/Unit No. & Building
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                aria-label="Room/Floor/Unit No. & Building" name="clientRFUB" id="clientRFUB"
                                placeholder=" Room/Floor/Unit No. & Building *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">House/Lot & Block No.
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" aria-label="House/Lot & Block No."
                                name="clientHLB" id="clientHLB" placeholder="House/Lot & Block No. *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Street" name="clientStreet"
                                id="clientStreet" placeholder="Street *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Subdivision</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Subdivision" name="subdivision"
                                id="subdivision" placeholder="Subdivision *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="barangay" name="clientBrgyAddress"
                                id="clientBrgyAddress" placeholder="Barangay *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="mobile-number" name="clientCityAddress"
                                id="clientCityAddress" placeholder="City *">
                        </div>
                    </div>

                    <hr>
                    <h3>
                        <small class="text-muted">Company Information</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Company Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Company Name*"
                                name="companyName" id="companyName" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Room / Floor / Unit No. &
                            Building
                            Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Room/Floor/Unit No. & Building"
                                name="companyInitalAddress" id="companyInitalAddress"
                                placeholder=" Room/Floor/Unit No. & Building*">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Street" name="companyStreet"
                                id="companyStreet" placeholder="Street *">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="barangay" name="companyBrgyAddress"
                                id="companyBrgyAddress" placeholder="Barangay *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="mobile-number" name="companyCityAddress"
                                id="companyCityAddress" placeholder="City *">
                        </div>
                    </div>

                    <hr>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Client</button>
            </div>

            </form>
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
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script src="js/imageLoading.js"></script>
<script src="js/dashboard-listing.js"></script>
<script src="js/dashboard-transaction.js"></script>
<script src="js/propertyupload.js"></script>
</body>

</html>