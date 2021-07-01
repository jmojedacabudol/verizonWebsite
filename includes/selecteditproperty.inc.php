<?php
include 'dbh.inc.php';

$data = array();

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from property WHERE usersId=" . $_POST['usersId'] . " and approval in  ('Posted','On-Going') limit 5");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, 'select * from property WHERE usersId=' . $_POST['usersId'] . ' and approval in ("Posted","On-Going") and propertyname like "%' . $search . '%" limit 5');
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['propertyid'], "text" => $row['propertyname']);
}
echo json_encode($data);