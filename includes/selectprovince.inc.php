<?php
include 'dbh.inc.php';

$data = array();

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from refprovince limit 5");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, "select * from refprovince where provDesc like '%" . $search . "%' limit 5");
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['id'], "text" => $row['provDesc']);
}
echo json_encode($data);