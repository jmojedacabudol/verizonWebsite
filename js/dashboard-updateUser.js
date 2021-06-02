$(function () {
    $("#updateForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("editSubmit", "editProfile");
        // for (var value of formData.keys()) {
        //     console.log(value);
        // }

        var newpass = formData.get("newpass");
        var confirmpass = formData.get("confirm-pass");

        Swal.fire({
            icon: "info",
            title: "Do you want to save the changes you made?",
            text: "Kindly, check your credentials before saving",
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: "No",
            confirmButtonColor: "#3CB371",
            cancelButtonColor: "#70945A"
        }).then(result => {
            if (result.value) {
                //if passwords is not empty
                if (newpass !== "" && confirmpass !== "") {
                    if (passwordValidation(newpass, confirmpass, 8, 15)) {
                        Swal.fire({
                            text: "Please Wait....",
                            allowOutsideClick: false,
                            showConfirmButton: false,

                            willOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        $.ajax({
                            url: "includes/dashboard-User.inc.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: "POST",
                            success: function (data) {
                                Swal.close();
                                console.log(data)
                                if (data == "User Updated!") {
                                    $("#update-error").html(``);
                                    Swal.fire({
                                        icon: "success",
                                        title: "Account Updated",
                                        text: "The page will now reload.",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        timer: 2000
                                    }).then(function (result) {
                                        location.reload();
                                    })
                                } else {
                                    if (data !== "") {
                                        $("#update-error").html(`<div class='alert alert-success' id='alert' role='alert'>${data}</div>`);
                                    }
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            },
                        });
                    };
                    return false;
                } else {

                    //no passwords needs and only img to upload
                    Swal.fire({
                        text: "Please Wait....",
                        allowOutsideClick: false,
                        showConfirmButton: false,

                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: "includes/dashboard-User.inc.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: "POST",
                        success: function (data) {
                            Swal.close();
                            console.log(data)
                            if (data == "User Updated!") {
                                $("#update-error").html(``);
                                Swal.fire({
                                    icon: "success",
                                    title: "Account Updated",
                                    text: "The page will now reload.",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 2000
                                }).then(function (result) {
                                    location.reload();
                                })
                            } else {
                                if (data !== "") {
                                    $("#update-error").html(`<div class='alert alert-success' id='alert' role='alert'>${data}</div>`);
                                }
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    });
                }

            };
        });
    });
});


//PASSWORD VALIDATION
function passwordValidation(password, confirmpassword, min, max) {
    var passwordformat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/
    if (password !== "" && confirmpassword !== "") {
        if (password.length >= min && password.length < max && confirmpassword.length >= min && confirmpassword.length < max) {
            if (password === confirmpassword) {
                if (password.match(passwordformat) && confirmpassword.match(passwordformat)) {
                    $("#update-error").html('');
                    $("#newpass").removeClass("input-error");
                    $("#confirm-pass").removeClass("input-error");
                    return true;
                } else {
                    $("#update-error").html('<div class="alert alert-danger" role="alert">Your Password must contain at least 1 capital Letter, at leat 1 small letter, at least 1 number, and at least 1 special character/s.</div>');
                    $("#newpass").addClass("input-error");
                    $("#confirm-pass").addClass("input-error");
                    return false;
                }
            } else {
                $("#update-error").html('<div class="alert alert-danger" role="alert">Password and Confirm password must be the same. Try checking "show password" if it matches.</div>');
                $("#newpass").addClass("input-error");
                $("#confirm-pass").addClass("input-error");
                return false;
            }
        } else {
            $("#update-error").html('<div class="alert alert-danger" role="alert">Password and Confirm password must have 6 or more unique characters.</div>');
            $("#newpass").addClass("input-error");
            $("#confirm-pass").addClass("input-error");
            return false;
        }
    } else {
        $("#update-error").html('<div class="alert alert-danger" role="alert">The "New Password"" field is empty. Please try creating a unique one.</div>');
        $("#newpass").addClass("input-error");
        $("#confirm-pass").addClass("input-error");
        return false;
    }
}