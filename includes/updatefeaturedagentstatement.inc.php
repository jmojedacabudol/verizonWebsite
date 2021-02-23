<?php

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $newdescription = $_POST['newdescription'];
    require_once 'dbh.inc.php';

    $sql = "UPDATE property SET approval = 1  WHERE propertyid=?;";

    $sql = "UPDATE featuredAgent SET description =? WHERE featId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Statement Failed!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ss', $newdescription, $userId);
        mysqli_stmt_execute($stmt);
        echo "Success";
    }

}