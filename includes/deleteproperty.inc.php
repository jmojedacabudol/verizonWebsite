<?php

if (isset($_POST['propertyId'])) {
    $propertyid = $_POST['propertyId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    deleteProperty($propertyid, $conn);
    echo "Listing Deleted";
    exit();

} else {
    echo "No";
}