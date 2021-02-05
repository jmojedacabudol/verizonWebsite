<?php

if (isset($_POST['campaignId'])) {
    include_once 'dbh.inc.php';

    $propertyId = $_POST['campaignId'];
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
            // echo "<p class='mproperties-desc'>";
            // echo $row['propertyname'];
            // echo "</p>";
            echo "<p class='mproperties-desc'>Description";
            echo "</p>";
            echo "<p class='mproperties-subdesc'>";
            echo $row['propertydesc'];
            echo "</p> <br>";

            echo "<p class='mproperties-desc'>Location";
            echo "</p>";
            echo $row['propertylocation'];
            echo "<br>";
            echo "<br>";
            echo " <!--Properties-Bedrooms--->";
            echo "<div class='container'>";
            echo "<div class='row'>";
            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-bed'></i>&nbsp";
            echo $row['propertybedrooms'];
            echo "</b><br>";
            echo "<p class='mproperties-br2'> Bed rooms </p>";
            echo "</div>";

            echo " <div class='col-sm mproperties-features'>";
            echo "<b class='mproperties-br1'> <i class='fas fa-car'></i>&nbsp;";
            echo $row['propertycarpark'];
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