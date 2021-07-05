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
            <a class="navbar-brand js-scroll-trigger" id="admin"><img src="assets/img/logo.png" alt="" /> </a>
        </div>
    </nav>
    <div class="main">
        <div class="container front">
            <div class="row justify-content-center">
                <div class="col-md-6 login-form-1">
                    <div class="card">
                        <article class="card-body">
                            <h4 class="card-title text-center mb-4 mt-1 textToGreen">Admin Login</h4>
                            <hr>
                            <div id="form-message" style="text-align:center;">

                            </div>

                            <form id="adminloginform" action="includes/login.inc.php" method="post">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="username *" name="uid"
                                        id="admin" />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input type="Password" class="form-control" placeholder="password *" name="pwd">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-green btn-primary-w100"> Login
                                    </button>
                                </div> <!-- form-group// -->
                            </form>
                        </article>
                    </div> <!-- card.// -->
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
                        <div id="register-form-message" style="text-align:center;">

                        </div>
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
                                <input type="Password" class="form-control" placeholder="Password *" name="pwd"
                                    id="pwd" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="Password" class="form-control" placeholder="Confirm Password *"
                                    name="pwdrepeat" id="pwdrepeat" /> <br>
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
                        <button type="submit" name='admin-register' class="btn btn-primary">Save
                            changes</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="js/admin-login.js"></script>

</html>