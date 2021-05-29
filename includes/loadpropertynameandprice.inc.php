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

            echo " <h2 class='properties-modal-title text-secondary text-uppercase mb-0'>";
            echo $row['propertyname'];
            echo "</h2>";
            echo "<h5 class='text-uppercase mproperties-price'> ₱ ";
            if ($row['propertyrentchoice'] === null) {
                // echo $row['propertyamount'];
                echo $row['propertyamount'];

            } else {
                echo $row['propertyamount'] . "/" . $row['propertyrentchoice'];
                // echo $row['propertyamount'] . "/" . $row['propertyrentchoice'];
            }
            echo "</h5>";

        }
    }
}