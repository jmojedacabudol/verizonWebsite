<?php
include 'dbh.inc.php';

$data = array();

if (!isset($_POST['searchTerm'])) {
    $fetchData = mysqli_query($conn, "select * from refbrgy limit 15");
} else {
    $search = $_POST['searchTerm'];
    $fetchData = mysqli_query($conn, "select * from refbrgy where brgyDesc like '%" . $search . "%' limit 5");
}

while ($row = mysqli_fetch_array($fetchData)) {
    $data[] = array("id" => $row['brgyDesc'], "text" => $row['brgyDesc']);
}
echo json_encode($data);