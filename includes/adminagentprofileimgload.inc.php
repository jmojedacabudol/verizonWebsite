<?php
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $featureAgent = "no-user";

    if (isset($_POST['featuredAgent'])) {
        $featureAgent = $_POST['featuredAgent'];

    }

    include_once 'dbh.inc.php';

    if ($featureAgent != "no-user") {
        $sql = "SELECT profile_Img from featuredAgent WHERE featId=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<tr>";
            echo "SQL ERROR";
            echo "</tr>";
            exit();
        }

        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $counter = 0;
// $flag = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $databaseFileName = $row['profile_Img'];
                if ($databaseFileName == null) {
                    echo '<img src="assets/img/user.png" class="d-block img-property" alt="..." >';

                } else {
                    $fileName = "../uploads/$databaseFileName" . "*";
                    $info = glob($fileName);
                    $fileext = explode(".", $info[0]);
                    $fileactualext = $fileext[4];

                    echo '<img src="uploads/' . $row['profile_Img'] . "." . $fileactualext . '" class="d-block img-property" alt="..." >';

                }

            }

        } else {
            echo "<tr>";
            echo "No Data";
            echo "</tr>";
        }

    } else {
        $sql = "SELECT profile_Img from users WHERE usersId=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<tr>";
            echo "SQL ERROR";
            echo "</tr>";
            exit();
        }

        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $counter = 0;
// $flag = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $databaseFileName = $row['profile_Img'];
                if ($databaseFileName == null) {
                    echo '<img src="assets/img/user.png" class="d-block img-property" alt="..." >';

                } else {
                    $fileName = "../uploads/$databaseFileName" . "*";
                    $info = glob($fileName);
                    $fileext = explode(".", $info[0]);
                    $fileactualext = $fileext[4];

                    echo '<img src="uploads/' . $row['profile_Img'] . "." . $fileactualext . '" class="d-block img-property" alt="..." >';

                }

            }

        } else {
            echo "<tr>";
            echo "No Data";
            echo "</tr>";
        }

    }

}