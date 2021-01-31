<?php
include 'dbh.inc.php';

$data = array();

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from managers limit 5");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, "select * from managers where name like '%" . $search . "%' limit 5");
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['managerId'], "text" => $row['name']);
}
echo json_encode($data);