<?php
require_once 'dbh.inc.php';

if (isset($_POST['transactionId'])) {
    define("TESING", true);
    $transactionId = $_POST['transactionId'];
    $client1 = null;
    $client2 = null;

    $sql = "SELECT firstClientId,secondClientId FROM transactions WHERE transactionId=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $transactionId);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($resultData) > 0) {
            while ($row = mysqli_fetch_assoc($resultData)) {
                $client1 = $row['firstClientId'];
                $client2 = $row['secondClientId'];
            }
        }
    }

//get the client information
    if ($client1 !== null && $client2 !== null) {
        $clientSql = 'SELECT primaryId,secondaryId FROM clients WHERE clientId=?;';
        $clientStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($clientStmt, $clientSql)) {
            echo "Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($clientStmt, 's', $client1);
            mysqli_stmt_execute($clientStmt);

            $resultData = mysqli_stmt_get_result($clientStmt);
            if (mysqli_num_rows($resultData) > 0) {
                while ($row = mysqli_fetch_assoc($resultData)) {
                    //delete the file from folder
                    unlink('../uploads/' . $row['primaryId']);
                    unlink('../uploads/' . $row['secondaryId']);

                }
            }
        }

        //2nd CLIENT

        $clientSql = 'SELECT primaryId,secondaryId FROM clients WHERE clientId=?;';
        $clientStmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($clientStmt, $clientSql)) {
            $result = "Statement Failed";
            exit();
        } else {
            mysqli_stmt_bind_param($clientStmt, 's', $client2);
            mysqli_stmt_execute($clientStmt);

            $resultData = mysqli_stmt_get_result($clientStmt);
            if (mysqli_num_rows($resultData) > 0) {
                while ($row = mysqli_fetch_assoc($resultData)) {
                    //delete the file from folder
                    unlink('../uploads/' . $row['primaryId']);
                    unlink('../uploads/' . $row['secondaryId']);

                }
            }
        }

        //delete the client information

        $deleteSql = "DELETE from clients WHERE clientId IN (?,?);";
        $deletestmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($deletestmt, $deleteSql)) {
            echo "Internal Error: Transaction`s Statement Error";
        } else {
            mysqli_stmt_bind_param($deletestmt, 'ss', $client1, $client2);
            if (mysqli_stmt_execute($deletestmt)) {

                //delete the transaction itself
                $transactionSql = "DELETE from transactions WHERE transactionId=?";
                $deletestmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($deletestmt, $transactionSql)) {
                    echo "Internal Error: Transaction`s Statement Error";
                } else {
                    mysqli_stmt_bind_param($deletestmt, 's', $transactionId);
                    if (mysqli_stmt_execute($deletestmt)) {
                        echo "Client information Deleted";
                    } else {
                        mysqli_stmt_close($deletestmt);

                    }
                }
            } else {
                mysqli_stmt_close($deletestmt);

            }
        }

    } else {

        if ($client1 !== null) {
            $clientSql = 'SELECT primaryId,secondaryId FROM clients WHERE clientId=?;';
            $clientStmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($clientStmt, $clientSql)) {
                $result = "Statement Failed";
                exit();
            } else {
                mysqli_stmt_bind_param($clientStmt, 's', $client1);
                mysqli_stmt_execute($clientStmt);

                $resultData = mysqli_stmt_get_result($clientStmt);
                if (mysqli_num_rows($resultData) > 0) {
                    while ($row = mysqli_fetch_assoc($resultData)) {
                        //delete the file from folder
                        unlink('../uploads/' . $row['primaryId']);
                        unlink('../uploads/' . $row['secondaryId']);

                    }
                }
            }

            //delete the client information

            $deleteSql = "DELETE FROM clients WHERE clientId=?;";
            $deletestmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($deletestmt, $deleteSql)) {
                echo "Internal Error: Transaction`s Statement Error";
            } else {
                mysqli_stmt_bind_param($deletestmt, 's', $client1);
                if (mysqli_stmt_execute($deletestmt)) {

                    //delete the transaction itself
                    $transactionSql = "DELETE from transactions WHERE transactionId=?";
                    $deletestmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($deletestmt, $transactionSql)) {
                        echo "Internal Error: Transaction`s Statement Error";
                    } else {
                        mysqli_stmt_bind_param($deletestmt, 's', $transactionId);
                        if (mysqli_stmt_execute($deletestmt)) {
                            echo "Client information Deleted";
                        } else {
                            mysqli_stmt_close($deletestmt);

                        }
                    }

                } else {
                    mysqli_stmt_close($deletestmt);

                }
            }

        } else {

            $clientSql = 'SELECT primaryId,secondaryId FROM clients WHERE clientId=?;';
            $clientStmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($clientStmt, $clientSql)) {
                echo "Statement Failed";
                exit();
            } else {
                mysqli_stmt_bind_param($clientStmt, 's', $client2);
                mysqli_stmt_execute($clientStmt);

                $resultData = mysqli_stmt_get_result($clientStmt);
                if (mysqli_num_rows($resultData) > 0) {
                    while ($row = mysqli_fetch_assoc($resultData)) {
                        //delete the file from folder
                        unlink('../uploads/' . $row['primaryId']);
                        unlink('../uploads/' . $row['secondaryId']);

                    }
                }
            }

            //delete the client information
            $deleteSql = "DELETE FROM clients WHERE clientId=?;";
            $deletestmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($deletestmt, $deleteSql)) {
                echo "Internal Error: Transaction`s Statement Error";
            } else {
                mysqli_stmt_bind_param($deletestmt, 's', $client2);
                if (mysqli_stmt_execute($deletestmt)) {

                    //delete the transaction itself
                    $transactionSql = "DELETE from transactions WHERE transactionId=?";
                    $deletestmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($deletestmt, $transactionSql)) {
                        echo "Internal Error: Transaction`s Statement Error";
                    } else {
                        mysqli_stmt_bind_param($deletestmt, 's', $transactionId);
                        if (mysqli_stmt_execute($deletestmt)) {
                            echo "Client information Deleted";
                        } else {
                            mysqli_stmt_close($deletestmt);

                        }
                    }

                } else {
                    mysqli_stmt_close($deletestmt);

                }
            }
        }
    }

} else {
    echo 'No Transaction Found!';
}