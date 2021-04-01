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
            <form action="properties.php" method="get">
                <div class="container text-black">
                    <h2 class="h2-size">Find your ideal property </h2>
                    <div class="row align-left text-black">
                        <?php
//check if there are items inside forms to save after page refresh
if (isset($_GET['offertype'])) {
    $offertype = $_GET['offertype'];
    // echo $offertype;
}
if (isset($_GET['propertylocation'])) {
    $propertylocation = $_GET['propertylocation'];
} else {
    $propertylocation = '';
}
if (isset($_GET['lotarea'])) {
    $lotarea = $_GET['lotarea'];
} else {
    $lotarea = '';
}
if (isset($_GET['floorarea'])) {
    $floorarea = $_GET['floorarea'];
} else {
    $floorarea = '';
}
if (isset($_GET['propertyType'])) {
    $propertytype = $_GET['propertyType'];
} else {
    $propertytype = '';
}
if (isset($_GET['minpropertybedrooms'])) {
    $minpropertybedrooms = $_GET['minpropertybedrooms'];
} else {
    $minpropertybedrooms = '';
}
if (isset($_GET['maxpropertybedrooms'])) {
    $maxpropertybedrooms = $_GET['maxpropertybedrooms'];
} else {
    $maxpropertybedrooms = '';
}

echo '<div class="col-md-3">';
echo ' <div class="form-group">';
echo '<select name="offertype" id=offerType class="form-control">';

if ($offertype == 'sell') {
    echo '<option hidden>Offer Type</option>';
    echo '<option>Any</option>';
    echo '<option value="Sell" selected>For Sale</option>';
    echo '<option value="Rent">For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

} else if ($offertype == 'rent') {
    echo '<option hidden>Offer Type</option>';
    echo '<option>Any</option>';

    echo '<option value="Sell">For Sale</option>';
    echo '<option value="Rent"selected>For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

} else if ($offertype == 'presell') {
    echo '<option hidden>Offer Type</option>';
    echo '<option>Any</option>';

    echo '<option value="Sell">For Sale</option>';
    echo '<option value="Rent">For Rent</option>';
    echo '<option value="Presell" selected>Preselling</option>';

} else if ($offertype == "Any") {
    echo '<option hidden>Offer Type</option>';
    echo '<option selected>Any</option>';
    echo '<option value="Sell">For Sale</option>';
    echo '<option value="Rent">For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

} else {
    echo '<option hidden selected>Offer Type</option>';
    echo '<option>Any</option>';
    echo '<option value="Sell">For Sale</option>';
    echo '<option value="Rent">For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

}
echo '</select>';
echo '</div>';
echo '</div>';

echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo ' <div class="input-group-prepend">';
echo '   <span class="input-group-text" id="basic-addon1"><i
                                                class="fas fa-map-marker-alt"></i></span>';
echo '</div>';
echo '<input type="text" name="propertylocation" class="form-control"
                                        placeholder="Enter Location" aria-label="Location" value="';
echo $propertylocation;
echo '"aria-describedby="basic-addon1">';
echo '</div>';
echo '</div>';
echo '</div>';

echo '   <div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo '  <div class="input-group-prepend">';
echo ' <a class="btn btn-secondary" id="lotAreaBtn">Lot
                                            Area/sqm</a>';
echo '</div>';
echo '<input type="text" class="form-control form-ctrl" placeholder="0" id="onlyNumbers1"
                                        name="lotarea" onkeypress="return isNumber(event)" onpaste="return false;"
                                        aria-label="" aria-describedby="button-addon3" value="';
echo $lotarea;
echo '">';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo '     <div class="input-group-prepend">';
echo '   <a class="btn btn-secondary" id="floorAreaBtn">Floor
                                            Area/sqm</s></a>';
echo '</div>';

echo '<input type="text" class="form-control form-ctrl" placeholder="0" id="onlyNumbers2"
                                        name="floorarea" onkeypress="return isNumber(event)" onpaste="return false;"
                                        aria-label="" aria-describedby="button-addon3" value="';
echo $floorarea . '">';

echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="row align-left text-black">';
echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<select name="propertytype" id=propertyType class="form-control">';
if ($propertytype == 'Building') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option selected>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Condominium') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option selected>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Lots') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option selected>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'House and Lot') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option selected>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Industrial') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option selected>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Offices') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option selected>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Warehouse') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option selected>Warehouse</option>';

} else if ($propertytype == 'Any') {
    echo '<option hidden>Property Type</option>';
    echo '<option selected>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == '') {
    echo '<option hidden selected>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Property Type') {
    echo '<option hidden selected>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lots</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Industrial</option>';
    echo '<option>Offices</option>';
    echo '<option>Warehouse</option>';

}
echo '</select>';

echo '</div>';
echo '</div>';

echo ' <div class="col-md-3">';
echo ' <div class="form-group">';
echo '<input type="number"  max="10" class="form-control"
                                    placeholder="Minimum No. of Bedrooms"  name="minpropertybedrooms"aria-label=""
                                    aria-describedby="button-addon3" value="';
echo $minpropertybedrooms . '">';

echo '</div>';
echo '</div>';

echo ' <div class="col-md-3">';
echo '<div class="form-group">';
echo '<input type="number"  max="10" class="form-control"
                                    placeholder="Maximum No. of Bedrooms" name="maxpropertybedrooms" aria-label=""
                                    aria-describedby="button-addon3" value="';
echo $maxpropertybedrooms . '">';
echo '</div>';
echo '</div>';

echo '<div class="col-md-3">';
echo '      <div class="form-group">';
echo '    <button type="submit" name="filtersubmit" value="filter"
                                    class="btn btn-primary w-100">Search</button>';
echo '</div>';

echo '</div>';

echo '</div>';

?>


                    </div>

            </form>
    </header>






    <!-- Properties Section-->
    <div class="container padding-mobile">
        <!--Properties Section Heading-->
        <h5 class="page-section-heading text-center text-uppercase text-header-green"> <br> PROPERTIES</h5> <br>

        <!-- Properties Grid Items-->
        <div id="propertiesContainer">
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

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            //properties order and sequence
            if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
                $sort = "property.propertyamount";
                $sequence = "DESC";
            } else {
                $sort = $_GET['sort'];
                $sequence = $_GET['sequence'];

            }

            echo '<div class=form-inline>';
            if ($sort == "property.propertyamount") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertyfloorarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '">Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertylotarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            echo '&nbsp;&nbsp;';

            if ($sequence == "DESC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '" selected>Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '">Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sequence == "ASC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '">Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '" selected>Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            // echo '<select class="form-control" onchange="location=this.value;">';
            // echo '<option>Highest First</option>';
            // echo '<option>Lowest First</option>';
            // echo '</select>';
            echo '&nbsp;&nbsp;';
            echo '</div>';

            mysqli_stmt_bind_param($stmt, 'ss', $string, $offertype);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $this_page_first_result = ($page - 1) * $results_per_page;

            echo '<nav aria-label="Page navigation example">';
            echo '<ul class="pagination justify-content-end">';
            // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';
            for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

                if ($pageNo == $page) {
                    echo '<li class="page-item active"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                } else {
                    echo '<li class="page-item"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                }
                // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
            }
            // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
            echo '</ul>';
            echo '</nav>';

            $paginationSql =
                "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertyname LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page;

            // "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertyname LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid LIMIT " . $this_page_first_result . "," . $results_per_page;

            $paginationStmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($paginationStmt, $paginationSql)) {
                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($paginationStmt, 'ss', $string, $offertype);
            mysqli_stmt_execute($paginationStmt);
            $paginationResult = mysqli_stmt_get_result($paginationStmt);
            if (mysqli_num_rows($paginationResult) > 0) {
                while ($row = mysqli_fetch_assoc($paginationResult)) {

                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
                echo "<h6 style='text-align:center; color:#70945A;'>No Property found for search keyword ''" . $query . "''</h6>";

            }

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
            //properties page
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            //properties order and sequence
            if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
                $sort = "property.propertyamount";
                $sequence = "DESC";
            } else {
                $sort = $_GET['sort'];
                $sequence = $_GET['sequence'];

            }

            mysqli_stmt_bind_param($stmt, 's', $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            echo '<div class=form-inline>';
            if ($sort == "property.propertyamount") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

// echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertyfloorarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '">Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

// echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertylotarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Lot Area</option>';

// echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            echo '&nbsp;&nbsp;';

            if ($sequence == "DESC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '" selected>Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '">Lowest First</option>';

// echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sequence == "ASC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '">Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '" selected>Lowest First</option>';

// echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            // echo '<select class="form-control" onchange="location=this.value;">';
            // echo '<option>Highest First</option>';
            // echo '<option>Lowest First</option>';
            // echo '</select>';
            echo '&nbsp;&nbsp;';
            echo '</div>';

            $number_of_results = mysqli_num_rows($result);
            // echo $number_of_results;
            $number_of_pages = ceil($number_of_results / $results_per_page);

            $this_page_first_result = ($page - 1) * $results_per_page;

            echo '<nav aria-label="Page navigation example">';
            echo '<ul class="pagination justify-content-end">';
            // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';

            for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

                if ($pageNo == $page) {
                    echo '<li class="page-item active"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                } else {
                    echo '<li class="page-item"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                }
                // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
            }

            // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
            echo '</ul>';
            echo '</nav>';

            $paginationSql =

                "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page;

            // echo $paginationSql;

            // "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid LIMIT " . $this_page_first_result . "," . $results_per_page;

            $paginationStmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($paginationStmt, $paginationSql)) {
                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($paginationStmt, 's', $offertype);
            mysqli_stmt_execute($paginationStmt);
            $paginationResult = mysqli_stmt_get_result($paginationStmt);

            if (mysqli_num_rows($paginationResult) > 0) {
                while ($row = mysqli_fetch_assoc($paginationResult)) {

                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
                echo "<h6 style='text-align:center; color:#70945A;'>No Property found for search keyword ''" . $query . "''</h6>";

            }

        }
        //SEARCH FOR PROPERTY LOCATION
    } else if ($searchOption == 'property-location') {
        if ($query != "") {
            $sql =
                "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertylocation LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid;";

            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {

                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
                $sort = "property.propertyamount";
                $sequence = "DESC";
            } else {
                $sort = $_GET['sort'];
                $sequence = $_GET['sequence'];

            }

            echo '<div class=form-inline>';
            if ($sort == "property.propertyamount") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertyfloorarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '">Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertylotarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            echo '&nbsp;&nbsp;';

            if ($sequence == "DESC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '" selected>Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '">Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sequence == "ASC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '">Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '" selected>Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            // echo '<select class="form-control" onchange="location=this.value;">';
            // echo '<option>Highest First</option>';
            // echo '<option>Lowest First</option>';
            // echo '</select>';
            echo '&nbsp;&nbsp;';
            echo '</div>';

            mysqli_stmt_bind_param($stmt, 'ss', $string, $offertype);

            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $number_of_results = mysqli_num_rows($result);
            $number_of_pages = ceil($number_of_results / $results_per_page);
            $this_page_first_result = ($page - 1) * $results_per_page;

            echo '<nav aria-label="Page navigation example">';
            echo '<ul class="pagination justify-content-end">';
            // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';

            for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

                if ($pageNo == $page) {
                    echo '<li class="page-item active"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                } else {
                    echo '<li class="page-item"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                }
                // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
            }

            // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
            echo '</ul>';
            echo '</nav>';

            $paginationSql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertylocation LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page;

// "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertylocation LIKE ?  AND offertype= ? AND property.approval=1 GROUP BY property.propertyid LIMIT " . $this_page_first_result . "," . $results_per_page;

            $paginationStmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($paginationStmt, $paginationSql)) {
                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($paginationStmt, 'ss', $string, $offertype);
            mysqli_stmt_execute($paginationStmt);
            $paginationResult = mysqli_stmt_get_result($paginationStmt);
            if (mysqli_num_rows($paginationResult) > 0) {
                while ($row = mysqli_fetch_assoc($paginationResult)) {

                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
                echo "<h6 style='text-align:center; color:#70945A;'>No Property found for search keyword ''" . $query . "''</h6>";

            }

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

            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            //properties order and sequence
            if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
                $sort = "property.propertyamount";
                $sequence = "DESC";
            } else {
                $sort = $_GET['sort'];
                $sequence = $_GET['sequence'];

            }

            echo '<div class=form-inline>';
            if ($sort == "property.propertyamount") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertyfloorarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '">Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '">Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sort == "property.propertylotarea") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
                echo '" selected>Sort by Price</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
                echo '">Sort by Floor Area</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
                echo '" selected >Sort by Lot Area</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            echo '&nbsp;&nbsp;';

            if ($sequence == "DESC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '" selected>Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '">Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            } else if ($sequence == "ASC") {
                echo '<select class="form-control" onchange="location=this.value;">';
                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
                echo '">Highest First</option>';

                echo '<option value="properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
                echo '" selected>Lowest First</option>';

                // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
                echo '</select>';

            }

            // echo '<select class="form-control" onchange="location=this.value;">';
            // echo '<option>Highest First</option>';
            // echo '<option>Lowest First</option>';
            // echo '</select>';
            echo '&nbsp;&nbsp;';
            echo '</div>';

            mysqli_stmt_bind_param($stmt, 's', $offertype);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $number_of_results = mysqli_num_rows($result);
            // echo $number_of_results;
            $number_of_pages = ceil($number_of_results / $results_per_page);

            $this_page_first_result = ($page - 1) * $results_per_page;

            echo '<nav aria-label="Page navigation example">';
            echo '<ul class="pagination justify-content-end">';
            // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';

            for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

                if ($pageNo == $page) {
                    echo '<li class="page-item active"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                } else {
                    echo '<li class="page-item"><a class="page-link" href="';
                    echo 'properties.php?offertype=' . $offertype . '&searchOption=' . $searchOption . "&query=" . $query . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                    echo '">' . $pageNo;
                    echo '</a></li>';

                }
                // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
            }

            // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
            echo '</ul>';
            echo '</nav>';

            $paginationSql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page;

            // "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND offertype= ? AND property.approval=1 GROUP BY property.propertyid LIMIT " . $this_page_first_result . "," . $results_per_page;

            $paginationStmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($paginationStmt, $paginationSql)) {
                echo "<tr>";
                echo "SQL ERROR";
                echo "</tr>";
                exit();
            }

            mysqli_stmt_bind_param($paginationStmt, 's', $offertype);
            mysqli_stmt_execute($paginationStmt);
            $paginationResult = mysqli_stmt_get_result($paginationStmt);

            if (mysqli_num_rows($paginationResult) > 0) {
                while ($row = mysqli_fetch_assoc($paginationResult)) {

                    $databaseFileName = $row['file_name'];
                    $filename = "uploads/$databaseFileName" . "*";
                    $fileInfo = glob($filename);
                    $fileext = explode(".", $fileInfo[0]);
                    $fileactualext = $fileext[2];

                    echo " <div class='card mb-3 w-100'>";
                    echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
                    echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
                echo "<br>";
                echo "<h6 style='text-align:center; color:#70945A;'>No Property found for search keyword ''" . $query . "''</h6>";

            }

        }

    }

} else if (isset($_GET['propertyType'])) {
    //check if the selected is from property types

    $propertyType = $_GET['propertyType'];
    $results_per_page = 5;
    $userlogged = "no-user";

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }

    // echo $propertyType;
    $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.approval=1 AND property.propertytype=?  GROUP BY property.propertyid;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {

        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
        $sort = "property.propertyamount";
        $sequence = "DESC";
    } else {
        $sort = $_GET['sort'];
        $sequence = $_GET['sequence'];

    }

    echo '<div class=form-inline>';
    if ($sort == "property.propertyamount") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
        echo '" selected>Sort by Price</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
        echo '">Sort by Floor Area</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
        echo '">Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sort == "property.propertyfloorarea") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
        echo '">Sort by Price</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
        echo '" selected >Sort by Floor Area</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
        echo '">Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sort == "property.propertylotarea") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence;
        echo '" selected>Sort by Price</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence;
        echo '">Sort by Floor Area</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence;
        echo '" selected >Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    }

    echo '&nbsp;&nbsp;';

    if ($sequence == "DESC") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
        echo '" selected>Highest First</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
        echo '">Lowest First</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sequence == "ASC") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC';
        echo '">Highest First</option>';

        echo '<option value="properties.php?propertyType=' . $propertyType . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC';
        echo '" selected>Lowest First</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    }

// echo '<select class="form-control" onchange="location=this.value;">';
    // echo '<option>Highest First</option>';
    // echo '<option>Lowest First</option>';
    // echo '</select>';
    echo '&nbsp;&nbsp;';
    echo '</div>';

    mysqli_stmt_bind_param($stmt, 's', $propertyType);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $number_of_results = mysqli_num_rows($result);
    $number_of_pages = ceil($number_of_results / $results_per_page);
    $this_page_first_result = ($page - 1) * $results_per_page;
    //display the number of pages if there is a property
    if ($number_of_results > 0) {
        echo '<nav aria-label="Page navigation example">';
        echo '<ul class="pagination justify-content-end">';
        // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';

        for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

            if ($pageNo == $page) {
                echo '<li class="page-item active"><a class="page-link" href="';
                echo 'properties.php?propertyType=' . $propertyType . '&page=' . $pageNo . '.&sort=' . $sort . "&sequence=" . $sequence;
                echo '">' . $pageNo;
                echo '</a></li>';

            } else {
                echo '<li class="page-item"><a class="page-link" href="';
                echo 'properties.php?propertyType=' . $propertyType . '&page=' . $pageNo . '&sort=' . $sort . "&sequence=" . $sequence;
                echo '">' . $pageNo;
                echo '</a></li>';

            }
            // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
        }

        // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
        echo '</ul>';
        echo '</nav>';

    }

    $paginationSql =
        "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertytype=?  AND property.approval=1 GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page;

    // "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.approval=1 AND property.propertytype=?  GROUP BY property.propertyid LIMIT " . $this_page_first_result . "," . $results_per_page;

    $paginationStmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($paginationStmt, $paginationSql)) {
        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }

    mysqli_stmt_bind_param($paginationStmt, 's', $propertyType);
    mysqli_stmt_execute($paginationStmt);
    $paginationResult = mysqli_stmt_get_result($paginationStmt);

    if (mysqli_num_rows($paginationResult) > 0) {
        while ($row = mysqli_fetch_assoc($paginationResult)) {

            $databaseFileName = $row['file_name'];
            $filename = "uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[2];

            echo " <div class='card mb-3 w-100'>";
            echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
            echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
        echo "<br>";
        echo "<h6 style='text-align:center; color:#70945A;'>No Property found under  ''" . $propertyType . "''</h6>";

    }

} else if (isset($_GET['filtersubmit'])) {

    $query = "SELECT property.propertyid, property.usersId,property.propertyname,property.propertylocation,MIN(images.file_name)AS file_name FROM property,images  WHERE  property.propertyid = images.propertyid AND property.approval  NOT IN (0, 2, 3)";

    // for pagination
    $results_per_page = 5;

    $by_offertype = $_GET['offertype'];
    $by_propertylocation = $_GET['propertylocation'];
    $by_propertylotarea = $_GET['lotarea'];
    $by_propertyfloorarea = $_GET['floorarea'];
    $by_propertytype = $_GET['propertytype'];
    $by_minpropertybedrooms = $_GET['minpropertybedrooms'];
    $by_maxpropertybedrooms = $_GET['maxpropertybedrooms'];

    $userlogged = "no-user";

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }

    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    if (!isset($_GET['sort']) && !isset($_GET['sequence'])) {
        $sort = "property.propertyamount";
        $sequence = "DESC";
    } else {
        $sort = $_GET['sort'];
        $sequence = $_GET['sequence'];

    }

    echo '<div class=form-inline>';
    if ($sort == "property.propertyamount") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '" selected>Sort by Price</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '">Sort by Floor Area</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '">Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sort == "property.propertyfloorarea") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '">Sort by Price</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '" selected >Sort by Floor Area</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '">Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sort == "property.propertylotarea") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '" selected>Sort by Price</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '">Sort by Floor Area</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
        echo '" selected >Sort by Lot Area</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    }

    echo '&nbsp;&nbsp;';

    if ($sequence == "DESC") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC' . "&filtersubmit=filter";
        echo '" selected>Highest First</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC' . "&filtersubmit=filter";
        echo '">Lowest First</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    } else if ($sequence == "ASC") {
        echo '<select class="form-control" onchange="location=this.value;">';
        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC' . "&filtersubmit=filter";
        echo '">Highest First</option>';

        echo '<option value="properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC' . "&filtersubmit=filter";
        echo '" selected>Lowest First</option>';

        // echo '<option value="properties.php?offertType=Presell">Sort by Lot Area</option>';
        echo '</select>';

    }

// echo '<select class="form-control" onchange="location=this.value;">';
    // echo '<option>Highest First</option>';
    // echo '<option>Lowest First</option>';
    // echo '</select>';
    echo '&nbsp;&nbsp;';
    echo '</div>';

//Do real escaping here
    $conditions = array();

    if (!empty($by_offertype)) {
        if ($by_offertype !== 'Offer Type') {
            if ($by_offertype === 'Any') {
                $conditions[] = "offertype IN ('Sell','Rent','Presell')";
            } else {
                $conditions[] = "offertype='$by_offertype'";
            }
        }

    }
    if (!empty($by_propertylocation)) {

        $conditions[] = "propertylocation='$by_propertylocation'";
    }
    if (!empty($by_propertylotarea)) {
        $conditions[] = "propertylotarea='$by_propertylotarea'";
    }
    if (!empty($by_propertyfloorarea)) {
        $conditions[] = "propertyfloorarea='$by_propertyfloorarea'";
    }
    if (!empty($by_propertytype)) {
        if ($by_propertytype !== 'Property Type') {
            if ($by_propertytype === 'Any') {
                $conditions[] = "propertytype IN ('Building','Condominium','Lots','House and Lot','Industrial','Offices','Warehouse')";
            } else {
                $conditions[] = "propertytype='$by_propertytype'";
            }
        }
    }

    if (!empty($by_minpropertybedrooms) && !empty($by_maxpropertybedrooms)) {
        $conditions[] = "propertybedrooms BETWEEN '$by_minpropertybedrooms' AND '$by_maxpropertybedrooms'";
    } else {
        if (!empty($by_minpropertybedrooms)) {
            $conditions[] = "propertybedrooms='$by_minpropertybedrooms'";
        } else if (!empty($by_maxpropertybedrooms)) {
            echo "Min Bedroom is empty";
            exit();
        }

    }

    $sql = $query;
// $test = "";
    if (count($conditions) > 0) {
        $sql .= " AND " . implode(' AND ', $conditions) . "GROUP BY property.propertyid;";

    } else {
        $sql .= "GROUP BY property.propertyid;";
    }

// echo $sql;
    $result = mysqli_query($conn, $sql);
    $number_of_results = mysqli_num_rows($result);
    $number_of_pages = ceil($number_of_results / $results_per_page);
    $this_page_first_result = ($page - 1) * $results_per_page;
    if ($number_of_results > 0) {
        echo '<nav aria-label="Page navigation example">';
        echo '<ul class="pagination justify-content-end">';
        // echo '<li class="page-item"><a class="page-link" href="#">Previous</a></li>';

        for ($pageNo = 1; $pageNo <= $number_of_pages; $pageNo++) {

            if ($pageNo == $page) {

                echo '<li class="page-item active"><a class="page-link" href="';
                echo 'properties.php??offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $pageNo . '&sort=' . $sort . '&sequence=' . $sequence . "&filtersubmit=filter";
                echo '">' . $pageNo;
                echo '</a></li>';

            } else {
                echo '<li class="page-item"><a class="page-link" href="';
                echo 'properties.php?offertype=' . $by_offertype . "&propertylocation=" . $by_propertylocation . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $pageNo . '&sort=' . $sort . '&sequence=' . $sequence . "&filtersubmit=filter";
                echo '">' . $pageNo;
                echo '</a></li>';

            }
            // echo "<a href='properties.php?offertype=" . $offertype . "&searchOption=" . $searchOption . "&query=" . $query . "page=" . $page . "'>" . $page . "</a>";
        }

        // echo '<li class="page-item"><a class="page-link" href="#">Next</a></li>';
        echo '</ul>';
        echo '</nav>';

    }
    //sql for displaying the properties
    $paginationSql = $query;

    if (count($conditions) > 0) {
        $paginationSql .= " AND " . implode(' AND ', $conditions) . "GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page . ";";

    } else {
        $paginationSql .= "GROUP BY property.propertyid ORDER BY CAST(" . $sort . " AS UNSIGNED)" . $sequence . " LIMIT " . $this_page_first_result . "," . $results_per_page . ";";
    }

    $paginationResult = mysqli_query($conn, $paginationSql);
    if (mysqli_num_rows($paginationResult) > 0) {
        while ($row = mysqli_fetch_assoc($paginationResult)) {

            $databaseFileName = $row['file_name'];
            $filename = "uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[2];

            echo " <div class='card mb-3 w-100'>";
            echo " <div class='properties-item mx-auto' onclick='viewProperty(";
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
            echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
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
    } else {
        //no property found
        echo "<br>";
        echo "<h6 style='text-align:center; color:#70945A;'>No Property found </h6>";

    }

    // if (mysqli_num_rows($result) > 0) {
    //     // while ($row = mysqli_fetch_assoc($result)) {

    //     //     $databaseFileName = $row['file_name'];
    //     //     $filename = "uploads/$databaseFileName" . "*";
    //     //     $fileInfo = glob($filename);
    //     //     $fileext = explode(".", $fileInfo[0]);
    //     //     $fileactualext = $fileext[2];

    //     //     echo " <div class='card mb-3 w-100'>";
    //     //     echo " <div class='properties-item mx-auto' onclick='viewProperty(";
    //     //     echo $row['propertyid'];
    //     //     echo ")'";
    //     //     echo ">";
    //     //     echo "<img class='card-img-top' src='";
    //     //     echo "uploads/" . $row['file_name'] . "." . $fileactualext;
    //     //     echo "' alt=''>";
    //     //     echo " </div>";
    //     //     echo " <div class='card-body'>";
    //     //     echo " <h5 class='card-title'>";
    //     //     echo $row['propertyname'];
    //     //     echo "</h5>";
    //     //     echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
    //     //     echo $row['propertylocation'];
    //     //     echo "</p>";
    //     //     echo "<div class='container'>";
    //     //     echo "<div class='row'>";

    //     //     echo "<div class='col-md-4'>";
    //     //     echo "<div class='form-group'>";
    //     //     echo " <button type='button' class='btn btn-primary w-100' onclick='viewProperty(";
    //     //     echo $row['propertyid'];
    //     //     echo ")'";
    //     //     echo "><i class='fas fa-info'></i>&nbsp; View Info</button>";

    //     //     echo "</div>";
    //     //     echo "</div>";

    //     //     echo "<div class='col-md-4'>";
    //     //     echo "<div class='form-group'>";
    //     //     echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

    //     //     echo "</div>";
    //     //     echo "</div>";

    //     //     echo "<div class='col-md-4'>";
    //     //     echo "<div class='form-group'>";
    //     //     // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
    //     //     //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
    //     //     //                     Tour</button>";
    //     //     echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
    //     //       Tour</button>");

    //     //     echo "</div>";
    //     //     echo "</div>";
    //     //     echo "</div>";
    //     //     echo "</div>";
    //     //     echo "</div>";
    //     //     echo "</div>";

    //     // }
    // } else {
    //     echo "No Data";
    // }

} else {
    //no property selected and will go to home page
    echo "<h6 style='text-align:center; color:green;'>No Property found</h6>";

}

?>
        </div>
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
<!-- <script src="js/propertySearch.js"></script> -->
<script src="js/propertyViewing.js"></script>
<script src="js/viewpropertyAgent.js"></script>
<!-- <script src="js/messages.js"></script> -->
<script src="js/indexSearch.js"></script>
<script src="js/login.js"></script>
</body>

</html>