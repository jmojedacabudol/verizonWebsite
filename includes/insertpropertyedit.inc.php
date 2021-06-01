<?php

require_once 'dbh.inc.php';

if (isset($_POST['ePropertyId'])) {
    //Property Id to Edit
    $propertyId = $_POST['ePropertyId'];

    $eListingTitle = $_POST['eListingTitle'];
    $eListingType = $_POST['eListingType'];
    $eListingUnitNo = $_POST['eListingUnitNo'];
    $eListingSubCategory = $_POST['eListingSubCategory'];
    $eListingOfferType = $_POST['eListingOfferType'];
    $eListingRentChoice = $_POST['eListingRentChoice'];
    $eListingPrice = $_POST['eListingPrice'];
    $eListingLotArea = $_POST['eListingLotArea'];
    $eListingFloorArea = $_POST['eListingFloorArea'];
    $eListingBedrooms = $_POST['eListingBedrooms'];
    $eListingCapacityOfGarage = $_POST['eListingCapacityOfGarage'];
    $eListingDesc = $_POST['eListingDesc'];
    $eListingRFUB = $_POST['eListingRFUB'];
    $eListingHLB = $_POST['eListingHLB'];
    $eListingStreet = $_POST['eListingStreet'];
    $eListingSubdivision = $_POST['eListingSubdivision'];
    $eListingBrgyAddress = $_POST['eListingBrgyAddress'];
    $eListingCityAddress = $_POST['eListingCityAddress'];

    //property Images
    $propertyImage = $_FILES['eListingImage'];

    //property ATS File
    $propertyATS = $_FILES['eListingATS'];

    //check if the images uploaded is too lardge

    //check first the size/s of all img/s of Property
    if (checkPropertyImgSize($propertyImage)) {
        //return the error
        echo "Property Image/s is too large.";
        exit();
    }

    //check for size of ATS file
    if (invalidATSSize($propertyATS)) {
        echo "ATS file is too large.";
        exit();
    }

//UPLOAD THE EDITTED INFORMATION

    //check if the user change in any of the property information

    $propertysql = "SELECT * FROM property WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";
    $query = "UPDATE property SET ";
    $conditions = array();

    //do escaping here

    $result = mysqli_query($conn, $propertysql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['propertyname'] != $eListingTitle) {
                $conditions[] = "propertyname=" . "'" . mysqli_real_escape_string($conn, $eListingTitle) . "'";
            }
            if ($row['propertytype'] != $eListingType) {
                $conditions[] = "propertytype=" . "'" . mysqli_real_escape_string($conn, $eListingType) . "'";
            }
            if ($row['unitNo'] != $eListingUnitNo) {
                $conditions[] = "unitNo=" . "'" . mysqli_real_escape_string($conn, $eListingUnitNo) . "'";
            }

            if ($row['subcategory'] != $eListingSubCategory) {
                $conditions[] = "subcategory=" . "'" . mysqli_real_escape_string($conn, $eListingSubCategory) . "'";
            }

            if ($row['offertype'] != $eListingOfferType) {
                $conditions[] = "offertype=" . "'" . mysqli_real_escape_string($conn, $eListingOfferType) . "'";
            }

            if ($row['propertyrentchoice'] != $eListingRentChoice) {
                $conditions[] = "propertyrentchoice=" . "'" . mysqli_real_escape_string($conn, $eListingRentChoice) . "'";
            }

            if ($row['propertyamount'] != $eListingPrice) {
                $conditions[] = "propertyamount=" . "'" . mysqli_real_escape_string($conn, $eListingPrice) . "'";
            }

            if ($row['propertylotarea'] != $eListingLotArea) {
                $conditions[] = "propertylotarea=" . "'" . mysqli_real_escape_string($conn, $eListingLotArea) . "'";
            }
            if ($row['propertyfloorarea'] != $eListingFloorArea) {
                $conditions[] = "propertyfloorarea=" . "'" . mysqli_real_escape_string($conn, $eListingFloorArea) . "'";
            }
            if ($row['propertybedrooms'] != $eListingBedrooms) {
                $conditions[] = "propertybedrooms=" . "'" . mysqli_real_escape_string($conn, $eListingBedrooms) . "'";
            }
            if ($row['propertycarpark'] != $eListingCapacityOfGarage) {
                $conditions[] = "propertycarpark=" . "'" . mysqli_real_escape_string($conn, $eListingCapacityOfGarage) . "'";
            }

            if ($row['propertydesc'] != $eListingDesc) {
                $conditions[] = "propertydesc=" . "'" . mysqli_real_escape_string($conn, $eListingDesc) . "'";
            }
            if ($row['RoomFloorUnitNoBuilding'] != $eListingRFUB) {
                $conditions[] = "RoomFloorUnitNoBuilding=" . "'" . mysqli_real_escape_string($conn, $eListingRFUB) . "'";
            }
            if ($row['HouseLotBlockNo'] != $eListingHLB) {
                $conditions[] = "HouseLotBlockNo=" . "'" . mysqli_real_escape_string($conn, $eListingHLB) . "'";
            }
            if ($row['street'] != $eListingStreet) {
                $conditions[] = "street=" . "'" . mysqli_real_escape_string($conn, $eListingStreet) . "'";
            }
            if ($row['subdivision'] != $eListingSubdivision) {
                $conditions[] = "subdivision=" . "'" . mysqli_real_escape_string($conn, $eListingSubdivision) . "'";
            }

            if ($row['barangay'] != $eListingBrgyAddress) {
                $conditions[] = "barangay=" . "'" . mysqli_real_escape_string($conn, $eListingBrgyAddress) . "'";
            }
            if ($row['city'] != $eListingCityAddress) {
                $conditions[] = "city=" . "'" . mysqli_real_escape_string($conn, $eListingCityAddress) . "'";
            }

        }
        $sql = $query;
        // $test = "";
        if (count($conditions) > 0) {
            $sql .= implode(' , ', $conditions) . " WHERE propertyid=$propertyId";
        } else {
            //property can be updated without text and only pictures
            try {
                //check for property images changed
                $targetDir = '../uploads/';
                $fileNames = array_filter($propertyImage['name']);
                if (!empty($fileNames)) {
                    foreach ($propertyImage['name'] as $key => $val) {
                        $fileName = basename($propertyImage['name'][$key]);
                        $fileExt = explode('.', $fileName);
                        $fileTmpName = $propertyImage['tmp_name'];
                        $fileActualExt = strtolower(end($fileExt));
                        $newFileName = uniqid('', true);
                        $fileNameNew = $newFileName . "." . $fileActualExt;

                        $targetFilePath = $targetDir . $fileNameNew;

                        if (!move_uploaded_file($propertyImage['tmp_name'][$key], $targetFilePath)) {
                            throw new Exception("Image NOT UPLOADED" . $_FILES["file"]["error"]);
                            //break the loop
                            break;
                            exit();
                        }
                        //insert the pictures to file folder
                        $sql = "INSERT INTO images (propertyid,file_name) VALUES(?,?);";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            //break the loop
                            break;
                            throw new Exception($this->mysqli->error);
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, 'ss', $propertyId, $newFileName);
                            if (!mysqli_stmt_execute($stmt)) {
                                //break the loop
                                break;
                                throw new Exception($this->mysqli->error);
                                mysqli_stmt_close($stmt);

                            }
                        }
                    }
                    //only picture upload
                    echo "Success, Property Updated!";
                    //exit the script
                    exit();

                } else {
                    //no pictures found to add to the database and file folder
                    echo "No Edit/s Found";
                    exit();
                }

            } catch (Exception $e) {
                echo $e;
                exit();
            }
        }

        //EXECUTE THE UPDATE WITH IMAGES AND UPDATED INFORMATION OF PROPERTY
        //add closing semi column
        $sql .= ";";
        //EXECUTE THE QUERY

        try {
            $query = mysqli_query($conn, $sql);
            if ($query === false) {
                throw new Exception($this->mysqli->error);
            }
            //check for property images changed
            $targetDir = '../uploads/';
            $fileNames = array_filter($propertyImage['name']);
            if (!empty($fileNames)) {
                foreach ($propertyImage['name'] as $key => $val) {
                    $fileName = basename($propertyImage['name'][$key]);
                    $fileExt = explode('.', $fileName);
                    $fileTmpName = $propertyImage['tmp_name'];
                    $fileActualExt = strtolower(end($fileExt));
                    $newFileName = uniqid('', true);
                    $fileNameNew = $newFileName . "." . $fileActualExt;

                    $targetFilePath = $targetDir . $fileNameNew;
                    if (!move_uploaded_file($propertyImage['tmp_name'][$key], $targetFilePath)) {
                        throw new Exception("Image NOT UPLOADED" . $_FILES["file"]["error"]);
                        //break the loop
                        break;
                        //exit the script
                        exit();
                    }
                    $sql = "INSERT INTO images (propertyid,file_name) VALUES(?,?);";
                    $stmt = mysqli_stmt_init($conn);

                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        throw new Exception($this->mysqli->error);
                        //break the loop
                        break;
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, 'ss', $propertyId, $newFileName);
                        if (!mysqli_stmt_execute($stmt)) {
                            throw new Exception($this->mysqli->error);
                            //break the loop
                            break;
                            mysqli_stmt_close($stmt);

                        }
                    }
                }
                //updated with pcitures
                echo "Success, Property Updated";
                exit();
            } else {
                //property updated without pictures
                echo "Success, Property Updated!";
            }

        } catch (Exception $e) {
            echo $e;
            exit();
        }

    } else {
        echo "No Property Found to Edit";
    }

} else {
    echo "Error Updating the Property: Contact Developer!";
}