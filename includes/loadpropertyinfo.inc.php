<?php

if (isset($_POST['propertyId'])) {
    include_once 'dbh.inc.php';

    $propertyId = $_POST['propertyId'];
    $sql = "SELECT * FROM property WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $propertyId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $counter = 0;
    // $flag = 0;

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            echo "<div class='container'>";
            echo " <img class='img-fluid rounded mb-5' src='uploads/";
            echo $row['propertyimage'] . ".jpg'";
            echo "  alt=''/>";
            echo "</div>";
            echo "<!-- properties Modal - Details-->";
            echo "<h4 class='text-uppercase mproperties-available'> <i class='fas fa-home icon-green'></i>
     AVAILABLE &nbsp;</h4>";
            echo "<hr> ";
            echo "</hr>";
            echo "<p class='mproperties-desc'>Description";
            echo "</p>";
            echo "<pre class='mproperties-subdesc'>";
            echo $row['propertydesc'];
            echo "</pre> <br>";

            echo "<p class='mproperties-desc'>Location";
            echo "</p>";
            echo completeAddress($row['RoomFloorUnitNoBuilding'], $row['HouseLotBlockNo'], $row['street'], $row['subdivision'], $row['barangay'], $row['city']);
            echo "<br>";
            echo "<br>";
            echo " <!--Properties-Bedrooms--->";
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-bed'></i>&nbsp";
            if ($row['propertybedrooms'] == null) {
                echo "0";

            } else {
                echo $row['propertybedrooms'];

            }
            echo "</b><br>";
            echo "<p class='mproperties-br2'> Bed rooms </p>";
            echo "</div>";

            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-car'></i>&nbsp;";
            if ($row['propertycarpark'] == null) {
                echo "0";

            } else {
                echo $row['propertycarpark'];

            }
            echo "</b><br>";
            echo "<p class='mproperties-br2'> Car Parks </p>";
            echo "</div>";

            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-border-all'></i>&nbsp;";
            echo $row['propertyfloorarea'];
            echo "</b><br>";
            echo "<p class='mproperties-br2'> Floor Area  </p>";
            echo "</div>";

            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-ruler-combined'></i>&nbsp;";
            echo $row['propertylotarea'];
            echo "</b><br>";
            echo "<p class='mproperties-br2'> Lot Area </p>";
            echo "</div>";

        }
    }
}

function completeAddress($RFUB, $HLB, $street, $subdivision, $barangay, $city)
{

    if ($RFUB != null && $HLB != null && $street != null && $subdivision != null && $barangay != null && $city != null) {
        //all is not empty
        return ucfirst($RFUB) . " " . ucfirst($HLB) . " " . ucfirst($street) . " " . ucfirst($subdivision) . " " . ucfirst($barangay) . ", " . ucfirst($city);
    } else if ($RFUB == null && $HLB != null && $street != null && $subdivision != null && $barangay != null && $city != null) {
        //RFUB is  empty
        return ucfirst($HLB) . " " . ucfirst($street) . " " . ucfirst($subdivision) . " " . ucfirst($barangay) . ", " . ucfirst($city);

    } else if ($RFUB != null && $HLB == null && $street != null && $subdivision != null && $barangay != null && $city != null) {
        //HLB is  empty
        return ucfirst($RFUB) . " " . ucfirst($street) . " " . ucfirst($subdivision) . " " . ucfirst($barangay) . ", " . ucfirst($city);

    } else if ($RFUB == null && $HLB != null && $street != null && $subdivision == null && $barangay != null && $city != null) {
        //RFUB and subdivision is  empty
        return ucfirst($HLB) . " " . ucfirst($street) . " " . ucfirst($barangay) . ", " . ucfirst($city);

    } else if ($RFUB != null && $HLB == null && $street != null && $subdivision == null && $barangay != null && $city != null) {
        //HLB and subdivision is  empty
        return ucfirst($RFUB) . " " . ucfirst($street) . " " . ucfirst($barangay) . ", " . ucfirst($city);

    }

}