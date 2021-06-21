<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['eSubmit'])) {
    $ePropertyType = $_POST['ePropertyType'];
    $eSubcategory = $_POST['eSubcategory'];
    $ePropertyOfferType = $_POST['ePropertyOfferType'];
    $eUnitNo = $_POST['eUnitNo'];
    $ePropertyTcp = $_POST['ePropertyTcp'];
    $ePropertyAddress = $_POST['ePropertyAddress'];
    $eTerms = $_POST['eTerms'];
    $eStatus = $_POST['eStatus'];
    $eTransactionDate = $_POST['eTransactionDate'];
    $eSaleDate = $_POST['eSaleDate'];
    $eFinalTcp = $_POST['eFinalTcp'];
    $eCommission = $_POST['eCommission'];
    $eReceivable = $_POST['eReceivable'];
    $eAgentCommission = $_POST['eAgentCommission'];
    $eArCommission = $_POST['eArCommission'];
    $eBuyersCommssion = $_POST['eBuyersCommssion'];
    $eFinalReceivable = $_POST['eFinalReceivable'];
    $firstClient = $_POST['firstClient'];
    $firstClient = $_POST['firstClient'];

    $transactionId = $_POST['transactionId'];

    // echo $eReceivable, $eAgentCommission, $eArCommission, $eBuyersCommssion, $eFinalReceivable;

    $propertysql = "SELECT * FROM transactions WHERE transactionId=" . "'" . mysqli_real_escape_string($conn, $transactionId) . "'";
    $query = "UPDATE transactions SET ";
    $conditions = array();

    //do escaping here

    $result = mysqli_query($conn, $propertysql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['TCP'] != $ePropertyTcp) {
                $conditions[] = "TCP=" . "'" . mysqli_real_escape_string($conn, $ePropertyTcp) . "'";
            }
            if ($row['termsOfPayment'] != $eTerms) {
                $conditions[] = "termsOfPayment=" . "'" . mysqli_real_escape_string($conn, $eTerms) . "'";
            }
            if ($row['status'] != $eStatus) {
                $conditions[] = "status=" . "'" . mysqli_real_escape_string($conn, $eStatus) . "'";
            }
            if ($row['dateOfTransaction'] != $eTransactionDate) {
                $conditions[] = "dateOfTransaction=" . "'" . mysqli_real_escape_string($conn, $eTransactionDate) . "'";
            }
            if ($row['dataOfReservation'] != $eSaleDate) {
                $conditions[] = "dataOfReservation=" . "'" . mysqli_real_escape_string($conn, $eSaleDate) . "'";
            }
            if ($row['finalTCP'] != $eFinalTcp) {
                $conditions[] = "finalTCP=" . "'" . mysqli_real_escape_string($conn, $eFinalTcp) . "'";
            }
            if ($row['commission'] != $eCommission) {
                $conditions[] = "commission=" . "'" . mysqli_real_escape_string($conn, $eCommission) . "'";
            }
            if ($row['receivable'] != $eReceivable) {
                $conditions[] = "receivable=" . "'" . mysqli_real_escape_string($conn, $eReceivable) . "'";
            }
            if ($row['commissionAgent'] != $eAgentCommission) {
                $conditions[] = "commissionAgent=" . "'" . mysqli_real_escape_string($conn, $eAgentCommission) . "'";
            }
            if ($row['commissionAR'] != $eArCommission) {
                $conditions[] = "commissionAR=" . "'" . mysqli_real_escape_string($conn, $eArCommission) . "'";
            }
            if ($row['commissionBuyer'] != $eBuyersCommssion) {
                $conditions[] = "commissionBuyer=" . "'" . mysqli_real_escape_string($conn, $eBuyersCommssion) . "'";
            }
            if ($row['receivable2'] != $eFinalReceivable) {
                $conditions[] = "receivable2=" . "'" . mysqli_real_escape_string($conn, $eFinalReceivable) . "'";
            }
            if ($row['firstClientId'] != $firstClient) {
                $conditions[] = "firstClientId=" . "'" . mysqli_real_escape_string($conn, $firstClient) . "'";
            }

            if ($row['secondClientId'] !== null || $row['secondClientId'] != null) {
                if ($row['secondClientId'] != $secondClient) {
                    $conditions[] = "secondClientId=" . "'" . mysqli_real_escape_string($conn, $secondClient) . "'";
                }

            }

        }

        $sql = $query;
        // $test = "";
        if (count($conditions) > 0) {
            $sql .= implode(' , ', $conditions) . "WHERE transactionId=" . "'" . mysqli_real_escape_string($conn, $transactionId) . "'";
        } else {
            echo "No Edit/s Found";
            exit();
        }
        $sql .= ";";

        try {
            $query = mysqli_query($conn, $sql);
            if ($query === false) {
                throw new Exception($this->mysqli->error);
            }
            echo "Transaction Editted";
        } catch (Exception $e) {
            echo $e;
            exit();
        }

    } else {
        echo "No Transaction Found!";
        exit();
    }

} else {
    echo "No Transaction Found";
    exit();
}