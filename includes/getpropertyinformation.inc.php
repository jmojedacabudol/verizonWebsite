<?php
require_once 'dbh.inc.php';

//get the full information of the propertyid selected
if (isset($_POST['propertyId'])) {
    $data = array();

    $propertyId = $_POST['propertyId'];

    $sql = "SELECT * FROM property WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //get the unit number if the property type is a condo
            if ($row['propertytype'] == "Condominium") {
                $data[] = array("propertyType" => $row['propertytype'], "unitNo" => $row['unitNo'], "propertyPrice" => $row['propertyamount'], "RoomFloorUnitNoBuilding" => $row['RoomFloorUnitNoBuilding'], "HouseLotBlockNo" => $row['HouseLotBlockNo'], "street" => $row['street'], "subdivision" => $row['subdivision'], "barangay" => $row['barangay'], "city" => $row['city'], "propertyOffertType" => $row['offertype'], "propertyApprovalStatus" => $row['approval']);

            } else {
                $data[] = array("propertyType" => $row['propertytype'], "unitNo" => "None", "propertyPrice" => $row['propertyamount'], "RoomFloorUnitNoBuilding" => $row['RoomFloorUnitNoBuilding'], "HouseLotBlockNo" => $row['HouseLotBlockNo'], "street" => $row['street'], "subdivision" => $row['subdivision'], "barangay" => $row['barangay'], "city" => $row['city'], "propertyOffertType" => $row['offertype'], "propertyApprovalStatus" => $row['approval']);

            }

        }
    }
    echo json_encode($data);

}