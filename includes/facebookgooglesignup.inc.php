<?php

// echo $_POST['mobile'],$_POST['position'],$_POST['manager'],$_POST['providerId'];
// print_r($_FILES['validid']);
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$mobile = $_POST['mobile'];
$position = $_POST['position'];
$managerid = $_POST['manager'];
$providerId = $_POST['providerId'];
$validid = $_FILES['validid'];
$insertedUserId = "";

if (emailExists($conn, $email)) {
    echo '<div class = "alert alert-danger" role = "alert">Email already exists</div>';
    exit();
}

if (mobileNumberExists($conn, $mobile) !== false) {
    echo '<div class = "alert alert-danger" role = "alert">Mobile Number Exists!</div>';
    exit();
}

$fileName = $validid['name'];
$fileExt = explode('.', $fileName);
$fileTmpName = $validid['tmp_name'];
$fileActualExt = strtolower(end($fileExt));
$newFileName = uniqid('', true);
$fileNameNew = $newFileName . "." . $fileActualExt;
$fileDestination = '../uploads/' . $fileNameNew;

if (move_uploaded_file($fileTmpName, $fileDestination)) {

    if ($position === "Agent" && $managerid == 0) {
        $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,validid_key,Tag) VALUES(?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "1st Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'sssssss', $email, $firstname, $lastname, $mobile, $position, $newFileName, $providerId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Success1";
            // $result = "Upload Success";

        }
    } else if ($position === "Agent" && $managerid != 0) {

        $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,validid_key,managerid,Tag) VALUES(?,?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "2nd Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'ssssssss', $email, $firstname, $lastname, $mobile, $position, $newFileName, $managerid, $providerId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Success2";
        }
        //             $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key) VALUES('" . $email . "','" . $firstname . "','" . $lastname . "','" . $mobile . "','" . $position . "','" . $pwd . "','" . $newFileName . "');";
        // $result = print_r("option1" . $sql);
        // mysqli_query($conn, $sql);

    } else if ($position === 'Manager') {
        $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,validid_key,Tag) VALUES(?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "3rd Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'sssssss', $email, $firstname, $lastname, $mobile, $position, $newFileName, $providerId);
            mysqli_stmt_execute($stmt);
            $insertedUserId = $conn->insert_id; // function will now return the ID instead of true.

            mysqli_stmt_close($stmt);

            $sql2 = "INSERT INTO managers (name,usersId) VALUES(?,?);";
            $stmt2 = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                echo "4th Statement Failed";
                exit();
            } else {
                $managername = $firstname . " " . $lastname;
                mysqli_stmt_bind_param($stmt2, 'ss', $managername, $insertedUserId);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);

                echo "Success3";
                // $result = 'Success3';
                //exit();
            }
        }
    }
} else {
    //error in uploading
    echo "Upload Error";
    exit();
}