<?php
if (isset($_POST['propertyId'])) {

    require_once 'dbh.inc.php';
    $propertyId = $_POST['propertyId'];
    $data = array();

    $sql = "SELECT * FROM property WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //get property informations

            $data[] = array("propertyname" => $row['propertyname'], "unitNo" => $row['unitNo'], "offertype" => $row['offertype'], "propertytype" => $row['propertytype'], "subcategory" => $row['subcategory'], "propertylotarea" => $row['propertylotarea'], "propertyfloorarea" => $row['propertyfloorarea'], "propertybedrooms" => $row['propertybedrooms'], "propertycarpark" => $row['propertycarpark'], "propertyamount" => $row['propertyamount'], "propertydesc" => $row['propertydesc'], "ATSFile" => $row['ATSFile'], "RoomFloorUnitNoBuilding" => $row['RoomFloorUnitNoBuilding'], "HouseLotBlockNo" => $row['HouseLotBlockNo'], "street" => $row['street'], "subdivision" => $row['subdivision'], "barangay" => $row['barangay'], "city" => $row['city'], "propertyrentchoice" => $row['propertyrentchoice']);

        }
        echo json_encode($data);
    } else {
        echo "No Data Found!";
    }
} else {
    echo "No Property Found!";
}

// echo '<h3><small class="text-muted">Property Information</small></h3>';

// echo '<div class="form-group row">
//       <label for="up-valid-id" class="col-4 col-form-label">Image</label>
//             <div class="col-8" id="propertyImgHolder">
//                 <input type="file" name="elistingImage[]" id="elistingImg" multiple
//                     accept=".jpg, .jpeg, .png">
//             </div>
//         </div>';
// echo '<div id="propertyImgs">';
// echo '</div>';

// echo '<div class="form-group row">
//             <label for="listing-title" class="col-4 col-form-label">Listing
//                 Title</label>
//             <div class="col-8">
//                 <input id="elistingTitle" name="elistingTitle" placeholder="Listing Title *"
//                     class="form-control transform" type="text" value="' . $row['propertyname'] . '">
//             </div>
//         </div>';

// if ($row['propertytype'] === "Building") {

//     echo '<div class="form-group row">
// <label for="listing-type" class="col-4 col-form-label">Property Type</label>
//             <div class="col-8">
//                 <select id=elistingType name="elistingType" class="form-control"
//                     onchange="allVariation(this.value)">
//                     <option value="default">Property Type</option>
//                     <option value="Building" selected>Building</option>
//                     <option value="Condominium">Condominium</option>
//                     <option value="Lot">Lot</option>
//                     <option value="House and Lot">House and Lot</option>
//                     <option value="Office">Office</option>
//                     <option value="Warehouse">Warehouse</option>

//                 </select>
//             </div>
//         </div>';

//     echo ' <!-- Unit No -->
//         <div class="form-group row hidden" id="unitNoHolder">
//             <label for="listing-title" class="col-4 col-form-label">Unit No</label>
//             <div class="col-8">
//                 <input id="elistingUnitNo" name="elistingUnitNo" placeholder="Unit No *"
//                     class="form-control here" type="text">
//             </div>
//         </div>';

//     echo '
//         <!-- Sub category -->
//         <div class="form-group row" id="subCategoryHolder">
//             <label for="listing-type" class="col-4 col-form-label">Sub Category</label>
//             <div class="col-8">
//                 <select id="elistingSubCategory" name="elistingSubCategory" class="form-control">';

//     if ($row['subcategory'] === "Commercial") {
//         echo '      <option value="default">Select Sub Category</option>
//                     <option value="Commercial" selected>Commercial</option>
//                     <option value="Residential">Residential</option>';
//     } else if ($row['subcategory'] === "Residential") {
//         echo '      <option value="default">Select Sub Category</option>
//                     <option value="Commercial">Commercial</option>
//                     <option value="Residential"selected>Residential</option>';

//     }
//     echo '</select>
//             </div>
//         </div>';

//     if ($row['offertype'] === "Rent") {
//         echo '  <div class="form-group row">
//             <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
//             <div class="col-8">
//                 <select name="listingOfferType" class="form-control" onchange="priceVariation(this.value)"
//                     id="eofferType">
//                     <option value="default">Select Offer Type</option>
//                     <option value="Sell">Sell</option>
//                     <option value="Rent"selected>Rent</option>
//                     <option value="Presell">Presell</option>
//                 </select>
//             </div>
//         </div>';

//         echo '   <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Price</label>
//             <div class="col-8">
//                 <div class="input-group w-100">
//                     <div class="input-group-prepend">
//                         <span class="input-group-text">₱</span>
//                     </div>
//                     <input type="text" id="offerchoice" name="listingRentChoice" style="display:none;" value="' . $row['propertyrentchoice'] . '">
//                     <input type="text" class="form-control CurrencyInput"
//                         onkeypress="return isNumberKey(event)" aria-label="Price" id="listingPrice"
//                         name="listingPrice" value="' . $row['propertyamount'] . '">
//                     <div class="input-group-append" id="rentBtn">';

//         if ($row['propertyrentchoice'] === "Daily") {
//             echo '      <button class="btn btn-primary" id="dailyBtn" type="button">Daily</button>
//                         <button class="btn btn-secondary" id="weeklyBtn" type="button">Weekly</button>
//                         <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>';
//         } else if ($row['propertyrentchoice'] === "Weekly") {
//             echo '      <button class="btn btn-secondary" id="dailyBtn" type="button">Daily</button>
//                         <button class="btn btn-primary" id="weeklyBtn" type="button">Weekly</button>
//                         <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>';

//         }if ($row['propertyrentchoice'] === "Monthly") {
//             echo '      <button class="btn btn-secondary" id="dailyBtn" type="button">Daily</button>
//                         <button class="btn btn-primary" id="weeklyBtn" type="button">Weekly</button>
//                         <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>';
//         }

//         echo '</div>
//                 </div>
//             </div>
//         </div>';

//     } else if ($row['offertype'] === "Sell") {
//         echo '  <div class="form-group row">
//             <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
//             <div class="col-8">
//                 <select name="listingOfferType" class="form-control" onchange="priceVariation(this.value)"
//                     id="eofferType">
//                     <option value="default">Select Offer Type</option>
//                     <option value="Sell" selected>Sell</option>
//                     <option value="Rent">Rent</option>
//                      <option value="Presell">Presell</option>
//                 </select>
//             </div>
//         </div>';

//         echo '   <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Price</label>
//             <div class="col-8">
//                 <div class="input-group w-100">
//                     <div class="input-group-prepend">
//                         <span class="input-group-text">₱</span>
//                     </div>
//                     <input type="text" id="offerchoice" name="listingRentChoice" style="display:none;">
//                     <input type="text" class="form-control CurrencyInput"
//                         onkeypress="return isNumberKey(event)" aria-label="Price" id="listingPrice"
//                         name="listingPrice"  value="' . $row['propertyamount'] . '">
//                     <div class="input-group-append hidden" id="rentBtn">
//                         <button class="btn btn-secondary" id="dailyBtn" type="button">Daily</button>
//                         <button class="btn btn-secondary" id="weeklyBtn" type="button">Weekly</button>
//                         <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>
//                      </div>
//                 </div>
//             </div>
//         </div>';

//     } else if ($row['offertype'] === "Presell") {
//         echo '  <div class="form-group row">
//             <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
//             <div class="col-8">
//                 <select name="listingOfferType" class="form-control" onchange="priceVariation(this.value)"
//                     id="eofferType">
//                     <option value="default">Select Offer Type</option>
//                     <option value="Sell">Sell</option>
//                     <option value="Rent">Rent</option>
//                      <option value="Presell" selected>Presell</option>
//                 </select>
//             </div>
//         </div>';

//         echo '   <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Price</label>
//             <div class="col-8">
//                 <div class="input-group w-100">
//                     <div class="input-group-prepend">
//                         <span class="input-group-text">₱</span>
//                     </div>
//                     <input type="text" id="offerchoice" name="listingRentChoice" style="display:none;"  value="' . $row['propertyrentchoice'] . '">
//                     <input type="text" class="form-control CurrencyInput"
//                         onkeypress="return isNumberKey(event)" aria-label="Price" id="listingPrice"
//                         name="elistingPrice"  value="' . $row['propertyamount'] . '">
//                     <div class="input-group-append hidden" id="rentBtn">
//                         <button class="btn btn-selected" id="dailyBtn" type="button">Daily</button>
//                         <button class="btn btn-secondary" id="weeklyBtn" type="button">Weekly</button>
//                         <button class="btn btn-secondary" id="monthlyBtn" type="button">Monthly</button>
//                      </div>
//                 </div>
//             </div>
//         </div>';

//     }

//     echo '<div class="form-group row">
//             <label for="onlyNumbers1" class="col-4 col-form-label">Lot Area</label>
//             <div class="col-8">
//                 <div class="input-group w-100">
//                     <input type="text" class="form-control" aria-label="Lot Area" name="listingLotArea"
//                         id="listingLotArea" placeholder="Lot Area *"
//                         onkeypress="return isNumberKey(event)" value="' . $row['propertylotarea'] . '"/>

//                     <div class="input-group-append">
//                         <span class="input-group-text">sqm</span>
//                     </div>
//                 </div>
//             </div>
//         </div>';

//     echo '<div class="form-group row">
//             <label for="onlyNumbers2" class="col-4 col-form-label">Floor Area</label>
//             <div class="col-8">
//                 <div class="input-group w-100">
//                     <input type="text" class="form-control" aria-label="floor-area" name="listingFloorArea"
//                         id="listingFloorArea" placeholder="Floor Area *"
//                         onkeypress="return isNumberKey(event)" value="' . $row['propertyfloorarea'] . '"/>

//                     <div class="input-group-append">
//                         <span class="input-group-text">sqm</span>
//                     </div>
//                 </div>
//             </div>
//         </div>';

//     echo ' <div class="form-group row hidden" id="noOfBedroomsHolder">
//             <label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>
//             <div class="col-8">
//                 <input type="text" class="form-control" aria-label="Bedrooms" name="listingBedrooms"
//                     id="listingBedrooms" placeholder="Bedrooms *" onkeypress="return isNumberKey(event)" />
//             </div>
//         </div>';

//     echo '<div class="form-group row hidden" id="capacityOfGarageHolder">
//             <label for="carpark" class="col-4 col-form-label">Capacity of Garage (No. of
//                 Cars)</label>
//             <div class="col-8">
//                 <input type="text" class="form-control" aria-label="listing-garage"
//                     name="listingCapacityOfGarage" id="listingCapacityOfGarage"
//                     placeholder="Capacity of Garage *" onkeypress="return isNumberKey(event)" />
//             </div>
//         </div>';

//     echo ' <div class="form-group row">
//             <label for="carpark" class="col-4 col-form-label">Description</label>
//             <div class="col-8">
//                 <textarea class="form-control" style="height: 150px;" name="listingDesc" id="listingDesc"
//                     placeholder="Enter Description Here">';
//     echo $row['propertydesc'];
//     echo '</textarea>
//             </div>
//         </div>';
//     echo '<h3> <small class="text-muted">Attachment</small></h3>';

//     echo '<div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Authorization to Sell (ATS)
//             </label>
//             <div class="col-1">
//                 <input type="file" name="elistingATS" id="elistingATS" class="hidden"
//                     accept=".jpg, .jpeg, .png, .pdf">
//                 <button class="btn btn-primary hidden" id="addATSBtn" type="button" data-toggle="tooltip"
//                     data-placement="top" title="Add ATS">+</button>
//             </div>
//             <div class="col-6" id="clientHolders">
//                 <div class="row">
//                     <div id="ATSFile" class="col-4">';
//     $databaseFileName = $row['ATSFile'];
//     $filename = "../uploads/$databaseFileName" . "*";
//     $fileInfo = glob($filename);
//     $fileext = explode(".", $fileInfo[0]);
//     $fileactualext = $fileext[4];

//     echo '<img src="uploads/' . $row['ATSFile'] . "." . $fileactualext . '" width="100px" height="100px" onclick="document.querySelector(`#elistingATS`).click()" style="cursor:pointer;">';

//     echo '</div>
//                     <div id="ATSDesc" class="col-8">
//                     <p>Filename: ' . $row['ATSFile'] . '.' . $fileactualext . '</p>
//                     </div>
//                 </div>
//                 <br>
//                 <p id="addATSNote">Click the image above to "Change" your
//                     ATS uploaded.</p>
//             </div>
//         </div>';

//     echo '<br><br><br>
//         <h3>
//             <small class="text-muted">Complete Address</small>
//         </h3>';

//     echo '  <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Room/Floor/Unit No. &
//                 Building
//             </label>
//             <div class="col-8">
//                 <input type="text" class="form-control transform"
//                     aria-label="Room/Floor/Unit No. & Building" name="listingRFUB" id="listingRFUB"
//                     placeholder=" Room/Floor/Unit No. & Building * " value="' . $row['RoomFloorUnitNoBuilding'] . '">
//             </div>
//         </div>';

//     echo ' <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label transform">House/Lot &
//                 Block
//                 No.
//             </label>
//             <div class="col-8">
//                 <input type="text" class="form-control transform" aria-label="House/Lot & Block No."
//                     name="listingHLB" id="listingHLB" placeholder="House/Lot & Block No. *" value="' . $row['HouseLotBlockNo'] . '">
//             </div>
//         </div>';

//     echo ' <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label transform">Street</label>
//             <div class="col-8">
//                 <input type="text" class="form-control transform" aria-label="Street" name="listingStreet"
//                     id="listingStreet" placeholder="Street *" onkeypress="return allowOnlyLetters(event);" value="' . $row['street'] . '">
//             </div>
//         </div>';

//     echo ' <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label transform">Subdivision</label>
//             <div class="col-8">
//                 <input type="text" class="form-control transform" aria-label="Subdivision"
//                     name="listingSubdivision" id="subdivision" onkeypress="return allowOnlyLetters(event);"
//                     placeholder="Subdivision *" value="' . $row['subdivision'] . '">
//             </div>
//         </div>';

//     echo '  <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">Barangay</label>
//             <div class="col-8">
//                 <select type="text" class="form-control" aria-label="barangay" name="listingBrgyAddress"
//                     id="listingBrgyAddress" placeholder="Barangay *" style="width: 100%">
//                     <option value=' . $row['barangay'] . '>' . $row['barangay'] . '</option>
//                 </select>
//             </div>
//         </div>';

//     echo ' <div class="form-group row">
//             <label for="allPropertyHolder" class="col-4 col-form-label">City</label>
//             <div class="col-8">
//                 <select type="text" class="form-control" aria-label="mobile-number"
//                     name="listingCityAddress" id="listingCityAddress" placeholder="City *"
//                     style="width: 100%">
//                      <option value=' . $row['city'] . '>' . $row['city'] . '</option>
//                 </select>
//             </div>
//         </div>';

//     echo ' </div>
// </div>
// <br>
// <div class="modal-footer">
//     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
//     <button type="submit" class="btn btn-primary" name="submit" id="listing-submit">Edit
//         Property</button>
// </div';

// }