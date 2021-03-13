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
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <table id="properties" class="display" style="width:100%">
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
        echo number_format($row['propertyamount']);
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
        echo "<button type='button' id='editProperty' class='btn btn-secondary w-100'>
                                        <i class='far fa-edit'></i>Edit</button>";
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
                                    <!-- <div class="form-group row">
                                        <label for="up-valid-id" class="col-4 col-form-label"> </label>
                                        <div class="col-8">
                                            <div class="col-md-12 silver w-100 h-100">
                                                <div class="container-fluid">
                                                    <div class="img-content">
                                                        <img id="propertyImg" class="img-responsive img-fluid"
                                                            style="height:300px; width:300px" src="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
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
                                                <option>Presell</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="location" class="col-4 col-form-label">Location</label>
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
                                                <option>House</option>
                                                <option>Industrial</option>
                                                <option>Offices</option>
                                                <option>Warehouse</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onlyNumbers1" class="col-4 col-form-label">Lot Area (per
                                            sqm)</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" placeholder="Enter No. of Lot Area"
                                                id="listing-lot-area" name="listing-lot-area" aria-label=""
                                                aria-describedby="button-addon3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="onlyNumbers2" class="col-4 col-form-label">Floor Area (per
                                            sqm)*</label>
                                        <div class="col-8">
                                            <input type="text" class="form-control"
                                                placeholder="Enter No. of Floor Area" id="listing-floor-area"
                                                name="listing-floor-area" aria-label=""
                                                aria-describedby="button-addon3">
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="bedroom" class="col-4 col-form-label">No. of Bedrooms</label>
                                        <div class="col-8">
                                            <input type="number" min="1" max="10" class="form-control"
                                                placeholder="Enter No. of Bedrooms" id="listing-bedroom"
                                                name="listing-bedroom" onkeypress="return isNumber(event)"
                                                onpaste="return false;" aria-label="" aria-describedby="button-addon3">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="carpark" class="col-4 col-form-label">No. of Carparks</label>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="submit" id="listing-submit">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>



<br>
<br>
<br>

<!-- properties Modals-->
<div class="properties-modal modal fade" id="propertiesModal1" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <br>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg">

                            <!-- properties Modal - Title-->
                            <h2 class="properties-modal-title text-secondary text-uppercase mb-0"
                                id="propertiesModal1Label">Down Avenue</h2>
                            <h5 class="text-uppercase mproperties-price"> P 40,000,000 </h5><br>


                            <!-- properties Modal - Image-->
                            <div class="container">
                                <img class="img-fluid rounded mb-5" src="assets/img/properties/sampl_properties1_xl.png"
                                    alt="" />
                            </div>




                            <!-- properties Modal - Details-->

                            <h4 class="text-uppercase mproperties-available"> <i class="fas fa-home icon-green"></i>
                                AVAILABLE &nbsp;</h4>
                            <p class="mproperties-desc">Impressive Complex Mansion for Sale in Ayala Village </p>
                            <p class="mproperties-subdesc">Beautifully-designed, all the finishes were upgraded to
                                deliver top of the line commitment to the homeowners. Elegant granite countertops
                                and
                                rare usage of Narra wood was created for your townhouse. This smart e-home with
                                solar
                                power, a swimming pool, security all day and night provides an ideal home for you
                                and
                                your loved ones.</p> <br>
                            <!--Properties-Bedrooms--->
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm mproperties-features">
                                        <b class="mproperties-br1"> <i class="fas fa-bed"></i>&nbsp;6</b> <br>
                                        <p class="mproperties-br2"> Bedrooms </p>
                                    </div>
                                    <div class="col-sm mproperties-features">
                                        <b class="mproperties-br1"> <i class="fas fa-bath"></i>&nbsp;6</b> <br>
                                        <p class="mproperties-br2"> Bathrooms </p>
                                    </div>
                                    <div class="col-sm mproperties-features">
                                        <b class="mproperties-br1"> <i class="fas fa-car"></i>&nbsp;6</b> <br>
                                        <p class="mproperties-br2"> Car Parks </p>
                                    </div>
                                    <div class="col-sm mproperties-features">
                                        <b class="mproperties-br1"> <i class="fas fa-border-all"></i>&nbsp;438
                                            m<sup>2</sup></b> <br>
                                        <p class="mproperties-br2"> Floor Area </p>
                                    </div>
                                    <div class="col-sm mproperties-features">
                                        <b class="mproperties-br1"> <i class="fas fa-ruler-combined"></i>&nbsp;118
                                            m<sup>2</sup></b> <br>
                                        <p class="mproperties-br2"> Lot Area </p>
                                    </div>

                                </div>
                            </div>
                            <br>

                            <!--Home and Neighborhood Features--->
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm mproperties-features"> <b>Home Features</b> <br>
                                        <div class="mproperties-features-list">
                                            <i class="fas fa-check"></i> Outdoor Function Area <br>
                                            <i class="fas fa-check"></i> Smart Home<br>
                                            <i class="fas fa-check"></i> Walkin Closet<br>
                                            <i class="fas fa-check"></i> Premium Finish<br>
                                            <i class="fas fa-check"></i> Solar Panels<br>
                                        </div>
                                    </div>

                                    <div class="col-sm mproperties-features"> <b>Neighborhood Features</b> <br>
                                        <div class="mproperties-features-list">
                                            <i class="fas fa-check"></i> Private Gated Community<br>
                                            <i class="fas fa-check"></i> Swimming Pool<br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>


                            <br><br>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>






<!-- Save Changes Modal -->
<div class="modal fade" id="SaveChanges" tabindex="-1" role="dialog" aria-labelledby="SaveChanges" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Save changes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Confirm changes?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary"
                    onclick="location.href='user-property-listing.html';">Save</button>
            </div>
            <br><br>
        </div>
    </div>
</div>


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
            <script src="js/scripts.js"></script>
            <script src="js/imageLoading.js"></script>
            <script src="js/dashboard-listing.js"></script>
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