<?php

if (isset($_POST['managerId'])) {
    $managerId = $_POST['managerId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $result = denyManager($conn, $managerId);
    echo $result;

}