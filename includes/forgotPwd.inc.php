<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    if (forgotPwdEmailIsEmpty($email)) {
        echo "Fillup the fields!";
        exit();
    }
    $result = sendEmailChangePassword($conn, $email);
    echo $result;
    exit();

}