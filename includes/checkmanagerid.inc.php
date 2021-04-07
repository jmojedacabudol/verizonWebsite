<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['managerId'])) {
    $managerId = $_POST['managerId'];
    if (checkManagerId($managerId, $conn) !== 1) {
        //no manager Found
        echo 'No Manager Found!';
        // exit();
    }
}