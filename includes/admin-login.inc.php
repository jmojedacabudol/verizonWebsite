<?php

if (isset($_POST["submit"])) {

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($uid, $pwd) !== false) {
        echo "Please Fill out the fields.";
        exit();
    }

    $result = loginAdmin($conn, $uid, $pwd);
    echo $result;
} else {
    echo "no";
    // header("location: ../index.php");
    //exit();
}