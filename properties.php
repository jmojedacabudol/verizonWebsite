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
                        <div class="col-md-3">
                            <div class="form-group">

                                <?php
// the link come from "search" at index
//SEARCH FILTER

//check if there are items inside forms to save after page refresh
if (isset($_GET['offertype'])) {
    $offertype = $_GET['offertype'];
    // echo $offertype;
} else {
    $offertype = 'Any';

}

if (isset($_GET['offertype'])) {
    $offertype = $_GET['offertype'];
    // echo $offertype;
} else {
    $offertype = 'Any';

}

if (isset($_GET['subType'])) {
    $subType = $_GET['subType'];
    // echo $offertype;
} else {
    $subType = '';
}

if (isset($_GET['city'])) {
    $city = $_GET['city'];
} else {
    $city = '';
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
if (isset($_GET['propertytype'])) {
    $propertytype = $_GET['propertytype'];
} else {
    $propertytype = 'Any';
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

//OFFFER TYPE
echo '<select name="offertype" id=offerType class="form-control">';
if ($offertype == 'Sell') {
    echo '<option hidden>Offer Type</option>';
    echo '<option>Any</option>';
    echo '<option value="Sell" selected>For Sale</option>';
    echo '<option value="Rent">For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

} else if ($offertype == 'Rent') {
    echo '<option hidden>Offer Type</option>';
    echo '<option>Any</option>';
    echo '<option value="Sell">For Sale</option>';
    echo '<option value="Rent"selected>For Rent</option>';
    echo '<option value="Presell">Preselling</option>';

} else if ($offertype == 'Presell') {
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

//LOCATION

echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo ' <div class="input-group-prepend">';
echo '   <span class="input-group-text" id="basic-addon1"><i
                                                class="fas fa-map-marker-alt"></i></span>';
echo '</div>';
echo '<input type="text" name="city" class="form-control"
                                        placeholder="Enter Location" aria-label="Location" value="';
echo $city;
echo '"aria-describedby="basic-addon1">';
echo '</div>';
echo '</div>';
echo '</div>';

//LOT AREA

echo '   <div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo '  <div class="input-group-prepend">';
echo ' <a class="btn btn-success disabled" id="lotAreaBtn">Lot
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

//FLOOR AREA

echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<div class="input-group w-100">';
echo '     <div class="input-group-prepend">';
echo '   <a class="btn btn-success disabled" id="floorAreaBtn">Floor
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

//PROPERTY TYPE

echo '<div class="row align-left text-black">';
echo '<div class="col-md-3">';
echo '<div class="form-group">';
echo '<select name="propertytype" id=propertyType class="form-control" onchange="subCategoryDisplay(this.value)">';
if ($propertytype == 'Building') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option selected>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Condominium') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option selected>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Lot') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option selected>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'House and Lot') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option selected>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Office') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option selected>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Warehouse') {
    echo '<option hidden>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option selected>Warehouse</option>';

} else if ($propertytype == 'Any') {
    echo '<option hidden>Property Type</option>';
    echo '<option selected>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == '') {
    echo '<option hidden selected>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

} else if ($propertytype == 'Property Type') {
    echo '<option hidden selected>Property Type</option>';
    echo '<option>Any</option>';
    echo '<option>Building</option>';
    echo '<option>Condominium</option>';
    echo '<option>Lot</option>';
    echo '<option>House and Lot</option>';
    echo '<option>Office</option>';
    echo '<option>Warehouse</option>';

}
echo '</select>';

echo '</div>';
echo '</div>';

//SUB CATEGORY
if ($propertytype === "Building") {
    echo '<div class="col-md-3" id="subCategoryHolder">';
    echo '<div class="form-group">';
    echo '<select name="subType" id=subCategory class="form-control">';

    if ($subType === "Residential") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option selected>Residential</option>';
        echo '<option>Commercial</option>';

    } else {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Residential</option>';
        echo '<option selected>Commercial</option>';

    }

    echo '</select>';
    echo '</div>';
    echo '</div>';

} else if ($propertytype === "Condominium") {
    echo '<div class="col-md-3" id="subCategoryHolder">';
    echo '<div class="form-group">';
    echo '<select name="subType" id=subCategory class="form-control">';

    if ($subType === "Residential") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option selected>Residential</option>';
        echo '<option>Commercial</option>';
        echo '<option>Parking</option>';

    } else if ($subType === "Parking") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Residential</option>';
        echo '<option>Commercial</option>';
        echo '<option selected>Parking</option>';

    } else if ($subType === "Commercial") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Residential</option>';
        echo '<option selected>Commercial</option>';
        echo '<option>Parking</option>';

    }

    echo '</select>';
    echo '</div>';
    echo '</div>';

} else if ($propertytype === "Lot") {
    echo ' <div class="col-md-3" id="subCategoryHolder">';
    echo '<div class="form-group">';
    echo '<select name="subType" id=subCategory class="form-control">';

    if ($subType === "Agricultural") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option selected>Agricultural</option>';
        echo '<option>Commercial</option>';
        echo '<option>Residential</option>';
        echo '<option>Industrial</option>';

    } else if ($subType === "Commercial") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Agricutural</option>';
        echo '<option selected>Commercial</option>';
        echo '<option>Residential</option>';
        echo '<option>Industrial</option>';

    } else if ($subType === "Residential") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Agricutural</option>';
        echo '<option>Commercial</option>';
        echo '<option selected>Residential</option>';
        echo '<option>Industrial</option>';

    } else if ($subType === "Industrial") {
        echo '<option hidden>Property Sub Category</option>';
        echo '<option>Agricutural</option>';
        echo '<option>Commercial</option>';
        echo '<option>Residential</option>';
        echo '<option selected>Industrial</option>';

    }

    echo '</select>';
    echo '</div>';
    echo '</div>';

} else {
    echo ' <div class="col-md-3 hidden" id="subCategoryHolder">';
    echo '<div class="form-group">';
    echo '<select name="subType" id=subCategory class="form-control">';
    echo '</select>';
    echo '</div>';
    echo '</div>';

}

//MIN BEDROOMS

echo ' <div class="col-md-3">';
echo ' <div class="form-group">';
echo '<input type="number"  max="10" class="form-control"
                                    placeholder="Minimum No. of Bedrooms"  name="minpropertybedrooms"aria-label=""
                                    aria-describedby="button-addon3" value="';
echo $minpropertybedrooms . '">';

echo '</div>';
echo '</div>';

//MAX BEDROOMS
echo ' <div class="col-md-3">';
echo '<div class="form-group">';
echo '<input type="number"  max="10" class="form-control"
                                    placeholder="Maximum No. of Bedrooms" name="maxpropertybedrooms" aria-label=""
                                    aria-describedby="button-addon3" value="';
echo $maxpropertybedrooms . '">';
echo '</div>';
echo '</div>';

echo '<div class="col-md-12">';
echo '      <div class="form-group">';
echo '    <button type="submit" class="btn btn-primary w-100">Search</button>';
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
$query = "SELECT property.propertyid, property.usersId,property.propertyname,property.city,MIN(images.file_name)AS file_name FROM property,images  WHERE  property.propertyid = images.propertyid AND property.approval IN ('Posted','On-Going')";

$by_offertype = $offertype;

if (isset($_GET['searchOption'])) {
    $by_searchOption = $_GET['searchOption'];

} else {
    $by_searchOption;
}

$by_query;
if (isset($_GET['query'])) {
    $by_query = $_GET['query'];

} else {
    $by_query;

}

$by_city = $city;
$by_lotarea = $lotarea;
$by_floorarea = $floorarea;
$by_propertytype = $propertytype;
$by_minpropertybedrooms = $minpropertybedrooms;
$by_maxpropertybedrooms = $maxpropertybedrooms;
$by_subType = $subType;

// for pagination
$results_per_page = 5;

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
    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '" selected>Sort by Price</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '">Sort by Floor Area</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '">Sort by Lot Area</option>';

    echo '</select>';

} else if ($sort == "property.propertyfloorarea") {
    echo '<select class="form-control" onchange="location=this.value;">';
    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '">Sort by Price</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '" selected >Sort by Floor Area</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '">Sort by Lot Area</option>';

    echo '</select>';

} else if ($sort == "property.propertylotarea") {
    echo '<select class="form-control" onchange="location=this.value;">';
    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyamount' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '" selected>Sort by Price</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertyfloorarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '">Sort by Floor Area</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=property.propertylotarea' . '&sequence=' . $sequence . "&filtersubmit=filter";
    echo '" selected >Sort by Lot Area</option>';

    echo '</select>';

}

echo '&nbsp;&nbsp;';

if ($sequence == "DESC") {
    echo '<select class="form-control" onchange="location=this.value;">';
    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC' . "&filtersubmit=filter";
    echo '" selected>Highest First</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC' . "&filtersubmit=filter";
    echo '">Lowest First</option>';

    echo '</select>';

} else if ($sequence == "ASC") {
    echo '<select class="form-control" onchange="location=this.value;">';
    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=DESC' . "&filtersubmit=filter";
    echo '">Highest First</option>';

    echo '<option value="properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $page . '&sort=' . $sort . '&sequence=ASC' . "&filtersubmit=filter";
    echo '" selected>Lowest First</option>';

    echo '</select>';

}

echo '&nbsp;&nbsp;';
echo '</div>';

$conditions = array();
if (!empty($by_searchOption)) {
    if ($by_searchOption === 'property-name') {
        if (!empty($by_query)) {
            $conditions[] = "propertyname LIKE" . "'%" . mysqli_real_escape_string($conn, $by_query) . "%'";
        }

    } else if ($by_searchOption === 'property-location') {
        if (!empty($by_query)) {
            $conditions[] = "RoomFloorUnitNoBuilding LIKE" . "'%" . mysqli_real_escape_string($conn, $by_query) . "%' OR HouseLotBlockNo LIKE " . "'%" . mysqli_real_escape_string($conn, $by_query) . "%' OR street LIKE '%" . mysqli_real_escape_string($conn, $by_query) . "%' OR subdivision LIKE '%" . mysqli_real_escape_string($conn, $by_query) . "%' OR barangay LIKE '%" . mysqli_real_escape_string($conn, $by_query) . "%' OR city LIKE '%" . mysqli_real_escape_string($conn, $by_query) . "%'";
        }
    }
}

if (!empty($by_offertype)) {
    if ($by_offertype !== 'Offer Type') {
        if ($by_offertype === 'Any') {
            $conditions[] = "offertype IN ('Sell','Rent','Presell')";
        } else {
            $conditions[] = "offertype=" . "'" . mysqli_real_escape_string($conn, $by_offertype) . "'";
        }
    }

}

if (!empty($by_city)) {
    $conditions[] = "city=" . "'" . mysqli_real_escape_string($conn, $by_city) . "'";
}
if (!empty($by_lotarea)) {
    $conditions[] = "propertylotarea=" . "'" . mysqli_real_escape_string($conn, $by_lotarea) . "'";
}
if (!empty($by_floorarea)) {
    $conditions[] = "propertyfloorarea=" . "'" . mysqli_real_escape_string($conn, $by_floorarea) . "'";
}
if (!empty($by_propertytype)) {
    if ($by_propertytype !== 'Property Type') {
        if ($by_propertytype === 'Any') {
            $conditions[] = "propertytype IN ('Building','Condominium','Lot','House and Lot','Office','Warehouse')";
        } else {
            $conditions[] = "propertytype=" . "'" . mysqli_real_escape_string($conn, $by_propertytype) . "'";
        }
    }
}

if (!empty($by_subType)) {
    $conditions[] = "subcategory=" . "'" . mysqli_real_escape_string($conn, $by_subType) . "'";

}

if (!empty($by_minpropertybedrooms) && !empty($by_maxpropertybedrooms)) {
    $conditions[] = "propertybedrooms BETWEEN '$by_minpropertybedrooms' AND '$by_maxpropertybedrooms'";
} else {
    if (!empty($by_minpropertybedrooms)) {
        $conditions[] = "propertybedrooms=" . "'" . mysqli_real_escape_string($conn, $by_minpropertybedrooms) . "'";
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

echo $sql;

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
            echo 'properties.php??offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $pageNo . '&sort=' . $sort . '&sequence=' . $sequence . "&filtersubmit=filter";
            echo '">' . $pageNo;
            echo '</a></li>';

        } else {
            echo '<li class="page-item"><a class="page-link" href="';
            echo 'properties.php?offertype=' . $by_offertype . "&city=" . $by_city . "&lotarea=" . $by_propertylotarea . "&floorarea=" . $by_propertyfloorarea . "&propertytype=" . $by_propertytype . "&minpropertybedrooms=" . $by_minpropertybedrooms . "&maxpropertybedrooms=" . $by_maxpropertybedrooms . '&page=' . $pageNo . '&sort=' . $sort . '&sequence=' . $sequence . "&filtersubmit=filter";
            echo '">' . $pageNo;
            echo '</a></li>';

        }

    }

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
        echo "<img class='card-img-top img-properties' src='";
        echo "uploads/" . $row['file_name'] . "." . $fileactualext;
        echo "' alt=''>";
        echo " </div>";
        echo " <div class='card-body'>";
        echo " <h5 class='card-title'>";
        echo ucwords($row['propertyname']);
        echo "</h5>";
        echo "<p class='card-text'> <i class='fas fa-map-marker-alt'></i>&nbsp;";
        echo $row['city'];
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
<script src="js/propertiesdisplay.js"></script>
</body>

</html>