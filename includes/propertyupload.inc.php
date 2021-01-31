<?php
if (isset($_POST['submit'])) {
    session_start();
    $propertyName = $_POST['listing-title'];
    $propertyOfferType = $_POST['listing-offer-type'];
    $propertyLocation = $_POST['listing-location'];
    $propertyType = $_POST['listing-type'];
    $propertyLotArea = $_POST['listing-lot-area'];
    $propertyFloorArea = $_POST['listing-floor-area'];
    $propertyBedroom = $_POST['listing-bedroom'];
    $propertyCarpark = $_POST['listing-carpark'];
    $propertyRentChoice = $_POST['listing-rentChoice'];
    $propertyAmount = $_POST['listing-price'];
    $propertyDesc = $_POST['listing-desc'];
    $propertyImage = $_FILES['listing-image'];
    $propertyOwner = $_SESSION['userid'];

    // echo $propertyImage;
    // $errorEmpty = false;
    // $errorImage = false;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // // echo $propertyName, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyAmount, $propertyDesc;
    if (emptypInputProperty($propertyName, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyAmount, $propertyDesc) !== false) {

        echo "<div class='alert alert-danger' id='alert' role='alert'>
                  Please Fill out the fields.
                 </div>";
        exit();
    }
    if (emptyPropertyImg($propertyImage) !== false) {
        echo "<div class='alert alert-danger' id='alert' role='alert'>
                  No Image found.
                 </div>";
        exit();
    }

    // // print_r($propertyImage['size']);
    // // $fileNames = array_filter($propertyImage['name']);
    // // print_r($fileNames);
    // // $result = invalidImgType($propertyImage);
    // // echo $result;
    if (invalidPropertyImg($propertyImage) === true) {
        echo "<div class='alert alert-danger' id='alert' role='alert'>
                  File is not an Image.
                 </div>";

        exit();
    }

    if (invalidPropertyImgSize($propertyImage) === true) {
        echo "<div class='alert alert-danger' id='alert' role='alert'>
                  Image too large.
                 </div>";
        exit();
    }

    $result = uploadProperty($propertyOwner, $propertyName, $propertyOfferType, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyCarpark, $propertyAmount, $propertyDesc, $propertyRentChoice, $propertyImage, $conn);
    echo "<div class='alert alert-success' id='alert' role='alert'>
                 $result
                 </div>";

} else {
    echo "<div class='alert alert-danger' id='alert' role='alert'>
                  Error occured.
                 </div>";

}