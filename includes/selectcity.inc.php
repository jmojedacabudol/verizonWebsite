<?php
include 'dbh.inc.php';

$data = array();

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from cities limit 15");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, "select * from cities where name like '%" . $search . "%' limit 5");
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['name'], "text" => $row['name']);
}
echo json_encode($data);