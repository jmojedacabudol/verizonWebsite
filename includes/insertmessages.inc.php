<?php

if (isset($_POST['userlogged']) && isset($_POST['propertyId'])) {

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    session_start();

    $userId = $_POST['userlogged'];
    //propertyId
    $propertyId = $_POST['propertyId'];

    if ($userId === "no-user") {
        $username = $_POST['name'];
        $usernumber = $_POST['userNo'];

        //no user logged in
        if (userMobileNumberExist($conn, $usernumber, $propertyId, "messages")) {
            echo 'Mobile Number Exists!';
            exit();
        }
            if (notvalidMobileNumber($usernumber)) {
            echo "Invalid Mobile Number!";
            exit();
        }
        
            if (notvalidMobileNumber($usernumber)) {
            echo "Invalid Mobile Number!";
            exit();
        }

        //get the agent`s information
        $agentSql = "SELECT users.usersId, users.usersFirstName, users.userLastName,property.propertyname FROM users  INNER JOIN property USING(usersid)  WHERE propertyid=?";

        $getAgentStmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($getAgentStmt, $agentSql)) {
            echo "No Property Found";
            exit();
        }
        mysqli_stmt_bind_param($getAgentStmt, 's', $propertyId);
        mysqli_stmt_execute($getAgentStmt);
        $result = mysqli_stmt_get_result($getAgentStmt);
        $row = mysqli_fetch_assoc($result);

        $agentId = $row['usersId'];
        $agentName = $row['usersFirstName'] . " " . $row['userLastName'];
        $propertyName = $row['propertyname'];

// echo "Property Agent: " . $agentId, $agentName, $propertyName;

//insert to database
        $result = insertMessage($username, $usernumber, $propertyId, $propertyName, $agentId, $agentName, $conn);
        echo $result;

    } else {
        //check if the user is currently logged in
        if (isset($_SESSION['userid'])) {
            $userloggedin = $_SESSION['userid'];
            if ($userloggedin == $userId) {
                //get the user`s information
                $userLoggedSql = "SELECT usersFirstName,userLastName,usersMobileNumber FROM users WHERE usersId=?;";

                $userloggedinStmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($userloggedinStmt, $userLoggedSql)) {
                    echo "User Statement Error";
                    exit();
                }
                mysqli_stmt_bind_param($userloggedinStmt, 's', $userId);
                mysqli_stmt_execute($userloggedinStmt);
                $result = mysqli_stmt_get_result($userloggedinStmt);
                $row = mysqli_fetch_assoc($result);

                $loggedUserNAME = $row['usersFirstName'] . " " . $row['userLastName'];
                $loggedUserNumber = $row['usersMobileNumber'];

                // echo "User Info: " . $loggedUserNAME, $loggedUserNumber;
                //check if the user already made a message for the property
                if (userMobileNumberExist($conn, $loggedUserNumber, $propertyId, "messages")) {
                    echo 'Mobile Number Exists!';
                    exit();
                }

                //get the agent`s information
                $agentSql = "SELECT users.usersId, users.usersFirstName, users.userLastName,property.propertyname FROM users  INNER JOIN property USING(usersid)  WHERE propertyid=?";

                $getAgentStmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($getAgentStmt, $agentSql)) {
                    echo "No Property Found";
                    exit();
                }
                mysqli_stmt_bind_param($getAgentStmt, 's', $propertyId);
                mysqli_stmt_execute($getAgentStmt);
                $result = mysqli_stmt_get_result($getAgentStmt);
                $row = mysqli_fetch_assoc($result);

                $agentId = $row['usersId'];
                $agentName = $row['usersFirstName'] . " " . $row['userLastName'];
                $propertyName = $row['propertyname'];

                // echo "Property Agent: " . $agentId, $agentName, $propertyName;

                //insert to database
                $result = insertMessage($loggedUserNAME, $loggedUserNumber, $propertyId, $propertyName, $agentId, $agentName, $conn);
                echo $result;

            } else {
                echo "Different User Logged in";
            }
        } else {
            echo "No User Logged in";
        }
    }
} else {
    echo "No user Found";
}

// if (isset($_POST['submit'])) {
//     $userName = $_POST['name'];
//     $userNo = $_POST['userNo'];
//     $propertyId = $_POST['propertyId'];
//     $agentId;
//     $agentName;
//     $propertyName;

//     require_once 'dbh.inc.php';
//     require_once 'functions.inc.php';

//     // echo $userName, $userNo;
//     if (emptyInputLogin($userName, $userNo) !== false) {
//         echo "Please Input information";
//         exit();
//     }
//     if (notvalidMobileNumber($userNo)) {
//         echo "Invalid Mobile Number!";
//         exit();
//     }

//     if (mobileNumberExists($conn, $userNo) !== false) {
//         echo 'Mobile Number Exists!';
//         exit();
//     }

//     $sql = "SELECT users.usersId, users.usersFirstName, users.userLastName,property.propertyname FROM users  INNER JOIN property USING(usersid)  WHERE propertyid=?";

//     $stmt = mysqli_stmt_init($conn);

//     if (!mysqli_stmt_prepare($stmt, $sql)) {

//         echo "SQL ERROR";

//         exit();
//     }
//     mysqli_stmt_bind_param($stmt, 's', $propertyId);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $row = mysqli_fetch_assoc($result);

//     $agentId = $row['usersId'];
//     $agentName = $row['usersFirstName'] . " " . $row['userLastName'];
//     $propertyName = $row['propertyname'];

//     // echo $agentId, $agentName, $propertyName;

//     //echo $userName, $userNo, $propertyId, $propertyName, $agentId, $agentName;
//     $result = insertMessage($userName, $userNo, $propertyId, $propertyName, $agentId, $agentName, $conn);
//     echo $result;
//     // exit();

// } else {
//     echo "SQL Error";
// }