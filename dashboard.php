<?php
session_start();
if (isset($_SESSION["userid"])) {
    require_once 'header.php';
    require_once 'sidenav.php';

    $userlogged = $_SESSION['userid'];

    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $userlogged);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseFileName = $row['profile_Img'];
            $filename = "uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[2];
            echo "<div class='main'>";
            echo "<div class='card container-fluid'>";
            echo "<div class='card-body'>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<h4 align='center'>My Profile</h4>";
            echo "<hr>";
            echo "</div>";
            echo "</div>";
            echo "<div class='row'>";
            echo "<div class='col-md-12 silver'>";
            echo "<div class='container-fluid square'>";
            echo " <div class='img-content'>";
            echo "<img class='img-responsive img-fluid' src='uploads/";
            echo $row['profile_Img'] . "." . $fileactualext;
            echo "'>";
            echo " <div class='btn-change'>";
            echo "<br>";
            echo " <input id='fileInput' type='file'style='display:none;'/>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<hr>";
            echo "<div class='row'>";
            echo "<div class='col-md-12'>";
            echo "<form>";
            echo "<div class='form-group row'>";
            echo " <label for='name' class='col-4 col-form-label'>First Name</label>";
            echo " <div class='col-8'>";
            echo " <input id='name' name='name'class='form-control here' value='";
            echo $row['usersFirstName'];
            echo "' type='text' disabled>";
            echo "</div>";
            echo "</div>";
            echo "<div class='form-group row'>";
            echo " <label for='lastname' class='col-4 col-form-label'>Last Name</label>";
            echo " <div class='col-8'>";
            echo " <input id='lastname' name='lastname' class='form-control here' value='";
            echo $row['userLastName'];
            echo "' type='text' disabled>";
            echo "</div>";
            echo "</div>";
            echo "<div class='form-group row'>";
            echo "<label for='select' class='col-4 col-form-label'>Position Type</label>";
            echo "<div class='col-8'>";
            if ($row['usersPosition'] === "Agent") {
                echo "<select id='select'";
                echo "name='select' class='custom-select' disabled>";
                echo "<option value='Agent'selected>Agent</option>";
                echo "<option value='Manager'>Manager</option>";
                echo "</select>";
            } else {
                if ($row['approval'] === 0) {
                    echo "<select id='select'";
                    echo "name='select' class='custom-select' disabled>";
                    echo "<option value='Agent'>Agent</option>";
                    echo "<option value='Manager'selected>Manager(Pending)</option>";
                    echo "</select>";

                } else if ($row['approval'] === 1) {
                    echo "<select id='select'";
                    echo "name='select' class='custom-select' disabled>";
                    echo "<option value='Agent'>Agent</option>";
                    echo "<option value='Manager'selected>Manager(Approved)</option>";
                    echo "</select>";

                } else if ($row['approval'] === 1) {
                    echo "<select id='select'";
                    echo "name='select' class='custom-select' disabled>";
                    echo "<option value='Agent'>Agent</option>";
                    echo "<option value='Manager'selected>Manager(Denied)</option>";
                    echo "</select>";

                }
            }
            echo "</div>";
            echo "</div>";

            echo "<div class='form-group row'>";
            echo " <label for='lastname' class='col-4 col-form-label'>Email</label>";
            echo " <div class='col-8'>";
            echo " <input id='email' name='email' value='";
            echo $row['companyEmail'] . "'";
            echo " class='form-control here'type='text' disabled>";
            echo "</div>";
            echo "</div>";

            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
} else {
    header('location: index.php');
}

?>








<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


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
                                <img class="img-fluid rounded mb-5" src="assets/img/properties/sampl_properties1_xl.png"
                                    alt="" />
                            </div>




                            <!-- properties Modal - Details-->

                            <h4 class="text-uppercase mproperties-available"> <i class="fas fa-home icon-green"></i>
                                AVAILABLE &nbsp;</h4>
                            <p class="mproperties-desc">Impressive Complex Mansion for Sale in Ayala
                                Village </p>
                            <p class="mproperties-subdesc">Beautifully-designed, all the finishes were
                                upgraded to deliver top of the line commitment to the homeowners.
                                Elegant granite countertops and rare usage of Narra wood was created for
                                your townhouse. This smart e-home with solar power, a swimming pool,
                                security all day and night provides an ideal home for you and your loved
                                ones.</p> <br>
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

                                    <div class="col-sm mproperties-features"> <b>Neighborhood
                                            Features</b> <br>
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


<!-- Valid Id Modal -->
<div class="modal fade" id="ValidIdModal" tabindex="-1" role="dialog" aria-labelledby="ValidIdModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Valid Id</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 silver w-100 h-100">
                        <div class="container-fluid">
                            <div class="img-content">
                                <i class="fas fa-image"></i>
                                <img class="img-responsive img-fluid" src="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <br><br>
        </div>
    </div>
</div>






</body>

<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="assets/mail/contact_me.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>

</html>