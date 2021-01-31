<?php
require_once 'header.php';
?>


<?php
require_once 'sidenav.php'
?>
<div class="main">
    <div class="card container-fluid">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4>Message List</h4>

                    <form class="form-group">

                        <div class="col-md-4">
                            <!-- Search form -->

                            <input id="Agents_table" class="form-control" type="text" placeholder="Search"
                                aria-label="Search">
                        </div>



                </div>
            </div>
            <hr>
            <div class="card container-fluid">
                <<table id="Agents" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Position</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger</td>
                            <td>Nixon</td>
                            <td>094593748239</td>
                            <td>tigernizxon@gmail.com</td>
                            <td>Agents</td>

                        </tr>
                        <tr>
                            <td>Douglas</td>
                            <td>Carter</td>
                            <td>093485726374</td>
                            <td>carterd@gmail.com</td>
                            <td>Agent</td>

                        </tr>
                        <tr>
                            <td>Nicol</td>
                            <td>Jean</td>
                            <td>09374628465</td>
                            <td>jeannicol@gmail.com</td>
                            <td>Manager</td>

                        </tr>

                        </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="js/test.js"></script>
<script src="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $("#Agents_table").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#Agents tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>

</body>

</html>