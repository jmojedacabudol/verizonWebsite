<?php

if (isset($_POST['userId'])) {
    $userid = $_POST['userId'];
    // echo $userid;
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    echo deleteUser($userid, $conn);
    exit();

} else {
    echo "No User Found";
}