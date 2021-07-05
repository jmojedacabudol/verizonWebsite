<?php
require_once 'admin-header.php';

?>

<div class="main">
    <div class="card">
        <h5 class="card-header textToGreen">Properties</h5>
        <div class="card-body">


            <table id="properties" class="display table-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>Property Id</th>
                        <th>Property Name</th>
                        <th>Location</th>
                        <th>Lot Area</th>
                        <th>Floor Area</th>
                        <th>Property type</th>
                        <th>Sub Category</th>
                        <th>Offer Type</th>
                        <th>Price</th>
                        <th>Agent</th>
                        <th>Status</th>
                        <th class='notexport'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sql = "SELECT property.*,users.usersFirstName,users.userLastName,users.usersEmail FROM property,users WHERE property.approval !=3 AND property.usersId=users.usersId;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>";
        echo $row['propertyid'];
        echo "</td>";
        echo "<td>";
        echo $row['propertyname'];
        echo "</td>";
        echo "<td>";
        echo $row['barangay'] . "," . $row['city'];
        echo "</td>";

        echo "<td>";
        echo $row['propertylotarea'];
        echo "</td>";

        echo "<td>";
        echo $row['propertyfloorarea'];
        echo "</td>";
        echo "<td>";
        echo $row['propertytype'];
        echo "</td>";
        echo "<td>";
        echo $row['subcategory'];
        echo "</td>";
        echo "<td>";
        echo $row['offertype'];
        echo "</td>";
        echo "<td>₱&nbsp;&nbsp;";
        echo $row['propertyamount'];
        echo "</td>";

        echo "<td>";
        echo $row['usersFirstName'] . " " . $row['userLastName'];
        echo "</td>";

        // echo "<td>";
        // echo $row['approval'];
        // echo "</td>";

        if ($row['approval'] === "Pending") {
            echo "<td style='color:orange;'><i class='fas fa-clock'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";
        } else if ($row['approval'] === "Posted") {
            echo "<td style='color:green;'><i class='fas fa-check'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";
        } else if ($row['approval'] === "Deny") {
            echo "<td style='color:red;'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";
        } else if ($row['approval'] === "On-Going") {
            echo "<td style='color:green'><i class='fas fa-redo'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";

        } else if ($row['approval'] === "Closed") {
            echo "<td style='color:red'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";

        } else if ($row['approval'] === "Cancelled") {
            echo "<td style='color:red'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo $row['approval'];
            echo "</td>";

        }

        echo "<td>";
        echo " <button class='btn btn-success' id='approveBtn' type='text' aria-label='approve'><i
                                        class='far fa-check-circle'></i></button>";
        echo " <button class='btn btn-danger' id='denyBtn' type='text' aria-label='deny'><i
                                        class='far fa-times-circle'></i></button>";
        echo " <button class='btn btn-info' id='viewBtn' type='text' aria-label='view'><i
                                        class='far fa-eye'></i></button>";

        echo " <button class='btn btn-warning' id='editBtn' type='text' aria-label='view'><i class='far fa-edit'></i></button>";

        echo " <a class='btn btn-dark' type='text' aria-label='Email' href='mailto:";
        echo $row['usersEmail'] . "'" . "`;><i class='far fa-envelope'></i></a>";

        echo "</td>";
        echo "</tr>";
    }
}
?>

                </tbody>
                <tfoot>
                    <tr>
                        <th>Property Id</th>
                        <th>Property Name</th>
                        <th>Location</th>
                        <th>Lot Area</th>
                        <th>Floor Area</th>
                        <th>Property type</th>
                        <th>Sub Category</th>
                        <th>Offer Type</th>
                        <th>Price</th>
                        <th>Agent</th>
                        <th>Status</th>
                        <th class='notexport'>Action</th>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>


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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div id='propertyContainer'></div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id='property-title'></div>
                            <div id='property-info'> </div>
                        </div>

                    </div>
                </div>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" id='approvelisting' class="btn btn-success">Approve</button>
                <button type="button" id='denylisting' class="btn btn-danger">Deny</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Edit Property Modal -->
<div class="modal fade bd-example-modal" id="editPropertyModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title textToGreen">Edit Property Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="col-md-12">
                    <form id="epropertyForm" action="includes/insertpropertyedit.inc.php" method="post"
                        enctype='multipart/form-data'>
                        <span style="text-align:center;" id="ePropertyUploadAlert"></span>
                        <h3>
                            <small class="text-muted">Property Information</small>
                        </h3>


                        <div class="form-group row">
                            <label for="up-valid-id" class="col-4 col-form-label">Image</label>
                            <div class="col-8" id="ePropertyImgHolder">
                                <input type="file" name="eListingImage[]" id="eListingImg" multiple
                                    accept=".jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div id="propertyImgs">
                        </div>


                        <div class="form-group row">
                            <label for="listing-title" class="col-4 col-form-label">Listing
                                Title</label>
                            <div class="col-8">
                                <input id="eListingTitle" name="eListingTitle" placeholder="Listing Title *"
                                    class="form-control transform" type="text">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="listing-type" class="col-4 col-form-label">Property Type</label>
                            <div class="col-8">
                                <select id=eListingType name="eListingType" class="form-control"
                                    onchange="allVariations(this.value)">
                                    <option value="default" selected>Property Type</option>
                                    <option value="Building">Building</option>
                                    <option value="Condominium">Condominium</option>
                                    <option value="Lot">Lot</option>
                                    <option value="House and Lot">House and Lot</option>
                                    <option value="Office">Office</option>
                                    <option value="Warehouse">Warehouse</option>

                                </select>
                            </div>
                        </div>
                        <!-- Unit No -->

                        <div class="form-group row hidden" id="eUnitNoHolder">
                            <label for="listing-title" class="col-4 col-form-label">Unit No</label>
                            <div class="col-8">
                                <input id="eListingUnitNo" name="eListingUnitNo" placeholder="Unit No *"
                                    class="form-control here" type="text">
                            </div>
                        </div>


                        <!-- Sub category -->
                        <div class="form-group row hidden" id="eSubCategoryHolder">
                            <label for="listing-type" class="col-4 col-form-label">Sub Category</label>
                            <div class="col-8">
                                <select id='eListingSubCategory' name="eListingSubCategory" class="form-control">
                                    <option hidden value="default">Select Category</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
                            <div class="col-8" id="ePropertyOfferType">
                                <!-- <select name="eListingOfferType" class="form-control"
                                    onchange="priceVariations(this.value)" id="eListingOfferType">
                                    <option value="default" selected>Please select offer type first</option>
                                    <option value="Rent">Rent</option>
                                    <option value="Sell">Sell</option>
                                </select> -->
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label">Price</label>
                            <div class="col-8">
                                <div class="input-group w-100">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="text" id='eListingRentChoice' name="eListingRentChoice"
                                        style="display:none;" onchange='rentChoiceVariation(this.value)'>
                                    <input type="text" class="form-control CurrencyInput"
                                        onkeypress="return isNumberKey(event)" aria-label="Price" id="eListingPrice"
                                        name="eListingPrice">
                                    <div class="input-group-append hidden" id='eRentBtn'>
                                        <button class="btn btn-secondary" id="eDailyBtn"
                                            onclick="buttonVariations(this.id)" type="button">Daily</button>
                                        <button class="btn btn-secondary" id="eWeeklyBtn"
                                            onclick="buttonVariations(this.id)" type="button">Weekly</button>
                                        <button class="btn btn-secondary" id="eMonthlyBtn"
                                            onclick="buttonVariations(this.id)" type="button">Monthly</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="onlyNumbers1" class="col-4 col-form-label">Lot Area</label>
                            <div class="col-8">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control" aria-label="Lot Area" name="eListingLotArea"
                                        id="eListingLotArea" placeholder="Lot Area *" />

                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="eFloorAreaHolder">
                            <label for="onlyNumbers2" class="col-4 col-form-label">Floor Area</label>
                            <div class="col-8">
                                <div class="input-group w-100">
                                    <input type="text" class="form-control" aria-label="floor-area"
                                        name="eListingFloorArea" id="eListingFloorArea" placeholder="Floor Area *" />

                                </div>
                            </div>
                        </div>


                        <div class="form-group row" id="eNoOfBedroomsHolder">
                            <label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>
                            <div class="col-8">
                                <input type="text" class="form-control" aria-label="Bedrooms" name="eListingBedrooms"
                                    id="eListingBedrooms" placeholder="Bedrooms *" />
                            </div>
                        </div>

                        <div class="form-group row" id="eCapacityOfGarageHolder">
                            <label for="carpark" class="col-4 col-form-label">Capacity of Garage (No. of
                                Cars)</label>
                            <div class="col-8">
                                <input type="text" class="form-control" aria-label="listing-garage"
                                    name="eListingCapacityOfGarage" id="eListingCapacityOfGarage"
                                    placeholder="Capacity of Garage *" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="carpark" class="col-4 col-form-label">Description</label>
                            <div class="col-8">
                                <textarea class="form-control" style="height: 150px;" name='eListingDesc'
                                    id="eListingDesc" placeholder="Enter Description Here"></textarea>
                            </div>
                        </div>
                        <h3>
                            <small class="text-muted">Attachment</small>
                        </h3>

                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label">Authorization to Sell (ATS)
                            </label>
                            <div class="col-1">
                                <input type="file" name="eListingATS" id="eListingATS" class="hidden"
                                    accept=".jpg, .jpeg, .png, .pdf" onchange="ATSFile(this)">
                                <button class="btn btn-primary" id="eAddATSBtn" type="button" data-toggle="tooltip"
                                    data-placement="top" title="Add ATS"
                                    onclick="document.getElementById('eListingATS').click()">+</button>
                            </div>
                            <div class="col-6" id="eClientHolders">
                                <div class="row">
                                    <div id="eATSFile" class="col-4"></div>
                                    <div id="eATSDesc" class="col-8"></div>
                                </div>
                                <br>
                                <p id="eAddATSNote" class="hidden">Click the image above to "Change" your
                                    ATS uploaded.</p>
                            </div>
                        </div>
                        <br>
                        <br><br>
                        <h3>
                            <small class="text-muted">Complete Address</small>
                        </h3>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label">Room/Floor/Unit No. &
                                Building
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control transform"
                                    aria-label="Room/Floor/Unit No. & Building" name="eListingRFUB" id="eListingRFUB"
                                    placeholder=" Room/Floor/Unit No. & Building *">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label transform">House/Lot &
                                Block
                                No.
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control transform" aria-label="House/Lot & Block No."
                                    name="eListingHLB" id="eListingHLB" placeholder="House/Lot & Block No. *">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                            <div class="col-8">
                                <input type="text" class="form-control transform" aria-label="Street"
                                    name="eListingStreet" id="eListingStreet" placeholder="Street *"
                                    onkeypress="return allowOnlyLetters(event);">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label transform">Subdivision</label>
                            <div class="col-8">
                                <input type="text" class="form-control transform" aria-label="Subdivision"
                                    name="eListingSubdivision" id="eListingSubdivision"
                                    onkeypress="return allowOnlyLetters(event);" placeholder="Subdivision *">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                            <div class="col-8">
                                <select type="text" class="form-control" aria-label="barangay"
                                    name="eListingBrgyAddress" id="eListingBrgyAddress" placeholder="Barangay *"
                                    style="width: 100%">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                            <div class="col-8">
                                <select type="text" class="form-control" aria-label="mobile-number"
                                    name="eListingCityAddress" id="eListingCityAddress" placeholder="City *"
                                    style="width: 100%">
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="submit" id="eListing-submit">Save</button>
            </div>

            </form>
        </div>
    </div>
</div>






<!-- Bootstrap core JS-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<!-- Numeral Plugin -->
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<!-- Select2 Plugin -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="js/adminProperty.js"></script>
<script src="js/imageLoading.js"></script>



</body>

</html>