<?php

// echo $_POST['providerId'];
require_once 'dbh.inc.php';
require_once 'functions.inc.php';


$userEmail = $_POST['userEmail'];

$sql = "SELECT Tag FROM users WHERE usersEmail=?;";
$stmt = mysqli_stmt_init($conn);


if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "statemen Failed";
    exit();
}
mysqli_stmt_bind_param($stmt, 's', $userEmail);
mysqli_stmt_execute($stmt);

$resultData = mysqli_stmt_get_result($stmt);
// echo $resultData;
if (mysqli_num_rows($resultData) > 0) {
    while ($row = mysqli_fetch_assoc($resultData)) {
        echo $row['Tag'];
    }
} else {
    echo "No User";
}
