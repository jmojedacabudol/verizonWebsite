<?php

if (isset($_POST['managerId'])) {
    $managerId = $_POST['managerId'];
    $agents = 0;
    require_once 'dbh.inc.php';

    $countSql = "SELECT COUNT(usersid) as Agents FROM users WHERE managerid=?;";
    $countStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($countStmt, $countSql)) {
        echo "statement Failed";
        exit();
    }
    mysqli_stmt_bind_param($countStmt, 's', $managerId);
    mysqli_stmt_execute($countStmt);
    $countResult = mysqli_stmt_get_result($countStmt);
// echo $resultData;
    if (mysqli_num_rows($countResult) > 0) {
        while ($row = mysqli_fetch_assoc($countResult)) {
            $agents = $row['Agents'];
        }
    }

    if ($agents != 0) {
        $sql = "SELECT * FROM users WHERE managerid=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "statement Failed";
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $managerId);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
// echo $resultData;
        if (mysqli_num_rows($resultData) > 0) {
            while ($row = mysqli_fetch_assoc($resultData)) {
                $data[] = array(
                    'id' => $row['usersId'],
                    'Agent' => $row['usersFirstName'] . " " . $row['userLastName'],
                    'Number' => $row['usersMobileNumber'],
                    'Email' => $row['usersEmail'],
                );
                // $data[] = $row['usersId'];
                // $data[] = $row['usersFirstName'] . " " . $row['userLastName'];
                // $data[] = $row['usersMobileNumber'];
                // $data[] = $row['usersEmail'];

            }
            echo json_encode($data);
            // mysqli_stmt_close($stmt);

        }
    }
} else {
    echo "None";
}