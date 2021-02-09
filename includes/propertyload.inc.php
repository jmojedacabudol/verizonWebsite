<?php

if (isset($_POST['location'])) {
    $string = strtolower($_POST['location']);
    $offertype = $_POST['offertype'];
    $userlogged = "no-user";
    session_start();

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }
    include_once 'dbh.inc.php';

    if ($string === "") {
        $sql = "SELECT property.propertyid,usersId,propertyamount,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.offertype= ? AND property.approval  NOT IN (0, 2, 3) GROUP BY property.propertyid DESC LIMIT 3";

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
                echo "uploads/" .$row['file_name'] . "." . $fileactualext;
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
            echo "No data";
            mysqli_stmt_close($stmt);

        }

    } else {
        $location = "%$string%";

        $sql = "SELECT property.propertyid,propertyamount,usersId,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND  propertylocation LIKE ? AND offertype=? AND property.approval  NOT IN (0, 2, 3) GROUP BY property.propertyid";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {

            echo "<tr>";
            echo "SQL ERROR";
            echo "</tr>";
            exit();
        }
        mysqli_stmt_bind_param($stmt, 'ss', $location, $offertype);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
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
                echo "uploads/" .$row['file_name'] . "." . $fileactualext;
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
                echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
                      Tour</button>");

                // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
                //                     data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
                //                     Tour</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }
            mysqli_stmt_close($stmt);

        } else {
            echo "No data";
            mysqli_stmt_close($stmt);

        }
    }
} else if (isset($_POST['propertyType'])) {
    $propertyType = $_POST['propertyType'];
    $userlogged = "no-user";
    session_start();

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }

    include_once 'dbh.inc.php';

    $sql = "SELECT property.propertyid,propertyamount,usersId,propertydesc,propertyname, propertybedrooms,property.propertylocation,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.propertytype=? AND property.approval  NOT IN (0, 2, 3) GROUP BY property.propertyid";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {

        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $propertyType);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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
           echo "uploads/" .$row['file_name'] . "." . $fileactualext;
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

            echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $row['propertyid'] . "\",\"" . $row['propertyname'] . "\",\"" . $row['usersId'] . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
                      Tour</button>");

            // echo " <button type='button' class='btn btn-primary w-100' data-toggle='modal'
            //                         data-target='#bookaTourModal'><i class='fas fa-info'></i>&nbsp; Book a
            //                         Tour</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";

        }
        mysqli_stmt_close($stmt);
    } else {
        echo "No Data";
    }
} else {
    echo "No Data";
}