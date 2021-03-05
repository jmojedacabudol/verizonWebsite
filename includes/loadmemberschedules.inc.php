<?php

if (isset($_POST['memberId'])) {

    $memberId = $_POST['memberId'];

    require_once 'dbh.inc.php';

    $sql = "SELECT * FROM schedules WHERE agentId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "statement Failed";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $memberId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
// echo $resultData;
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            $data[] = array(
                'Id' => $row['scheduleid'],
                'Client' => $row['clientname'],
                'Number' => $row['usersMobileNumber'],
                'Property' => $row['propertyname'],
                'Date' => $row['start_event'],
            );
        }
        echo json_encode($data);

    }

    // mysqli_stmt_close($stmt);

}