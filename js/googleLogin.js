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
            console.log("No User Found");
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