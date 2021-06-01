<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST["submit"])) {

    $email = $_POST['uid'];
    $pwd = $_POST['pwd'];

    if (emptyInputLogin($email, $pwd) !== false) {
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