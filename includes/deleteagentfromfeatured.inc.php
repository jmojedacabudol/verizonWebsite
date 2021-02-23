<?php

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    require_once 'dbh.inc.php';

    $sql = "DELETE FROM featuredAgent WHERE featId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Statement Failed!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        echo "Success";
    }

}