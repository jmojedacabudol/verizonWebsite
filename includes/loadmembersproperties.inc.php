<?php

if (isset($_POST['memberId'])) {

    $memberId = $_POST['memberId'];
    $approve = '<p style="color:green;"><i class="fas fa-check"></i>&nbsp;&nbsp;"Posted"</p>';
    $pending = '<p style="color:orange;"><i class="fas fa-clock"></i>&nbsp;&nbsp;"Pending"</p>';
    $denied = '<p style="color:red;"><i class="fas fa-window-close"></i>&nbsp;&nbsp;"Denied"</p>';
    require_once 'dbh.inc.php';

    $sql = "SELECT * FROM property WHERE usersId=?;";
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
                'Id' => $row['propertyid'],
                'Property' => $row['propertyname'],
                'OfferType' => $row['offertype'],
                'Location' => $row['propertylocation'],
                'Price' => $row['propertyamount'],
                'Approval' => $row['approval'],
            );

        }
        echo json_encode($data);
    }

    // mysqli_stmt_close($stmt);

}