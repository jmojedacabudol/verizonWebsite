</body>

</html>



<!-- Bootstrap core JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Third party plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<!-- <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script> -->
<!-- Google API -->
<script src="https://apis.google.com/js/platform.js" async defer></script>
<!-- fullcalendar bundle -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js'></script>
<!-- Select2 Plugin -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Contact form JS-->
<script src="assets/mail/jqBootstrapValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="assets/mail/contact_me.js"></script>
<!-- Moment Js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.js"></script>

<!-- Script for mobile number and tin number -->
<script>
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

//preventing numbers to names
function allowOnlyLetters(evt) {
    var inputValue = evt.charCode;
    if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) {
        event.preventDefault();
    }
}



$('.dropdown-submenu a.test').on("click", function(e) {
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
});

function add3Dots(string, limit) {
    var dots = "...";
    if (string.length > limit) {
        // you can also use substr instead of substring
        string = string.substring(0, limit) + dots;
    }
    return string;
}


function test(number) {
    window.open(`tel:${number}`)
}
</script>

<!-- Core theme JS-->
<script src="js/scripts.js?v=1.2"></script>
<script src="js/propertyViewing.js?v=1.2"></script>
<script src="js/indexSearch.js?v=1.2"></script>
<script src="js/login.js?v=1.2"></script>
<script src="js/register.js?v=1.2"></script>
<script src="js/viewpropertyAgent.js"></script>
<script src="js/loadCalendar.js?v=1.1"></script>
<script src="js/forgotPwd.js?v=1.2"></script>