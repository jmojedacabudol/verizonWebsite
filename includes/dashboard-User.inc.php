<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if ($_POST['editSubmit']) {

    define("TESTING", true);
    $profileImg = $_FILES['profilePic'];
    $validId = $_FILES['validId'];
    $newpass = $_POST['newpass'];
    $confirmpass = $_POST['confirm-pass'];

    // $usersNumber;
    $userlogged = "no-user";
    session_start();
    if (isset($_SESSION['userid'])) {
        $userlogged = $_SESSION['userid'];
    } else {
        echo "No User Logged in!";
        exit();
    }
    //check if profile img is less than 5mb
    if (invalidImgSize($profileImg)) {
        echo "Profile Image is too large!";
        exit();
    }

    //check if profile img is less than 5mb
    if (invalidImgSize($validId)) {
        echo "Valid Id Image is too large!";
        exit();
    }

//---------UPDATE THE PASSWORD---------
    if ($newpass !== "" && $confirmpass !== "") {
        $hashedPwd = password_hash(mysqli_real_escape_string($conn, $newpass), PASSWORD_DEFAULT);
        //update the pass of user
        $sql = "UPDATE users SET usersPwd=?;";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            if (TESTING) {
                echo "Error Updating Password to datebase!";
                exit();
            }

        } else {
            mysqli_stmt_bind_param($stmt, 's', $hashedPwd);
            if (mysqli_stmt_execute($stmt)) {
                //User`s PASSWORD SUCCESSFULLY changed!
                echo "User Updated!";
                exit();
            }
        }

    }
//---------UPDATE THE PASSWORD ENDS HERE---------

    //-----------DELETE OLD PICTURES OF USER------------
    if ($profileImg['size'] !== 0 && $validId['size'] !== 0) {
        $sql = "SELECT validid_key,profile_Img FROM users where usersId=" . mysqli_real_escape_string($conn, $userlogged);
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                //unlink the profile Img
                $unlinkProfileImg = $row['profile_Img'];
                $unlinkProfileFileName = "../uploads/$unlinkProfileImg" . "*";
                $unlinkProfileFileInfo = glob($unlinkProfileFileName);
                $unlinkProfileFileext = explode(".", $unlinkProfileFileInfo[0]);
                $unlinkProfileFileactualext = $unlinkProfileFileext[4];
                unlink('../uploads/' . $unlinkProfileImg . "." . $unlinkProfileFileactualext);

                //unlink valida id Img
                $unlinkValidIdFile = $row['validid_key'];
                $unlinkValidFilename = "../uploads/$unlinkValidIdFile" . "*";
                $unlinkValidFileInfo = glob($unlinkValidFilename);
                $unlinkValidFileext = explode(".", $unlinkValidFileInfo[0]);
                $unlinkValidFileactualext = $unlinkValidFileext[4];
                unlink('../uploads/' . $unlinkValidIdFile . "." . $unlinkValidFileactualext);

                //-----------UPLOAD FILES OF USER--------------------

                //upload the profile image to file folder
                $profileFileName = $profileImg['name'];
                $profileFileExt = explode('.', $profileFileName);
                $profileFileTmpName = $profileImg['tmp_name'];
                $profileFileActualExt = strtolower(end($profileFileExt));
                $profileNewFileName = uniqid('', true);
                $profileFileNameNew = $profileNewFileName . "." . $profileFileActualExt;
                $profileFileDestination = '../uploads/' . $profileFileNameNew;

                if (move_uploaded_file($profileFileTmpName, $profileFileDestination)) {
                    //upload the profile image to file folder
                    $validFileName = $validId['name'];
                    $validFileExt = explode('.', $validFileName);
                    $validFileTmpName = $validId['tmp_name'];
                    $validFileActualExt = strtolower(end($validFileExt));
                    $validNewFileName = uniqid('', true);
                    $validFileNameNew = $validNewFileName . "." . $validFileActualExt;
                    $validFileDestination = '../uploads/' . $validFileNameNew;

                    if (move_uploaded_file($validFileTmpName, $validFileDestination)) {

                        //---------UPDATE THE PASSWORD---------
                        if ($newpass !== "" && $confirmpass !== "") {
                            $hashedPwd = password_hash(mysqli_real_escape_string($conn, $newpass), PASSWORD_DEFAULT);
                            //update the pass of user
                            $sql = "UPDATE users SET usersPwd=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                if (TESTING) {
                                    echo "Error Updating Password to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $hashedPwd);
                                if (mysqli_stmt_execute($stmt)) {
                                    //User`s PASSWORD SUCCESSFULLY changed!
                                    //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                                    $imgSql = "UPDATE users SET validid_key=?,profile_Img=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                                    $imgStmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                        if (TESTING) {
                                            echo "Error Updating valid Id and Profile Image to datebase!";
                                            exit();
                                        }

                                    } else {
                                        mysqli_stmt_bind_param($imgStmt, 'ss', $validNewFileName, $profileNewFileName);
                                        if (mysqli_stmt_execute($imgStmt)) {
                                            //user profile img and valid id key successfully updated
                                            echo "User Updated!";
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);

                                        } else {
                                            //display the error in testing mode
                                            if (TESTING) {
                                                //inserting ATS name error
                                                $result = mysqli_stmt_error($imgStmt);
                                            }
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);
                                            exit();

                                        }
                                    }

                                    //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($stmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($stmt);
                                    exit();

                                }
                            }

                        } else {
                            //password/s are empty display success message
                            //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                            $imgSql = "UPDATE users SET validid_key=?,profile_Img=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                            $imgStmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                if (TESTING) {
                                    echo "Error Updating valid Id and Profile Image to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($imgStmt, 'ss', $validNewFileName, $profileNewFileName);
                                if (mysqli_stmt_execute($imgStmt)) {
                                    //user profile img and valid id key successfully updated
                                    echo "User Updated!";
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        echo mysqli_stmt_error($imgStmt);
                                        exit();
                                    }
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);
                                    exit();
                                }
                            }

                            //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----
                        }
                        //---------UPDATE THE PASSWORD ENDS HERE---------

                    } else {
                        //show error in uploading ATS FILE in testing mode
                        if (TESTING) {
                            echo "Profile Image NOT UPLOADED" . $_FILES["file"]["error"];
                        }
                        exit();

                    }

                } else {
                    //show error in uploading profile FILE in testing mode
                    if (TESTING) {
                        echo "Profile Image NOT UPLOADED" . $_FILES["file"]["error"];
                        exit();
                    }
                    exit();

                }

            }
        } else {
            echo "No Files Selected";
            exit();
        }
        //-----------UPLOAD FILES OF USER ENDS HERE----------

    } else {
        if ($profileImg['size'] !== 0) {
            $sql = "SELECT profile_Img FROM users where usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    //unlink the profile Img
                    $unlinkProfileImg = $row['profile_Img'];
                    $unlinkProfileFileName = "../uploads/$unlinkProfileImg" . "*";
                    $unlinkProfileFileInfo = glob($unlinkProfileFileName);
                    $unlinkProfileFileext = explode(".", $unlinkProfileFileInfo[0]);
                    $unlinkProfileFileactualext = $unlinkProfileFileext[4];
                    unlink('../uploads/' . $unlinkProfileImg . "." . $unlinkProfileFileactualext);

                    //-----------UPLOAD FILES OF USER--------------------

                    //upload the profile image to file folder
                    $profileFileName = $profileImg['name'];
                    $profileFileExt = explode('.', $profileFileName);
                    $profileFileTmpName = $profileImg['tmp_name'];
                    $profileFileActualExt = strtolower(end($profileFileExt));
                    $profileNewFileName = uniqid('', true);
                    $profileFileNameNew = $profileNewFileName . "." . $profileFileActualExt;
                    $profileFileDestination = '../uploads/' . $profileFileNameNew;

                    if (move_uploaded_file($profileFileTmpName, $profileFileDestination)) {

                        //---------UPDATE THE PASSWORD---------
                        if ($newpass !== "" && $confirmpass !== "") {
                            $hashedPwd = password_hash(mysqli_real_escape_string($conn, $newpass), PASSWORD_DEFAULT);
                            //update the pass of user
                            $sql = "UPDATE users SET usersPwd=?" . mysqli_real_escape_string($conn, $userlogged) . ";";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                if (TESTING) {
                                    echo "Error Updating Password to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $hashedPwd);
                                if (mysqli_stmt_execute($stmt)) {
                                    //User`s PASSWORD SUCCESSFULLY changed!
                                    //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                                    $imgSql = "UPDATE users SET profile_Img=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                                    $imgStmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                        if (TESTING) {
                                            echo "Error Updating valid Id and Profile Image to datebase!";
                                            exit();
                                        }

                                    } else {
                                        mysqli_stmt_bind_param($imgStmt, 'd', $profileNewFileName);
                                        if (mysqli_stmt_execute($imgStmt)) {
                                            //user profile img and valid id key successfully updated
                                            echo "User Updated!";
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);

                                        } else {
                                            //display the error in testing mode
                                            if (TESTING) {
                                                //inserting ATS name error
                                                $result = mysqli_stmt_error($imgStmt);
                                            }
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);
                                            exit();

                                        }
                                    }

                                    //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($stmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($stmt);
                                    exit();

                                }
                            }

                        } else {

                            //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                            $imgSql = "UPDATE users SET profile_Img=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                            $imgStmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                if (TESTING) {
                                    echo "Error Updating Profile Image to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($imgStmt, 's', $profileNewFileName);
                                if (mysqli_stmt_execute($imgStmt)) {
                                    //user profile img and valid id key successfully updated
                                    echo "User Updated!";
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($imgStmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);
                                    exit();

                                }
                            }

                            //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----

                        }
                        //---------UPDATE THE PASSWORD ENDS HERE---------

                    } else {
                        //show error in uploading profile FILE in testing mode
                        if (TESTING) {
                            echo "Profile Image NOT UPLOADED" . $_FILES["file"]["error"];
                        }
                        exit();
                    }
                    //-----------UPLOAD FILES OF USER ENDS HERE----------

                }
            } else {
                echo "No Files Selected";
                exit();
            }

        } else if ($validId['size'] !== 0) {
            $sql = "SELECT validid_key FROM users where usersId=" . mysqli_real_escape_string($conn, $userlogged);
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    //unlink valida id Img
                    $unlinkValidIdFile = $row['validid_key'];
                    $unlinkValidFilename = "../uploads/$unlinkValidIdFile" . "*";
                    $unlinkValidFileInfo = glob($unlinkValidFilename);
                    $unlinkValidFileext = explode(".", $unlinkValidFileInfo[0]);
                    $unlinkValidFileactualext = $unlinkValidFileext[4];
                    unlink('../uploads/' . $unlinkValidIdFile . "." . $unlinkValidFileactualext);

                    //-----------UPLOAD FILES OF USER--------------------

                    //upload the profile image to file folder
                    $validFileName = $validId['name'];
                    $validFileExt = explode('.', $validFileName);
                    $validFileTmpName = $validId['tmp_name'];
                    $validFileActualExt = strtolower(end($validFileExt));
                    $validNewFileName = uniqid('', true);
                    $validFileNameNew = $validNewFileName . "." . $validFileActualExt;
                    $validFileDestination = '../uploads/' . $validFileNameNew;

                    if (move_uploaded_file($validFileTmpName, $validFileDestination)) {

                        //---------UPDATE THE PASSWORD---------
                        if ($newpass !== "" && $confirmpass !== "") {
                            $hashedPwd = password_hash(mysqli_real_escape_string($conn, $newpass), PASSWORD_DEFAULT);
                            //update the pass of user
                            $sql = "UPDATE users SET usersPwd=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                if (TESTING) {
                                    echo "Error Updating Password to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $hashedPwd);
                                if (mysqli_stmt_execute($stmt)) {
                                    //User`s PASSWORD SUCCESSFULLY changed!
                                    //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                                    $imgSql = "UPDATE users SET valid_key=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                                    $imgStmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                        if (TESTING) {
                                            echo "Error Updating valid Id Image to datebase!";
                                            exit();
                                        }

                                    } else {
                                        mysqli_stmt_bind_param($imgStmt, 's', $validNewFileName);
                                        if (mysqli_stmt_execute($imgStmt)) {
                                            //user profile img and valid id key successfully updated
                                            echo "User Updated!";
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);

                                        } else {
                                            //display the error in testing mode
                                            if (TESTING) {
                                                //inserting ATS name error
                                                $result = mysqli_stmt_error($imgStmt);
                                            }
                                            //close statement;
                                            mysqli_stmt_close($imgStmt);
                                            exit();

                                        }
                                    }

                                    //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($stmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($stmt);
                                    exit();

                                }
                            }

                        } else {
                            //password/s are empty display success message
                            //------UPDATE THE FILES NAMES( profileImg,validid)---------------
                            $imgSql = "UPDATE users SET validid_key=? WHERE usersId=" . mysqli_real_escape_string($conn, $userlogged) . ";";
                            $imgStmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($imgStmt, $imgSql)) {
                                if (TESTING) {
                                    echo "Error Updating valid Id Image to datebase!";
                                    exit();
                                }

                            } else {
                                mysqli_stmt_bind_param($imgStmt, 's', $validNewFileName);
                                if (mysqli_stmt_execute($imgStmt)) {
                                    //user profile img and valid id key successfully updated
                                    echo "User Updated!";
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);

                                } else {
                                    //display the error in testing mode
                                    if (TESTING) {
                                        //inserting ATS name error
                                        $result = mysqli_stmt_error($imgStmt);
                                    }
                                    //close statement;
                                    mysqli_stmt_close($imgStmt);
                                    exit();

                                }
                            }

                            //------UPDATE THE FILES NAMES( profileImg,validid) ENDS HERE-----

                        }
                        //---------UPDATE THE PASSWORD ENDS HERE---------

                    } else {
                        //show error in uploading ATS FILE in testing mode
                        if (TESTING) {
                            echo "Profile Image NOT UPLOADED" . $_FILES["file"]["error"];
                        }
                        exit();

                    }
                    //-----------UPLOAD FILES OF USER ENDS HERE----------

                }
            } else {
                echo "No Files Selected";
                exit();
            }

        }
    }
//-----------DELETE OLD PICTURES OF USER ENDS HERE------------

} else {
    echo " No Account to Edit!";
    exit();
}