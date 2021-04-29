<?php

require_once 'dbh.inc.php';

if (isset($_POST['usersId'])) {
    $usersId = $_POST['usersId'];

    $sql = "SELECT * FROM property WHERE usersId=" . "'" . mysqli_real_escape_string($conn, $usersId) . "'";

    $result = mysqli_query($conn, $sql);
    echo "<option></option>";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value=' . $row['properyid'] . '.>' . $row['propertyname'] . '</option>';

        }
    }

}