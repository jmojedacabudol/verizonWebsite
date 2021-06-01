<?php
require_once 'dbh.inc.php';

if (isset($_POST['clientId'])) {
    define("TESTING", true);
    $clientId = $_POST['clientId'];
    //INSERT TO CLIENTS TABLE
    $sql = "SELECT primaryId,secondaryId FROM clients WHERE clientId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Internal Error: Transaction`s Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $clientId);
        if (mysqli_stmt_execute($stmt)) {
            $resultData = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($resultData) > 0) {
                while ($row = mysqli_fetch_assoc($resultData)) {
                    //delete the img from file folder
                    unlink('../uploads/' . $row['primaryId']);
                    unlink('../uploads/' . $row['secondaryId']);
                }
                $deleteSql = "DELETE FROM clients WHERE clientId=?;";
                $deletestmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($deletestmt, $deleteSql)) {
                    echo "Internal Error: Transaction`s Statement Error";
                } else {
                    mysqli_stmt_bind_param($deletestmt, 's', $clientId);
                    if (mysqli_stmt_execute($deletestmt)) {
                        echo "Client information Deleted";
                    } else {
                        mysqli_stmt_close($deletestmt);

                        if (TESTING) {
                            //inserting property information error
                            echo mysqli_stmt_error($deletestmt);
                        }
                        exit();
                    }

                }

            } else {
                echo "No Client Information Found";
                mysqli_stmt_close($deletestmt);
                exit();
            }
        } else {
            mysqli_stmt_close($stmt);

            if (TESTING) {
                //inserting property information error
                echo mysqli_stmt_error($stmt);
            }
            exit();
        }

    }

} else {
    echo "Error Find the Client Information";
    exit();
}