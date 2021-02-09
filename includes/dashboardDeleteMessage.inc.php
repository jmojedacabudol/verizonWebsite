<?php

require_once 'dbh.inc.php';

if (isset($_POST['messageId'])) {
    $messageId = $_POST['messageId'];
    $sql = "DELETE FROM messages WHERE messageId=?;";
    $result = '';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = 'Oppss Something Happened';
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $messageId);
        mysqli_stmt_execute($stmt);
        $result = 'Success';
        mysqli_stmt_close($stmt);
    }
    echo $result;
}
