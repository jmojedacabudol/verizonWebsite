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



<!--Edit transaction Modal -->

<div class="modal fade bd-example-modal" id="editTransaction" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title textToGreen">Edit Transaction</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id='editTransactionForm' method="post">
                    <span id="eTransactionAlert" class="center"></span>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Name</label>
                        <div class="col-8">
                            <select class="form-control" onchange="ePropertyNameBehavior(this.value)"
                                id="eAllPropertyHolder" name="eAgentProperties" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Type</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Property Type *"
                                name="ePropertyType" id="ePropertyType" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Sub Category</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Sub Category*"
                                name="eSubcategory" id="eSubcategory" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Offer Type</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important"
                                placeholder="Property Offer Type *" name="ePropertyOfferType" id="ePropertyOfferType"
                                readonly />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Unit Number</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Unit No *"
                                name="eUnitNo" id="eUnitNo" readonly />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">TCP</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" onkeypress="return eIsNumberKey(event)"
                                    aria-label=" Amount (to the nearest peso)" id="ePropertyTcp" name="ePropertyTcp"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Property Address</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform important" placeholder="Address*"
                                name="ePropertyAddress" id="ePropertyAddress" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Terms of Payment</label>
                        <div class="col-8">
                            <select class="form-control transform" name="eTerms" id="eTerms">
                                <option value="default">Select Terms of Payment</option>
                                <option>Cash</option>
                                <option>In-house Financing</option>
                                <option>Bank Financing</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Client's Details</label>
                        <div class="col-1">
                            <button class="btn btn-primary" id="eAddClientBtn" type="button" data-toggle="tooltip"
                                data-placement="top" title="Add Client" onclick="addClientInfo()">+</button>
                        </div>
                        <div class="col-6" id="eClientHolders">
                            <div class="row">
                                <div id="eClient0" class="col-4"></div>
                                <div id="eClient1" class="col-4"></div>
                            </div>
                            <br>
                            <p id="eAddClientNote" class="hidden">Click the image/s above to add/change your Client
                                Information</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Status</label>
                        <div class="col-8">
                            <select class="form-control transform" name="eStatus" id="eStatus">
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
                                name="eTransactionDate" id=eTransactionDate />
                        </div>
                    </div>

                    <div class="form-group row hidden" id="eDateOf">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Date of
                            Reservation</label>
                        <div class="col-8">
                            <input type="date" class="form-control" placeholder="Date of sale*" id="eSaleDate"
                                name="eSaleDate" />
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
                                    aria-label=" Amount (to the nearest peso)" onblur="eCalculateReceivable()"
                                    name="eFinalTcp" id="eFinalTcp" placeholder="Final TCP *"
                                    onkeypress="return isNumberKey(event)" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control transform" onkeyup="eCalculateReceivable()"
                                    onchange="calculateReceivable()" placeholder="Commission *" name="eCommission"
                                    id="eCommission" min="1" step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="eReceivableHolder">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Receivable</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" id="eReceivable" placeholder="Receivable *"
                                    onkeypress="return isNumberKey(event)" name="eReceivable"
                                    onkeyup="eCalculateFinalReceivable()" />

                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="eAgentCommissionHolder">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Agent's Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control" id="eAgentCommission"
                                    placeholder="Agents Commission*" name="eAgentCommission"
                                    onchange="eCalculateFinalReceivable()" onkeyup="eCalculateFinalReceivable()" min="1"
                                    step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="eARCommissionHolder">
                        <label for="ar-commission" class="col-4 col-form-label">AR Verizon Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control " id="eArCommission"
                                    placeholder="AR Verizon Commission*" name="eArCommission" min="1" step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="eBuyersCommissionHolder">
                        <label for="buyers-commision" class="col-4 col-form-label">Buyer`s Commission</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="number" class="form-control " id="eBuyersCommssion"
                                    placeholder="Buyer's Commission*" name="eBuyersCommssion" min="1" step="0.1" />
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="eFinalTcpHolder">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Final Receivable (Agent)</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" class="form-control" onkeypress="return eIsNumberKey(event)"
                                    aria-label=" Amount (to the nearest peso)" name="eFinalReceivable"
                                    id="eFinalReceivable" placeholder="Final Receivable *">

                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="eSubmit" id="eTransactionSubmit">Add</button>
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
                <h5 class="modal-title textToGreen" id="exampleModalLabel">Add Client Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='addClientForm' method="post">
                    <span id='addClientAlert' class="center"></span>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Client`s Name</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control transform" aria-label="first-name" name="fName"
                                    id="fName" title="First name should only contain letters. e.g. Juan"
                                    placeholder="First Name *" onkeypress="return allowOnlyLetters(event);">
                                <input type=" text" class="form-control transform" aria-label="middle-name" name="mName"
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

                            <div class="input-group select-group w-100">
                                <input type="text" class="form-control input-group-addon"
                                    onkeypress="return isNumberKey(event)" aria-label="landline-number"
                                    name="clientLocalLandlineNumber" id="clientLocalLandlineNumber"
                                    placeholder="Local Number *" maxlength="3" />
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                    aria-label="landline-number" name="clientLandlineNumber" id="clientLandlineNumber"
                                    placeholder="Landline Number *" maxlength="8" />
                            </div>
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
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widow">Widow</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        <small class="text-muted">Documents</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Upload 2 images of your
                            valid Ids
                            (Permanent and
                            Secondary) </label>
                        <div class="col-8">

                            <div class="row">
                                <div class="col-6">
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="firstValidId"
                                        alt="Select 1st Valid Id" title="First Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="firstValidIdHolder" id="firstValidIdHolder" class="hidden"
                                        accept=".jpg, .jpeg, .png" />
                                </div>
                                <div class=col-6>
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="secondValidId"
                                        alt="Select 2nd Valid Id" title="Second Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="secondValidIdHolder" id="secondValidIdHolder"
                                        class="hidden" accept=".jpg, .jpeg, .png" />
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
                        <label for="allPropertyHolder" class="col-4 col-form-label">Room/Floor/Unit No. &
                            Building
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                aria-label="Room/Floor/Unit No. & Building" name="clientRFUB" id="clientRFUB"
                                placeholder=" Room/Floor/Unit No. & Building *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">House/Lot & Block
                            No.
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
                                id="clientStreet" placeholder="Street *" onkeypress="return allowOnlyLetters(event);">
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
                            <select type="text" class="form-control" aria-label="barangay" name="clientBrgyAddress"
                                id="clientBrgyAddress" placeholder="Barangay *" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <select type="text" class="form-control" aria-label="mobile-number" name="clientCityAddress"
                                id="clientCityAddress" placeholder="City *" style="width: 100%">
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h3>
                        <small class="text-muted">Company Information</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Company
                            Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" placeholder="Company Name*"
                                name="companyName" id="companyName" onkeypress="return allowOnlyLetters(event);" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Room / Floor /
                            Unit No. &
                            Building
                            Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                aria-label="Room/Floor/Unit No. & Building" name="companyInitalAddress"
                                id="companyInitalAddress" placeholder=" Room/Floor/Unit No. & Building*">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                onkeypress="return allowOnlyLetters(event);" aria-label="Street" name="companyStreet"
                                id="companyStreet" placeholder="Street *">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <select type="text" class="form-control transform" aria-label="barangay"
                                name="companyBrgyAddress" id="companyBrgyAddress" placeholder="Barangay *"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <select type="text" class="form-control transform" aria-label="mobile-number"
                                name="companyCityAddress" id="companyCityAddress" placeholder="City *"
                                style="width: 100%">
                            </select>
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






<!-- Edit Client -->
<div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel "
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title textToGreen" id="exampleModalLabel">Edit Client Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='editClientForm' method="post" enctype='multipart/form-data'>
                    <span id='editClientAlert' class="center"></span>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Client`s Name</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control transform" aria-label="first-name" name="eFName"
                                    id="eFName" title="First name should only contain letters. e.g. Juan"
                                    placeholder="First Name *" onkeypress="return allowOnlyLetters(event);">
                                <input type=" text" class="form-control transform" aria-label="middle-name"
                                    name="eMName" id="eMName"
                                    title="Middle name should only contain letters. e.g. Mendoza"
                                    placeholder="Middle Name *" onkeypress="return allowOnlyLetters(event);">
                                <input type="text" class="form-control transform" aria-label="last-name" name="eLName"
                                    id="eLName" title="Last name should only contain letters. e.g. Dela Cruz"
                                    placeholder="Last Name *" onkeypress="return allowOnlyLetters(event);">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Mobile Number</label>
                        <div class="col-8">
                            <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                aria-label="mobile-number" name="eClientMobileNumber" id="eClientMobileNumber"
                                placeholder="Mobile Number *" maxlength="11">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Landline Number</label>
                        <div class="col-8">

                            <div class="input-group select-group w-100">
                                <input type="text" class="form-control input-group-addon"
                                    onkeypress="return isNumberKey(event)" aria-label="landline-number"
                                    name="eClientLocalLandlineNumber" id="eClientLocalLandlineNumber"
                                    placeholder="Local Number *" maxlength="3" />
                                <input type="text" class="form-control" onkeypress="return isNumberKey(event)"
                                    aria-label="landline-number" name="eClientLandlineNumber" id="eClientLandlineNumber"
                                    placeholder="Landline Number *" maxlength="8" />
                            </div>
                        </div>

                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Email Address</label>
                        <div class="col-8">
                            <input type="email" class="form-control" aria-label="email-address" name="eEmailAddress"
                                id="eEmailAddress" placeholder="email *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Birthdate</label>
                        <div class="col-8">
                            <input type="date" class="form-control" name="eBirthday" id="eBirthday" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-4 col-form-label">Gender</label>
                        <div class="col-8">
                            <select class="form-control transform" name="eGender" id="eGender">
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
                                name="eClientAge" id="eClientAge" onkeypress="return isNumberKey(event)"
                                maxlength="2" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-4 col-form-label">Civil Status</label>
                        <div class="col-8">
                            <select class="form-control transform" name="eCivilStatus" id="eCivilStatus">
                                <option value="default" hidden>Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Widow">Widow</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h3>
                        <small class="text-muted">Documents</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Upload 2 images of your valid
                            Ids
                            (Permanent and
                            Secondary) </label>
                        <div class="col-8">

                            <div class="row">
                                <div class="col-6">
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="eFirstValidId"
                                        alt="Select 1st Valid Id" title="First Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="eFirstValidIdHolder" id="eFirstValidIdHolder"
                                        class="hidden" accept=".jpg, .jpeg, .png" />

                                </div>
                                <div class=col-6>
                                    <img class="addCursorPointer img-thumbnail img-fluid" id="eSecondValidId"
                                        alt="Select 2nd Valid Id" title="Second Valid Id" src="assets/img/user.png" />
                                    <br>
                                    <input type="file" name="eSecondValidIdHolder" id="eSecondValidIdHolder"
                                        class="hidden" accept=".jpg, .jpeg, .png" />
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
                                aria-label="Room/Floor/Unit No. & Building" name="eClientRFUB" id="eClientRFUB"
                                placeholder=" Room/Floor/Unit No. & Building *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">House/Lot & Block No.
                        </label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" aria-label="House/Lot & Block No."
                                name="eClientHLB" id="eClientHLB" placeholder="House/Lot & Block No. *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Street" name="eClientStreet"
                                id="eClientStreet" placeholder="Street *" onkeypress="return allowOnlyLetters(event);">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Subdivision</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Subdivision" name="eSubdivision"
                                id="eSubdivision" placeholder="Subdivision *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <select type="text" class="form-control" aria-label="barangay" name="eClientBrgyAddress"
                                id="eClientBrgyAddress" placeholder="Barangay *" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <select type="text" class="form-control" aria-label="mobile-number"
                                name="eClientCityAddress" id="eClientCityAddress" placeholder="City *"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>

                    <hr>
                    <h3>
                        <small class="text-muted">Company Information</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Company Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" placeholder="Company Name*"
                                name="eCompanyName" id="eCompanyName" onkeypress="return allowOnlyLetters(event);" />
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Room / Floor / Unit
                            No. &
                            Building
                            Name</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                aria-label="Room/Floor/Unit No. & Building" name="eCompanyInitalAddress"
                                id="eCompanyInitalAddress" placeholder=" Room/Floor/Unit No. & Building*">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform"
                                onkeypress="return allowOnlyLetters(event);" aria-label="Street" name="eCompanyStreet"
                                id="eCompanyStreet" placeholder="Street *">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <select type="text" class="form-control transform" aria-label="barangay"
                                name="eCompanyBrgyAddress" id="eCompanyBrgyAddress" placeholder="Barangay *"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <select type="text" class="form-control transform" aria-label="company-Address"
                                name="eCompanyCityAddress" id="eCompanyCityAddress" placeholder="City *"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>

                    <hr>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Edit Client</button>
            </div>

            </form>
        </div>
    </div>
</div>




<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Select2 Plugin -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Datatables plugins -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<!-- Numeral Plugin -->
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<!-- Moment Plugin -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.js"></script>
<script src="js/functions.js?v=1.2"></script>
<script src="js/adminTransactions.js?v=1.2"></script>
<script>
</script>
</body>

</html>