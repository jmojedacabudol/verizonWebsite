<?php
require_once 'dbh.inc.php';

if (isset($_POST['clientId'])) {

    $clientId = $_POST['clientId'];
    $data = array();

    $sql = "SELECT * FROM clients WHERE clientId=" . "'" . mysqli_real_escape_string($conn, $clientId) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //get client informations

            $data[] = array("firstName" => $row['firstName'], "middleName" => $row['middleName'], "lastName" => $row['lastName'], "mobileNumber" => $row['mobileNumber'], "areaCode" => $row['areaCode'], "landlineNumber" => $row['landlineNumber'], "email" => $row['email'], "birthday" => $row['birthday'], "gender" => $row['gender'], "age" => $row['age'], "civilStatus" => $row['civilStatus'], "RoomFloorUnitNoBuilding" => $row['RoomFloorUnitNoBuilding'], "HouseLotBlockNo" => $row['HouseLotBlockNo'], "street" => $row['street'], "subdivision" => $row['subdivision'], "barangay" => $row['barangay'], "city" => $row['city'], "companyName" => $row['companyName'], "companyRoomFloorUnitNoBuilding" => $row['companyRoomFloorUnitNoBuilding'], "companyStreet" => $row['companyStreet'], "companyBarangay" => $row['companyBarangay'], "companyCity" => $row['companyCity'], "primaryId" => $row['primaryId'], "secondaryId" => $row['secondaryId']);

        }
        echo json_encode($data);
    } else {
        echo "No Client Found!";
    }
} else {
    echo "No Client Found!";
}