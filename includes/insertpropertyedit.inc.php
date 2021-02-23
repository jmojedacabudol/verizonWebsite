<?php

if (isset($_POST['propertyId'])) {
    $propertyId = $_POST['propertyId'];

    $elistingtitle = $_POST['elisting-title'];
    $elistingoffertype = $_POST['elisting-offer-type'];
    $elistinglocation = $_POST['elisting-location'];
    $elistingrentChoice = $_POST['elisting-rentChoice'];
    $elistingprice = $_POST['elisting-price'];
    $elistingtype = $_POST['elisting-type'];
    $elistinglotarea = $_POST['elisting-lot-area'];
    $elistingfloorarea = $_POST['elisting-floor-area'];
    $elistingbedroom = $_POST['elisting-bedroom'];
    $elistingcarpark = $_POST['elisting-carpark'];
    $elistingdesc = $_POST['elisting-desc'];

    $propertyImage = $_FILES['listing-image'];

    require_once 'dbh.inc.php';

//check if the user change in any of the property information

    $propertysql = "SELECT * FROM property WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";
    $query = "UPDATE property SET ";
    $conditions = array();
//do escaping here

    $result = mysqli_query($conn, $propertysql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['propertyname'] != $elistingtitle) {
                $conditions[] = "propertyname=" . "'" . mysqli_real_escape_string($conn, $elistingtitle) . "'";
            }
            if ($row['offertype'] != $elistingoffertype) {
                $conditions[] = "offertype=" . "'" . mysqli_real_escape_string($conn, $elistingoffertype) . "'";
            }
            if ($row['propertylocation'] != $elistinglocation) {
                $conditions[] = "propertylocation=" . "'" . mysqli_real_escape_string($conn, $elistinglocation) . "'";
            }

            if ($row['propertyrentchoice'] != $elistingrentChoice) {
                $conditions[] = "propertyrentchoice=" . "'" . mysqli_real_escape_string($conn, $elistingrentChoice) . "'";
            }

            if ($row['propertyamount'] != $elistingprice) {
                $conditions[] = "propertyamount=" . "'" . mysqli_real_escape_string($conn, $elistingprice) . "'";
            }

            if ($row['propertytype'] != $elistingtype) {
                $conditions[] = "propertytype=" . "'" . mysqli_real_escape_string($conn, $elistingtype) . "'";
            }

            if ($row['propertylotarea'] != $elistinglotarea) {
                $conditions[] = "propertylotarea=" . "'" . mysqli_real_escape_string($conn, $elistinglotarea) . "'";
            }

            if ($row['propertyfloorarea'] != $elistingfloorarea) {
                $conditions[] = "propertyfloorarea=" . "'" . mysqli_real_escape_string($conn, $elistingfloorarea) . "'";
            }

            if ($row['propertybedrooms'] != $elistingbedroom) {
                $conditions[] = "propertybedrooms=" . "'" . mysqli_real_escape_string($conn, $elistingbedroom) . "'";
            }
            if ($row['propertybedrooms'] != $elistingbedroom) {
                $conditions[] = "propertybedrooms=" . "'" . mysqli_real_escape_string($conn, $elistingbedroom) . "'";
            }
            if ($row['propertycarpark'] != $elistingcarpark) {
                $conditions[] = "propertycarpark=" . "'" . mysqli_real_escape_string($conn, $elistingcarpark) . "'";
            }
            if ($row['propertydesc'] != $elistingdesc) {
                $conditions[] = "propertydesc=" . "'" . mysqli_real_escape_string($conn, $elistingdesc) . "'";
            }

        }
        $sql = $query;
        // $test = "";
        if (count($conditions) > 0) {
            $sql .= implode(' , ', $conditions) . " WHERE propertyid=$propertyId";
        }

        $sql .= ";";
        //compare the string to check if there is anything to update in database
        if (mysqli_query($conn, $sql)) {
            // echo "Update Happens  ";
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
                    if (move_uploaded_file($propertyImage['tmp_name'][$key], $targetFilePath)) {

                        // $insertValuesSQL .= $propertyid . ",('" . $fileName . "'),";

                        $sql = "INSERT INTO images (propertyid,file_name) VALUES(?,?);";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "stmt failed";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, 'ss', $propertyId, $newFileName);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        $result = "uploaderror ";
                        exit();
                    }
                }
                //upload successful
                echo "Successfully updated your with Images.";

            } else {
                echo "Successfully updated your Property without Images.";
            }

        } else {
            // echo "No Updates Happened  ";
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
                    if (move_uploaded_file($propertyImage['tmp_name'][$key], $targetFilePath)) {

                        // $insertValuesSQL .= $propertyid . ",('" . $fileName . "'),";

                        $sql = "INSERT INTO images (propertyid,file_name) VALUES(?,?);";
                        $stmt = mysqli_stmt_init($conn);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "stmt failed";
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, 'ss', $propertyId, $newFileName);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);
                        }
                    } else {
                        $result = "uploaderror ";
                        exit();
                    }
                }
                //upload successful
                echo "Successfully updated your with Images.";

            } else {
                echo "Successfully updated your Property without Images.";
            }

        }
    }

}