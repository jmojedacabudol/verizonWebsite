<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['addClientBtn'])) {
    // $clients = json_decode(stripslashes($_POST['clients']), true);
    // print_r($_FILES['firstValidId']);
    $fName = $_POST['fName'];
    $mName = $_POST['mName'];
    $lName = $_POST['lName'];
    $clientMobileNumber = $_POST['clientMobileNumber'];
    $clientLandlineNumber = $_POST['clientLandlineNumber'];
    $emailAddress = $_POST['emailAddress'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $clientAge = $_POST['clientAge'];
    $civilStatus = $_POST['civilStatus'];
    $firstValidIdHolder = $_FILES['firstValidIdHolder'];
    $secondValidIdHolder = $_FILES['secondValidIdHolder'];
    $clientRFUB = $_POST['clientRFUB'];
    $clientHLB = $_POST['clientHLB'];
    $clientStreet = $_POST['clientStreet'];
    //subdivision can be empty
    $subdivision = $_POST['subdivision'];
    $clientBrgyAddress = $_POST['clientBrgyAddress'];
    $clientCityAddress = $_POST['clientCityAddress'];
    $companyName = $_POST['companyName'];
    $companyInitalAddress = $_POST['companyInitalAddress'];
    $companyStreet = $_POST['companyStreet'];
    $companyBrgyAddress = $_POST['companyBrgyAddress'];
    $companyCityAddress = $_POST['companyCityAddress'];
    $areaCode = $_POST['clientLocalLandlineNumber'];

    //check first the size/s of all img/s of Property
    if (invalidImgSize($firstValidIdHolder)) {
        //return the error
        echo "First Valid Id Image is too large.";
        exit();
    }
    if (invalidImgSize($secondValidIdHolder)) {
        //return the error
        echo "Second Valid Id Image is too large.";
        exit();
    }

    //insert to table
    $result = insertClientInformation($conn, $fName, $mName, $lName, $clientMobileNumber, $clientLandlineNumber, $emailAddress, $birthday, $gender, $clientAge, $civilStatus, $clientRFUB, $clientHLB, $clientStreet, $subdivision, $clientBrgyAddress, $clientCityAddress, $companyName, $companyInitalAddress, $companyStreet, $companyBrgyAddress, $companyCityAddress, $firstValidIdHolder, $secondValidIdHolder, $areaCode);
    echo $result;

} else {
    echo "Error finding Clients";
}