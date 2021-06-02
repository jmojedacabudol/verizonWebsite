<?php
session_start();
include_once 'includes/dbh.inc.php';
if (!isset($_SESSION['adminUser'])) {
    header("location: ../admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Verizon Real Estate</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/mystyles.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />



</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="assets/img/logo.png" alt="" /> </a>
        </div>
        <div class="sidenav">
            <a href="admin-agents.php"><i class="fas fa-user-edit"></i> &nbsp;Accounts</a>
            <div class="dropdown-divider"></div>
            <a href="admin-managers.php"><i class="fas fa-user-tie"></i>&nbsp;Managers</a>
            <div class="dropdown-divider"></div>
            <a href="admin-properties.php"><i class="fas fa-home"></i> &nbsp;Properties</a>
            <div class="dropdown-divider"></div>
            <a href="admin-messages.php"><i class="fas fa-comment"></i> &nbsp;Messages</a>
            <div class="dropdown-divider"></div>
            <a href="admin-schedules.php"><i class="fas fa-clock"></i> &nbsp;Schedules</a>
            <div class="dropdown-divider"></div>
            <a href="admin-transactions.php"><i class="fas fa-list"></i> &nbsp;Transactions</a>
            <div class="dropdown-divider"></div>
            <a style='cursor:pointer;' data-toggle='modal' data-target='#ConfirmLogout'><i
                    class="fas fa-sign-out-alt"></i> &nbsp;Logout</a>

        </div>
    </nav>



    <!-- Confirm Logout Modal -->
    <div class="modal fade" id="ConfirmLogout" tabindex="-1" role="dialog" aria-labelledby="ConfirmLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Do you really wish to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='includes/adminlogout.inc.php'">Yes</button>
                </div>
                <br><br>
            </div>
        </div>
    </div>