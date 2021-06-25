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
    <link rel="icon" type="image/png" href="assets/img/header.png">
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />
    <link href='assets/fullcalendar/main.css' rel='stylesheet' />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/mystyles.css?v=1.3" rel="stylesheet" />
    <meta name="google-signin-client_id"
        content="475682005183-t604pq7p67an7j8ko8tmugbpbais63ms.apps.googleusercontent.com">


</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="assets/img/logo.png"
                    alt="AR Verizon Logo" /> </a>
            <button
                class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded"
                type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mx-0">
                        <a class="nav-link py-3 px-0  px-lg-3" href="index.php">Home <span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle py-3 px-0  px-lg-3 " href="http://example.com"
                            id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">Property</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle">Building</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Building&sub-type=Residential">Residential</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Building&sub-type=Commercial">Commercial</a>
                                    </li>
                                </ul>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle">Condominium</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Condominium&sub-type=Residential">Residential</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Condominium&sub-type=Commercial">Commercial</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Condominium&sub-type=Parking">Parking</a>
                                    </li>
                                </ul>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle">Lot</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Lot&sub-type=Agricultural">Agricultural</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Lot&sub-type=Commercial">Commercial</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Lot&sub-type=Residential">Residential</a>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li><a class="dropdown-item"
                                            href="properties.php?propertytype=Lot&sub-type=Industrial">Industrial</a>
                                    </li>
                                </ul>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="properties.php?propertytype=House and Lot">House and
                                    Lot</a></li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="properties.php?propertytype=Office">Office</a>
                            </li>
                            <div class="dropdown-divider"></div>
                            <li><a class="dropdown-item" href="properties.php?propertytype=Warehouse">Warehouse</a></li>

                        </ul>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                            href="index.php#AboutUs">About Us</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
                            href="index.php#Agents">Agent</a></li>

                    <?php
if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid'];

    $sql = "SELECT usersFirstName from users WHERE usersId=?";
    $stmt = mysqli_stmt_init($conn);
    $result;

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL Error";
    } else {
        mysqli_stmt_bind_param($stmt, 's', $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $result = $row['usersFirstName'];
        mysqli_stmt_close($stmt);
    }

    echo "<li class='nav-item mx-0 mx-lg-1 dropdown'>";
    echo "<a class='nav-link dropdown-toggle nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger' href='' id='navbarDropdown3' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    echo "Welcome, " . $result;
    echo "</a>";
    echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown3'>";
    echo "<a class='dropdown-item' href='dashboard.php'>Dashboard</a>";
    echo " <div class='dropdown-divider'></div>";
    echo "<a class='dropdown-item loginPointer' data-toggle='modal' data-target='#ConfirmLogout'>Log Out</a>";
    echo "</div>";
    echo "</li>";
} else {
    echo "<li class='nav-item mx-0 mx-lg-1'><a class='nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger loginPointer' data-toggle='modal' data-target='#Login'>Log In</a></li>";
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
                        <h3 class="login-title">Registration</h3>
                    </div>
                    <form id='registraitonForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>

                        <div class="center">
                            <img class="addCursorPointer profileImage" id="imgFileUpload" alt="Select Profile Image"
                                title="Profile Image" src="assets/img/user.png" />
                            <br>
                            <input type="file" name="FileUpload" id="FileUpload" class="hidden"
                                accept=".jpg, .jpeg, .png" />
                            <br>
                            <p>Click image to select your Profile Image</p>
                        </div>
                        <div id="registration-alert" class="center"></div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email *" name="email" /> <br>
                        </div>
                        <p class="noteIndention"><strong>Note:
                            </strong> Please provide a valid email address. Your login access will be
                            sent to specified
                            email.</p>
                        <div class="form-group">
                            <input type="text" class="form-control transform"
                                onkeypress="return allowOnlyLetters(event);" placeholder="First Name *"
                                name="firstname" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control transform"
                                onkeypress="return allowOnlyLetters(event);" placeholder="Middle Name *"
                                name="middlename" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control transform"
                                onkeypress="return allowOnlyLetters(event);" placeholder="Last Name *"
                                name="lastname" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="date" class="form-control" name="birthday">
                            <br>
                        </div>


                        <div class="form-group">
                            <input type="text" class="form-control transform" placeholder="House no. *"
                                name="house-number" />
                            <br>
                        </div>

                        <div class="form-group">
                            <select class="form-control transform" id="brgy" name="brgy" style="width: 100%">
                                <!-- <option value="default" hidden>Select Barangay</option> -->
                            </select>
                        </div>

                        <div class="form-group">
                            <select class="form-control transform" id="city" name="city" style="width: 100%">
                                <!-- <option value="default" hidden>Select City/Municipality</option> -->
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control transform" id="province" style="width: 100%" name="province">
                                <!-- <option value="default" hidden>Select Province</option> -->
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" onkeypress="return isNumberKey(event);" class="form-control"
                                placeholder="TIN No. *" name="tin" maxlength="12">
                            <br>
                        </div>
                        <div class="form-group">
                            <input type="text" onkeypress="return isNumberKey(event);" class="form-control"
                                placeholder="Mobile No. *" maxlength="11" name="mobile" />
                            <br>
                        </div>

                        <div class="form-group">
                            <select class="form-control" id="posSelect" name="position">
                                <option hidden>Position Type</option>
                                <option>Agent</option>
                                <option>Manager</option>
                            </select>
                        </div>
                        <p class="noteIndention hidden"><strong>Note:
                            </strong> For the approval of your position as Manager, you are
                            required to recruit
                            at least 3
                            agents within 30 days. Failure to complete this requirement, the system will automatically
                            change your status to "Agent" position.</p>

                        <p class="noteIndention hidden">
                            <strong>Note: </strong> If you dont provide a manager Id, AR Verizon will be your default
                            manager.
                        </p>
                        <div class="form-group">
                            <input type="text" id="managerId" name="managerId" class="form-control hidden"
                                placeholder="Enter Manager ID" />
                        </div>

                        <div class="form-group">
                            <h6 class="login-title">Select Valid ID</h6>
                            <input name="filevalidid" id="filevalidid" type="file" class="btn btn-secondary w-100"
                                accept=".jpg, .jpeg, .png" />
                        </div>

                        <p class="noteIndention"><strong>Note:
                            </strong> Valid Government ID with address and picture
                            -UMID, SSS, Driver's License</p>

                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <div class="form-group form-check">
                                <input type="checkbox" name="termsNConditions" class="form-check-input"
                                    id="termsNCondtions">
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
                            <a href="#" class="forgot-pwd addCursorPointer">Already a member? Log in here</a>
                        </div>
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>



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
                                        class="forgot-pwd addCursorPointer" id="link-forget-pw">Forgot Password?</a>
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
                    <p><b>Note:</b> Kindly, fill out the following fields for account verification.</p>

                    <form id='forgotPwdForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email *" name="email" /> <br>
                        </div>

                        <!-- <div class="form-group">
                            <input type="number" class="form-control" maxlength="11" placeholder="Mobile No. *"
                                name="mobile" />
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
                        </div> -->

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



    <!-- Reset Password Modal -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="resetPwd"
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
                        <h3 class="login-title">Reset Password</h3>

                        <div id="resetPwd-Alert" style="text-align:center;">
                        </div>

                    </div>
                    <p><b>Note:</b> For setting up a new password, it shoud contain at least 1 capital Letter, at
                        leat 1 small letter, at least 1 number, and at least 1 special character/s</p>
                    <form id='resetPwdForm' action="includes/signup.inc.php" method="post"
                        enctype='multipart/form-data'>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Password *" name="resetPwd" />
                            <br>
                        </div>

                        <div class="form-group">
                            <input type="Password" class="form-control" placeholder="Confirm Password *"
                                name="restPwdRepeat" />
                            <br>
                        </div>

                        <div class="form-group">
                            <!-- <input type="Submit" class="btn btn-primary btn-primary-w100" value="Register" /> -->
                            <button type="submit" class="btn btn-primary btn-primary-w100"
                                name="resetPwdBtn">Submit</button>

                            <hr>

                            <button class="reset-button-margin btn btn-secondary btn-primary-w100" class="close"
                                data-dismiss="modal" name="forgotPwdBtn">Cancel</button>
                        </div>
                    </form>
                    <br>
                </div>

            </div>
        </div>
    </div>

    <!-- End of Reset Password Modal -->

    <script>
    //get the userid of logged user
    var sessionId = "<?php if (isset($_SESSION['userid'])) {
    echo $_SESSION['userid'];
}?>";
    if (sessionId != "") {
        localStorage.setItem(`userlogged`, sessionId)
    }
    </script>