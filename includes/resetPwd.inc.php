<?php

if (isset($_POST['submit'])) {
    $email = $_POST['userEmail'];
    $pwd = $_POST['resetPwd'];
    $pwdrepeat = $_POST['restPwdRepeat'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    // echo $email, $mobile, $pwd, $pwdrepeat;
    if (resetPwdInputsEmpty($pwd, $pwdrepeat)) {
        echo "Fillup the fields!";
        exit();
    }
    if (passwordNotSame($pwd, $pwdrepeat)) {
        echo "Passwords not Match!";
        exit();
    }

    if (changePassword($conn, $email, $pwd)) {
        echo "Success";
        exit();
    } else {
        echo "Error Updating Password";
        exit();
    }

}