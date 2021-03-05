function onSignIn(googleUser) {
    // Useful data for your client-side scripts:
    var profile = googleUser.getBasicProfile();
    var firstname = profile.getGivenName();
    var lastname = profile.getFamilyName();
    var email = profile.getEmail();
    var providerId = "Google";
    //set the providerId localStorage
    localStorage.setItem("providerId", providerId);




    $.post("includes/checkaccounttag.inc.php", {
        "userEmail": email
    }, function (data) {
        if (data == "Google") {
            //   console.log("User Exists Under Facebook");
            $.post("includes/facebookgooglelogin.inc.php", {
                "email": email
            }, function (data) {
                if (data == "Success") {
                    Swal.fire({
                        text: "Please Wait....",
                        allowOutsideClick: false,
                        showConfirmButton: false,

                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    Swal.fire({
                        icon: "success",
                        title: "Login Success",

                    }).then(result => {
                        if (result.value) {
                            var auth2 = gapi.auth2.getAuthInstance();
                            auth2.signOut().then(function () {
                                auth2.disconnect();
                                location.reload();
                            });

                        }
                    })
                }

            })
        } else if (data != "No User") {
            Swal.fire({
                icon: "error",
                title: "Your email is already taken.",
                text: "Your email is not available because it is registered to other account."
            })
        } else {
            // console.log("No User Found");
            //show register modal with modified registration inputs
            $('#Login').modal('hide');
            $('#fbGoogleRegister').modal({
                backdrop: 'static',
                keyboard: false
            });

            //insert the value of facebook credentials into form inputs and disable
            $("#userEmail").val(email);
            $("#first-name").val(firstname);
            $("#last-name").val(lastname);

            $("#email,#first-name,#last-name").attr('readonly', true);
        }

    });
}

function registerButtonRender(Size) {
    document.getElementById("googleSigninReg").setAttribute("data-width", `'${Size}'`);
}


function buttonRender(Size) {
    document.getElementById("googleSignin").setAttribute("data-width", `'${Size}'`);
}

//resize for google sign in in login
function resize() {
    if ($(window).width() < 410) {
        buttonRender(306.82)
    } else if ($(window).width() == 633) {
        buttonRender(480)
    } else if ($(window).width() > 633 && $(window).width() <= 845) {
        buttonRender(430)
    } else if ($(window).width() > 845 && $(window).width() <= 1091) {
        buttonRender(207)
    } else if ($(window).width() > 1092) {
        buttonRender(336)
    }
}

//resize for google sign in  in registration
function resize2() {
    if ($(window).width() < 410) {
        registerButtonRender(378.06)
    } else if ($(window).width() > 519 && $(window).width() <= 892) {
        registerButtonRender(430)
    } else if ($(window).width() > 893) {
        registerButtonRender(688.02)
    }
}
$(window).on("resize", resize);
resize(); // call once initially
resize2();