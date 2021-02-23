<?php

if (isset($_POST['userId'])) {

    $userId = $_POST['userId'];
    $featureMessage = $_POST['featureMessage'];

    include_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Stament Failed";
        exit();
    }

    if (empty($featureMessage)) {
        echo "Feature message cannot be empty.";
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);

    //get the full information of the agent
    //insert the agents full information to featured table

    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        //check if the user is already featured in the website.
        $agentNumber = $row['usersMobileNumber'];
        // $test = agentAlreadyfeatured($conn, $agentNumber);
        // echo $test;
        if (agentAlreadyfeatured($conn, $agentNumber)) {
            echo "User already featured.";
            exit();
        }
        //check if the featured table is exceeding its limit of 3 featured agent/s
        $featureTableLength = featuredTable($conn);

        if ($featureTableLength >= 3) {
            echo "Featured table exceeds! Please delete an agent first";
            exit();
        }

        if (userHaveNoProfileImg($conn, $agentNumber)) {
            echo "User does not have profile Image to be display.";
            exit();
        }
        $agentName = $row['usersFirstName'] . " " . $row['userLastName'];
        $agentNumber = $row['usersMobileNumber'];
        $agentEmail = $row['usersEmail'];
        $agentProfile = $row['profile_Img'];
        $agentsPosition = $row['usersPosition'];

        $insertsql = "INSERT INTO featuredAgent (usersName,usersNumber,usersEmail,usersPosition,description,profile_Img) VALUES(?,?,?,?,?,?);";
        $insertStmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($insertStmt, $insertsql)) {
            echo "Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($insertStmt, 'ssssss', $agentName, $agentNumber, $agentEmail, $agentsPosition, $featureMessage, $agentProfile);
            mysqli_stmt_execute($insertStmt);
            mysqli_stmt_close($insertStmt);
            echo "Success";
            // header("location: ../index.php?error=none ");
            //exit();
        }

    } else {
        echo "No Data";
    }

}