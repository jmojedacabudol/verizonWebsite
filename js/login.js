$(() => {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("submit", "listing-submit");
        // fd.append(this);
        // fd.append("submit", "propertySubmitBtn");
        // Display the values
        // for (var value of formData.keys()) {
        //     console.log(value);
        // }
        // console.log($("#loginForm").serialize());

        var email = formData.get("uid");

        Swal.fire({
            text: "Please Wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: "includes/login.inc.php",
            data: formData,
            processData: false,
            contentType: false,
            type: "POST",
            success: function (data) {
                Swal.close();
                $("#loginNotf").html('');
                if (data == "Password reset needed") {

                    $("#Login").modal('hide');
                    $("#resetPwd").modal('show');
                    resetPwd(email).then((result) => {
                        console.log(result);
                        if (result == "Success") {
                            $("#resetPwd-Alert").html("");
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "You have successfully change your password",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                focusConfirm: true,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            $("#resetPwd-Alert").html('<div class = "alert alert-danger" role = "alert" >' + result + '</div>');
                        }
                    }).catch(error => {
                        console.log(error);
                    });
                } else if (data == "Success") {
                    Swal.close();
                    Swal.fire({
                        icon: "success",
                        title: "Log In Succesful",
                        text: "Click ''Proceed'' to continue to website.",
                        allowOutsideClick: false,
                        confirmButtonText: "Proceed",
                        confirmButtonColor: "#3CB371",
                    }).then(result => {
                        if (result.value) {
                            location.reload();
                        }
                    })
                } else {
                    Swal.close();
                    $("#loginNotf").html(`<div class = "alert alert-danger" role = "alert" >${data}</div>`);
                }
            },
            error: function (data) {
                console.log(data);
            },
        });
    })
})

//for reseting the user`s password
function resetPwd(email) {

    return new Promise((resolve, reject) => {
        $("#resetPwdForm").submit(function (event) {
            event.preventDefault();

            Swal.fire({
                icon: "info",
                title: "Do you want to save the changes you made?",
                text: "Please check your credentials before saving",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelBUttonText: "No",
                confirmButtonColor: "#3CB371",
                cancelButtonColor: "#70945A",
                focusConfirm: true,
            }).then(result => {
                if (result.value) {
                    var formData = new FormData(this);
                    formData.append("submit", "resetPwdBtn");
                    formData.append("userEmail", email);

                    var pwd = formData.get("resetPwd");
                    var confirmPwd = formData.get("restPwdRepeat");
                    //check the uniqueness of password
                    if (passwordValidation(pwd, confirmPwd, 6, 20)) {
                        $.ajax({
                            url: "includes/resetPwd.inc.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: "POST",
                            success: function (data) {
                                resolve(data);
                            },
                            error: function (data) {
                                reject(data);
                            }
                        });
                    };
                    return false;
                }
            });
        });
    });
};

//PASSWORD VALIDATION
function passwordValidation(password, confirmpassword, min, max) {
    var passwordformat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/
    if (password !== "" && confirmpassword !== "") {
        if (password.length >= min && password.length < max && confirmpassword.length >= min && confirmpassword.length < max) {
            if (password === confirmpassword) {
                if (password.match(passwordformat) && confirmpassword.match(passwordformat)) {
                    return true;
                } else {
                    $("#resetPwd-Alert").html('<div class="alert alert-danger" role="alert">Your Password must contain at least 1 capital Letter, at leat 1 small letter, at least 1 number, and at least 1 special characters.</div>');
                    return false;
                }
            } else {
                $("#resetPwd-Alert").html('<div class="alert alert-danger" role="alert">Password and Confirm password must be the same. Try checking "show password" to confirm your passwords matches.</div>');
                return false;
            }
        } else {
            $("#resetPwd-Alert").html('<div class="alert alert-danger" role="alert">Password and Confirm password must be 6 or more unique characters.</div>');
            return false;
        }
    } else {
        $("#resetPwd-Alert").html('<div class="alert alert-danger" role="alert">Your account needs a password. Try creating a unique one.</div>');
        return false;
    }
}