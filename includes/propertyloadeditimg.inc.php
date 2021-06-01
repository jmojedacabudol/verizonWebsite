<?php

if (isset($_POST['propertyId'])) {
    $propertyId = $_POST['propertyId'];
    require_once 'dbh.inc.php';

    $sql = "SELECT file_name FROM images WHERE propertyid=" . "'" . mysqli_real_escape_string($conn, $propertyId) . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $databaseFileName = $row['file_name'];
            $filename = "../uploads/$databaseFileName" . "*";
            $fileInfo = glob($filename);
            $fileext = explode(".", $fileInfo[0]);
            $fileactualext = $fileext[4];

            $doc = new DOMDocument('1.0');
            $img = $doc->createElement('img');
            $img->setAttribute('src', 'uploads/' . $row['file_name'] . "." . $fileactualext);
            $img->setAttribute('id', $row['file_name']);
            $img->setAttribute('height', '60px');
            $img->setAttribute('width', '60px');
            $img->setAttribute('marginLeft', '15px');
            $img->setAttribute('class', 'propertyEditImg');
            $img->setAttribute('onclick', 'deletePropertyImg(this.id,' . $propertyId . ')');
            $doc->appendChild($img);
            echo $doc->saveHTML();
        }
    }
} else {
    echo "No Image Found";
}