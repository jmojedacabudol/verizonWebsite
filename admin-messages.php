<?php
require_once 'admin-header.php';

?>
<div class="main">



    <div class="card">
        <h5 class="card-header textToGreen">Messages</h5>
        <div class="card-body">
            <table id="messages" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>User Name</th>
                        <th>Mobile Number</th>
                        <th>Property Id</th>
                        <th>Property Name</th>
                        <th>Agent Id</th>
                        <th>Agent Name</th>
                        <th class='notexport'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$sql = "SELECT * FROM messages;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>";
        echo $row['messageId'];
        echo "</td>";
        echo "<td>";
        echo $row['userName'];
        echo "</td>";
        echo "<td>";
        echo $row['usersMobileNumber'];
        echo "</td>";
        echo "<td>";
        echo $row['propertyId'];
        echo "</td>";

        echo "<td>";
        echo $row['propertyName'];
        echo "</td>";
        echo "<td>";
        echo $row['agentId'];
        echo "</td>";
        echo "<td>";
        echo $row['agentname'];
        echo "</td>";
        echo "<td>";
        echo " <button class='btn btn-danger' id='deleteBtn' type='text' aria-label='deny'>Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
}
?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
<script src="js/adminMessages.js"></script>

</body>

</html>