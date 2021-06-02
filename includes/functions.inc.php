<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

function emptyInputsSignup($email, $pwd, $pwdrepeat, $firstname, $lastname, $mobile, $position, $managerid)
{
    $result;
    if (empty($email) || empty($pwd) || empty($pwdrepeat) || empty($firstname) || empty($lastname) || empty($mobile) || $position === "Position Type" || $managerid === 0) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

// function pwdMatch($pwd, $pwdrepeat)
// {
//     $result;
//     if ($pwd !== $pwdrepeat) {
//         $result = true;
//     } else {
//         $result = false;
//     }
//     return $result;
// }

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE companyEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "statement Failed";
        //exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    // echo $resultData;
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        return $row;
    } else {
        $result = 0;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function mobileNumberExists($conn, $mobile)
{
    $sql = "SELECT * FROM users WHERE usersMobileNumber=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $mobile);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function userMobileNumberExist($conn, $mobile, $propertyId, $tableName)
{
    $sql = "SELECT propertyId,usersMobileNumber FROM $tableName WHERE usersMobileNumber=? AND propertyId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "Statement Failed";
        // exit();
    }
    mysqli_stmt_bind_param($stmt, 'ss', $mobile, $propertyId);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    // echo $resultData;
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        return $row;
    } else {
        $result = 0;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function userNotApproved($conn, $propertyOwner)
{
    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $propertyOwner);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        if ($row['approval'] === 0) {
            $result = true;
        }
    } else {
        $result = false;
    }
    return $result;
    mysqli_stmt_close($stmt);
}

function createManagerUser($conn, $email, $firstname, $middlename, $lastname, $birthday, $houseno, $brgy, $city, $province, $tin, $mobile, $position, $profileImg, $valididimg, $password)
{
//result variable
    $result = "";
    $managerId;
//upload first: profile image
    $profileImgName = $profileImg['name'];
    $profileExt = explode('.', $profileImgName);
    $profileTmpName = $profileImg['tmp_name'];
    $profileFileActualExt = strtolower(end($profileExt));
    $newProfileFileName = uniqid('', true);
    $profileFileNameNew = $newProfileFileName . "." . $profileFileActualExt;
    $profileFileDestination = '../uploads/' . $profileFileNameNew;

    if (move_uploaded_file($profileTmpName, $profileFileDestination)) {
        //profile Image Uploaded successfully
        //upload second: valid Img
        $fileName = $valididimg['name'];
        $fileExt = explode('.', $fileName);
        $fileTmpName = $valididimg['tmp_name'];
        $fileActualExt = strtolower(end($fileExt));
        $newFileName = uniqid('', true);
        $fileNameNew = $newFileName . "." . $fileActualExt;
        $fileDestination = '../uploads/' . $fileNameNew;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            //valid Id Uploaded Successfully
            $companyEmail = strtolower(current(explode("@", $email))) . "@arverizon.com";

            $sql = "INSERT INTO users (usersEmail,companyEmail,usersFirstName,usersMiddleName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key,profile_Img,birthday,houseNo,tinNo,barangay,city,province) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $result = "Internal Error: Manager`s Statement Error";
            } else {

                mysqli_stmt_bind_param($stmt, 'ssssssssssssssss', $email, $companyEmail, $firstname, $middlename, $lastname, $mobile, $position, $password, $newFileName, $newProfileFileName, $birthday, $houseno, $tin, $brgy, $city, $province);
                if (mysqli_stmt_execute($stmt)) {
                    //get the id of latest inserted query;
                    $managerId = $conn->insert_id;
                    mysqli_stmt_close($stmt);
                    $managerReference = "AR-" . strtoupper($firstname[0]) . strtoupper($lastname[0]) . $managerId;

                    //insert the user to manager table
                    $sql = "INSERT INTO managers (name,usersId,managerReference) VALUES(?,?,?);";
                    $stmt = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        $result = "Internal Error: Manager`s Statement Error";
                    } else {
                        $name = $firstname . " " . $lastname;
                        mysqli_stmt_bind_param($stmt, 'sss', $name, $managerId, $managerReference);
                        if (mysqli_stmt_execute($stmt)) {
                            // $result = "Manager Successfully Registered";
                            $result = sendEmail($companyEmail, $email, $password, $firstname, $lastname);
                        } else {
                            //error in inserting in manager table
                            $result = "Internal Server Error";
                        }
                    }
                } else {
                    $result = "Internal Server Error";
                }
            }
        } else {
            //error in uploading valid Id
            $result = "Error Uploading valid Image";
        }

    } else {
        //error in upload profile img
        $result = "Error Uploading Profile Image";
    }
    return $result;
}

function createAgentUser($conn, $email, $firstname, $middlename, $lastname, $birthday, $houseno, $brgy, $city, $province, $tin, $mobile, $position, $profileImg, $valididimg, $password, $managerid)
{
//result variable
    $result = "";
//upload first: profile image
    $profileImgName = $profileImg['name'];
    $profileExt = explode('.', $profileImgName);
    $profileTmpName = $profileImg['tmp_name'];
    $profileFileActualExt = strtolower(end($profileExt));
    $newProfileFileName = uniqid('', true);
    $profileFileNameNew = $newProfileFileName . "." . $profileFileActualExt;
    $profileFileDestination = '../uploads/' . $profileFileNameNew;

    if (move_uploaded_file($profileTmpName, $profileFileDestination)) {
        //profile Image Uploaded successfully
        //upload second: valid Img
        $fileName = $valididimg['name'];
        $fileExt = explode('.', $fileName);
        $fileTmpName = $valididimg['tmp_name'];
        $fileActualExt = strtolower(end($fileExt));
        $newFileName = uniqid('', true);
        $fileNameNew = $newFileName . "." . $fileActualExt;
        $fileDestination = '../uploads/' . $fileNameNew;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            //valid Id Uploaded Successfully
            $companyEmail = strtolower(current(explode("@", $email))) . "@arverizon.com";

            $sql = "INSERT INTO users (usersEmail,companyEmail,usersFirstName,usersMiddleName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key,profile_Img,birthday,houseNo,tinNo,barangay,city,province,managerid) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $result = "Internal Error: Agent`s Statement Error";
            } else {

                mysqli_stmt_bind_param($stmt, 'sssssssssssssssss', $email, $companyEmail, $firstname, $middlename, $lastname, $mobile, $position, $password, $newFileName, $newProfileFileName, $birthday, $houseno, $tin, $brgy, $city, $province, $managerid);
                if (mysqli_stmt_execute($stmt)) {
                    // $result = "Agent Successfully Registered";
                    $result = sendEmail($companyEmail, $email, $password, $firstname, $lastname);

                } else {
                    $result = "Internal Server Error";
                }
            }
        } else {
            //error in uploading valid Id
            $result = "Error Uploading valid Image";
        }

    } else {
        //error in upload profile img
        $result = "Error Uploading Profile Image";
    }
    return $result;

}

function emptyInputLogin($email, $pwd)
{
    $result;
    if (empty($email) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $pwd)
{
    $uidExists = emailExists($conn, $email);
    $result = false;
    if ($uidExists === 0) {
        $result = "User does not exist";
    } else {
        //get the user password and compare to users password in the database
        $hashedPwd = $uidExists['usersPwd'];
        $userTag = $uidExists['Tag'];
        if ($userTag == "New User") {
            //password is not hashed and need to be change
            $result = "Password reset needed";

        } else {
            //check if the password user typed is verified
            $checkPwd = password_verify($pwd, $hashedPwd);
            if ($checkPwd === false) {
                $result = "Wrong logged in Credentials";
            } else if ($checkPwd === true) {
                session_start();
                $_SESSION["userid"] = $uidExists["usersId"];
                $result = "Success";
            }

        }
    }

    return $result;
}

function emptyvalIdImg($valididimg)
{

    $fileError = $valididimg['error'];
    $result;
    if ($fileError === 4) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidImgType($valididimg)
{
    $fileName = $valididimg['name'];
    $fileError = $valididimg['error'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'tiff');
    $result;

    if (!in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            $result = true;
        }
    } else {
        $result = false;
    }
    return $result;
}

function invalidImgSize($valididimg)
{
    $fileSize = $valididimg['size'];
    $result;
    if ($fileSize < 5000000) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function invalidATSSize($ATS)
{
    $fileSize = $ATS['size'];
    $result = true;
    if ($fileSize < 5000000) {
        $result = false;
    }
    return $result;
}

function emptypropertyImg($propertyImage)
{
    $result = false;
    $fileNames = array_filter($propertyImage['name']);
    if (empty($fileNames)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidPropertyImg($propertyImage)
{
    // $fileName = $valididimg['name'];
    // $fileError = $valididimg['error'];
    // $fileExt = explode('.', $fileName);
    // $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'tiff');
    $targetDir = "uploads/";

    $fileNames = array_filter($propertyImage['name']);

    // print_r(pathinfo($fileNames, PATHINFO_EXTENSION));

    if (!empty($fileNames)) {
        foreach ($propertyImage['name'] as $key => $val) {
            // File upload path
            $fileName = basename($propertyImage['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            if (!in_array($fileType, $allowed)) {
                // Upload file to server
                $result = true;
                return $result;
            }
        }
    }
}

function checkPropertyImgSize($propertyImage)
{
    $fileSize = array_filter($propertyImage['size']);
    $result = false;
    if (!empty($fileSize)) {
        foreach ($propertyImage['size'] as $key => $val) {
            // File upload path
            $fileSizes = $propertyImage['size'][$key];
            //if the file img is greater than 5mb (5,000,000 bytes)
            if ($fileSizes > 5000000) {
                $result = true;
            }
        }
    }
    return $result;
}

function emptypInputProperty($propertyName, $propertyLocation, $propertyLotArea, $propertyFloorArea, $propertyAmount, $propertyDesc)
{
    $result;
    if (empty($propertyName) || empty($propertyLocation) || empty($propertyLotArea) || empty($propertyFloorArea) || empty($propertyAmount) || empty($propertyDesc)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function uploadProperty($conn, $propertyImage, $propertyName, $propertyType, $listingUnitNo, $listingSubCategory, $propertyOfferType, $listingPrice, $listingRentChoice, $listingLotArea, $listingFloorArea, $listingBedrooms, $listingCapacityOfGarage, $propertyDesc, $propertyATS, $listingRFUB, $listingHLB, $listingStreet, $listingSubdivision, $listingBrgyAddress, $listingCityAddress, $propertyOwner)
{
    //testing mode set to true if you want to see error in execution
    define("TESTING", false);
    $result = "default";

    $sql = "SELECT approval FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Internal Error: Users`s Statement Error";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyOwner);
        mysqli_stmt_execute($stmt);
        //store users approval status
        $approvalStatus = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($approvalStatus)) {
            //user is still pending and his property upload will be pending also
            if ($row['approval'] === 0) {
                //create insert sql for property upload
                $insertsql = "INSERT INTO property(usersId,propertyname,unitNo,offertype,propertytype,subcategory,propertylotarea,propertyfloorarea,propertybedrooms,propertycarpark,propertyamount,propertydesc,RoomFloorUnitNoBuilding,HouseLotBlockNo,street,subdivision,barangay,city,propertyrentchoice)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
                $insertstmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($insertstmt, $insertsql)) {
                    $result = "Internal Error: Property`s Statement Error";
                } else {
                    mysqli_stmt_bind_param($insertstmt, 'sssssssssssssssssss', $propertyOwner, $propertyName, $listingUnitNo, $propertyOfferType, $propertyType, $listingSubCategory, $listingLotArea, $listingFloorArea, $listingBedrooms, $listingCapacityOfGarage, $listingPrice, $propertyDesc, $listingRFUB, $listingHLB, $listingStreet, $listingSubdivision, $listingBrgyAddress, $listingCityAddress, $listingRentChoice);
                    //execute the query
                    if (mysqli_stmt_execute($insertstmt)) {
                        //get the id of insert property
                        $propertyId = $conn->insert_id;

                        // upload the images to data file folder
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
                                    $sql = "INSERT INTO images (propertyid,file_name) VALUES(?,?);";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                                        if (TESTING) {
                                            //show this error in testing mode
                                            $result = "Error inserting image name to datebase!";
                                        }
                                        //stop the loop
                                        break;
                                    } else {
                                        mysqli_stmt_bind_param($stmt, 'ss', $propertyId, $newFileName);
                                        if (!mysqli_stmt_execute($stmt)) {
                                            //display the error in testing mode
                                            if (TESTING) {
                                                //inserting property information error
                                                $result = mysqli_stmt_error($stmt);
                                            }
                                            //close statement;
                                            mysqli_stmt_close($stmt);

                                            break;
                                        }
                                    }
                                } else {
                                    //show error in uploading ATS FILE in testing mode
                                    if (TESTING) {
                                        $result = "Image NOT UPLOADED" . $_FILES["file"]["error"];
                                    }
                                    break;
                                }
                            }
                        }
                        //upload ATS FILE and insert the name of file to database
                        $ATSFileName = $propertyATS['name'];
                        $ATSExt = explode('.', $ATSFileName);
                        $ATSTmpName = $propertyATS['tmp_name'];
                        $ATSFileActualExt = strtolower(end($ATSExt));
                        $ATSFileNewName = explode(' ', trim($propertyName))[0] . "_ATS" . uniqid('', true);
                        $ATSFileNameWithExt = $ATSFileNewName . "." . $ATSFileActualExt;
                        $ATSFileDestination = '../uploads/' . $ATSFileNameWithExt;

                        if (move_uploaded_file($ATSTmpName, $ATSFileDestination)) {
                            //insert the file name to property`s information
                            $sql = "UPDATE property SET ATSFile = ?  WHERE propertyid=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                if (TESTING) {
                                    $result = "Error inserting ATS name to datebase!";
                                }

                            } else {
                                mysqli_stmt_bind_param($stmt, 'ss', $ATSFileNewName, $propertyId);
                                if (mysqli_stmt_execute($stmt)) {
                                    //PROPERTY SUCCESSFULLY CREATED!
                                    $result = "Property Submitted";
                                    //close statement;
                                    mysqli_stmt_close($stmt);
                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($stmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($stmt);
                                }
                            }

                        } else {
                            //show error in uploading ATS FILE in testing mode
                            if (TESTING) {
                                $result = "ATS NOT UPLOADED" . $_FILES["file"]["error"];
                            }
                        }

                    } else {
                        //display the error in testing mode
                        if (TESTING) {
                            //inserting property information error
                            $result = mysqli_stmt_error($insertstmt);
                        }
                        //close statement;
                        mysqli_stmt_close($insertstmt);
                    }
                }
            }
        }
    }
    return $result;
}

function propertyAlreadyApproved($propertyid, $conn)
{
    $sql = "SELECT * FROM property WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $approval = $row['approval'];
        mysqli_stmt_close($stmt);

        if ($approval == 1) {
            $result = true;
        } else {
            $result = false;
        }
    }
    return $result;
}

function approvePropertyStatus($propertyid, $conn)
{
    $result;
    $sql = "UPDATE property SET approval = 'Posted'  WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyid);
        mysqli_stmt_execute($stmt);
    }
}

function propertyAlreadydenied($propertyid, $conn)
{
    $sql = "SELECT * FROM property WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $approval = $row['approval'];
        mysqli_stmt_close($stmt);

        if ($approval == 2) {
            $result = true;
        } else {
            $result = false;
        }
    }
    return $result;
}

function denyPropertyStatus($propertyid, $conn)
{
    $sql = "UPDATE property SET approval = 'Deny'  WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyid);
        mysqli_stmt_execute($stmt);
    }
}

function deleteProperty($propertyid, $conn)
{
    $sql = "UPDATE property SET approval = 3  WHERE propertyid=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $propertyid);
        mysqli_stmt_execute($stmt);
    }
}

function userAlreadyApproved($userid, $conn)
{
    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $approval = $row['approval'];
        mysqli_stmt_close($stmt);

        if ($approval == 1) {
            $result = true;
        } else {
            $result = false;
        }
    }
    return $result;
}

function approveUserStatus($userid, $conn)
{
    // $result;
    $sql = "UPDATE users SET approval = 1  WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userid);
        mysqli_stmt_execute($stmt);
    }
}

function userAlreadydenied($userid, $conn)
{
    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $approval = $row['approval'];
        mysqli_stmt_close($stmt);

        if ($approval == 2) {
            $result = true;
        } else {
            $result = false;
        }
    }
    return $result;
}

function denyUserStatus($userid, $conn)
{
    $sql = "UPDATE users SET approval = 2  WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userid);
        mysqli_stmt_execute($stmt);
    }
}

function deleteUser($userid, $conn)
{
    $sql = "UPDATE users SET approval = 3  WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userid);
        mysqli_stmt_execute($stmt);
    }
}

function minGreaterThanMax($minBedrooms, $maxBedrooms)
{
    $result;

    if ($minBedrooms > $maxBedrooms) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

// function searchProperty($offerType, $location, $lotArea, $floorArea, $propertyType, $minBedrooms, $maxBedrooms){

// SELECT *
// FROM property
// WHERE (job_lvl >= 200) OR
//   (hire_date < '01/01/1998')

// $sql = "SELECT * FROM property WHERE usersEmail=?;";
// $stmt = mysqli_stmt_init($conn);

// if (!mysqli_stmt_prepare($stmt, $sql)) {
//     header("location: ../index.php?error=stmtfailed");
//     exit();
// }
// mysqli_stmt_bind_param($stmt, 's', $email);
// mysqli_stmt_execute($stmt);

// $resultData = mysqli_stmt_get_result($stmt);

// if ($row = mysqli_fetch_assoc($resultData)) {
//     return $row;
// } else {
//     $result = false;
//     return $result;
// }

// mysqli_stmt_close($stmt);

// }

function insertMessage($userName, $userNo, $propertyId, $propertyName, $agentId, $agentName, $conn)
{
    $sql = "INSERT INTO messages (userName,usersMobileNumber,propertyId,propertyName,agentId,agentname) VALUES(?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "Statement Failed";
        //  exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'ssisis', $userName, $userNo, $propertyId, $propertyName, $agentId, $agentName);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $result = "Message saved";
        // header("location: ../index.php?error=none ");
        //exit();
    }
    return $result;
}

function notvalidMobileNumber($userNo)
{
    $pattern = '/^(09|\+639)\d{9}$/';
    $result = 1;

    if (preg_match($pattern, $userNo)) {
        $result = 0;
    }
    return $result;
}

// ADMIN FUNCTIONS
function emptyInputs($username, $email, $pwd, $pwdrepeat, $firstname, $lastname, $mobile)
{
    $result;
    if (empty($username) || empty($email) || empty($pwd) || empty($pwdrepeat) || empty($firstname) || empty($lastname) || empty($mobile)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createAdminAccount($username, $email, $pwd, $firstname, $lastname, $mobile, $conn)
{
    $result = "";
    $sql = "INSERT INTO admin (adminEmail,adminFirstName,adminLastName,adminMobileNumber,usersPwd,adminusername) VALUES(?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "1st Statement Failed";

        //exit();
    } else {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, 'ssssss', $email, $firstname, $lastname, $mobile, $hashedPwd, $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $result = "Upload Success2";
    }
    return $result;
}

function loginAdmin($conn, $uid, $pwd)
{
    $result = "";

    $sql = "SELECT * FROM admin WHERE adminEmail=? OR adminusername=? ;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        //header("location: ../index.php?error=stmtfailed");
        $result = 'stmtfailed';
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'ss', $uid, $uid);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {

        $pwdhashed = $row['usersPwd'];
        $checkPwd = password_verify($pwd, $pwdhashed);
        if ($checkPwd === false) {
            // header("location: ../index.php?error=wronglogin");
            $result = "Wrong logged in Credentials";
            // exit();
        } else if ($checkPwd === true) {
            session_start();
            $_SESSION["adminUser"] = $row["adminid"];
            // header("location: ../index.php");
            // exit();
            $result = "Success";
        }
    } else {
        $result = "No User Found";
    }

    mysqli_stmt_close($stmt);
    return $result;
}

function agentAlreadyfeatured($conn, $userNumber)
{
    $sql = "SELECT featId FROM featuredAgent WHERE usersNumber=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "statement Failed";
        //exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $userNumber);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
// echo $resultData;
    if (mysqli_num_rows($resultData) > 0) {
        $row = mysqli_fetch_assoc($resultData);
        $result = true;
    } else {
        $result = false;
    }

    mysqli_stmt_close($stmt);
    return $result;
}

function userHaveNoProfileImg($conn, $agentNumber)
{
    $sql = "SELECT profile_Img FROM users WHERE usersMobileNumber=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "statement Failed";
        //exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $agentNumber);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
// echo $resultData;
    if (mysqli_num_rows($resultData) > 0) {
        while ($row = mysqli_fetch_assoc($resultData)) {
            if ($row['profile_Img'] == null) {
                $result = true;

            } else {
                $result = false;

            }

        }

    } else {
        $result = false;
    }

    mysqli_stmt_close($stmt);
    return $result;

}

function featuredTable($conn)
{
    $sql = "SELECT COUNT(featId) as Agents FROM featuredAgent;";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        return $row['Agents'];

    }

}

function forgotPwdInputsEmpty($email, $mobile, $pwd, $pwdrepeat)
{
    $result = false;

    if (empty($email) || empty($mobile) || empty($pwd) || empty($pwdrepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function resetPwdInputsEmpty($pwd, $pwdrepeat)
{
    $result = false;

    if (empty($pwd) || empty($pwdrepeat)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function passwordNotSame($pwd, $pwdrepeat)
{
    $result = false;

    if ($pwd != $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function changePassword($conn, $email, $pwd)
{
    $sql = "UPDATE users SET usersPwd=?, Tag=? WHERE companyEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    $Tag = "Regular User";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "statement Failed";
        //exit();
    }
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, 'sss', $hashedPwd, $Tag, $email);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        $result = true;
    } else {
        mysqli_stmt_close($stmt);
        $result = false;

    }
    return $result;
}

function deleteMessage($messagedId, $conn)
{
    $sql = "DELETE FROM messages WHERE messageId=?;";
    $result = '';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $messagedId);
        mysqli_stmt_execute($stmt);
        $result = "Success";
    }
    mysqli_stmt_close($stmt);
    return $result;
}

function deleteSchedule($scheduleId, $conn)
{
    $sql = "DELETE FROM schedules WHERE scheduleid=?;";
    $result = '';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $scheduleId);
        mysqli_stmt_execute($stmt);
        $result = "Success";
    }
    mysqli_stmt_close($stmt);
    return $result;

}

function approveManager($conn, $managerId)
{
    $sql = "UPDATE managers SET approval=1 WHERE managerId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = "";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
    }
    mysqli_stmt_bind_param($stmt, 's', $managerId);
    if (mysqli_stmt_execute($stmt)) {
        $result = "Success";
    } else {
        $result = "Error in updating the Account!";
    }
    return $result;
    mysqli_stmt_close($stmt);
}

function denyManager($conn, $managerId)
{
    $sql = "UPDATE managers SET approval=2 WHERE managerId=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = "";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
    }
    mysqli_stmt_bind_param($stmt, 's', $managerId);
    if (mysqli_stmt_execute($stmt)) {
        $result = "Success";
    } else {
        $result = "Error in updating the Account!";
    }
    return $result;
    mysqli_stmt_close($stmt);
}

function checkManagerId($managerId, $conn)
{
    $sql = "SELECT * from managers WHERE managerReference=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = "";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Statement Failed";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $managerId);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        $result = mysqli_num_rows($resultData);
        if (mysqli_num_rows($resultData) > 0) {
            //there is a result
            $result = true;
            // $row = mysqli_fetch_assoc($resultData);
            // $reuslt = $row;
        } else {
            $result = false;
        }

        mysqli_stmt_close($stmt);
    }
    return $result;
}

function sendEmail($companyemail, $email, $defaultPassword, $firstname, $lastname)
{
    $result = "";
    try {
        require '../PHPMailer/src/PHPMailer.php';
        require '../PHPMailer/src/Exception.php';
        require '../PHPMailer/src/SMTP.php';

        $mail = new PHPMailer();
        $mail->IsHTML(true);
        $mail->IsSMTP(true);
        $mail->CharSet = "utf-8";
// Sending Email
        // $mail->SMTPAuth = true; // enable SMTP authentication
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // sets the prefix to the servier
        // $mail->Host = "smtp.elasticemail.com"; // sets GMAIL as the SMTP server
        // $mail->Port = 2525; // set the SMTP port for the GMAIL server
        // $mail->Username = "nonreply@arverizon.com"; // GMAIL username
        // $mail->Password = "BEE0AAD9AFCC23302CACD16D67246F43B4CC"; // GMAIL password

        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->Host = 'mail.arverizon.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'noreply@arverizon.com'; //SMTP username
        $mail->Password = 'Z9H*k?wUb(YH'; //SMTP password
        $mail->SMTPSecure = 'tls'; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//Recipients
        $mail->setFrom('noreply@arverizon.com', 'AR Verizon');

//ROOM FOR IMPROVE

        // $mail->DKIM_domain = 'arverizon.com';
        // $mail->DKIM_private = '../keys/private.key';
        // $mail->DKIM_selector = 'phpmailer';
        // $mail->DKIM_passphrase = '';
        // $mail->DKIM_identity = $mail->From;

        $mail->addAddress($email); //Add a recipient
        $mail->addReplyTo('helpdesk@arverizon.com', 'Customer Service');
        $mail->addCC('helpdesk@arverizon.com');

        $email_template = '../email_templates/emailTemplate.html';

        $username = 'nonreply@arverizon.com';
        $password = 'C6D97476387E1AA45833DFDA523959397F5B';

        $message = file_get_contents($email_template);
        $message = str_replace('%USER_NAME%', $firstname . " " . $lastname, $message);
        $message = str_replace('%EMAIL_ADDRESS%', $companyemail, $message);
        $message = str_replace('%EMAIL_PASSWORD%', $defaultPassword, $message);

        //adding image to the website
        $message = str_replace("%BANNER_ACCOUNT%", "https://i.ibb.co/kJ1bxCJ/banner-Account.jpg", $message);
        $message = str_replace("%FB_LOGO%", "https://i.ibb.co/vBQBvDr/fbLogo.png", $message);
        $message = str_replace("%INSTA_LOGO%", "https://i.ibb.co/nfQzV4t/insta-Logo.png", $message);
        $message = str_replace("%TWITTER_LOGO%", "https://i.ibb.co/Chh4wJX/twitter-Logo.png", $message);

        $mail->MsgHTML($message);
        $mail->Subject = "Welcome to AR Verizon";
        $mail->send();
        $result = 'Message has been sent';

    } catch (Exception $e) {
        $result = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    return $result;
}

function createTransaction($conn, $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $Address, $terms, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable, $firstClient, $secondClient, $propertyId)
{
    $result = "";
    $sql = "INSERT INTO transactions (agentId,propertyName,propertyType,category,unitNo,TCP,termsOfPayment,address,status,dateOfTransaction,dataOfReservation,finalTCP,commission,receivable,commissionAgent,commissionAR,commissionBuyer,receivable2,firstClientId,secondClientId,propertyId) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        $result = "Internal Error: Transaction`s Statement Error";
    } else {

        mysqli_stmt_bind_param($stmt, 'sssssssssssssssssssss', $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $terms, $Address, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable, $firstClient, $secondClient, $propertyId);
        if (mysqli_stmt_execute($stmt)) {
            //get the id of latest inserted query;
            $result = "Transaction Created";
        } else {
            $result = mysqli_stmt_error($stmt);
        }

    }
    return $result;
}

function insertClientInformation($conn, $fName, $mName, $lName, $clientMobileNumber, $clientLandlineNumber, $emailAddress, $birthday, $gender, $clientAge, $civilStatus, $clientRFUB, $clientHLB, $clientStreet, $subdivision, $clientBrgyAddress, $clientCityAddress, $companyName, $companyInitalAddress, $companyStreet, $companyBrgyAddress, $companyCityAddress, $firstValidIdHolder, $secondValidIdHolder)
{
    $result = "default";
    //testing mode (to see error properly)
    define("TESTING", false);

    $firstValidIdImgName = $firstValidIdHolder['name'];
    $firstValidIdExt = explode('.', $firstValidIdImgName);
    $firstValidIdTmpName = $firstValidIdHolder['tmp_name'];
    $firstValidIdActualExt = strtolower(end($firstValidIdExt));
    $newFirstValidIdFileName = uniqid('', true);
    $firstValidIdFileNameNew = $newFirstValidIdFileName . "." . $firstValidIdActualExt;
    $profileFileDestination = '../uploads/' . $firstValidIdFileNameNew;

    //upload first valid Id to file folder
    if (move_uploaded_file($firstValidIdTmpName, $profileFileDestination)) {
        //upload the second Valid Id

        $secondValidIdImgName = $secondValidIdHolder['name'];
        $secondValidIdExt = explode('.', $secondValidIdImgName);
        $secondValidIdTmpName = $secondValidIdHolder['tmp_name'];
        $secondValidIdActualExt = strtolower(end($secondValidIdExt));
        $newSecondValidIdFileName = uniqid('', true);
        $secondValidIdFileNameNew = $newSecondValidIdFileName . "." . $secondValidIdActualExt;
        $profileFileDestination = '../uploads/' . $secondValidIdFileNameNew;

        //upload second valid Id to file folder
        if (move_uploaded_file($secondValidIdTmpName, $profileFileDestination)) {
            //upload the second Valid Id

            //INSERT TO CLIENTS TABLE
            $sql = "INSERT INTO clients (firstName,middleName,lastName,mobileNumber,landlineNumber,email,birthday,gender,age,civilStatus,RoomFloorUnitNoBuilding,HouseLotBlockNo,street,subdivision,barangay,city,companyName,companyRoomFloorUnitNoBuilding,companyStreet,companyBarangay,companyCity,primaryId,secondaryId) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $result = "Internal Error: Transaction`s Statement Error";
            } else {
                mysqli_stmt_bind_param($stmt, 'sssssssssssssssssssssss', $fName, $mName, $lName, $clientMobileNumber, $clientLandlineNumber, $emailAddress, $birthday, $gender, $clientAge, $civilStatus, $clientRFUB, $clientHLB, $clientStreet, $subdivision, $clientBrgyAddress, $clientCityAddress, $companyName, $companyInitalAddress, $companyStreet, $companyBrgyAddress, $companyCityAddress, $firstValidIdFileNameNew, $secondValidIdFileNameNew);
                if (mysqli_stmt_execute($stmt)) {

                    mysqli_stmt_close($stmt);
                    //return the name of the client
                    // insert->id returns zero if there is an error
                    $result = $conn->insert_id;
                } else {
                    mysqli_stmt_close($stmt);

                    if (TESTING) {
                        //inserting property information error
                        $result = mysqli_stmt_error($stmt);
                    }

                }
            }
        } else {
            //error in upload second valid Id
            //show error in uploading ATS FILE in testing mode
            if (TESTING) {
                $result = "Second Image NOT UPLOADED" . $secondValidIdHolder["error"];
            }
            exit();
        }

    } else {
        //error in upload first valid Id
        //show error in uploading ATS FILE in testing mode
        if (TESTING) {
            $result = "First Image NOT UPLOADED" . $firstValidIdHolder["error"];
        }
        exit();
    }
    echo $result;
}