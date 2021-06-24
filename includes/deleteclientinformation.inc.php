<?php
require_once 'dbh.inc.php';

if (isset($_POST['clientId'])) {
    define("TESTING", false);
    $clientId = $_POST['clientId'];
    $client1 = null;
    $client2 = null;
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

                    $client1 = $row['primaryId'];
                    $client2 = $row['secondaryId'];
                }
                $deleteSql = "DELETE FROM clients WHERE clientId=?;";
                $deletestmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($deletestmt, $deleteSql)) {
                    echo "Internal Error: Transaction`s Statement Error";
                } else {
                    mysqli_stmt_bind_param($deletestmt, 's', $clientId);
                    if (mysqli_stmt_execute($deletestmt)) {
                        //get the transaction id using client id and delete that client id from said transaction
                        deleteClientIdInTransaction($clientId, $conn);
                    } else {
                        mysqli_stmt_close($deletestmt);

                        if (TESTING) {
                            //inserting property information error
                            echo mysqli_stmt_error($deletestmt);
                            exit();

                        }
                    }
                }
            } else {
                //no clients is found in clients table therefore delete the client id from transaction
                deleteClientIdInTransaction($clientId, $conn);
                mysqli_stmt_close($stmt);
                // exit();
            }
        } else {
            mysqli_stmt_close($stmt);

            if (TESTING) {
                //inserting property information error
                echo mysqli_stmt_error($stmt);
                exit();

            }

        }

    }

} else {
    echo "Error Find the Client Information";
    exit();
}

function deleteClientIdInTransaction($clientId, $conn)
{
    $transactionSql = "SELECT transactionId,firstClientId,secondClientId FROM transactions WHERE firstClientId=? OR secondClientId=?;";
    $transactionStmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($transactionStmt, $transactionSql)) {
        echo "Statement Failed";
        exit();
    } else {
        $processedClientId = mysqli_real_escape_string($conn, $clientId);
        mysqli_stmt_bind_param($transactionStmt, 'ss', $processedClientId, $processedClientId);
        if (mysqli_stmt_execute($transactionStmt)) {
            $result = mysqli_stmt_get_result($transactionStmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    //delete the transaction client ids if they mataches the value of "clientId";
                    if ($row['firstClientId'] === $clientId) {
                        echo deleteFirstClientIdFromTransaction($clientId, $row['transactionId'], $conn);
                    } else if ($row['secondClientId'] === $clientId) {
                        echo deleteSecondClientIdFromTransaction($clientId, $row['transactionId'], $conn);
                    }
                }
            } else {
                //just delete the client information if there is no transaction found
                echo "Client information Deleted without transaction";
            }
        } else {
            echo mysqli_stmt_error($transactionStmt);

        }
    }

}

function deleteFirstClientIdFromTransaction($firstClientId, $transactionId, $conn)
{
    //delete the client id from transactions
    $updatetransactionsql = "UPDATE transactions SET firstClientId=? WHERE transactionId=?;";
    $updatetransactionstmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($updatetransactionstmt, $updatetransactionsql)) {
        $result = "Statement failed";
        exit();
    } else {
        $nullValue = null;
        mysqli_stmt_bind_param($updatetransactionstmt, 'ss', $nullValue, $transactionId);
        if (mysqli_stmt_execute($updatetransactionstmt)) {
            mysqli_stmt_close($updatetransactionstmt);
            $result = "Client Deleted";
        } else {
            //error occured
            $result = mysqli_stmt_error($updatetranasctionstmt);
        }
    }
    return $result;
}

function deleteSecondClientIdFromTransaction($seconrdClientId, $transactionId, $conn)
{
    //delete the client id from transactions
    $updatetransactionsql = "UPDATE transactions SET seconrdClientId=? WHERE transactionId=?;";
    $updatetransactionstmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($updatetransactionstmt, $updatetransactionsql)) {
        $result = "Statement failed";
        exit();
    } else {
        $nullValue = null;

        mysqli_stmt_bind_param($updatetransactionstmt, 'ss', $nullValue, $transactionId);
        if (mysqli_stmt_execute($updatetransactionstmt)) {
            mysqli_stmt_close($updatetransactionstmt);
            $result = "Client Deleted";

        } else {
            //error occured
            $result = mysqli_stmt_error($updatetransactionstmt);
        }
    }
    return $result;

}