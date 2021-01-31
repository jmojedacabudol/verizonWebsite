<?php

if (isset($_POST["submit"])) {

    $email = $_POST['uid'];
    $pwd = $_POST['pwd'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $pwd) !== false) {
        // header("location: ../index.php?error=emptyinput");
        // echo "Success";
        echo 'Fill All Fields!';
        exit();
    }

    $result = loginUser($conn, $email, $pwd);
    echo $result;
} else {
    // header("location: ../index.php");
    echo "Oppsss something happened";
    exit();
}