<?php

if (isset($_POST['propertyId'])) {
    include_once 'dbh.inc.php';
    $userlogged = "no-user";
    $propertid;
    $propertyname;
    session_start();

    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    }

    $propertyId = $_POST['propertyId'];
    $sql = "SELECT P.usersId,P.propertyname,P.propertyid,C.file_name FROM property P INNER JOIN images C ON C.propertyid = P.propertyid WHERE C.propertyid=?";
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

        echo '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">';
        echo '<div class="carousel-inner h-400">';

        while ($row = mysqli_fetch_assoc($result)) {
            $propertid = $row['propertyid'];
            $propertyname = $row['propertyname'];
            $databaseFileName = $row['file_name'];
            $usersId = $row['usersId'];
            $fileName = "../uploads/$databaseFileName" . "*";
            $info = glob($fileName);
            $fileext = explode(".", $info[0]);
            $fileactualext = $fileext[4];
            // print_r($fileactualext);

            if ($counter === 0) {
                echo '<div class="carousel-item active" >';

                echo '<img src="uploads/' . $row['file_name'] . "." . $fileactualext . '" class="d-block img-property" alt="..." >';
                echo "</div>";
            } else {
                echo '<div class="carousel-item">';
                echo '<img src="uploads/' . $row['file_name'] . "." . $fileactualext . '" class="d-block img-property" alt="..." >';
                echo "</div>";
            }
            // $flag++;
            $counter++;
        }
        echo '</div>';
        echo '<a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>';

        echo '</div> <br><br>';

        // echo "<div class='col-md-4'>";
        // echo "<div class='form-group'>";
        echo (" <button type='button' class='btn btn-primary w-100' onclick='viewAgent(\"" . $userlogged . "\" ,\"" . $propertid . "\")'><i class='fas fa-user'></i>&nbsp; Contact Agent</button>");

        // echo "</div>";
        // echo "</div>";

        // echo "<div class='col-md-4'>";
        echo "<div class='form-group'>";

        echo (" <button type='button' class='btn btn-primary w-100' onclick='viewPropertyCalendar(\"" . $userlogged . "\" ,\"" . $propertid . "\",\"" . $propertyname . "\",\"" . $usersId . "\" )'><i class='fas fa-info'></i>&nbsp; Book a
                      Tour</button>");
        echo "</div>";
        // echo "</div>";

    } else {
        echo "<tr>";
        echo "No Data";
        echo "</tr>";
    }

}