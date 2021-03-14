<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'includes/dbh.inc.php';

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

    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel='stylesheet'
        type='text/css'>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />
    <link href='assets/fullcalendar/main.css' rel='stylesheet' />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/mystyles.css" rel="stylesheet" />
    <meta name="google-signin-client_id"
        content="475682005183-t604pq7p67an7j8ko8tmugbpbais63ms.apps.googleusercontent.com">


</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="assets/img/logo.png" alt="" /> </a>
            <button
                class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded"
                type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                            href="index.php">Home</a></li>
                    <form action="properties.php" method="get">
                        <!-- <form id='navForm' action="properties.php" method="get"> -->
                        <!-- <input id="propType" name="propertyType" style="display:none;" value="" /> -->
                        <li class="nav-item mx-0 mx-lg-1 dropdown">
                            <a class="nav-link dropdown-toggle nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                                href="properties.html" id="navbarDropdown2" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Properties </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                <button type='submit' id='propBuilding' name="propertyType" value="Building"
                                    class="dropdown-item">Building</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="Condominium"
                                    id='propCondominium'>Condominium</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="Lots"
                                    id='propFarmLots'>Lots</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="House"
                                    id='propHouse'>House</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="Industrial"
                                    id='propIndustrial'>Industrial</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="Offices"
                                    id='propOffices'>Offices</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item" type='submit' name="propertyType" value="Warehouse"
                                    id='propWarehouse'>Warehouse</button>
                            </div>
                        </li>
                    </form>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                            href="index.php#AboutUs">About Us</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                            href="index.php#Agents">Agent</a></li>

                    <?php
if (isset($_SESSION['userid'])) {
    echo "<li class='nav-item mx-0 mx-lg-1 dropdown'>";
    echo "<a class='nav-link dropdown-toggle nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger' href='' id='navbarDropdown3' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                My Profile </a>";
    echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown3'>";
    echo "<a class='dropdown-item' href='dashboard.php'>Dashboard</a>";
    echo " <div class='dropdown-divider'></div>";
    echo "<a class='dropdown-item' data-toggle='modal' data-target='#ConfirmLogout'>Log Out</a>";
    echo "</div>";
    echo "</li>";
} else {
    echo "<li class='nav-item mx-0 mx-lg-1'><a class='nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger' data-toggle='modal' data-target='#Login'>Log In</a></li>";
}
?>

                </ul>
            </div>
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
                        onclick="location.href='includes/logout.inc.php'">Yes</button>
                </div>
                <br><br>
            </div>
        </div>
    </div>




    <!-- Registration Modal-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="Register"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 login-form-1">
                        <h3 class="login-title">Register</h3>
                        <div id="registration-alert" style="text-align:center;">
                        </div>

                    </div>
                    <form id='registraitonForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email *" name="email" /> <br>
                        </div>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Password *" name="pwd" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Confirm Password *"
                                name="pwdrepeat" />
                            <br>
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

                        <div class="form-group">
                            <select class="form-control" id="posSelect" name="position">
                                <option hidden>Position Type</option>
                                <option>Agent</option>
                                <option>Manager</option>
                            </select>
                        </div>

                        <div class="form-group" id="managerContainer" style="display:none;">
                            <select class="form-control" name="manager" id='selUser'>
                                <option value="0" hidden>Select Manager</option>
                            </select>
                            <br>
                        </div>

                        <div class="form-group">
                            <input id="fileValidId" type="file" style="display:none;" />
                            <h6 class="login-title">Select Valid ID</h6>
                            <input type="file" class="btn btn-secondary w-100" name="validid" /> <br>
                        </div>
                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <div class="form-group form-check">
                                <input type="checkbox" name="termsNConditions" class="form-check-input"
                                    id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">I have read and agree to
                                    the </label>
                                <a href="termsandcondition.php" target="_blank">&nbsp;Terms and
                                    Conditions
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <button type="submit" class="btn btn-primary btn-primary-w100"
                                name="submit">Register</button>
                        </div>
                        <div class="form-group"> <br>
                            <a href="#" class="forgot-pwd">Already a member? Log in here</a>
                        </div>


                        <div>
                            <hr data-content="OR" class="hr-text">
                        </div>

                        <div class="g-signin2" data-onsuccess="onSignIn" id='googleSigninReg' data-theme="dark"></div>
                        <!-- <button type="Submit" class="btn btn-primary btn-red" data-toggle="modal" data-target="#Register" data-dismiss="modal"> <i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Sign Up with Google </button> -->

                        <div class="form-group">

                            <button type="submit" name="registration-submit" class="btn btn-primary btn-blue"
                                onclick="fbLogin();"><i class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Sign Up with
                                Facebook
                            </button>
                        </div>
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>



    <!-- Facebook And Gmail Register Modal-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="fbGoogleRegister"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="col-md-6 login-form-1">
                        <h3 class="login-title">Register</h3>
                        <div id="fbGooglregistration-alert">
                        </div>

                    </div>
                    <form id='fbGoogleregistraitonForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email *" id='userEmail' name="email" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="First Name *" id='first-name'
                                name="firstname" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Last Name *" id='last-name'
                                name="lastname" />
                            <br>
                        </div>


                        <div class="form-group">
                            <input type="number" maxlength="11" class="form-control" placeholder="Mobile No. *"
                                name="mobile" />
                            <br>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="fbGooglePosSelect" name="position">
                                <option hidden>Position Type</option>
                                <option>Agent</option>
                                <option>Manager</option>
                            </select>
                        </div>

                        <div class="form-group" id="fbGooglemanagerContainer" style="display:none;">
                            <select class="form-control" name="manager" id='fbGoogleselUser'>
                                <option value="0" hidden>Select Manager</option>
                            </select>
                            <br>
                        </div>


                        <div class="form-group">
                            <h6 class="login-title">Select Valid ID</h6>
                            <input type="file" class="btn btn-secondary w-100" name="validid" /> <br>
                        </div>
                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck2">
                                <label class="form-check-label" for="exampleCheck1">I have read and agree to
                                    the </label>
                                <a href="termsandcondition.php" target="_blank">&nbsp;Terms and
                                    Conditions
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-primary-w100"
                                name="submit">Register</button>
                        </div>

                        <div class="form-group">
                            <button type="button" id='closeBtn'
                                class="btn btn-secondary btn-primary-w100">Close</button>
                        </div>
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <!-- Facebook And Gmail Register Modal Ends Here-->



    <!-- Terms and Condition Modal -->

    <div class="modal fade bd-example-modal-lg" data-target="#termscondition" id="termscondition" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Log In Modal-->
    <div class="properties-modal modal fade" id="Login" tabindex="-1" role="dialog"
        aria-labelledby="propertiesModal2Label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="container login-container">
                    <br><br>
                    <div class="row justify-content-center">
                        <div class="col-md-6 login-form-1">

                            <form id='loginForm' action="includes/login.inc.php" method="post">
                                <!-- <div class="form-group">
                                    <button type="Submit" class="btn btn-primary btn-red" data-toggle="modal" data-target="#Register" data-dismiss="modal"> <i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp; Sign in with Google -
                                        (Coming
                                        Soon)
                                    </button>
                                </div> -->
                                <div class="g-signin2" data-onsuccess="onSignIn" id='googleSignin' data-theme="dark"
                                    style="align:center; "></div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-blue" onclick="fbLogin();"> <i
                                            class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Sign in with
                                        Facebook
                                    </button>
                                </div>

                                <div>
                                    <hr data-content="OR" class="hr-text">
                                </div>
                                <div id="loginNotf"></div>
                                <div class="form-group">
                                    <input id='uid' type="text" class="form-control" placeholder="Your Email *"
                                        name="uid">
                                    <br>
                                </div>

                                <div class="form-group">
                                    <input id='pwd' type="Password" class="form-control" placeholder="Your Password *"
                                        name="pwd" /> <br>
                                </div>

                                <div class="form-group">
                                    <a data-toggle="modal" data-target="#forgotPwd" data-dismiss="modal"
                                        class="forgot-pwd" id="link-forget-pw">Forgot Password?</a>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-green btn-primary-w100"
                                        name="submit" id='loginBtn'> Login </button>
                                </div>

                                <div>
                                    <hr>
                                </div>
                            </form>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-primary-w100" data-toggle="modal"
                                    data-target="#Register" data-dismiss="modal"> Register
                                    for free</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div> <br><br>
            </div>
        </div>
    </div>
    <!--End of Log In Modal-->


    <!-- Forgot Password Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="forgotPwd"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-6 login-form-1">
                        <h3 class="login-title">Forgot Password</h3>
                        <div id="forgotPwd-Alert" style="text-align:center;">
                        </div>

                    </div>
                    <form id='forgotPwdForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email *" name="email" /> <br>
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control" placeholder="Mobile No. *" name="mobile" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Password *" name="pwd" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Confirm Password *"
                                name="pwdrepeat" />
                            <br>
                        </div>

                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <button type="submit" class="btn btn-primary btn-primary-w100"
                                name="forgotPwdBtn">Submit</button>
                        </div>
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <!-- End of Forgot Password Modal -->

    <script>
    //get the userid of logged user
    var sessionId = "<?php if (isset($_SESSION['userid'])) {
    echo $_SESSION['userid'];
}?>";
    if (sessionId != "") {
        localStorage.setItem(`userlogged`, sessionId)
    }
    </script>