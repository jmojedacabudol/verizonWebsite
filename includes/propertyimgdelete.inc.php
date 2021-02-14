<?php
if (isset($_POST['file_name'])) {
    $file_name = $_POST['file_name'];
    include_once 'dbh.inc.php';


    $sql = "SELECT file_name FROM images WHERE file_name ='$file_name';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $databaseFileName = $row['file_name'];
            $filename = "../uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[4];
            // print_r($fileactualext);
            //delete the picture from the database
            unlink('../uploads/' . $row['file_name'] . "." . $fileactualext);
        }
    }

    $sql2 = "DELETE FROM images WHERE file_name=?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql2)) {
        echo "stmtfailed";
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $file_name);
    if(mysqli_stmt_execute($stmt)){
        echo "Picture Deleted";
    }else{
        echo "Error Occured!";
    }
 
} else {
    echo "Opps Something happened";
}
