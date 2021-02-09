<?php
$query = "UPDATE users SET ";
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$profileImg = $_FILES['profilePic'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$newpass = $_POST['newpass'];
$confirmpass = $_POST['confirm-pass'];
$validId = $_FILES['validId'];

$userlogged = "no-user";
session_start();

if (isset($_SESSION['userid'])) {
    $userlogged = $_SESSION['userid'];
}
// echo $userlogged;
//Do real escaping here

$conditions = array();

if ($profileImg['size'] !== 0 && $profileImg['error'] === 0) {
    $sql = "SELECT profile_Img FROM users where usersId=$userlogged AND profile_Img!='';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseFileName = $row['profile_Img'];
            $filename = "../uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[4];
            // print_r($fileactualext);
            //delete the picture from the database
            unlink('../uploads/' . $row['profile_Img'] . "." . $fileactualext);
        }
    }
    //create the name of the file
    $fileName = $profileImg['name'];
    $fileExt = explode('.', $fileName);
    $fileTmpName = $profileImg['tmp_name'];
    $fileActualExt = strtolower(end($fileExt));
    $newFileName = uniqid('', true);
    $fileNameNew = $newFileName . "." . $fileActualExt;
    $fileDestination = '../uploads/' . $fileNameNew;

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        $conditions[] = "profile_Img='$newFileName'";
    } else {
        echo "Upload Error";
        exit;
    }
}

if (!empty($firstname)) {
    $conditions[] = "usersFirstName=" . "'" . mysqli_real_escape_string($conn, $firstname) . "'";
}
if (!empty($lastname)) {
    $conditions[] = "userLastName=" . "'" .  mysqli_real_escape_string($conn, $lastname) . "'";
}
if (!empty($email)) {
    if (invalidEmail($email) !== false) {
        echo 'Choose proper e-mail!';
        exit();
    }
    $conditions[] = "usersEmail=" . "'" .  mysqli_real_escape_string($conn, $email) . "'";
}
if (!empty($newpass) && !empty($confirmpass)) {
    if (pwdMatch($newpass, $confirmpass) !== false) {
        echo '<div class = "alert alert-danger" role = "alert">Passwords doesn`t match!</div>';
        exit();
    }

    $hashedPwd = password_hash(mysqli_real_escape_string($conn, $newpass), PASSWORD_DEFAULT);
    $conditions[] = "usersPwd='$hashedPwd'";
}
if ($validId['size'] !== 0 && $validId['error'] === 0) {
    $sql = "SELECT validid_key FROM users where usersId=$userlogged AND validid_key!='';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseFileName = $row['validid_key'];
            $filename = "../uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[4];
            // print_r ($filename);
            //delete the picture from the database
            unlink('../uploads/' . $row['validid_key'] . "." . $fileactualext);
        }
    }
    //create the name of the file
    $fileName = $validId['name'];
    $fileExt = explode('.', $fileName);
    $fileTmpName = $validId['tmp_name'];
    $fileActualExt = strtolower(end($fileExt));
    $newFileName = uniqid('', true);
    $fileNameNew = $newFileName . "." . $fileActualExt;
    $fileDestination = '../uploads/' . $fileNameNew;

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        $conditions[] = "validid_key='$newFileName'";
    } else {
        echo "Upload Error";
        exit;
    }
}

$sql = $query;
// $test = "";
if (count($conditions) > 0) {
    $sql .= implode(' , ', $conditions) . " WHERE usersId=$userlogged";
}

$sql .= ";";
$result = mysqli_query($conn, $sql);

echo $result;
