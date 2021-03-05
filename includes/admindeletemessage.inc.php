<?php

if (isset($_POST['messageId'])) {
    $messagedId = $_POST['messageId'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $result = deleteMessage($messagedId, $conn);
    echo $result;
    exit();

}