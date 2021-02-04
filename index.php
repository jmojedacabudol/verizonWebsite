<?php

require_once 'header.php';
//session_star();

?>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
        xfbml: true,
        version: 'v9.0'
    });
};

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- Your Chat Plugin code -->
<div class="fb-customerchat" attribution="setup_tool" page_id="468977866973999" theme_color="#70945A">
</div>
<!-- Masthead-->
<section class="page-section properties" id="Home">
    <!-- Masthead Heading-->
    <header class="masthead bg-photo text-white text-center">
        <!--Call Us Panel-->
        <div class="overlay">
            <i class="fas fa-phone"></i> Call Us! (02) 799-4864
        </div>
        <!---End of Call Us Panel--->


        <!--Slogan-->
        <div class="container align-items-center">
            <div class="container slogan-size">
                <h2 class="slogan-text">We don't just sell. We build dreams. </h2>
            </div>
        </div>
        <!--End of SLogan-->


        <!--Search Panel-->
        <div class="container front">

            <div class="container  search-box-panel d-flex flex-column">

                <div class="container-fluid ">
                    <!--Row1 Title-->
                    <div class="row align-left">
                        <div class="col-md">
                            <div class="form-group">
                                <h4 class="h4-black"> Finding your ideal property</h4>
                            </div>
                        </div>

                    </div>

                    <!--Row2 Buy/Rent-->
                    <form id='searchForm' action="properties.php" method="post">
                        <div class="row align-left text-black">

                            <div class="col-md">
                                <div class="form-group">
                                    <input id="offertype" name="offertype" style="display:none;" value="sell" />
                                    <div class="btn-group" role="group" aria-label="Buy or Rent">
                                        <button type="button" id="forsaleBtn" class="btn btn-primary">For
                                            Sale</button>
                                        <button type="button" id="forrentBtn" class="btn btn-secondary">For
                                            Rent</button>
                                        <button type="button" id="presellingBtn"
                                            class="btn btn-secondary">Preselling</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--Row3 Location-->
                        <div class="row align-left text-black">

                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="input-group w-100">

                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="fas fa-map-marker-alt"></i></span>
                                        </div>

                                        <input type="text" name='location' class="form-control"
                                            placeholder="Enter Location" aria-label="Location"
                                            aria-describedby="basic-addon1" id="loc_">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="submit" name='searchSubmit' id="submitBtn" class="btn btn-primary"
                                        style="width: 120px;">Search</button>
                                </div> <br>
                            </div>

                        </div>
                    </form>
                    <!--On key press SEARCH-->
                    <script>
                    var inputA = document.getElementById("loc_");
                    inputA.addEventListener("keyup", function(event) {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById("submitBtn").click();
                        }
                    });
                    </script>


                    <!--Row4 Search Button-->
                    <div class="row align-left text-black">


                    </div>

                </div>
                <!--container fluid-->
            </div>
            <!--container front end-->
        </div>
        <!--container end-->

        <!--End of Search Panel-->

        <!--Carousel-->
        <div class="container-fluid back">
            <div id="carouselExampleIndicators" class="carousel slide panel-margin w-100" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner h-600 toprem">

                    <div class="carousel-item active">
                        <img class="d-block w-100" src="assets/img/slider1.png" alt="First slide">
                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100" src="assets/img/slider2.png" alt="Second slide">
                    </div>

                    <div class="carousel-item">
                        <img class="d-block w-100" src="assets/img/slider3.png" alt="Third slide">
                    </div>

                </div>
            </div>
        </div>
        <!---End of Carousel-->
    </header>


    <!-- Latest Properties Section-->
    <div class="container">
        <!-- Latest Properties Section Heading-->
        <h5 class="page-section-heading text-center text-uppercase text-header-green h5-size"><br><br>LATEST PROPERTIES
            FOR SALE
        </h5>
        <!-- Icon Divider-->
        <br> <br> <br>
        <!-- Latest Properties Grid Items-->
        <div class="container-fluid">
            <div class="row justify-content-center padding-pr">
                <!-- Latest Properties Item 1-->
                <?php
$sql = "SELECT property.propertyid,propertyamount,propertydesc,propertyname, propertybedrooms,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.approval  NOT IN (0, 2, 3) AND property.offertype='Sell' GROUP BY property.propertyid DESC LIMIT 3;";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $databaseFileName = $row['file_name'];
        $filename = "uploads/$databaseFileName" . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);
        $fileactualext = $fileext[2];
// print_r($fileInfo);
        echo "<div class='col-md-6 col-lg-4 mb-5'>";
        echo "<div class='properties-item mx-auto'>";
        echo "<div class='properties-item-caption d-flex align-items-center justify-content-center h-100 w-100'>";
        echo "<div class='properties-item-caption-content text-center text-white'>";
        echo "<button type='submit' class='btn btn-primary' onclick='viewCampaign(";
        echo $row['propertyid'];
        echo ")'>Read More</button>";
        echo "</div>";
        echo "</div>";
        echo "  <img class='img-fluid' style='width:100vw; height:400px'src='uploads/";
        echo $row['file_name'] . "." . $fileactualext;
        echo "' alt='' />";
        echo "<h4 class='text-uppercase lproperties-title'>";
        echo $row['propertyname'];
        echo "</h4>";
        echo "<h5 class='text-uppercase lproperties-price'> P ";
        echo $row['propertyamount'];
        echo "</h5>";
        echo "<h6 class='lproperties-br'>";
        echo $row['propertybedrooms'];
        echo " Bedrooms </h6>";
        echo "<p class='lproperties-desc'> ";
        echo $row['propertydesc'];
        echo "</p>";
        echo "</div>";
        echo "</div>";

    }
} else {
    echo "<p>No Latest Properties for Sale</p>";
}
?>


            </div>
        </div>
    </div>
</section>

<!-- Latest Rental Properties Section-->
<!-- Latest Rental Properties Section Heading-->

<h2 class="page-section-heading text-center text-uppercase text-header-green">LATEST RENTAL PROPERTIES</h2> <br>

<section class="page-section properties properties-bg-green">
    <div class="container">
        <!-- Latest Rental Properties Grid Items-->
        <div class="row justify-content-center">
            <?php
$sql = "SELECT property.propertyid,propertyamount,propertydesc,propertyname,property.propertyrentchoice, propertybedrooms,property.approval,MIN(images.file_name)AS file_name FROM property, images WHERE property.propertyid = images.propertyid AND property.approval  NOT IN (0, 2, 3) AND property.offertype='Rent' GROUP BY property.propertyid DESC LIMIT 3;";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $databaseFileName = $row['file_name'];
        $filename = "uploads/$databaseFileName" . "*";
        $fileInfo = glob($filename);
        $fileext = explode(".", $fileInfo[0]);
        $fileactualext = $fileext[2];
// print_r($fileInfo);
        echo '<div class="col-md-6 col-lg-4 mb-5">';
        echo '<div class="properties-item mx-auto">';
        echo '<div class="properties-item-caption d-flex align-items-center justify-content-center h-100 w-100">';
        echo '<div class="properties-item-caption-content text-center text-white">';
        echo ' <button type="submit" class="btn btn-primary" onclick="viewCampaign(';
        echo $row['propertyid'];
        echo ')">Read More</button></td>';
        echo ' </div>';
        echo ' </div>';
        echo '<img class="img-fluid" src="Uploads/';
        echo $row['file_name'] . "." . $fileactualext;
        echo '" alt="" />';
        echo '<h4 class="text-uppercase lrproperties-title">';
        echo $row['propertyname'];
        echo '</h4>';
        echo '<h6 class="lrproperties-br">';
        echo $row['propertybedrooms'];
        echo 'Bedroom/s </h6>';
        echo ' <p class="lrproperties-desc">';
        echo $row['propertydesc'];
        echo '</p>';
        echo ' <h5 class="lrproperties-price">';
        echo 'PHP ' . $row['propertyamount'] . '/' . $row['propertyrentchoice'];
        echo '</h5>';
        echo '</div>';
        echo '</div>';

    }
} else {
    echo "<p>No Latest Properties for Rent</p>";
}
?>


        </div>
    </div>
</section>


<!-- Agents Section-->
<section class="page-section mb-0" id="Agents">
    <div class="container">
        <!-- About Section Heading--><br>
        <h2 class="page-section-heading text-center text-uppercase text-header-green">TOP AGENTS</h2> <br> <br>

        <!-- Agents Section Content-->

        <div class="card-deck">
            <div class="card">
                <img class="card-img-top" src="assets/img/agent/agent1.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Mary Williams</h5>
                    <p class="card-text">Real Estate Broker <br> 09055797910 <br> marywilliams@hotmail.com</p>
                    <p class="card-text"><small class="text-muted">Mary has been consistently in the top 3 of Verizon’s
                            real estate teams and number 1 agent for 8 years.</small></p>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="assets/img/agent/agent2.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">James Thomas</h5>
                    <p class="card-text">Real Estate Broker <br> 0948123437 <br> thomasjames@hotmail.com</p>
                    <p class="card-text"><small class="text-muted">A high-touch broker known for his extensive market
                            knowledge and his unmatched devotion to clients.</small></p>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" src="assets/img/agent/agent3.png" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">John Mitchell</h5>
                    <p class="card-text">Real Estate Broker <br> 09991234588 <br> johnmitchell@hotmail.com</p>
                    <p class="card-text"><small class="text-muted">He brings fourteen years of experience in real
                            estate, excellent customer service and a commitment to work hard. </small></p>
                </div>
            </div>
        </div>
        <br><br>
        <br>
    </div>
</section>


<!-- About Us Section-->
<section class="page-section bg-primary text-white mb-0" id="AboutUs">
    <div class="container">
        <h2 class="page-section-heading text-center text-uppercase text-white">About Us</h2><br><br>
    </div>

    <!-- About Section Heading-->
    <!-- Mission and vision Content-->
    <div class="container-fluid">
        <div class="row padding-pr">

            <div class="col-lg-4 ml-auto">
                <h3 class="page-section-heading text-center text-uppercase text-white">Mission</h3>
                <p class="lead" align="justify">
                    &nbsp;&nbsp;&nbsp; We are dedicated in providing world-class service and market-leading expertise to
                    our clients. We are passionate about providing the extra value that others simply will not. To
                    modernize and progress the experience of buying and selling real estate by cultivating a spirit of
                    collaboration, innovation, and integrity
                </p>
            </div>

            <div class="col-lg-4 mr-auto">
                <h3 class="page-section-heading text-center text-uppercase text-white">Vision</h3>
                <p class="lead" align="justify"> &nbsp;&nbsp;&nbsp; The vision of AR VERIZON REAL ESTATE COMPANY is to
                    achieve the highest possible standards of the real estate market while establishing our agency as
                    the premier and preferred real estate marketing partner of leading developers in the country.</p>
            </div>
        </div>
    </div>
    <!-- Call Us & Email Us Button-->
    <div class="text-center mt-4">
        <a class="btn btn-xl btn-outline-light" href="#contact">
            <i class="fas fa-phone"></i>
            &nbsp;Call Us
        </a>
        &nbsp;
        <a class="btn btn-xl btn-outline-light" href="mailto:helpdesk@arverizon.com">
            <i class="far fa-envelope"></i>
            &nbsp;Email Us
        </a>
    </div>
</section>


<!-- Copyright Section-->
<div class="copyright py-4 text-center text-white">

    <small>Unit 808 The Prestige Tower, Emerald Ave., Ortigas Center, Pasig City</small><br>
    <a href="https://www.facebook.com/MRVerizonRealEstateServices"> <i class="fab fa-facebook-f"></i></i></a>
    &nbsp;
    <a href=""> <i class="fab fa-instagram"></i></a>
    &nbsp;
    <a href=""> <i class="fab fa-twitter"></i></a>
    &nbsp;<br>
    <small>Copyright © AR Verizon 2021</small>
</div>


<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
<div class="scroll-to-top d-lg-none position-fixed">
    <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i
            class="fa fa-chevron-up"></i></a>
</div>


<!-- properties Modal-->
<div class="properties-modal modal fade" id="propertiesModal1" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content"> <br>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
            <br>
            <div class="modal-body">

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-lg-7">
                            <div id='propertyContainer'></div>
                        </div>
                        <div class="col-md-6 col-lg-5">
                            <div id='property-title'></div>
                            <div id='property-info'> </div>
                        </div>

                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>



<!-- Sig In Modal-->
<div class="properties-modal modal fade" id="Login" tabindex="-1" role="dialog" aria-labelledby="propertiesModal2Label"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="container login-container">
                <br><br>
                <div class="row justify-content-center">
                    <div class="col-md-6 login-form-1">
                        <form>


                            <div class="form-group">
                                <button type="Submit" class="btn btn-primary btn-red" data-toggle="modal"
                                    data-target="#Register" data-dismiss="modal"> <i
                                        class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Sign in with Google </button>
                            </div>

                            <div class="form-group">
                                <button type="Submit" class="btn btn-primary btn-blue" data-toggle="modal"
                                    data-target="#Register" data-dismiss="modal"> <i
                                        class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Sign in with Facebook
                                </button>
                            </div>
                           
                            <div>
                                <hr data-content="OR" class="hr-text">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Your Email *" id="_email"
                                    name="email" />
                                <br>
                            </div>

                            <div class="form-group">
                                <input type="Password" class="form-control" id="_pw" placeholder="Your Password *"
                                    name="pwd">
                                <br>
                            </div>

                            <div class="form-group">
                                <a data-toggle="modal" data-target="#Register" data-dismiss="modal" class="forgot-pwd"
                                    id="link-forget-pw">Forgot Password?</a>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-green btn-primary-w100" value="Login"
                                    id="btn-login" onclick="location.href='user-property-listing.php';"> Login
                                </button>
                            </div>

                            <div>
                                <hr>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-primary-w100" data-toggle="modal"
                                    data-target="#Register" data-dismiss="modal"> Register for free</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>



<!-- Contact Agent Modal-->
<div class="properties-modal modal fade" id="ContactAgent" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> Contact Agent
                        </div>
                        <div class="card-body" id="agentContainer">
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of ContactAgent Modal-->


<!-- User Modal-->
<div class="properties-modal modal fade" id="userContact" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> User Contact Information
                        </div>
                        <div class="card-body">
                            <div id='userNotification'></div>
                            <form id='userContactInfo' action="includes/messages.inc.php" method="post">
                                <input type="input" class="form-control" placeholder="Name" name="name" />
                                <br>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="userNo"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3" maxlength="11">
                                <br>
                                <button type="submit" name="contact-submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of User Modal-->





<!-- Book a Tour Modal-->
<div class="properties-modal modal fade" id="bookaTourModal" tabindex="-1" role="dialog"
    aria-labelledby="propertiesModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> <br>
            <div class="modal-header">
                <h5 class="modal-title">Book a Tour</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times"></i></span>
                </button>
            </div>
            <br>
            <div class="modal-body">
                <div class='calendar-container'>
                    <div id='calendar'></div>
                </div>
                <div id='date-container'></div>
            </div>
        </div>
    </div>
</div>



<!-- User Schedule Modal-->
<div class="properties-modal modal fade" id="userInfo" tabindex="-1" role="dialog" aria-labelledby="ContactAgent"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content text-center">
            <div class="container login-container"> <br><br>
                <div class="modal-body">
                    <div class="card text-center">
                        <div class="card-header"> User Contact Information
                        </div>
                        <div class="card-body">
                            <div id="contact-error"></div>
                            <form id='userInfoForm' action="includes/inserttoschedules.inc.php" method="post">
                                <input type="input" class="form-control" placeholder="Name" name="userName" />
                                <br>
                                <input type="text" class="form-control" placeholder="Mobile Number" name="userNumber"
                                    onkeypress="return isNumber(event)" onpaste="return false;" aria-label=""
                                    aria-describedby="button-addon3" maxlength="11">
                                <br>
                                <button type="submit" name="contact-submit" class="btn btn-secondary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div> <br><br>
        </div>
    </div>
</div>
<!--End of User Info Modal-->
<!--End of Log In Modal-->

<?php

require_once 'footer.php';
//session_star();
?>