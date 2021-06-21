<?php

//[application]
$app_host = "mail.arverizon.com";
$app_email = "dontreply.info@arverizon.com";
$password = "vCuOP)dV(zMQ";

//reset password application

$app_resetPassword_host = "mail.arverizon.com";
$app_resetPasswod_email = "dontreply.resetpassword@arverizon.com";
$app_resetPassword_password = "gTj(1Zz+kia}";

//[database]
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "verizon";
$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}