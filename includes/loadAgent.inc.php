<?php

if (isset($_POST['propertyId'])) {

    $agent = $_POST['propertyId'];
    include_once 'dbh.inc.php';
    $sql = "SELECT usersFirstName,userLastName,usersMobileNumber,usersEmail FROM users WHERE usersId in (SELECT usersid FROM property WHERE propertyid=?);";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<tr>";
        echo "SQL ERROR";
        echo "</tr>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $agent);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "  <h5 class='card-title'>";
            echo $row['usersFirstName'] . " " . $row['userLastName'];
            echo "</h5>";
            echo " <p class='card-text'>";
            echo $row['usersMobileNumber'];
            echo "</p>";
            echo "<p class='card-text'>";
            echo $row['usersEmail'];
            echo "</p>";

        }
    }

} else {
    echo "Encountered Error";
}