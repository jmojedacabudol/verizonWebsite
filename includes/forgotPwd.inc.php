<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $pwd = $_POST['pwd'];
    $pwdrepeat = $_POST['pwdrepeat'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // echo $email, $mobile, $pwd, $pwdrepeat;
    if (forgotPwdInputsEmpty($email, $mobile, $pwd, $pwdrepeat)) {
        echo "Fillup the fields!";
        exit();
    }
    if (passwordNotSame($pwd, $pwdrepeat)) {
        echo "Passwords not Match!";
        exit();
    }

    if (accountIsNotRegularAccount($conn, $email)) {
        echo "You can only change password accounts that is registered normally.";
        exit();
    }

    if (emailAndMobileNumberNotExists($conn, $email, $mobile)) {
        echo "No User Found with that Credentials!";
        exit();
    }

    if (!changePassword($conn, $email, $pwd)) {
        echo "Error Updating Password!";
        exit();
    } else {
        echo "Success";
        exit();
    }

}