<?php
include 'dbh.inc.php';

$data = array();
session_start();
$userId = $_SESSION['userid'];

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from property WHERE usersId=" . $userId . " AND approval  NOT IN  ('Pending','Deny','Delete','On-Going','Closed','Cancelled') limit 5");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, 'select * from property WHERE usersId=' . $userId . '  AND approval  NOT IN  ("Pending","Deny","Delete","On-Going","Closed","Cancelled") AND propertyId LIKE "%' . $search . '%" limit 5');
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['propertyid'], "text" => $row['propertyname']);
}
echo json_encode($data);