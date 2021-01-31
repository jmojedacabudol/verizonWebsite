<?php

if (isset($_POST['submit'])) {

    $username = $_POST['uid'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwdrepeat = $_POST['pwdrepeat'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $mobile = $_POST['mobile'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputs($username, $email, $pwd, $pwdrepeat, $firstname, $lastname, $mobile) !== false) {
        echo ' <div class = "alert alert-danger" role = "alert" >Fill All Fields!</div>';
        exit();
    }

    if (invalidEmail($email) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Choose proper e-mail!</div>';
        exit();
    }

    if (pwdMatch($pwd, $pwdrepeat) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Passwords doesn`t match!</div>';
        exit();
    }

    //upload admin to database

    $result = createAdminAccount($username, $email, $pwd, $firstname, $lastname, $mobile, $conn);
    echo $result;

} else {
    echo "Opps Something happened.";
    exit();
}