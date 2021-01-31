<?php

if (isset($_POST['propertyId'])) {
    $propertyid = $_POST['propertyId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (propertyAlreadydenied($propertyid, $conn) !== false) {
        echo "Already Denied";
        exit();
    }
    denyPropertyStatus($propertyid, $conn);
    echo "Listing Denied";
    exit();

} else {
    echo "No";
}