<?php

if (isset($_POST['termsNConditions'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwdrepeat = $_POST['pwdrepeat'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mobile = $_POST['mobile'];
    $position = $_POST['position'];
    $valididimg = $_FILES['validid'];
    $managerid = $_POST['manager'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // echo $managerid, $position;

    // //echo $email, $pwd, $pwdrepeat, $firstname, $lastname, $mobile, $position, $managerid;

    if (emptyInputsSignup($email, $pwd, $pwdrepeat, $firstname, $lastname, $mobile, $position, $managerid) !== false) {
        // header("location: ../index.php?error=emptyinput");
        echo ' <div class = "alert alert-danger" role = "alert" >Fill All Fields!</div>';
        exit();
    }
    //$meg = invalidImgType($valididimg);
    //   echo $meg;
    if (invalidEmail($email) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Choose proper e-mail!</div>';
        exit();
    }
    if (emailExists($conn, $email)) {
        echo '<div class = "alert alert-danger" role = "alert">Email already exists</div>';
        exit();
    }

    if (mobileNumberExists($conn, $mobile) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Mobile Number Exists!</div>';
        exit();
    }

    if (emptyvalIdImg($valididimg) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Image is empty!</div>';
        exit();
    }

    if (invalidImgType($valididimg) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Invalid Image type</div>';
        exit();
    }

    if (invalidImgSize($valididimg) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Image is too large!</div>';
        exit();
    }
    // // echo $managerid;
    $result = createUser($conn, $email, $pwd, $firstname, $lastname, $mobile, $position, $valididimg, $managerid);
    echo $result;
    // echo "Upload Success";
    // // echo $position;

} else {
    echo '<div class = "alert alert-warning" role = "alert" style="text-align:center;">Please read the Terms and Conditions</div>';

}