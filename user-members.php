<?php
require_once 'header.php';
?>


<?php
require_once 'sidenav.php'
?>
<div class="main">


    <table id="properties" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Property Id</th>
                <th>Property Name</th>
                <th>Location</th>
                <th>Lot Area</th>
                <th>Floor Area</th>
                <th>Property type</th>
                <th>Offer Type</th>
                <th class='notexport'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
$sql = "SELECT * FROM property WHERE approval !=3;";
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
        echo $row['propertylocation'];
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
        echo $row['offertype'];
        echo "</td>";
        echo "<td>";
        echo " <button class='btn btn-success' id='approveBtn' type='text' aria-label='approve'><i
                                        class='far fa-check-circle'></i></button>";
        echo " <button class='btn btn-danger' id='denyBtn' type='text' aria-label='deny'><i
                                        class='far fa-times-circle'></i></button>";
        echo " <button class='btn btn-info' id='viewBtn' type='text' aria-label='view'><i
                                        class='far fa-eye'></i></button>";
        echo "</td>";

        echo "</tr>";
    }
}
?>

        </tbody>
    </table>






    <!-- properties Modals-->
    <!-- properties Modal 1-->
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
                                    <img class="img-fluid rounded mb-5"
                                        src="assets/img/properties/sampl_properties1_xl.png" alt="" />
                                </div>




                                <!-- properties Modal - Details-->

                                <h4 class="text-uppercase mproperties-available"> <i class="fas fa-home icon-green"></i>
                                    AVAILABLE &nbsp;</h4>
                                <p class="mproperties-desc">Impressive Complex Mansion for Sale in Ayala Village </p>
                                <p class="mproperties-subdesc">Beautifully-designed, all the finishes were upgraded to
                                    deliver top of the line commitment to the homeowners. Elegant granite countertops
                                    and rare usage of Narra wood was created for your townhouse. This smart e-home with
                                    solar power, a swimming pool, security all day and night provides an ideal home for
                                    you and your loved ones.</p> <br>
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




    <!-- Confirm Logout Modal -->
    <div class="modal fade" id="ConfirmLogout" tabindex="-1" role="dialog" aria-labelledby="ConfirmLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really wish to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="location.href='index.html';">Yes</button>
                </div>
                <br><br>
            </div>
        </div>
    </div>





    <!-- Bootstrap core JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Third party plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <!-- Contact form JS-->
    <script src="assets/mail/jqBootstrapValidation.js"></script>
    <script src="assets/mail/contact_me.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    </body>

    </html>