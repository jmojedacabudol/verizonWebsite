<?php
require_once 'header.php'
?>

<!-- Masthead-->
<section class="page-section properties" id="Home">
    <!-- Masthead Heading-->
    <header class="masthead bg-photo-pr text-center">
        <br> <br> <br> <br>
        <div class="container table-bg d-flex flex-column">

            <!-- Search-->
            <form id='propertySearch' action="properties.php" method="get">
                <div class="container text-black">
                    <h2 class="h2-size">Find your ideal property </h2>
                    <div class="row align-left text-black">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="offertype" id=offerType class="form-control">
                                    <option hidden>Offer Type</option>
                                    <option>Any</option>
                                    <option value="Sell">For Sale</option>
                                    <option value="Rent">For Rent</option>
                                    <option value="Presell">Preselling</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group w-100">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" name="propertylocation" class="form-control"
                                        placeholder="Enter Location" aria-label="Location"
                                        aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group w-100">
                                    <div class="input-group-prepend">
                                        <a class="btn btn-secondary" id='lotAreaBtn'>Lot
                                            Area/sqm</a>
                                    </div>
                                    <input type="text" class="form-control form-ctrl" placeholder="0" id="onlyNumbers1"
                                        name="lotarea" onkeypress="return isNumber(event)" onpaste="return false;"
                                        aria-label="" aria-describedby="button-addon3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group w-100">
                                    <div class="input-group-prepend">
                                        <a class="btn btn-secondary" id='floorAreaBtn'>Floor
                                            Area/sqm</s></a>
                                    </div>
                                    <input type="text" class="form-control form-ctrl" placeholder="0" id="onlyNumbers2"
                                        name="floorarea" onkeypress="return isNumber(event)" onpaste="return false;"
                                        aria-label="" aria-describedby="button-addon3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-left text-black">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="propertytype" id=propertyType class="form-control">
                                    <option hidden>Property Type</option>
                                    <option>Any</option>
                                    <option>Building</option>
                                    <option>Condominium</option>
                                    <option>Lots</option>
                                    <option>House</option>
                                    <option>Industrial</option>
                                    <option>Offices</option>
                                    <option>Warehouse</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" min="1" max="10" class="form-control"
                                    placeholder="Minimum No. of Bedrooms" id="minbr" name="minpropertybedrooms"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" min="1" max="10" class="form-control"
                                    placeholder="Maximum No. of Bedrooms" id="maxbr" name="maxpropertybedrooms"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" name='submit' class="btn btn-primary w-100">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    </header>





    <!-- Properties Section-->
    <div class="container padding-mobile">
        <!--Properties Section Heading-->
        <h5 class="page-section-heading text-center text-uppercase text-header-green"> <br> PROPERTIES</h5> <br>

        <div class=form-inline>
            <select id=sortby class="form-control">
                <option>Sort by Price</option>
                <option>Sort by Date Added</option>
                <option>Sort by Floor Area</option>
                <option>Sort by Lot Area</option>
            </select>
            &nbsp;&nbsp;

            <select id=highlow class="form-control">
                <option>Highest First</option>
                <option>Lowest First</option>
            </select>

            &nbsp;&nbsp;
        </div>


        <!--
        <nav aria-label="...">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <span class="page-link">
                        << </span>
                </li>
                <li class="page-item active">
                    <span class="page-link">
                        1
                        <span class="sr-only">(current)</span>
                    </span>



                <li class="page-item"><a class="page-link" href="#">2</a></li>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">>></a>
                </li>
            </ul>
        </nav> -->

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>





        <!-- Properties Grid Items-->
        <!-- <div id="propertiesContainer">

        </div> -->

        <?php
if (isset($_GET['offertype']) && isset($_GET['searchOption']) && isset($_GET['query'])) {

    $offertype = $_GET['offertype'];
    $searchOption = strtolower($_GET['searchOption']);
    $query = strtolower($_GET['query']);
    $string = "%$query%";

    //for pagination
    $results_per_page = 5;

    $userlogged = "no-user";

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }

    //check what searchoption selected
    //check if there is a query

    if ($searchOption == 'property-name') {
        if ($query != "") {

            $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertyname LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'ss', $string, $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
            }

            $this_page_first_result = ($page - 1) * $results_per_page;
            echo $this_page_first_result;
            // if (mysqli_num_rows($result) > 0) {
            //     while ($row = mysqli_fetch_assoc($result)) {
            //         $databaseFileName = $row['file_name'];
            //         $filename = "uploads/$databaseFileName" . "*";
            //         $fileInfo = glob($filename);
            //         $fileext = explode(".", $fileInfo[0]);
            //         $fileactualext = $fileext[2];

            //         echo " <div class='card mb-3 w-100'>";
            //         echo " <div class='properties-item mx-auto' onclick='viewCampaign(";
            //         echo $row['propertyid'];
            //         echo ")'";
            //         echo ">";
            //         echo "<img class='card-img-top' src='";
            //         echo "uploads/" . $row['file_name'] . "." . $fileactualext;
            //         echo "' alt=''>";
            //         echo " </div>";
            //         echo " <div class='card-body'>";
            //         echo " <h5 class='card-title'>";
            //         echo $row['propertyname'];
            //         echo "</h5>";
            //         echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
            //         echo $row['propertylocation'];
            //         echo "</p>";
            //         echo "<div class='container'>";
            //         echo "<div class='row'>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         echo " <button type='button' class='btn btn-primary w-100' onclick='viewCampaign(";
            //         echo $row['propertyid'];
            //         echo ")'";
            //         echo "><i class='fas fa-info'></i>&nbsp; View Info</button>";

            //         echo "</div>";
            //         echo "</div>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

            //         echo "</div>";
            //         echo "</div>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
            //         //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
            //         //                     Tour</button>";
            //         echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
            //           Tour</button>");

            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";

            //     }
            //     mysqli_stmt_close($stmt);
            // } else {
            //     //no property found
            //     echo "No Property Found";
            // }

        } else {
            //query is empty
            $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($stmt, 's', $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            for ($page = 1; $page <= $number_of_pages; $page++) {
                echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "&page=" . $page . "'>" . $page . "</a>";

            }

            $this_page_first_result = ($page - 1) * $results_per_page;

            // if (mysqli_num_rows($result) > 0) {
            //     while ($row = mysqli_fetch_assoc($result)) {
            //         $databaseFileName = $row['file_name'];
            //         $filename = "uploads/$databaseFileName" . "*";
            //         $fileInfo = glob($filename);
            //         $fileext = explode(".", $fileInfo[0]);
            //         $fileactualext = $fileext[2];

            //         echo " <div class='card mb-3 w-100'>";
            //         echo " <div class='properties-item mx-auto' onclick='viewCampaign(";
            //         echo $row['propertyid'];
            //         echo ")'";
            //         echo ">";
            //         echo "<img class='card-img-top' src='";
            //         echo "uploads/" . $row['file_name'] . "." . $fileactualext;
            //         echo "' alt=''>";
            //         echo " </div>";
            //         echo " <div class='card-body'>";
            //         echo " <h5 class='card-title'>";
            //         echo $row['propertyname'];
            //         echo "</h5>";
            //         echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
            //         echo $row['propertylocation'];
            //         echo "</p>";
            //         echo "<div class='container'>";
            //         echo "<div class='row'>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         echo " <button type='button' class='btn btn-primary w-100' onclick='viewCampaign(";
            //         echo $row['propertyid'];
            //         echo ")'";
            //         echo "><i class='fas fa-info'></i>&nbsp; View Info</button>";

            //         echo "</div>";
            //         echo "</div>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

            //         echo "</div>";
            //         echo "</div>";

            //         echo "<div class='col-md-4'>";
            //         echo "<div class='form-group'>";
            //         // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
            //         //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
            //         //                     Tour</button>";
            //         echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
            //           Tour</button>");

            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";
            //         echo "</div>";

            //     }
            //     mysqli_stmt_close($stmt);
            // } else {
            //     //no property found
            //     echo "No Property Found";
            // }

        }
        //SEARCH FOR PROPERTY LOCATION
    } else if ($searchOption == 'property-location') {
        if ($query != "") {
            $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertylocation LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid DESC LIMIT 3";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($stmt, 'ss', $string, $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewCampaign(";
                    echo $row['propertyid'];
                    echo ")'";
                    echo ">";
                    echo "<img class='card-img-top' src='";
                    echo "uploads/" . $row['file_name'] . "." . $fileactualext;
                    echo "' alt=''>";
                    echo " </div>";
                    echo " <div class='card-body'>";
                    echo " <h5 class='card-title'>";
                    echo $row['propertyname'];
                    echo "</h5>";
                    echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
                    echo $row['propertylocation'];
                    echo "</p>";
                    echo "<div class='container'>";
                    echo "<div class='row'>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewCampaign(";
                    echo $row['propertyid'];
                    echo ")'";
                    echo "><i class='fas fa-info'></i>&nbsp; View Info</button>";

                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
                    //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
                    //                     Tour</button>";
                    echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
                      Tour</button>");

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                }
                mysqli_stmt_close($stmt);
            } else {
                //no property found
                echo "No Property Found";
            }

        } else {
            //query is empty
            $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid DESC LIMIT 3";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                echo "<tr>";
                echo "SQL ERROR1";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($stmt, 's', $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewCampaign(";
                    echo $row['propertyid'];
                    echo ")'";
                    echo ">";
                    echo "<img class='card-img-top' src='";
                    echo "uploads/" . $row['file_name'] . "." . $fileactualext;
                    echo "' alt=''>";
                    echo " </div>";
                    echo " <div class='card-body'>";
                    echo " <h5 class='card-title'>";
                    echo $row['propertyname'];
                    echo "</h5>";
                    echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
                    echo $row['propertylocation'];
                    echo "</p>";
                    echo "<div class='container'>";
                    echo "<div class='row'>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewCampaign(";
                    echo $row['propertyid'];
                    echo ")'";
                    echo "><i class='fas fa-info'></i>&nbsp; View Info</button>";

                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

                    echo "</div>";
                    echo "</div>";

                    echo "<div class='col-md-4'>";
                    echo "<div class='form-group'>";
                    // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
                    //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
                    //                     Tour</button>";
                    echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
                      Tour</button>");

                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                }
                mysqli_stmt_close($stmt);
            } else {
                //no property found
                echo "No Property Found";
            }

        }

    }

}
//  else {
//     echo "Error Occured Contact Web Admin.";
// }
?>

</section>


<!-- properties Modal-->
<div class="properties-modal modal fade" id="propertiesModal1" tabindex="-1" role="dialog"
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
        </div>
    </div>
</div>




<!-- Contact Agent Modal-->
<div class="properties-modal modal fade" id="ContactAgent" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> Contact Agent
                        </div>
                        <div class="card-body" id="agentContainer">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of ContactAgent Modal-->


<!-- User Modal-->
<div class="properties-modal modal fade" id="userContact" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> User Contact Information
                        </div>
                        <div class="card-body">
                            <div id='userNotification'></div>
                            <form id='userContactInfo' action="includes/messages.inc.php" method="post">
                                <input type="input" class="form-control" placeholder="Name" name="name" />
                                <br>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="userNo"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3" maxlength="11">
                                <br>
                                <button type="submit" name="contact-submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of User Modal-->





<!-- Book a Tour Modal-->
<div class="properties-modal modal fade" id="bookaTourModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title">Book a Tour</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>
            <br>
            <div class="modal-body">
                <div class='calendar-container'>
                    <div id='calendar'></div>
                </div>
                <div id='date-container'></div>
            </div>
        </div>
    </div>
</div>



<!-- User Schedule Modal-->
<div class="properties-modal modal fade" id="userInfo" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> User Contact Information
                        </div>
                        <div class="card-body">
                            <div id="contact-error"></div>
                            <form id='userInfoForm' action="includes/inserttoschedules.inc.php" method="post">
                                <input type="input" class="form-control" placeholder="Name" name="userName" />
                                <br>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="userNumber"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3" maxlength="11">
                                <br>
                                <button type="submit" name="contact-submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of User Info Modal-->


<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- moment lib -->
<script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script>

<!-- fullcalendar bundle -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js'></script>

<!-- the moment-to-fullcalendar connector. must go AFTER the moment lib -->
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@5.5.0/main.global.min.js'></script>

<script src="assets/mail/contact_me.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script src="js/loadCalendar.js"></script>
<script src="js/propertySearch.js"></script>
<script src="js/propertyViewing.js"></script>
<script src="js/propertyload.js"></script>
<script src="js/viewpropertyAgent.js"></script>
<!-- <script src="js/messages.js"></script> -->
<script src="js/indexSearch.js"></script>
<script src="js/login.js"></script>
</body>

</html>