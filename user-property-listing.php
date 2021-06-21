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
                <h5 class="card-title textToGreen">Your Property Listing</h5>
                <!-- <input type="text" id="column3_search"> -->
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <table id="properties" class="display table-responsive">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Property Name</th>
                                    <th>Type</th>
                                    <th>Offer Type</th>
                                    <th>Location</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class='notexport'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
$sql = "SELECT * FROM property WHERE usersId=?;";
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
        echo $row['barangay'] . "," . $row['city'];
        echo "</td>";
        echo "<td>₱&nbsp;&nbsp;";
        echo $row['propertyamount'];
        echo "</td>";
        if ($row['approval'] === "Pending") {
            echo "<td style='color:orange;'><i class='fas fa-clock'></i>&nbsp;&nbsp;";
            echo "Pending";
            echo "</td>";
        } else if ($row['approval'] === "Posted") {
            echo "<td style='color:green;'><i class='fas fa-check'></i>&nbsp;&nbsp;";
            echo "Posted";
            echo "</td>";
        } else if ($row['approval'] === "Deny") {
            echo "<td style='color:red;'><i class='fas fa-window-close'></i>&nbsp;&nbsp;";
            echo "Denied";
            echo "</td>";
        }

        echo "<td>";
        echo "<button type='button' id='editProperty' class='btn btn-secondary w-50' data-toggle='tooltip' data-placement='bottom' title='Edit Property'>
                                        <i class='far fa-edit'></i>Edit</button>";
        echo "<button type='button' id='viewProperty' class='btn btn-info w-50' data-toggle='tooltip' data-placement='bottom' title='View Property'>
                                        <i class='far fa-eye'></i>View</button>";

        echo "</td>";

    }
}
?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Property Name</th>
                                    <th>Type</th>
                                    <th>Offer Type</th>
                                    <th>Location</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th class='notexport'>Action</th>
                                </tr>
                            </tfoot>
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
<div class="modal fade bd-example-modal" id="AddPropertyList" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title textToGreen">Add New Property Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <form id="propertyForm" action="includes/propertyupload.inc.php" method="post"
                            enctype='multipart/form-data'>
                            <span style="text-align:center;" id="propertyUploadAlert"></span>
                    </div>
                    <h3>
                        <small class="text-muted">Property Information</small>
                    </h3>


                    <div class="form-group row">
                        <label for="up-valid-id" class="col-4 col-form-label">Image</label>
                        <div class="col-8" id="propertyImgHolder">
                            <input type="file" name="listingImage[]" id="listingImg" multiple
                                accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="listing-title" class="col-4 col-form-label">Listing
                            Title</label>
                        <div class="col-8">
                            <input id="listingTitle" name="listingTitle" placeholder="Listing Title *"
                                class="form-control transform" type="text">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="listing-type" class="col-4 col-form-label">Property Type</label>
                        <div class="col-8">
                            <select id=listingType name="listingType" class="form-control"
                                onchange="allVariation(this.value)">
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

                    <div class="form-group row hidden" id="unitNoHolder">
                        <label for="listing-title" class="col-4 col-form-label">Unit No</label>
                        <div class="col-8">
                            <input id="listingUnitNo" name="listingUnitNo" placeholder="Unit No *"
                                class="form-control here" type="text">
                        </div>
                    </div>


                    <!-- Sub category -->
                    <div class="form-group row hidden" id="subCategoryHolder">
                        <label for="listing-type" class="col-4 col-form-label">Sub Category</label>
                        <div class="col-8">
                            <select id='listingSubCategory' name="listingSubCategory" class="form-control">
                                <option hidden value="default">Select Category</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
                        <div class="col-8">
                            <select name="listingOfferType" class="form-control" onchange="priceVariation(this.value)"
                                id="offerType">
                                <option value="default" selected>Complete the information above.</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Price</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">₱</span>
                                </div>
                                <input type="text" id='offerchoice' name="listingRentChoice" style="display:none;">
                                <input type="text" class="form-control CurrencyInput"
                                    onkeypress="return isNumberKey(event)" aria-label="Price" id="listingPrice"
                                    name="listingPrice">
                                <div class="input-group-append hidden" id='rentBtn'>
                                    <button class="btn btn-secondary" id="dailyBtn" type="button">Daily</button>
                                    <button class="btn btn-secondary" id="weeklyBtn" type="button">Weekly</button>
                                    <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="onlyNumbers1" class="col-4 col-form-label">Lot Area</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" aria-label="Lot Area" name="listingLotArea"
                                    id="listingLotArea" placeholder="Lot Area *" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="floorAreaHolder">
                        <label for="onlyNumbers2" class="col-4 col-form-label">Floor Area</label>
                        <div class="col-8">
                            <div class="input-group w-100">
                                <input type="text" class="form-control" aria-label="floor-area" name="listingFloorArea"
                                    id="listingFloorArea" placeholder="Floor Area *" />
                            </div>
                        </div>
                    </div>


                    <div class="form-group row" id="noOfBedroomsHolder">
                        <label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="Bedrooms" name="listingBedrooms"
                                id="listingBedrooms" placeholder="Bedrooms *" />
                        </div>
                    </div>

                    <div class="form-group row" id="capacityOfGarageHolder">
                        <label for="carpark" class="col-4 col-form-label">Capacity of Garage (No. of
                            Cars)</label>
                        <div class="col-8">
                            <input type="text" class="form-control" aria-label="listing-garage"
                                name="listingCapacityOfGarage" id="listingCapacityOfGarage"
                                placeholder="Capacity of Garage *" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="carpark" class="col-4 col-form-label">Description</label>
                        <div class="col-8">
                            <textarea class="form-control" style="height: 150px;" name='listingDesc' id="listingDesc"
                                placeholder="Enter Description Here"></textarea>
                        </div>
                    </div>
                    <h3>
                        <small class="text-muted">Attachment</small>
                    </h3>

                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Authorization to Sell (ATS)
                        </label>
                        <div class="col-1">
                            <input type="file" name="listingATS" id="listingATS" class="hidden"
                                accept=".jpg, .jpeg, .png, .pdf">
                            <button class="btn btn-primary" id="addATSBtn" type="button" data-toggle="tooltip"
                                data-placement="top" title="Add ATS">+</button>
                        </div>
                        <div class="col-6" id="clientHolders">
                            <div class="row">
                                <div id="ATSFile" class="col-4"></div>
                                <div id="ATSDesc" class="col-8"></div>
                            </div>
                            <br>
                            <p id="addATSNote" class="hidden">Click the image above to "Change" your
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
                                aria-label="Room/Floor/Unit No. & Building" name="listingRFUB" id="listingRFUB"
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
                                name="listingHLB" id="listingHLB" placeholder="House/Lot & Block No. *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" aria-label="Street" name="listingStreet"
                                id="listingStreet" placeholder="Street *" onkeypress="return allowOnlyLetters(event);">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label transform">Subdivision</label>
                        <div class="col-8">
                            <input type="text" class="form-control transform" aria-label="Subdivision"
                                name="listingSubdivision" id="subdivision" onkeypress="return allowOnlyLetters(event);"
                                placeholder="Subdivision *">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
                        <div class="col-8">
                            <select type="text" class="form-control" aria-label="barangay" name="listingBrgyAddress"
                                id="listingBrgyAddress" placeholder="Barangay *" style="width: 100%">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
                        <div class="col-8">
                            <select type="text" class="form-control" aria-label="mobile-number"
                                name="listingCityAddress" id="listingCityAddress" placeholder="City *"
                                style="width: 100%">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="submit" id="listing-submit">Add
                    Property</button>
            </div>
            <br>
            </form>
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
                <button type="submit" class="btn btn-primary" name="submit" id="eListing-submit">Save
                    Changes</button>
            </div>

            </form>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>









<!-- Bootstrap core JS-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="assets/mail/contact_me.js"></script>
<!-- Core theme JS-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="js/scripts.js"></script>


<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>
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

<script src="js/imageLoading.js"></script>
<script src="js/dashboard-listing.js"></script>
<script src="js/propertyupload.js"></script>


</body>

</html>