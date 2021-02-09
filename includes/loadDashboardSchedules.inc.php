<?php
require_once 'dbh.inc.php';
if (isset($_POST['userId'])) {
    $sql = "SELECT * FROM schedules WHERE agentId=?;";
    $stmt = mysqli_stmt_init($conn);
    $userId = $_POST['userId'];
    // echo $userId;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL ERROR";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                'id' => $row['scheduleid'],
                'title' =>  'Book Schedule',
                'start' => $row['start_event'],
                'end' => $row['end_event'],
                'textColor' => 'white',
                'edittable' => 'true',
                'color' => '#70945A',
            );
            // // $counter++;
        }
        // echo $counter . " AND ";
        echo json_encode($data);
    }
}
