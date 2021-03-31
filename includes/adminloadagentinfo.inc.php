<?php
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];
    $agentCount;
    //check if the call came from features Modal
    $featureUser = "none";
    if (isset($_POST['feature'])) {
        $featureUser = $_POST['feature'];
    }

    include_once 'dbh.inc.php';

    if ($featureUser == "none") {

//count the agent/s under a manager user
        $countSql = "SELECT COUNT(usersId) as Agents FROM users WHERE managerid=(SELECT managerid from managers WHERE usersId=?)";
        $countStmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($countStmt, $countSql)) {
            echo "SQL ERROR";
            exit();
        }

        mysqli_stmt_bind_param($countStmt, 's', $userId);
        mysqli_stmt_execute($countStmt);

        $countResult = mysqli_stmt_get_result($countStmt);
        if (mysqli_num_rows($countResult) > 0) {
            while ($row = mysqli_fetch_assoc($countResult)) {
                $agentCount = $row['Agents'];

            }
        } else {
            $agentCount = 0;
        }

        $sql = "SELECT * from users WHERE usersId=?";
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

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $databaseFileName = $row['validid_key'];
                $fileName = "../uploads/$databaseFileName" . "*";
                $info = glob($fileName);
                $fileext = explode(".", $info[0]);
                $fileactualext = $fileext[4];

                echo " <h2 class='properties-modal-title text-secondary text-uppercase mb-0'>";
                echo $row['usersFirstName'] . " " . $row['userLastName'];
                echo "</h2>";
                echo "<h5 class='mproperties-price'>";
                if ($row['usersPosition'] == 'Manager') {
                    echo $row['usersPosition'] . " ( " . $agentCount . " agent/s)";

                } else if ($row['usersPosition'] == "Agent") {
                    echo $row['usersPosition'];

                }
                echo "</h5>";
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Mobile Number: </h6>" . $row['usersMobileNumber'];
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Email: </h6>" . $row['usersEmail'];
                echo "<br>";
                if ($row['Tag'] == null) {
                    echo "<h6 style='color:#5C7B49'>Account Type: </h6>" . " Regular Registered Account";
                    echo "<br>";
                    echo "<br>";
                    echo "<h6 style='color:#5C7B49'>Change Password: </h6>";
                    echo "<input type='password' id='adminchangePassword'>";
                    echo "<button  style='margin-left:5px;'class='btn btn-success'id='changePwdBtn' onclick='changeUserPassword(";
                    echo $row['usersId'];
                    echo ")'>Submit</button>";
                } else if ($row['Tag'] == 'facebook') {
                    echo "<h6 style='color:#5C7B49'>Account Type: </h6>" . "Registered using " . "<p style='color:blue;'>Facebook</p>";

                } else if ($row['Tag'] == 'Google') {
                    echo "<h6 style='color:#5C7B49'>Account Type: </h6>" . "Registered using " . "<p style='Red'>Google</p>";

                }

                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Personal ID:</h6>";
                echo '<img src="uploads/' . $row['validid_key'] . "." . $fileactualext . '" width="60px" height="60px" class="propertyEditImg">';

            }

        } else {
            echo "<tr>";
            echo "No Data";
            echo "</tr>";
        }

    } else if ($featureUser == "Featured") {
        //the stats came from edit feature in "feature agent table"

        $sql = "SELECT * from featuredAgent WHERE featId=?";
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

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $databaseFileName = $row['profile_Img'];
                $fileName = "../uploads/$databaseFileName" . "*";
                $info = glob($fileName);
                $fileext = explode(".", $info[0]);
                $fileactualext = $fileext[4];

                echo " <h2 class='properties-modal-title text-secondary id='agentFullname' text-uppercase mb-0'>";
                echo $row['usersName'];
                echo "</h2>";
                echo "<h5 id='agentsPosition' class='mproperties-price'>";
                echo $row['usersPosition'];
                echo "</h5>";
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Mobile Number: </h6>" . $row['usersNumber'];
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Email: </h6>" . $row['usersEmail'];
                echo "<br>";
                echo '<textarea class="form-control" style="height: 150px;" id="editListing-desc"
                                name="elisting-desc">';
                echo $row['description'];
                echo '</textarea>';
            }

        } else {
            echo "<tr>";
            echo "No Data";
            echo "</tr>";
        }

    } else {

//count the agent/s under a manager user
        $countSql = "SELECT COUNT(usersId) as Agents FROM users WHERE managerid=(SELECT managerid from managers WHERE usersId=?)";
        $countStmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($countStmt, $countSql)) {
            echo "SQL ERROR";
            exit();
        }

        mysqli_stmt_bind_param($countStmt, 's', $userId);
        mysqli_stmt_execute($countStmt);

        $countResult = mysqli_stmt_get_result($countStmt);
        if (mysqli_num_rows($countResult) > 0) {
            while ($row = mysqli_fetch_assoc($countResult)) {
                $agentCount = $row['Agents'];

            }
        } else {
            $agentCount = 0;
        }

        $sql = "SELECT * from users WHERE usersId=?";
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

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $databaseFileName = $row['validid_key'];
                $fileName = "../uploads/$databaseFileName" . "*";
                $info = glob($fileName);
                $fileext = explode(".", $info[0]);
                $fileactualext = $fileext[4];

                echo " <h2 class='properties-modal-title text-secondary id='agentFullname' text-uppercase mb-0'>";
                echo $row['usersFirstName'] . " " . $row['userLastName'];
                echo "</h2>";
                echo "<h5 id='agentsPosition' class='mproperties-price'>";
                echo $row['usersPosition'];
                echo "</h5>";
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Mobile Number: </h6>" . $row['usersMobileNumber'];
                echo "<br>";
                echo "<h6 style='color:#5C7B49'>Email: </h6>" . $row['usersEmail'];
                echo "<br>";

            }

        } else {
            echo "<tr>";
            echo "No Data";
            echo "</tr>";
        }
    }

} else {
    echo "No User Data";
}