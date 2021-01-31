<?php

if (isset($_POST['propertyId'])) {
    $propertyid = $_POST['propertyId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (propertyAlreadyApproved($propertyid, $conn) !== false) {
        echo "Already Approved";
        exit();
    }
    approvePropertyStatus($propertyid, $conn);
    echo "Listing Approved";
    exit();

} else {
    echo "No";
}