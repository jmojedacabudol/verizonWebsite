<?php
// session_start();
include_once 'includes/dbh.inc.php';

?>

<div class="sidenav">

    <a href="user-edit-profile.php"><i class="fas fa-user-edit"></i> &nbsp; Edit Profile </a>
    <div class="dropdown-divider"></div>
    <a href="user-property-listing.php"><i class="fas fa-list"></i> &nbsp; Property Listing</a>
    <div class="dropdown-divider"></div>
    <?php
$sql = "SELECT usersPosition FROM users WHERE usersId=?;";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "<tr>";
    echo "SQL ERROR";
    echo "</tr>";
    exit();
}
mysqli_stmt_bind_param($stmt, 's', $_SESSION['userid']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['usersPosition'] !== "Agent") {
            echo '<a href="user-members.php"><i class="fas fa-users"></i> &nbsp; Team Members</a>';
        } else {
        }
    }
}
?>

    <a href="user-messages.php"><i class="fas fa-comment"></i> &nbsp; Message/s</a>
    <a href="user-schedule.php"><i class="fas fa-calendar-alt"></i> &nbsp; Schedule/s</a>
    <a href="user-transaction.php"><i class="fas fa-file-invoice"></i> &nbsp; Transaction/s</a>
    <hr>
    <p>For inquries email us at <br>
        <a href="mailto:helpdesk@arverizon.com">helpdesk@arverizon.com
        </a>
    </p>

</div>