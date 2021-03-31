$(function () {
    $("#posSelect").change(function () {
        var position = $(this).val();

        if (position === "Agent") {
            // document.getElementById("managerContainer").style.display = "block";
            $("#managerContainer").removeAttr("style").show();
            $("#selUser").select2({
                placeholder: "Select a Manager",
                ajax: {
                    url: "includes/selectmanager.inc.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

        } else {
            document.getElementById("managerContainer").style.display = "none";
            //reset the select 2 dropdown of managers
            $("#selUser").val('0').trigger('change')
            // console.log($("#selUser").val())
        }
    })


    // facebook and gmail login

    $("#fbGooglePosSelect").change(function () {
        var position = $(this).val();

        if (position === "Agent") {
            $("#fbGooglemanagerContainer").removeAttr("style").show();

            $("#fbGoogleselUser").select2({
                placeholder: "Select a Manager",
                allowClear: true,
                ajax: {
                    url: "includes/selectmanager.inc.php",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }
            });

        } else {
            $("#fbGooglemanagerContainer").removeAttr("style").hide();
            //reset the select 2 dropdown of managers
            $("#fbGoogleselUser").val('0').trigger('change')
            // console.log($("#fbGoogleselUser").val())
        }
    })



    $("#fbGoogleregistraitonForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        var temrsAgreement = document.getElementById("exampleCheck2");
        var contact = formData.get('mobile');
        var positionType = $("#fbGooglePosSelect").val();
        var image = formData.get('validid');
        //append the providerId to form
        formData.append("providerId", localStorage.getItem("providerId"));
        $("#email,#first-name,#last-name").prop('disabled', false);

        // for (var value of formData.keys()) {
        //     console.log(value);
        // }

        // for (var value of formData.values()) {
        //     console.log(value);
        // }


        if (temrsAgreement.checked) {
            if (informationEmpty(contact, positionType, image)) {
                if (mobileNumberValidation(contact)) {
                    if (formData.get('position') == "Agent" && formData.get('manager') == 0) {
                        Swal.fire({
                            icon: "info",
                            title: "Manager Info",
                            text: "By not selecting any Manager your default Manager will be AR Verizon.",
                            showCancelButton: true,
                            cancelButtonText: "No",
                            confirmButtonText: "Yes",
                            confirmButtonColor: "#3CB371",
                            cancelButtonColor: "#70945A"
                        }).then(result => {
                            if (result.value) {
                                $("#fbGooglregistration-alert").html('')
                                Swal.fire({
                                    text: "Please Wait....",
                                    allowOutsideClick: false,
                                    showConfirmButton: false,

                                    willOpen: () => {
                                        Swal.showLoading();
                                    },
                                });

                                $.ajax({
                                    url: "includes/facebookgooglesignup.inc.php",
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    type: "POST",
                                    success: function (data) {
                                        Swal.close();
                                        // console.log(data)
                                        if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Registration Complete",
                                                text: "You can now logged in.",
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                timer: 2000
                                            }).then(function (result) {
                                                location.reload();
                                            })

                                        } else {
                                            $("#fbGooglregistration-alert").html(data)
                                        }
                                    },
                                    error: function (data) {
                                        Swal.close();
                                        alert("Error: " + data);
                                    },
                                });

                            }
                        })
                    } else if (formData.get('position') == "Agent" && formData.get('manager') !== 0) {
                        $("#fbGooglregistration-alert").html('')
                        Swal.fire({
                            text: "Please Wait....",
                            allowOutsideClick: false,
                            showConfirmButton: false,

                            willOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        $.ajax({
                            url: "includes/facebookgooglesignup.inc.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: "POST",
                            success: function (data) {
                                Swal.close();
                                // console.log(data)
                                if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Registration Complete",
                                        text: "You can now logged in.",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        timer: 2000
                                    }).then(function (result) {
                                        location.reload();
                                    })

                                } else {
                                    $("#fbGooglregistration-alert").html(data)
                                }
                            },
                            error: function (data) {
                                Swal.close();
                                alert("Error: " + data);
                            },
                        });
                    } else if (formData.get('position') == "Manager") {
                        $("#fbGooglregistration-alert").html('')
                        Swal.fire({
                            text: "Please Wait....",
                            allowOutsideClick: false,
                            showConfirmButton: false,

                            willOpen: () => {
                                Swal.showLoading();
                            },
                        });

                        $.ajax({
                            url: "includes/facebookgooglesignup.inc.php",
                            data: formData,
                            processData: false,
                            contentType: false,
                            type: "POST",
                            success: function (data) {
                                Swal.close();
                                // console.log(data)
                                if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Registration Complete",
                                        text: "You can now logged in.",
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        timer: 2000
                                    }).then(function (result) {
                                        location.reload();
                                    })

                                } else {
                                    $("#fbGooglregistration-alert").html(data)
                                }
                            },
                            error: function (data) {
                                Swal.close();
                                alert("Error: " + data);
                            },
                        });
                    }
                }
            }
        } else {
            $("#fbGooglregistration-alert").html('<div class="alert alert-warning" role="alert">Please Read Our Terms and Conditions.</div>');
        }

    })
    // facebook and gmail login End here






    $("#registraitonForm").submit(function (event) {
        event.preventDefault();
        // alert($("#selUser").val())
        var formData = new FormData(this);
        // console.log(formData.get('position'));
        // console.log(formData.get('manager'));
        // formData.append("submit", "registration-submit");
        // console.log(formData.keys('manager'))

        if (formData.get('position') == "Agent" && formData.get('manager') == 0) {
            Swal.fire({
                icon: "info",
                title: "Manager Info",
                text: "By not selecting any Manager your default Manager will be AR Verizon.",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Yes",
                confirmButtonColor: "#3CB371",
                cancelButtonColor: "#70945A"
            }).then(result => {
                if (result.value) {
                    Swal.fire({
                        text: "Please Wait....",
                        allowOutsideClick: false,
                        showConfirmButton: false,

                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: "includes/signup.inc.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: "POST",
                        success: function (data) {
                            Swal.close();
                            // console.log(data)
                            if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                                Swal.fire({
                                    icon: "success",
                                    title: "Registration Complete",
                                    text: "You can now logged in.",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 2000
                                }).then(function (result) {
                                    location.reload();
                                })

                            } else {
                                $("#registration-alert").html(data)
                            }
                        },
                        error: function (data) {
                            Swal.close();
                            alert("Error: " + data);
                        },
                    });
                }
            })
        } else if (formData.get('position') == "Agent" && formData.get('manager') !== 0) {
            // for (var value of formData.values()) {
            //     console.log("Agent With Manager Form" + value);
            // }
            // var formData = new FormData(this);
            // // formData.append("submit", "registration-submit");
            // // console.log(formData.keys('manager'))
            // // for (var value of formData.keys()) {
            // //     console.log(value);
            // // }
            Swal.fire({
                text: "Please Wait....",
                allowOutsideClick: false,
                showConfirmButton: false,

                willOpen: () => {
                    Swal.showLoading();
                },
            });
            $.ajax({

                url: "includes/signup.inc.php",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function (data) {
                    Swal.close();
                    // console.log(data)
                    if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                        Swal.fire({
                            icon: "success",
                            title: "Registration Complete",
                            text: "You can now logged in.",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000
                        }).then(function (result) {
                            console.log(result)
                        })

                    } else {
                        $("#registration-alert").html(data)
                    }
                },
                error: function (data) {
                    Swal.close();
                    alert("Error Data: " + data);
                },
            });
        } else if (formData.get('position') == "Manager") {
            // for (var value of formData.values()) {
            //     console.log("Manager Form" + value);
            // }

            // var formData = new FormData(this);
            // // formData.append("submit", "registration-submit");
            // // console.log(formData.keys('manager'))
            // // for (var value of formData.keys()) {
            // //     console.log(value);
            // // }
            Swal.fire({
                text: "Please Wait....",
                allowOutsideClick: false,
                showConfirmButton: false,

                willOpen: () => {
                    Swal.showLoading();
                },
            });
            $.ajax({
                url: "includes/signup.inc.php",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function (data) {
                    Swal.close();
                    // console.log(data)
                    if (data == 'Success1' || data == 'Success2' || data == 'Success3') {
                        Swal.fire({
                            icon: "success",
                            title: "Registration Complete",
                            text: "You can now logged in.",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000
                        }).then(function (result) {
                            location.reload();
                        })

                    } else {
                        $("#registration-alert").html(data)
                    }
                },
                error: function (data) {
                    Swal.close();
                    alert("Error Data: " + data);
                },
            });
        }

    })


    $("#terms").click(function () {
        $("#Register").modal('hide');
        $("#termscondition").modal('show');

    })


})


function informationEmpty(mobile, positionType, image) {
    if (mobile == "" || positionType == "Position Type" || image.size == 0) {
        $("#fbGooglregistration-alert").html('<div class="alert alert-danger" role="alert">Please Fillup Fields!</div>');
        return false;

    } else {
        return true;
    }
}



function mobileNumberValidation(number) {
    var regex = /^(09|\+639)\d{9}$/;
    if (number !== "") {
        if (number.match(regex)) {
            return true;
        } else {
            $("#fbGooglregistration-alert").html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
            return false;
        }
    } else {
        $("#fbGooglregistration-alert").html('<div class="alert alert-danger" role="alert">Mobile Number Empty!</div>');
        return false;
    }

}