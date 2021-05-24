<?php

if (isset($_POST['submit'])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    session_start();
    $agentProperties = $_POST['propertyName'];
    $propertyType = $_POST['propertyType'];
    $propertyOfferType = $_POST['propertyOfferType'];
    $tcp = $_POST['tcp'];
    $Address = $_POST['Address'];
    $terms = $_POST['terms'];
    $status = $_POST['status'];
    $transactionDate = $_POST['transactionDate'];
    $finalTcp = $_POST['finalTcp'];

    $agentId = $_SESSION['userid'];

    //reservation date is used when condominium type is selected
    $reservationDate = null;
    $unitNo = null;

// dont get the values of receivable to final receivable when it is "preselling"
    $receivable = null;
    $agentsCommission = null;
    $arCommission = null;
    $buyersCommision = null;
    $finalReceivable = null;
    $commission = null;

    if ($propertyOfferType === "Preselling") {
        if ($propertyType === "Condominium") {
            //preselling condo
            $reservationDate = $_POST['saleDate'];

            $receivable = $_POST['receivable'];
            $agentsCommission = $_POST['agentsCommission'];
            $arCommission = $_POST['arCommission'];
            $buyersCommision = $_POST['buyersCommision'];
            $finalReceivable = $_POST['finalReceivable'];
            $commission = $_POST['commission'];
            $unitNo = $_POST['unitNo'];
            $result = createTransaction($conn, $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $Address, $terms, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable);
            //this result will return the index of transaction that is inserted
            echo $result;

        } else {
            //preselling but not condomonium
            //preselling condo
            $reservationDate = $_POST['saleDate'];
            $result = createTransaction($conn, $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $Address, $terms, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable);
            //this result will return the index of transaction that is inserted
            echo $result;

        }
    } else {
        if ($propertyType === "Condominium") {
            $unitNo = $_POST['unitNo'];
            $result = createTransaction($conn, $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $Address, $terms, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable);
//this result will return the index of transaction that is inserted
            echo $result;

        } else {
            $result = createTransaction($conn, $agentId, $agentProperties, $propertyType, $propertyOfferType, $unitNo, $tcp, $Address, $terms, $status, $transactionDate, $reservationDate, $finalTcp, $commission, $receivable, $agentsCommission, $arCommission, $buyersCommision, $finalReceivable);
//this result will return the index of transaction that is inserted
            echo $result;

        }
    }

} else {
    echo "Error: Script not found!";
}