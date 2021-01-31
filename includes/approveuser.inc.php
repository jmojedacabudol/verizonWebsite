<?php

if (isset($_POST['userId'])) {

    $userid = $_POST['userId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (userAlreadyApproved($userid, $conn) !== false) {
        echo "Already Approved";
        exit();
    }
    denyUserStatus($userid, $conn);
    echo "User Approved";
    exit();

} else {
    echo "No";
}