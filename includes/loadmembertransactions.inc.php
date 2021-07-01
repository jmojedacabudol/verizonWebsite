<?php

if (isset($_POST['memberId'])) {

    $memberId = $_POST['memberId'];

    require_once 'dbh.inc.php';

    $sql = "SELECT * FROM transactions WHERE agentId=?;";
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
            if ($row['propertyType'] == "Condominium") {
                $data[] = array(
                    'Id' => $row['transactionId'],
                    'Property Name' => $row['propertyName'],
                    'Property Type' => $row['propertyType'],
                    'Category' => $row['offertype'],
                    'Unit No' => $row['unitNo'],
                    'TCP' => "₱" . $row['TCP'],
                    'Terms Of Payment' => $row['termsOfPayment'],
                    'Address' => $row['address'],
                    'Status' => $row['status'],
                    'Date of Transaction' => $row['dateOfTransaction'],
                    'Date of Reservation' => $row['dataOfReservation'],
                    'Final TCP' => "₱" . $row['finalTCP'],
                    'Commission' => $row['commission'],
                    'Receivable' => "₱" . $row['receivable'],
                    'Agent`s Commission' => $row['commissionAgent'],
                    'AR`s Commision' => $row['commissionAR'],
                    'Buyer`s Commission' => $row['commissionBuyer'],
                    'Final Receivable' => "₱" . $row['receivable2'],
                );
            } else {
                $data[] = array(
                    'Id' => $row['transactionId'],
                    'Property Name' => $row['propertyName'],
                    'Property Type' => $row['propertyType'],
                    'Category' => $row['offertype'],
                    'Unit No' => $row['unitNo'],
                    'TCP' => "₱" . $row['TCP'],
                    'Terms Of Payment' => $row['termsOfPayment'],
                    'Address' => $row['address'],
                    'Status' => $row['status'],
                    'Date of Transaction' => $row['dateOfTransaction'],
                    'Date of Reservation' => 'N/A',
                    'Final TCP' => "₱" . $row['finalTCP'],
                    'Commission' => $row['commission'],
                    'Receivable' => "₱" . $row['receivable'],
                    'Agent`s Commission' => $row['commissionAgent'],
                    'AR`s Commision' => $row['commissionAR'],
                    'Buyer`s Commission' => $row['commissionBuyer'],
                    'Final Receivable' => "₱" . $row['receivable2'],
                );

            }
        }
        echo json_encode($data);

    }

    // mysqli_stmt_close($stmt);

}