<?php

if (isset($_POST['scheduleId'])) {
    $scheduleId = $_POST['scheduleId'];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $result = deleteSchedule($scheduleId, $conn);
    echo $result;
    exit();

}