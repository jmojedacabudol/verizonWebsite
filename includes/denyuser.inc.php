<?php

if (isset($_POST['userId'])) {
    $userid = $_POST['userId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (userAlreadydenied($userid, $conn) !== false) {
        echo "Already Denied";
        // exit();
    } else {
        denyUserStatus($userid, $conn);
        echo "User Denied";
        // exit();

    }

} else {
    echo "No";
}