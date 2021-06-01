<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['termsNConditions'])) {
    $profileImg = $_FILES['FileUpload'];
    $email = $_POST['email'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $birthday = $_POST['birthday'];
    $houseno = $_POST['house-number'];
    $brgy = $_POST['brgy'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $tin = $_POST['tin'];
    $mobile = $_POST['mobile'];
    $position = $_POST['position'];
    $password = $_POST['password'];

    $valididimg = $_FILES['filevalidid'];

    // echo $email, $firstname, $middlename, $lastname, $birthday, $houseno, $brgy, $city, $province, $tin, $mobile, $position;
    //check if the position is either Agent or Manager

    if ($position === "Agent") {
        //get the manager Id for the agent
        $managerid = $_POST['managerId'];

        // echo $managerid;
        if (emailExists($conn, $email)) {
            echo '<div class = "alert alert-danger" role = "alert">Email already exists</div>';
            exit();
        }

        if (mobileNumberExists($conn, $mobile) !== false) {
            echo '<div class = "alert alert-danger" role = "alert">Mobile Number Exists!</div>';
            exit();
        }

        if (invalidImgSize($valididimg) !== false) {
            echo '<div class = "alert alert-danger" role = "alert">Image is too large!</div>';
            exit();
        }

        $result = createAgentUser($conn, $email, $firstname, $middlename, $lastname, $birthday, $houseno, $brgy, $city, $province, $tin, $mobile, $position, $profileImg, $valididimg, $password, $managerid);
        echo $result;

    } else if ($position === "Manager") {
        //else if position is Manager
        if (emailExists($conn, $email)) {
            echo '<div class = "alert alert-danger" role = "alert">Email already exists</div>';
            exit();
        }

        if (mobileNumberExists($conn, $mobile) !== false) {
            echo '<div class = "alert alert-danger" role = "alert">Mobile Number Exists!</div>';
            exit();
        }

        if (invalidImgSize($valididimg) !== false) {
            echo '<div class = "alert alert-danger" role = "alert">Image is too large!</div>';
            exit();
        }

        $result = createManagerUser($conn, $email, $firstname, $middlename, $lastname, $birthday, $houseno, $brgy, $city, $province, $tin, $mobile, $position, $profileImg, $valididimg, $password);
        echo $result;

    }

} else {
    echo '<div class = "alert alert-warning" role = "alert" style="text-align:center;">Please read the Terms and Conditions</div>';

}