<?php

if (isset($_POST['userId'])) {
    $userid = $_POST['userId'];
    // echo $userid;
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    deleteUser($userid, $conn);
    echo "User Deleted";
    exit();

} else {
    echo "No";
}