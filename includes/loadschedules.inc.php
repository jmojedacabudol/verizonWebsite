<?php

require_once 'dbh.inc.php';
if (isset($_POST['propertyId'])) {
    $propertyid = $_POST['propertyId'];
    $userlogged = $_POST['userId'];

    $sql = "SELECT * FROM schedules WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL ERROR";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $propertyid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['userid'] == $userlogged) {
                $data[] = array(
                    'id' => $row['scheduleid'],
                    'title' => "Your Schedule",
                    'start' => $row['start_event'],
                    'end' => $row['end_event'],
                    // 'display' => 'background',
                    'textColor' => 'white',
                    'edittable' => 'true',
                );

            } else {
                $data[] = array(
                    'id' => $row['scheduleid'],
                    'title' => "Booked",
                    'start' => $row['start_event'],
                    'end' => $row['end_event'],
                    // 'display' => 'background',
                    'color' => '#70945A',
                    'textColor' => 'white',
                );

            }
            // // $counter++;
        }
        // echo $counter . " AND ";
        echo json_encode($data);
    }
//$sql = "SELECT * FROM schedules ORDER BY scheduleid;";

//  $result = mysqli_query($conn, $sql);
    // // $counter = 0;

// if (mysqli_num_rows($result) > 0) {
    //     while ($row = mysqli_fetch_assoc($result)) {
    //         $data[] = array(
    //             'id' => $row['scheduleid'],
    //             'title' => "Already Booked",
    //             'start' => $row['start_event'],
    //             'end' => $row['end_event'],
    //             // 'display' => 'background',
    //             // 'color' => '#70945A',
    //             // 'textColor' => 'white',
    //         );
    //         // $counter++;
    //     }
    //     // echo $counter . " AND ";
    //     echo json_encode($data);
    // }

}