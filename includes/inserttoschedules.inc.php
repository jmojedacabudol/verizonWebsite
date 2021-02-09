<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $username;
    $usernumber;
    $propertyname = $_POST['propertyname'];
    $propertyid = $_POST['propertyid'];
    $schedulestart = $_POST['start'];
    $scheduleend = $_POST['end'];
    $scheduleAgentId=$_POST['agentId'];

    if ($userId === 'no-user') {
        $username = $_POST['userName'];
        $usernumber = $_POST['userNumber'];

        if (notvalidMobileNumber($usernumber)) {
            echo "Invalid Mobile Number!";
            exit();
        }

        //no user logged in
        if (userMobileNumberExist($conn, $usernumber, $propertyid, "schedules")) {
            echo 'Mobile Number Exists!';
            exit();
        }

        $sql = "INSERT INTO schedules (propertyid,propertyname,clientname,usersMobileNumber,start_event,end_event,agentId) VALUES(?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // header("location: ../index.php?error=stmtfailed");
            echo "statement Failed";
            // exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'sssssss', $propertyid, $propertyname, $username, $usernumber, $schedulestart, $scheduleend,$scheduleAgentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Statement Success";
        }

    } else {
        $sql = "SELECT usersFirstName,userLastname,usersMobileNumber FROM users WHERE usersId=?;";

        $stmt = mysqli_stmt_init($conn);
        $userid = $_POST['userId'];
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "SQL ERROR";
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['usersFirstName'] . ' ' . $row['userLastname'];
            $usernumber = $row['usersMobileNumber'];

        } else {
            echo 'No such User';
            exit();
        }

        //no user logged in
        if (userMobileNumberExist($conn, $usernumber, $propertyid, "schedules")) {
            echo 'Mobile Number Exists!';
            exit();
        }

        $sql = "INSERT INTO schedules (propertyid,propertyname,clientname,usersMobileNumber,start_event,end_event,userid,agentId) VALUES(?,?,?,?,?,?,?,?);";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            // header("location: ../index.php?error=stmtfailed");
            echo "statement Failed";
            // exit();
        } else {
            mysqli_stmt_bind_param($stmt, 'ssssssss', $propertyid, $propertyname, $username, $usernumber, $schedulestart, $scheduleend, $userId,$scheduleAgentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo "Statement Success";
        }

    }

}