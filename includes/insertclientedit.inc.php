<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['eClientId'])) {

    //for testing purposes show detailed error
    define("TESTING", true);
    //client Id to Edit
    $clientId = $_POST['eClientId'];

    $eFName = $_POST['eFName'];
    $eMName = $_POST['eMName'];
    $eLName = $_POST['eLName'];
    $eClientMobileNumber = $_POST['eClientMobileNumber'];
    $eClientLandlineNumber = $_POST['eClientLandlineNumber'];
    $eEmailAddress = $_POST['eEmailAddress'];
    $eBirthday = $_POST['eBirthday'];
    $eGender = $_POST['eGender'];
    $eClientAge = $_POST['eClientAge'];
    $eCivilStatus = $_POST['eCivilStatus'];
    $eClientRFUB = $_POST['eClientRFUB'];
    $eClientHLB = $_POST['eClientHLB'];
    $eClientStreet = $_POST['eClientStreet'];
    $eSubdivision = $_POST['eSubdivision'];
    $eClientBrgyAddress = $_POST['eClientBrgyAddress'];
    $eClientCityAddress = $_POST['eClientCityAddress'];
    $eCompanyName = $_POST['eCompanyName'];
    $eCompanyInitalAddress = $_POST['eCompanyInitalAddress'];
    $eCompanyStreet = $_POST['eCompanyStreet'];
    $eCompanyBrgyAddress = $_POST['eCompanyBrgyAddress'];
    $eCompanyCityAddress = $_POST['eCompanyCityAddress'];

    //property Images
    $eFirstValidIdHolder = $_FILES['eFirstValidIdHolder'];

    //property ATS File
    $eSecondValidIdHolder = $_FILES['eSecondValidIdHolder'];

    //check if there are files in inputs
    //check if the images uploaded is too lardge

    if ($eFirstValidIdHolder['size'] !== 0) {
        if (invalidImgSize($eFirstValidIdHolder)) {
            //return the error
            echo "Primarty Image is too large.";
            exit();
        }
        // //delete the old valid primary Id
        // unlink('../uploads/' . $row['primaryId']);

    }

    if ($eSecondValidIdHolder['size'] !== 0) {
        if (invalidImgSize($eFirstValidIdHolder)) {
            //return the error
            echo "Secondary Image is too large.";
            exit();
        }
        // unlink('../uploads/' . $row['secondaryId']);
    }
//UPLOAD THE EDITTED INFORMATION

    //check if the user change in any of the property information

    $clientSql = "SELECT * FROM clients WHERE clientId=" . "'" . mysqli_real_escape_string($conn, $clientId) . "'";
    $query = "UPDATE clients SET ";
    $conditions = array();

    //do escaping here

    $result = mysqli_query($conn, $clientSql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['firstName'] != $eFName) {
                $conditions[] = "firstName=" . "'" . mysqli_real_escape_string($conn, $eFName) . "'";
            }
            if ($row['middleName'] != $eMName) {
                $conditions[] = "middleName=" . "'" . mysqli_real_escape_string($conn, $eMName) . "'";
            }
            if ($row['lastName'] != $eLName) {
                $conditions[] = "lastName=" . "'" . mysqli_real_escape_string($conn, $eLName) . "'";
            }

            if ($row['mobileNumber'] != $eClientMobileNumber) {
                $conditions[] = "mobileNumber=" . "'" . mysqli_real_escape_string($conn, $eClientMobileNumber) . "'";
            }

            if ($row['landlineNumber'] != $eClientLandlineNumber) {
                $conditions[] = "landlineNumber=" . "'" . mysqli_real_escape_string($conn, $eClientLandlineNumber) . "'";
            }

            if ($row['email'] != $eEmailAddress) {
                $conditions[] = "email=" . "'" . mysqli_real_escape_string($conn, $eEmailAddress) . "'";
            }

            if ($row['birthday'] != $eBirthday) {
                $conditions[] = "birthday=" . "'" . mysqli_real_escape_string($conn, $eBirthday) . "'";
            }

            if ($row['gender'] != $eGender) {
                $conditions[] = "gender=" . "'" . mysqli_real_escape_string($conn, $eGender) . "'";
            }
            if ($row['age'] != $eClientAge) {
                $conditions[] = "age=" . "'" . mysqli_real_escape_string($conn, $eClientAge) . "'";
            }
            if ($row['civilStatus'] != $eCivilStatus) {
                $conditions[] = "civilStatus=" . "'" . mysqli_real_escape_string($conn, $eCivilStatus) . "'";
            }
            if ($row['RoomFloorUnitNoBuilding'] != $eClientRFUB) {
                $conditions[] = "RoomFloorUnitNoBuilding=" . "'" . mysqli_real_escape_string($conn, $eClientRFUB) . "'";
            }

            if ($row['HouseLotBlockNo'] != $eClientHLB) {
                $conditions[] = "HouseLotBlockNo=" . "'" . mysqli_real_escape_string($conn, $eClientHLB) . "'";
            }
            if ($row['street'] != $eClientStreet) {
                $conditions[] = "street=" . "'" . mysqli_real_escape_string($conn, $eClientStreet) . "'";
            }
            if ($eSubdivision !== "") {
                if ($row['subdivision'] != $eSubdivision) {
                    $conditions[] = "subdivision=" . "'" . mysqli_real_escape_string($conn, $eSubdivision) . "'";
                }
            } else {
                //if empty
                if ($row['subdivision'] != $eSubdivision) {
                    $conditions[] = "subdivision=" . "'" . mysqli_real_escape_string($conn, $eSubdivision) . "'";
                }

            }
            if ($row['barangay'] != $eClientBrgyAddress) {
                $conditions[] = "barangay=" . "'" . mysqli_real_escape_string($conn, $eClientBrgyAddress) . "'";
            }

            if ($row['city'] != $eClientCityAddress) {
                $conditions[] = "city=" . "'" . mysqli_real_escape_string($conn, $eClientCityAddress) . "'";
            }
            if ($row['companyName'] != $eCompanyName) {
                $conditions[] = "companyName=" . "'" . mysqli_real_escape_string($conn, $eCompanyName) . "'";
            }
            if ($row['companyRoomFloorUnitNoBuilding'] != $eCompanyInitalAddress) {
                $conditions[] = "companyRoomFloorUnitNoBuilding=" . "'" . mysqli_real_escape_string($conn, $eCompanyInitalAddress) . "'";
            }

            if ($row['companyStreet'] != $eCompanyStreet) {
                $conditions[] = "companyStreet=" . "'" . mysqli_real_escape_string($conn, $eCompanyStreet) . "'";
            }

            if ($row['companyBarangay'] != $eCompanyBrgyAddress) {
                $conditions[] = "companyBarangay=" . "'" . mysqli_real_escape_string($conn, $eCompanyBrgyAddress) . "'";
            }
            if ($row['companyCity'] != $eCompanyCityAddress) {
                $conditions[] = "companyCity=" . "'" . mysqli_real_escape_string($conn, $eCompanyCityAddress) . "'";
            }

            //check if the valid Id`s is changed

            //PRIMARY ID
            //if input file firstvalidid
            if ($eFirstValidIdHolder['size'] !== 0) {
                //delete the old primarty id
                unlink('../uploads/' . $row['primaryId']);

                $firstValidIdImgName = $eFirstValidIdHolder['name'];
                $firstValidIdExt = explode('.', $firstValidIdImgName);
                $firstValidIdTmpName = $eFirstValidIdHolder['tmp_name'];
                $firstValidIdActualExt = strtolower(end($firstValidIdExt));
                $newFirstValidIdFileName = uniqid('', true);
                $firstValidIdFileNameNew = $newFirstValidIdFileName . "." . $firstValidIdActualExt;
                $profileFileDestination = '../uploads/' . $firstValidIdFileNameNew;

                //upload first valid Id to file folder
                if (move_uploaded_file($firstValidIdTmpName, $profileFileDestination)) {
                    $conditions[] = "primaryId=" . "'" . mysqli_real_escape_string($conn, $firstValidIdFileNameNew) . "'";

                } else {
                    //error in upload first valid Id
                    //show error in uploading ATS FILE in testing mode
                    if (TESTING) {
                        $result = "First Image NOT UPLOADED" . $eFirstValidIdHolder["error"];
                    } else {
                        $result = "First Image NOT UPLOADED";
                    }
                    //break the loop
                    break;
                    exit();
                }
            }

            //SECONDARY ID
            //if input file firstvalidid
            if ($eSecondValidIdHolder['size'] !== 0) {
                //delete the old primarty id
                unlink('../uploads/' . $row['secondaryId']);

                $secondValidIdImgName = $eSecondValidIdHolder['name'];
                $secondValidIdExt = explode('.', $secondValidIdImgName);
                $secondValidIdTmpName = $eSecondValidIdHolder['tmp_name'];
                $secondValidIdActualExt = strtolower(end($secondValidIdExt));
                $newSecondValidIdFileName = uniqid('', true);
                $secondValidIdFileNameNew = $newSecondValidIdFileName . "." . $secondValidIdActualExt;
                $profileFileDestination = '../uploads/' . $secondValidIdFileNameNew;

                //upload second valid Id to file folder
                if (move_uploaded_file($secondValidIdTmpName, $profileFileDestination)) {
                    $conditions[] = "secondaryId=" . "'" . mysqli_real_escape_string($conn, $secondValidIdFileNameNew) . "'";

                } else {
                    //error in upload first valid Id
                    //show error in uploading ATS FILE in testing mode
                    if (TESTING) {
                        $result = "Second Image NOT UPLOADED" . $eSecondValidIdHolder["error"];
                    } else {
                        $result = "Second Image NOT UPLOADED";
                    }
                    //break the loop
                    break;
                    exit();
                }
            }

        }
    }
    //add closing semi column
    $sql = $query;

    if (count($conditions) > 0) {
        $sql .= implode(' , ', $conditions) . " WHERE clientId=$clientId";
    } else {
        echo "No edit/s Found";
        exit();
    }
    $sql .= ";";

    try {
        $query = mysqli_query($conn, $sql);
        if ($query === false) {
            throw new Exception($this->mysqli->error);
        }
        echo "Success, Client Updated";
        exit();

    } catch (Exception $e) {
        echo $e;
        exit();
    }
} else {
    echo "Error Updating the Client: Contact Developer!";
}