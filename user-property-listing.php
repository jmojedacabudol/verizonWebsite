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
                <h5 class="card-title">Your Property Listing</h5>
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
        echo $row['propertylocation'];
        echo "</td>";
        echo "<td>₱&nbsp;&nbsp;";
        echo number_format((int) $row['propertyamount']);
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
        echo "<button type='button' id='editProperty' class='btn btn-secondary w-100' data-toggle='tooltip' data-placement='bottom' title='Edit Property'>
                                        <i class='far fa-edit'></i>Edit</button>";
        echo "<button type='button' id='viewProperty' class='btn btn-info w-100' data-toggle='tooltip' data-placement='bottom' title='View Property'>
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
                <h5 class="modal-title">Add New Property Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card container-fluid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="propertyForm" action="includes/propertyupload.inc.php" method="post"
                                    enctype='multipart/form-data'>
                                    <div id="form-message" style="text-align:center;">

                                    </div>
                                    <div class="form-group row">
                                        <label for="up-valid-id" class="col-4 col-form-label">Image</label>
                                        <div class="col-8">
                                            <!-- <input type="file" class="btn btn-secondary w-100" name="listing-image"
                                                id="fileImg" /> -->
                                            <input type="file" name="listing-image[]" multiple>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="listing-title" class="col-4 col-form-label">Listing
                                            Title</label>
                                        <div class="col-8">
                                            <input id="listing-title" name="listing-title"
                                                placeholder="Enter Listing Title" class="form-control here" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="listing-offer-type" class="col-4 col-form-label">Offer Type</label>
                                        <div class="col-8">
                                            <select id=listing-offer-type name="listing-offer-type"
                                                class="form-control">
                                                <option selected>Sell</option>
                                                <option>Rent</option>
                                                <option>Preselling</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="location" class="col-4 col-form-label">Street No/</label>
                                        <div class="col-8">
                                            <div class="input-group w-100">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                </div>

                                                <input type="text" id="listing-location" name="listing-location"
                                                    class="form-control" placeholder="Enter Location"
                                                    aria-label="Location" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="location" class="col-4 col-form-label">Price (₱)</label>
                                        <div class="col-8">
                                            <div class="input-group w-100">
                                                <input type="text" id='offerchoice' name="listing-rentChoice"
                                                    style="display:none;" value="none">
                                                <input type="number" class="form-control" placeholder="Enter Amount"
                                                    aria-label="Price" name='listing-price'
                                                    aria-describedby="basic-addon2">
                                                <div class="input-group-append" id='rentBtn' style="display:none;">
                                                    <button class="btn btn-secondary" id="dailyBtn"
                                                        type="button">Daily</button>
                                                    <button class="btn btn-secondary" id="weeklyBtn"
                                                        type="button">Weekly</button>
                                                    <button class="btn btn-secondary" id="monthlyBtn"
                                                        type="button">Monthly</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="listing-type" class="col-4 col-form-label">Property Type</label>
                                        <div class="col-8">
                                            <select id=listing-type name="listing-type" class="form-control">
                                                <option selected>Building</option>
                                                <option>Condominium</option>
                                                <option>Lots</option>
                                                <option>House and Lot</option>
                                                <option>Industrial</option>
                                                <option>Offices</option>
                                                <option>Warehouse</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onlyNumbers1" class="col-4 col-form-label">Lot Area (sqm)</label>
                                        <div class="col-8">
                                            <input type="number" class="form-control"
                                                placeholder="Enter No. of Lot Area" id="listing-lot-area"
                                                name="listing-lot-area" aria-label="" aria-describedby="button-addon3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onlyNumbers2" class="col-4 col-form-label">Floor Area (sqm)</label>
                                        <div class="col-8">
                                            <input type="number" class="form-control"
                                                placeholder="Enter No. of Floor Area" id="listing-floor-area"
                                                name="listing-floor-area" aria-label=""
                                                aria-describedby="button-addon3">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>
                                        <div class="col-8">
                                            <input type="number" min="0" max="10" class="form-control"
                                                placeholder="Enter No. of Bedrooms" id="listing-bedroom"
                                                name="listing-bedroom" onkeypress="return isNumber(event)"
                                                onpaste="return false;" aria-label="" aria-describedby="button-addon3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="carpark" class="col-4 col-form-label">Capacity of Garage (No. of
                                            Cars)</label>
                                        <div class="col-8">
                                            <input type="number" min="0" max="10" class="form-control"
                                                placeholder="Enter No. of Carparks" id="listing-carpark"
                                                name="listing-carpark" onkeypress="return isNumber(event)"
                                                onpaste="return false;" aria-label="" aria-describedby="button-addon3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="carpark" class="col-4 col-form-label">Description</label>
                                        <div class="col-8">
                                            <textarea class="form-control" style="height: 150px;" name='listing-desc'
                                                placeholder="Enter Description Here"></textarea>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </section>
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
</div>



<br>
<br>
<br>








<!-- Edit Property Modal -->
<div class="modal fade bd-example-modal" id="editPropertyModal" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Property Listing</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="card container-fluid">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="epropertyForm" action="includes/insertpropertyedit.inc.php" method="post"
                                    enctype='multipart/form-data'>
                                    <div id='propertyHolder'>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
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


<script src="js/imageLoading.js"></script>
<script src="js/dashboard-listing.js"></script>
<script src="js/propertyupload.js"></script>


</body>

</html>