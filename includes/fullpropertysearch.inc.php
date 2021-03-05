<?php
$query = "SELECT property.propertyid, property.usersId,property.propertyname,property.propertylocation,MIN(images.file_name)AS file_name FROM property,images  WHERE  property.propertyid = images.propertyid AND property.approval  NOT IN (0, 2, 3)";

require_once 'dbh.inc.php';

$by_offertype = $_POST['offertype'];
$by_propertylocation = $_POST['propertylocation'];
$by_propertylotarea = $_POST['lotarea'];
$by_propertyfloorarea = $_POST['floorarea'];
$by_propertytype = $_POST['propertytype'];
$by_minpropertybedrooms = $_POST['minpropertybedrooms'];
$by_maxpropertybedrooms = $_POST['maxpropertybedrooms'];

$userlogged = "no-user";
session_start();

if (isset($_SESSION['userid'])) {
    $userlogged = $_SESSION['userid'];
}

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
            $conditions[] = "propertytype IN ('Building','Condominium','Lots','House','Industrial','Offices','Warehouse')";
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

require_once 'dbh.inc.php';

$sql = $query;
// $test = "";
if (count($conditions) > 0) {
    $sql .= " AND " . implode(' AND ', $conditions) . "GROUP BY property.propertyid DESC LIMIT 10";

} else {
    $sql .= "GROUP BY property.propertyid DESC LIMIT 3";
}

$sql .= ";";
// echo $sql;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $databaseFileName = $row['file_name'];
        $filename = "../uploads/$databaseFileName" . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);
        $fileactualext = $fileext[4];

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
} else {
    echo "No Data";
}

//return $result;

//$result = mysqli_query($conn, $sql);

// if (mysqli_num_rows($result) > 0) {
//     echo "Madami";
// } else {
//     echo "Konti";
// }

// $offerType = $_GET['offerType'];
// $location = $_GET['location'];
// $lotArea = $_GET['onlyNumbers1'];
// $floorArea = $_GET['onlyNumber2'];
// $propertyType = $_GET['propertyType'];
// $minBedrooms = $_GET['minbr'];
// $maxBedrooms = $_GET['maxbr'];

// if ($offerType == "Offer Type") {
//     $offerType = "Any";
// }
// if ($location == "") {
//     $location = "Any";
// }

// if ($floorArea == "" && $location == "") {
//     $floorArea = "Any";
//     $lotArea = "Any";
// } else if ($floorArea != "") {
//     if ($propertyType == "Property Type") {
//         $propertyType = "Any";
//     }
// }

// if ($offerType == "Offer Type") {
//     $offerType = "Any";
// }
// if ($offerType == "Offer Type") {
//     $offerType = "Any";
// }

// echo $offerType, $location, $lotArea, $floorArea, $propertyType, $minBedrooms, $maxBedrooms;

// require_once 'dbh.inc.php';
// require_once 'functions.inc.php';

// if (minGreaterThanMax($minBedrooms, $maxBedrooms) !== false) {
//     echo "1";
//     exit();
// }

// $property = searchProperty($offerType, $location, $lotArea, $floorArea, $propertyType, $minBedrooms, $maxBedrooms);

// echo json_encode($property);

//exit();