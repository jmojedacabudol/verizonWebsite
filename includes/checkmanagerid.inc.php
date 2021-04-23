<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['managerId'])) {
    $managerId = $_POST['managerId'];

    $checkManagerId = checkManagerId($managerId, $conn);
    echo $checkManagerId;
    // if (checkManagerId($managerId, $conn) !== false) {
    //     //no manager Found
    //     echo 'No Manager Found!';
    //     // exit();
    // }
}