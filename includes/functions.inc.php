<?php

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

function pwdMatch($pwd, $pwdrepeat)
{
    $result;
    if ($pwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE usersEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    $result = false;
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../index.php?error=stmtfailed");
        $result = "statemen Failed";
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

function createUser($conn, $email, $pwd, $firstname, $lastname, $mobile, $position, $valididimg, $managerid)
{
    $fileName = $valididimg['name'];
    $fileExt = explode('.', $fileName);
    $fileTmpName = $valididimg['tmp_name'];
    $fileActualExt = strtolower(end($fileExt));
    $newFileName = uniqid('', true);
    $fileNameNew = $newFileName . "." . $fileActualExt;
    $fileDestination = '../uploads/' . $fileNameNew;
    $result = "";

    if (move_uploaded_file($fileTmpName, $fileDestination)) {
        // $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key) VALUES('" . $email . "','" . $firstname . "','" . $lastname . "','" . $mobile . "','" . $position . "','" . $pwd . "','" . $newFileName . "');";
        // print_r("option " . $sql . " and " . $newFileName);
        // $result = mysqli_query($conn, $sql);
        // echo $result;

        if ($position === "Agent" && $managerid == 0) {
            $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key) VALUES(?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $result = "1st Statement Failed";

                //exit();
            } else {
                $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, 'sssssss', $email, $firstname, $lastname, $mobile, $position, $hashedPwd, $newFileName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                $result = "Success1";
                // $result = "Upload Success";

            }
        } else if ($position === "Agent" && $managerid != 0) {

            $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key,managerid) VALUES(?,?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                //$result = "1st Statement Failed";

                //exit();
            } else {
                $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, 'ssssssss', $email, $firstname, $lastname, $mobile, $position, $hashedPwd, $newFileName, $managerid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                // $result = "Normal Agent2 Upload Success";
                $result = "Success2";
            }
            //             $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key) VALUES('" . $email . "','" . $firstname . "','" . $lastname . "','" . $mobile . "','" . $position . "','" . $pwd . "','" . $newFileName . "');";
            // $result = print_r("option1" . $sql);
            // mysqli_query($conn, $sql);

        } else if ($position === 'Manager') {
            $sql = "INSERT INTO users (usersEmail,usersFirstName,userLastName,usersMobileNumber,usersPosition,usersPwd,validid_key) VALUES(?,?,?,?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                // $result = "1st Statement Failed";
                //exit();
            } else {
                $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, 'sssssss', $email, $firstname, $lastname, $mobile, $position, $hashedPwd, $newFileName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                $sql2 = "INSERT INTO managers (name) VALUES(?);";
                $stmt2 = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                    //  $result2 = "2nd Statement Failed";
                    //exit();
                } else {
                    $managername = $firstname . " " . $lastname;
                    mysqli_stmt_bind_param($stmt2, 's', $managername);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);

                    // $result = "Manager Upload Success";
                    $result = 'Success3';
                    //exit();
                }
            }
            // $result = "Manager";

        }
    } else {
        $result = "Upload Error";
        //exit();
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

// function loginUser($conn, $email, $pwd)
// {
//     $uidExists = emailExists($conn, $email);
//     $result;
//     if ($uidExists === 0) {
//         // header("location: ../index.php?error=wronglogin");
//         $result = "User not Exists";
//         // exit();
//     } else {

//         $pwdhashed = $uidExists['usersPwd'];
//         $checkPwd = password_verify($pwd, $pwdhashed);

//         if ($checkPwd === false) {
//             // header("location: ../index.php?error=wronglogin");
//             $result = "Wrong logged in Credentials";
//             // exit();
//         } else if ($checkPwd === true) {
//             session_start();
//             $_SESSION["userid"] = $uidExists["usersId"];
//             // header("location: ../index.php");
//             // exit();
//             $result = "Success";
//         }

//     }

//     return $result;

// }

function loginUser($conn, $email, $pwd)
{
    $uidExists = emailExists($conn, $email);
    $result = false;
    if ($uidExists === 0) {
        // header("location: ../index.php?error=wronglogin");
        $result = "User not Exists";
        // exit();
    } else {
        $accountType = $uidExists['Tag'];
        if ($accountType == 'facebook') {
            session_start();
            $_SESSION["userid"] = $uidExists["usersId"];
            $result = "Success";
        } else if ($accountType == 'Google') {
            session_start();
            $_SESSION["userid"] = $uidExists["usersId"];
            $result = "Success";
        } else {
            $pwdhashed = $uidExists['usersPwd'];
            $checkPwd = password_verify($pwd, $pwdhashed);

            if ($checkPwd === false) {
                // header("location: ../index.php?error=wronglogin");
                $result = "Wrong logged in Credentials";
                // exit();
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
    if ($fileSize < 50000000) {
        $result = false;
    } else {
        $result = true;
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

function invalidPropertyImgSize($propertyImage)
{
    $fileSize = array_filter($propertyImage['size']);
    $result = false;

    // print_r($fileSize);
    // print_r(pathinfo($fileNames, PATHINFO_EXTENSION));

    if (!empty($fileSize)) {
        foreach ($propertyImage['size'] as $key => $val) {
            // File upload path
            $fileSizes = $propertyImage['size'][$key];

            // print_r($fileSizes);
            if ($fileSizes > 5000000) {
                // $result = true;
                $result = true;
                return $result;
            }
        }
    }
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

function uploadProperty($propertyOwner, $propertyName, $propertyOfferType, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyCarpark, $propertyAmount, $propertyDesc, $propertyRentChoice, $propertyImage, $conn)
{
    $result;
    if ($propertyCarpark === "") {
        $propertyCarpark = 0;
    }

    $sql = "SELECT * FROM users WHERE usersId=?;";
    $stmt = mysqli_stmt_init($conn);
    $insertValuesSQL = "";
    $result = "";
    $propertyid = "";
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $propertyOwner);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        if ($row['approval'] === 0) {

            $insertsql = "INSERT INTO property (usersId,propertyname,offertype,propertylocation,propertytype,propertylotarea,propertyfloorarea,propertybedrooms,propertycarpark,propertyamount,propertydesc,propertyrentchoice) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
            $insertstmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($insertstmt, $insertsql)) {
                // header("location: ../index.php?error=stmtfailed");
                $result = "statement1 failed";
                //exit();
            } else {
                mysqli_stmt_bind_param($insertstmt, 'ssssssssssss', $propertyOwner, $propertyName, $propertyOfferType, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyCarpark, $propertyAmount, $propertyDesc, $propertyRentChoice);
                mysqli_stmt_execute($insertstmt);
                $propertyid = $conn->insert_id; // function will now return the ID instead of true.
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

                                //exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, 'ss', $propertyid, $newFileName);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }
                            // echo $insertValuesSQL;
                        } else {
                            $result = "uploaderror ";
                            exit();
                        }
                    }
                }
                $result = "Your listing is now uploaded. Awaiting for Admin`s Approval.";
            }
        } else if ($row['approval'] === 1) {

            $sql2 = "INSERT INTO property (usersId,propertyname,offertype,propertylocation,propertytype,propertylotarea,propertyfloorarea,propertybedrooms,propertycarpark,propertyamount,propertydesc,propertyrentchoice) VALUES(?,?,?,?,?,?,?,?,?,?,?,?);";
            $stmt2 = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                // header("location: ../index.php?error=stmtfailed");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt2, 'ssssssssssss', $propertyOwner, $propertyName, $propertyOfferType, $propertyLocation, $propertyType, $propertyLotArea, $propertyFloorArea, $propertyBedroom, $propertyCarpark, $propertyAmount, $propertyDesc, $propertyRentChoice);
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_close($stmt2);
                $propertyid = $conn->insert_id; // function will now return the ID instead of true.

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

                                //exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, 'ss', $propertyid, $newFileName);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }
                            // echo $insertValuesSQL;
                        } else {
                            $result = "uploaderror ";
                            exit();
                        }
                    }
                }
                $result = "Property Uploaded.";
            }
        }
        return $result;
        mysqli_stmt_close($stmt);
    }
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
    $sql = "UPDATE property SET approval = 1  WHERE propertyid=?;";
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
    $sql = "UPDATE property SET approval = 2  WHERE propertyid=?;";
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