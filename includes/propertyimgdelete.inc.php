<?php
include_once 'dbh.inc.php';

if (isset($_POST['file_name'])) {
    $propertyFileName = $_POST['file_name'];
    $propertyId = $_POST['propertyId'];
    $propertyFileCount = 0;

    $countPropertyFileImageSql = "SELECT COUNT(file_name) as files FROM images WHERE propertyid=?";
    $countStmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($countStmt, $countPropertyFileImageSql)) {
        echo "Statement Error";
        //exit the script
        exit();
    } else {
        //check for the number of images found in database

        mysqli_stmt_bind_param($countStmt, 's', $propertyId);
        if (!mysqli_stmt_execute($countStmt)) {
            //error in executing count query
            echo mysqli_stmt_error($countStmt);

        } else {
            $result = mysqli_stmt_get_result($countStmt);
            while ($row = mysqli_fetch_assoc($result)) {
                $propertyFileCount = $row['files'];
            }
            mysqli_stmt_close($countStmt);
        }
        //if the property image is ony 1 proceed to error
        if ($propertyFileCount !== 1) {

            $fileName = $propertyFileName;
            $filename = "../uploads/$fileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[4];

            //delete the picture from the file folder
            unlink('../uploads/' . $fileName . "." . $fileactualext);

            $sql2 = "DELETE FROM images WHERE file_name=?;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql2)) {
                echo "Statement Error! Cannot delete the Image!";
                exit();
            }

            mysqli_stmt_bind_param($stmt, 's', $propertyFileName);
            if (!mysqli_stmt_execute($stmt)) {
                echo mysqli_stmt_error($stmt);
                exit();
            }
            echo "Property Image Deleted";

        } else {
            echo "Cannot delete this Property Image";
            exit();
        }
    }

} else {
    echo "File not found!";
}