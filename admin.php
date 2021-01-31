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
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="assets/img/logo.png" alt="" /> </a>
        </div>
    </nav>
    <div class="main">

        <div class="container front">
            <div class="container-fluid ">
                <div class="row justify-content-center">
                    <div class="col-md-6 login-form-1">
                        <form id="adminloginform" action="includes/login.inc.php" method="post">
                            <!-- <img src="images/admin_icon.svg" style="width:200px height:200px" alt=""> -->
                            <div id="form-message" style="text-align:center;">

                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Email *" name="uid"
                                    id="admin" /> <br>
                            </div>

                            <div class="form-group">
                                <input type="Password" class="form-control" placeholder="Your Password *" name="pwd">
                                <br>
                            </div>

                            <div class="form-group">
                                <a data-toggle="modal" name="createAdmin" data-target="#Register" data-dismiss="modal"
                                    class="forgot-pwd" style="display:none" id="createAdmin">Create Admin User</a>
                            </div>
                            <hr>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-green btn-primary-w100" value="Login">
                                    Login </button>
                            </div>

                            <div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Registration Modal-->
        <!-- Modal -->
        <div class="modal fade" id="Register" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Admin Registration</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id='adminRegister' action="includes/adminsignup.inc.php" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="username *" name="uid" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Email *" name="email" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="Password" class="form-control" placeholder="Password *" name="pwd" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="Password" class="form-control" placeholder="Confirm Password *"
                                    name="pwdrepeat" /> <br>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" name="firstname" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" name="lastname" />
                                <br>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Mobile No. *" name="mobile" />
                                <br>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name='admin-register' class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="js/admin-login.js"></script>

</html>