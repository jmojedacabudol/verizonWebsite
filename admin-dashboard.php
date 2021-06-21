<?php
require_once 'admin-header.php';
?>



<?php

$sql = "select COUNT(propertyid) as total_Property from property;";
$totalProperty;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $totalProperty = $row['total_Property'];
    }
}

$sql = "select COUNT(propertyid)as postedProperty from property  WHERE approval='Posted';";
$postedProperty;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $postedProperty = $row['postedProperty'];
    }
}

$sql = "select COUNT(propertyid)as pendingProperty from property  WHERE approval='Pending';";
$pendingProperty;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pendingProperty = $row['pendingProperty'];
    }
}

$sql = "select COUNT(usersId) as totalUsers from users;";
$totalUsers;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $totalUsers = $row['totalUsers'];
    }
}

$sql = "select COUNT(usersId)as regularUser from users  WHERE Tag='Regular User';";
$regularUser;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $regularUser = $row['regularUser'];
    }
}

$sql = "select COUNT(usersId)as newUser from users  WHERE Tag='New User';";
$newUser;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $newUser = $row['newUser'];
    }
}

$sql = "select COUNT(transactionId) as total_Transactions from transactions;";
$total_Transactions;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $total_Transactions = $row['total_Transactions'];
    }
}

?>


<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-blue order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Users</h6>
                        <h2 class="text-right"><i
                                class="fas fa-users f-left"></i><span><?php echo $totalUsers; ?></span></h2>
                        <p class="m-b-0">Verified User<span class="f-right"><?php echo $regularUser; ?></span></p>
                        <p class="m-b-0">Un Verified User<span class="f-right"><?php echo $newUser; ?></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-green order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Properties</h6>
                        <h2 class="text-right"><i
                                class="fas fa-home f-left"></i><span><?php echo $totalProperty; ?></span></h2>
                        <p class="m-b-0">Posted Properties<span class="f-right"><?php echo $postedProperty; ?></span>
                        </p>
                        <p class="m-b-0">Pending Properties<span class="f-right"><?php echo $pendingProperty; ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-yellow order-card">
                    <div class="card-block">
                        <h6 class="m-b-20">Transactions</h6>
                        <h2 class="text-right"><i
                                class="fas fa-handshake f-left"></i><span><?php echo $total_Transactions; ?></span></h2>
                        <!-- <p class="m-b-0">Completed Transactions<span class="f-right">351</span></p>
                        <p class="m-b-0">Pending Transactions<span class="f-right">351</span></p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</body>

</html>
<!-- Bootstrap core JS-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<!-- Numeral Plugin -->
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
<!-- Select2 Plugin -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>