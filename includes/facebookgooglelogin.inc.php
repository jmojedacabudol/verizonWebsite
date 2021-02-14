<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

$email = $_POST['email'];

$result = loginUser($conn, $email, "none");
echo $result;
