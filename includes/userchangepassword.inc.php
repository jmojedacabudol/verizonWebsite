<?php
require_once 'dbh.inc.php';

if (isset($_POST['userpassword']) && isset($_POST['agentId'])) {
    $usersId = $_POST['agentId'];
    $password = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET usersPwd=? WHERE usersId=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Oppss Something Happened';
    } else {
        mysqli_stmt_bind_param($stmt, 'ss', $password, $usersId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo 'Success';
    }

} else {
    echo "No User Found";
}