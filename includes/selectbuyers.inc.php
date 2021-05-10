<?php

require_once 'dbh.inc.php';

if (isset($_POST['propertySelected'])) {
    $propertySelected = $_POST['propertySelected'];

    $sql = "SELECT * FROM messages WHERE propertyId=" . "'" . mysqli_real_escape_string($conn, $propertySelected) . "'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<option></option>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['usersMobileNumber'] . '">' . $row['userName'] . '</option>';
        }
    } else {
        echo "<option>No Buyers Yet..</option>";

    }

}