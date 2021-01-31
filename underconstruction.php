<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;1,200&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
        integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <title>Verizon Real Estate</title>

</head>

<body>

    <div class="row">
        <div class='col-lg-6 vh-100 vw-100'>
            <div class="social-medias">
                <img id='companylogo' src="assets/img/logo.png" alt="">
                <h2>Ready for Big Opportunity?</h2>
                <h4>Be an accredited partner!</h4>
                <p>You can check our Social Medias for Updates</p>
                <div class="row">
                    <div class="col-lg-3">
                        <h3 id='countDays'>Day</h3>

                    </div>
                    <div class="col-lg-3">
                        <h3 id="countHour">Hours</h3>

                    </div>

                    <div class="col-lg-3">
                        <h3 id="countMin">Minutes</h3>

                    </div>

                    <div class="col-lg-3">
                        <h3 id="countSec">Seconds</h3>
                    </div>

                </div>

                <div class="media-icons">
                    <a href="https://www.facebook.com/MRVerizonRealEstateServices"><i
                            class="fab fa-facebook media-item fa-2x"></i></a>
                    <i class="fab fa-twitter-square media-item fa-2x"></i>
                    <i class="fab fa-instagram media-item fa-2x"></i>
                </div>


            </div>
        </div>
        <div class='col-lg-6 vh-100 vw-100'>
            <div class="imgBg">
                <img class="imgBg-item" src="assets/img/keyImage1.jpg" alt="">
                <img class="imgBg-item" src="assets/img/keyImage2.jpg" alt="">
                <img class="imgBg-item" src="assets/img/keyImage3.jpg" alt="">
            </div>
        </div>
    </div>


</body>



</div>
<script>
var todaydate = new Date();
var eventDate = new Date('01-20-2021');

var eventTime = eventDate.getTime();
var currentTime = todaydate.getTime();
var diffTime = eventTime - currentTime;
var duration = moment.duration(diffTime, 'milliseconds');
var interval = 1000;

setInterval(function() {
    duration = moment.duration(duration - interval, 'milliseconds');

    $("#countDays").text(duration.days() + " day/s")
    $("#countHour").text(duration.hours() + " hr")
    $("#countMin").text(duration.minutes() + " min")
    $("#countSec").text(duration.seconds() + " sec")
    // console.log(duration.hours() + ":" + duration.minutes() + ":" + duration.seconds())
}, interval);


$('.imgBg').each(function() {
    var delay = 7000;
    var speed = 1000;
    var itemSlide = $(this).find('.imgBg-item');
    var nowSlide = 0;

    $(itemSlide).hide();
    $(itemSlide[nowSlide]).show();
    nowSlide++;
    if (nowSlide >= itemSlide.length) {
        nowSlide = 0;
    }

    setInterval(function() {
        $(itemSlide).fadeOut(speed);
        $(itemSlide[nowSlide]).fadeIn(speed);
        nowSlide++;
        if (nowSlide >= itemSlide.length) {
            nowSlide = 0;
        }
    }, delay);
});
</script>

</html>