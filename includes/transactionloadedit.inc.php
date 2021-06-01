<?php
require_once 'dbh.inc.php';

if (isset($_POST['transactionId'])) {

    $transactionId = $_POST['transactionId'];
    $data = array();

    $sql = "SELECT * FROM transactions WHERE transactionId=" . "'" . mysqli_real_escape_string($conn, $transactionId) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //get client informations

            $data[] = array("propertyName" => $row['propertyName'], "propertyType" => $row['propertyType'], "category" => $row['category'], "unitNo" => $row['unitNo'], "TCP" => $row['TCP'], "termsOfPayment" => $row['termsOfPayment'], "address" => $row['address'], "status" => $row['status'], "dateOfTransaction" => $row['dateOfTransaction'], "dataOfReservation" => $row['dataOfReservation'], "finalTCP" => $row['finalTCP'], "commission" => $row['commission'], "receivable" => $row['receivable'], "commissionAgent" => $row['commissionAgent'], "commissionAR" => $row['commissionAR'], "commissionBuyer" => $row['commissionBuyer'], "receivable2" => $row['receivable2'], "firstClientId" => $row['firstClientId'], "secondClientId" => $row['secondClientId'], "propertyId" => $row['propertyId']);

        }
        echo json_encode($data);
    } else {
        echo "No Data Found!";
    }
} else {
    echo "No Transaction Found!";
}