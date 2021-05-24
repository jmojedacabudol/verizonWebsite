//validation for image validity
var validImagetypes = ["image/jpg", "image/png", "image/jpeg"];
$(function () {
    //displaying manager ID and Notes for Agents and Manager
    $("#posSelect").change(function () {
        var position = $(this).val();

        if (position === "Agent") {
            $("#managerId").removeClass("hidden");
            //note for manager Id
            $("p:nth-of-type(3)").removeClass("hidden");
            //hiding the note for registaring as manager
            $("p:nth-of-type(2)").addClass('hidden');
        } else if (position === "Manager") {
            $("#managerId").addClass("hidden");
            //note for manager Id
            $("p:nth-of-type(3)").addClass("hidden");
            //hiding the note for registaring as Manager
            $("p:nth-of-type(2)").removeClass('hidden');

        };
    });

    $("#brgy").select2({
        placeholder: "Select a Barangay",
        allowClear: true,
        ajax: {
            url: "includes/selectbrgy.inc.php",
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


    $("#city").select2({
        placeholder: "Select a City",
        allowClear: true,
        ajax: {
            url: "includes/selectcity.inc.php",
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


    $("#province").select2({
        placeholder: "Select a Province",
        allowClear: true,
        ajax: {
            url: "includes/selectprovince.inc.php",
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




    $("#registraitonForm").submit(function (event) {
        event.preventDefault();
        // alert($("#selUser").val())
        var formData = new FormData(this);
        // console.log(formData.get('position'));
        // console.log(formData.get('manager'));
        var generatedPassword = generatePassword();
        formData.append("password", generatedPassword);
        // console.log(formData.keys('manager'))

        var selectedPosition = formData.get("position");
        var managerId = formData.get("managerId");
        var imgURL = document.querySelector("#FileUpload");
        var email = formData.get("email");
        var firstName = formData.get("firstname");
        var middleName = formData.get("middlename");
        var lastName = formData.get("lastname");
        var birthday = formData.get("birthday");
        var address = formData.get("house-number");
        var tinNo = formData.get("tin");
        var mobileNo = formData.get("mobile");
        var selectedPosition = formData.get("position");
        var barangay = formData.get("brgy");
        var city = formData.get("city");
        var province = formData.get("province");
        var validId = document.querySelector("#filevalidid");
        var termsAgreement = document.querySelector("#termsNCondtions");
        //registration as agent


        if (imgValidation(imgURL, "Profile Image")) {
            if (emailValidation(email)) {
                //check if first name is valid format
                if (firstNameMiddleNameLastNameIsValid(firstName)) {
                    //check if middle name is valid format
                    if (firstNameMiddleNameLastNameIsValid(middleName)) {
                        //check if lastname is valid format
                        if (firstNameMiddleNameLastNameIsValid(lastName)) {
                            //check if birthday is above 18
                            if (birthdayValidation(birthday)) {
                                //check if the address is not empty and valid
                                if (addressValidation(address)) {
                                    //check if barangay address is not empty
                                    if (barangayValidation(barangay)) {
                                        //check if city address is not empty
                                        if (cityValidation(city)) {
                                            //check if province is not empty
                                            if (provinceValidation(province)) {
                                                //check if tin number is 12 characters
                                                if (tinValidation(tinNo)) {
                                                    //check if mobile number is valid
                                                    if (mobileNumberValidation(mobileNo)) {
                                                        if (positionValidation(selectedPosition)) {
                                                            if (selectedPosition === "Agent") {
                                                                //check if there is a manager corresponds to the manager Id provided 0=>False 1=>True 
                                                                managerIdValidation(managerId).then((result) => {
                                                                    //if the manager id is valid
                                                                    if (result === true) {
                                                                        //check if the id is valid
                                                                        if (imgValidation(validId, "Valid Id")) {
                                                                            //terms of Agreement
                                                                            if (termsAgreement.checked) {
                                                                                Swal.fire({
                                                                                    icon: "info",
                                                                                    title: "Register as an Agent of AR Verizon?",
                                                                                    text: "If you`re sure about all information kindly click ''Yes''",
                                                                                    showCancelButton: true,
                                                                                    cancelButtonText: "No",
                                                                                    confirmButtonText: "Yes",
                                                                                    confirmButtonColor: "#3CB371",
                                                                                    cancelButtonColor: "#70945A"
                                                                                }).then(result => {
                                                                                    if (result.value) {
                                                                                        $("#registration-alert").html("");
                                                                                        //insert to sql database
                                                                                        //email to user`s email
                                                                                        //notif to users about about the result

                                                                                        $.ajax({
                                                                                            url: "includes/signup.inc.php",
                                                                                            data: formData,
                                                                                            processData: false,
                                                                                            contentType: false,
                                                                                            type: "POST",
                                                                                            success: function (data) {
                                                                                                Swal.close();
                                                                                                // console.log(data)
                                                                                                if (data === "Message has been sent") {
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
                                                                                                    $("#registration-alert").html(data);
                                                                                                }
                                                                                            },
                                                                                            error: function (data) {
                                                                                                Swal.close();
                                                                                                alert("Error: " + data);
                                                                                            },
                                                                                        });
                                                                                    };
                                                                                });
                                                                            } else {
                                                                                $("#registration-alert").html('<div class="alert alert-warning" role="alert">Please Read Our Terms and Conditions.</div>');
                                                                            };
                                                                        };
                                                                    };
                                                                }).catch(error => {
                                                                    //there is no Manager Id
                                                                    $("#managerId").val("anf-Verizon");
                                                                    // // $("#registration-alert").html('<div class="alert alert-danger" role="alert">' + error + '!</div>');
                                                                    // var defaultManagaerId = $("#managerId").val();
                                                                    // if (defaultManagaerId !== "anf-Verizon") {
                                                                    //     //set AR Verizon as default manager 

                                                                    // } else {

                                                                    // }
                                                                });
                                                            } else if (selectedPosition === "Manager") {
                                                                //check if the id is valid
                                                                if (imgValidation(validId, "Valid Id")) {
                                                                    //terms of Agreement
                                                                    if (termsAgreement.checked) {
                                                                        Swal.fire({
                                                                            icon: "info",
                                                                            title: "Register as Manager of AR Verizon?",
                                                                            text: "If you`re sure about all information kindly click ''Yes''",
                                                                            showCancelButton: true,
                                                                            cancelButtonText: "No",
                                                                            confirmButtonText: "Yes",
                                                                            confirmButtonColor: "#3CB371",
                                                                            cancelButtonColor: "#70945A"
                                                                        }).then(result => {
                                                                            if (result.value) {
                                                                                $("#registration-alert").html("");
                                                                                //insert to sql database
                                                                                //email to user`s email
                                                                                //notif to users about about the result
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
                                                                                        if (data === "Message has been sent") {
                                                                                            Swal.fire({
                                                                                                icon: "success",
                                                                                                title: "Registration Complete",
                                                                                                text: "You can now logged in.",
                                                                                                showConfirmButton: false,
                                                                                                allowOutsideClick: false,
                                                                                                timer: 2000
                                                                                            }).then(function (result) {
                                                                                                location.reload();
                                                                                            });
                                                                                        } else {
                                                                                            $("#registration-alert").html(data);
                                                                                        };
                                                                                    },
                                                                                    error: function (data) {
                                                                                        Swal.close();
                                                                                        alert("Error: " + data);
                                                                                    },
                                                                                });
                                                                            };
                                                                        });
                                                                        // console.log(email, firstName, middleName, lastName, birthday, address, tinNo, mobileNo, selectedPosition, managerId);
                                                                    } else {
                                                                        $("#registration-alert").html('<div class="alert alert-warning" role="alert">Please Read Our Terms and Conditions.</div>');
                                                                    };
                                                                };
                                                            };
                                                        };
                                                    };
                                                };
                                            };
                                        };
                                    };
                                };
                            };
                        };
                    };
                };
            };
        };
        return false;
    });


    $("#terms").click(function () {
        $("#Register").modal('hide');
        $("#termscondition").modal('show');

    });


});




function generatePassword() {
    var pass = '';
    var str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' +
        'abcdefghijklmnopqrstuvwxyz0123456789@#$';

    for (i = 1; i <= 10; i++) {
        var char = Math.round(Math.random() *
            str.length + 1);

        pass += str.charAt(char)
    };

    return pass;
};




function addressValidation(address) {
    if (address !== "") {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">House number cannot be empty!</div>');
        return false;
    }
}

function barangayValidation(brgy) {
    if (brgy !== null) {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Barangay Adress cannot be empty!</div>');
        return false;
    }
}

function cityValidation(city) {
    if (city !== null) {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert"> City Adress cannot be empty!</div>');
        return false;
    }
}

function provinceValidation(province) {
    if (province !== null) {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Province cannot be empty!</div>');
        return false;
    }
}

function mobileNumberValidation(number) {
    var regex = /^(09|\+639)\d{9}$/;
    if (number !== "") {
        if (number.length === 11) {
            if (number.match(regex)) {
                return true;
            } else {
                $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
                return false;
            }
        } else {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
        }

    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Mobile Number Empty!</div>');
        return false;
    }

}


function positionValidation(selectedPosition) {
    if (selectedPosition === "Agent") {
        return true;
    } else if (selectedPosition === "Manager") {
        return true;
    } else {
        //selected position is invalid
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid Position type!</div>');
        return false;
    }
}

//function for selecting profile Img
$("#imgFileUpload").click(function () {
    $("#FileUpload").click();
});

$("#FileUpload").change(function () {
    previewImage(this, "imgFileUpload");

});




//FOR IMAGE PRELOAD
function previewImage(image_blog, container) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(`#${container}`).attr("src", e.target.result);
    };
    if (typeof (image_blog.files[0]) === 'undefined') {
        Swal.fire({
            icon: "error",
            title: "No Image Found",
            text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
        }).then(function (result) {
            if (result.value) {
                $(`#${container}`).attr("src", 'assets/img/user.png');
                $("#propertyImg").value = null;
            }
        });
    } else {
        var readImage = image_blog.files[0];
        var filetype = readImage["type"];
        //if Image is Valid
        if ($.inArray(filetype, validImagetypes) > 0) {
            reader.readAsDataURL(image_blog.files[0]);
            $(`#${container}`).value = readImage;
        }
        //else Image is Invalid
        else {
            Swal.fire({
                icon: "error",
                title: "Invalid Image",
                text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
            }).then(function (result) {
                if (result.value) {
                    reader.readAsDataURL(image_blog.files[0]);
                    $("#propertyImg").value = null;
                    $("#imgFileUpload").attr("src", "assets/img/user.png");
                }

            });
        }
    }
}

function firstNameMiddleNameLastNameIsValid(name) {
    if (name !== "") {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Either "First Name", "Middle Name" or "Last Name" is empty!</div>');
    }
}

//BIRTHDATE VALIDATION
function birthdayValidation(date) {
    if (date !== "") {
        var today = moment();
        var userdate = moment(date);
        var difference = today.diff(userdate, 'years')
        if (difference < 18) {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Should be at least 18 and above!</div>');
            return false;
        } else {
            return true;
        }

    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Bithdate cannot be empty!</div>');
        return false;
    }
}

function tinValidation(tin) {
    if (tin !== "") {
        if (tin.length === 12) {
            return true;
        } else {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid Tin Number!</div>');
            return false;
        }
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Tin Number cannot be empty!</div>');
        return false;
    }
}

function emailValidation(email) {
    if (email !== "") {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Email cannot be empty!</div>');
    }
}

function imgValidation(imgURL, location) {

    //check if the imgURL is empty
    if (imgURL.files.length !== 0) {
        //get the name and extension of the picture
        var imageExtension = imgURL.files[0]['type'];

        if ($.inArray(imageExtension, validImagetypes) > 0) {
            //check if name is not empty
            return true;

        } else {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid ' + location + ' type!' + '</div>');
            return false;
        }

    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Please select a ' + location + '</div>');
        return false;
    }

}

function managerIdValidation(managerid) {

    return new Promise((resolve, reject) => {
        //check if the manager is not empty
        Swal.fire({
            text: "Please Wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        if (managerid !== "") {
            //check if the manager id exists in database
            $.ajax({
                url: "includes/checkmanagerid.inc.php",
                data: {
                    "managerId": managerid
                },
                type: "POST",
                success: function (data) {
                    if (data == 1) {
                        Swal.close();
                        resolve(true);
                    } else {
                        //manager found
                        Swal.close();
                        reject("No Manager Found");
                    }
                },
                error: function (data) {
                    // alert(data);
                    // return false;
                    reject("Error Occured: Please contact admin");
                },
            });

        } else {
            Swal.close();
            Swal.fire({
                icon: "warning",
                title: "Manager Id is empty. ",
                text: "If you have a manager please insert his/her Id No. By clicking ''Proceed'' your default manager will be AR Verzion",
                confirmButtonText: "Proceed",
                confirmButtonColor: "#3CB371",
                allowOutsideClick: false,
                showCancelButton: true
            }).then(result => {
                if (result.value) {
                    resolve(result.value);
                    $("#managerId").val("AR-DM1");
                    return false;
                };
            });
        };
    });

}