<?php

require_once 'dbh.inc.php';

$sql = "SELECT adminid FROM admin";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "Admin Exists";
} else {
    echo "No Admin Exists";
}