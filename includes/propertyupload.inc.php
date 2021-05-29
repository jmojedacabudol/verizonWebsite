<?php
if (isset($_POST['submit'])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    session_start();

//all variables that have value of "null" will have a certain value in a condition

    $propertyImage = $_FILES['listingImage'];
    $propertyName = $_POST['listingTitle'];
    $propertyType = $_POST['listingType'];
    $listingUnitNo = null;

    if (isset($_POST['listingUnitNo']) && $_POST['listingUnitNo'] !== "") {
        $listingUnitNo = $_POST['listingUnitNo'];
    }

    $listingSubCategory = null;
    if (isset($_POST['listingSubCategory']) && $_POST['listingSubCategory'] !== "") {
        $listingSubCategory = $_POST['listingSubCategory'];
    }

    $listingOfferType = null;
    if (isset($_POST['listingOfferType']) && $_POST['listingOfferType'] !== "") {
        $listingOfferType = $_POST['listingOfferType'];
    }

    $listingPrice = $_POST['listingPrice'];

    $listingRentChoice = null;
    if (isset($_POST['listingRentChoice']) && $_POST['listingRentChoice'] !== "") {
        $listingRentChoice = $_POST['listingRentChoice'];
    }

    $listingLotArea = null;
    if (isset($_POST['listingLotArea']) && $_POST['listingLotArea'] !== "") {
        $listingLotArea = $_POST['listingLotArea'];
    }

    $listingFloorArea = null;
    if (isset($_POST['listingFloorArea']) && $_POST['listingFloorArea'] !== "") {
        $listingFloorArea = $_POST['listingFloorArea'];
    }

    $listingBedrooms = null;
    if (isset($_POST['listingBedrooms']) && $_POST['listingBedrooms'] !== "") {
        $listingBedrooms = $_POST['listingBedrooms'];
    }

    $listingCapacityOfGarage = null;

    $listingCapacityOfGarage = null;
    if (isset($_POST['listingCapacityOfGarage']) && $_POST['listingCapacityOfGarage'] !== "") {
        $listingCapacityOfGarage = $_POST['listingCapacityOfGarage'];
    }

    $propertyDesc = $_POST['listingDesc'];
    $propertyATS = $_FILES['listingATS'];
    $listingRFUB = $_POST['listingRFUB'];
    $listingHLB = $_POST['listingHLB'];
    $listingStreet = $_POST['listingStreet'];
    $listingSubdivision = $_POST['listingSubdivision'];
    $listingBrgyAddress = $_POST['listingBrgyAddress'];
    $listingCityAddress = $_POST['listingCityAddress'];
    $propertyOwner = $_SESSION['userid'];

    //check first the size/s of all img/s of Property
    if (checkPropertyImgSize($propertyImage)) {
        //return the error
        echo "Property Image/s is too large.";
        exit();
    }

    //check for size of ATS file
    if (invalidATSSize($propertyATS)) {
        echo "ATS file is too large.";
        exit();
    }

    //UPLOAD THE PROPERTY
    $result = uploadProperty($conn, $propertyImage, $propertyName, $propertyType, $listingUnitNo, $listingSubCategory, $listingOfferType, $listingPrice, $listingRentChoice, $listingLotArea, $listingFloorArea, $listingBedrooms, $listingCapacityOfGarage, $propertyDesc, $propertyATS, $listingRFUB, $listingHLB, $listingStreet, $listingSubdivision, $listingBrgyAddress, $listingCityAddress, $propertyOwner);

    echo $result;
    exit();

} else {
    echo "Error submitting Property Information: Contact Developer!";

}