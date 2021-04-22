//validation for image validity
var validImagetypes = ["image/gif", "image/jpg", "image/png", "image/jpeg", "gif", "jpg", "png", "jpeg"];
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

        }
    });


    $("#registraitonForm").submit(function (event) {
        event.preventDefault();
        // alert($("#selUser").val())
        var formData = new FormData(this);
        // console.log(formData.get('position'));
        // console.log(formData.get('manager'));
        // formData.append("submit", "registration-submit");
        // console.log(formData.keys('manager'))

        var selectedPosition = formData.get("position");
        var managerId = formData.get("managerId");
        var imgURL = document.querySelector("#FileUpload");
        var email = formData.get("email");
        var firstName = formData.get("firstname");
        var middleName = formData.get("middlename");
        var lastName = formData.get("lastname");
        var birthday = formData.get("birthday");
        var address = formData.get("full-address");
        var tinNo = formData.get("tin");
        var mobileNo = formData.get("mobile");
        var selectedPosition = formData.get("position");
        var validId = document.querySelector("#filevalidid");
        var termsAgreement = document.querySelector("#termsNCondtions");
        //registration as agent
        if (selectedPosition === "Agent") {
            if (imgValidation(imgURL, "Profile Image")) {
                //check if the email is in valid format
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
                                        //check if tin number is 12 characters
                                        if (tinValidation(tinNo)) {
                                            //check if mobile number is valid
                                            if (mobileNumberValidation(mobileNo)) {
                                                //check if there is a manager corresponds to the manager Id provided 0=>False 1=>True 
                                                managerIdValidation(managerId).then((result) => {
                                                    //if the manager id is empty and AR Verizon will be the default manager
                                                    if (result === true) {
                                                        var defaultManagaerId = $("#managerId").val();
                                                        if (defaultManagaerId !== "anf-Verizon") {
                                                            //set AR Verizon as default manager 
                                                            $("#managerId").val("anf-Verizon");

                                                        } else {
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
                                                                            console.log(selectedPosition);
                                                                        }
                                                                    })
                                                                    // console.log(email, firstName, middleName, lastName, birthday, address, tinNo, mobileNo, selectedPosition, managerId);
                                                                } else {
                                                                    $("#registration-alert").html('<div class="alert alert-warning" role="alert">Please Read Our Terms and Conditions.</div>');
                                                                }

                                                            }
                                                        }
                                                    }
                                                }).catch(error => {
                                                    $("#registration-alert").html('<div class="alert alert-danger" role="alert">' + error + '!</div>');
                                                });
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;

            //check if the id is valid
            //check if he checked the terms and agreement


        } else if (selectedPosition === "Manager") {
            if (imgValidation(imgURL, "Profile Image")) {
                //check if the email is in valid format
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
                                        //check if tin number is 12 characters
                                        if (tinValidation(tinNo)) {
                                            //check if mobile number is valid
                                            if (mobileNumberValidation(mobileNo)) {
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
                                                                var generatedPassword = generatePassword();
                                                                console.log(generatedPassword)
                                                            }
                                                        })
                                                        // console.log(email, firstName, middleName, lastName, birthday, address, tinNo, mobileNo, selectedPosition, managerId);
                                                    } else {
                                                        $("#registration-alert").html('<div class="alert alert-warning" role="alert">Please Read Our Terms and Conditions.</div>');
                                                    }

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return false;

        } else {
            //Agent nor Manager is selected
            console.log(selectedPosition);
        }


    })


    $("#terms").click(function () {
        $("#Register").modal('hide');
        $("#termscondition").modal('show');

    })


})




function generatePassword() {
    var pass = '';
    var str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' +
        'abcdefghijklmnopqrstuvwxyz0123456789@#$';

    for (i = 1; i <= 10; i++) {
        var char = Math.round(Math.random() *
            str.length + 1);

        pass += str.charAt(char)
    }

    return pass;
}



function addressValidation(address) {
    if (address !== "") {
        return true;
    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Adress cannot be empty!/div>');
        return false;
    }
}

function mobileNumberValidation(number) {
    var regex = /^(09|\+639)\d{9}$/;
    if (number !== "") {
        if (!number.length < 11) {
            if (number.match(regex)) {
                return true;
            } else {
                $("#registration-alert").html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
                return false;
            }
        } else {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Mobile Number is incomplete!</div>');
        }

    } else {
        $("#registration-alert").html('<div class="alert alert-danger" role="alert">Mobile Number Empty!</div>');
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
        if (!tin.length < 12) {
            return true;
        } else {
            $("#registration-alert").html('<div class="alert alert-danger" role="alert">Tin Number is incomplete!</div>');
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
    console.log(imgURL.files[0]['type'])
    //check if the imgURL is empty
    if (imgURL.files.length !== 0) {
        //get the name and extension of the picture
        var imageName = imgURL.files[0].name.split("/")[0];
        var imageExtension = imageName.split(".")[1];
        //check if the profile image is not the dafault image
        //default image name "user.png"
        //check image extension if it is valid image extension

        if (imageName !== "user") {
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
            //check if the manager id length =10(default manager Id length)
            if (!managerid.length < 10) {
                //check if the manager id exists in database
                $.ajax({
                    url: "includes/checkmanagerid.inc.php",
                    data: {
                        "managerId": managerid
                    },
                    type: "POST",
                    success: function (data) {
                        if (data === "No Manager Found!") {
                            Swal.close();
                            reject("No Manager Found");
                        } else {
                            //manager found
                            Swal.close();
                            resolve("Manager Found");
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
                    icon: "error",
                    title: "Invalid Manager Id",
                    text: "By clicking ''Proceed'' your default manager will be AR Verzion",
                    confirmButtonText: "Proceed",
                    confirmButtonColor: "#3CB371",
                    allowOutsideClick: false,
                }).then(result => {
                    if (result.value) {
                        resolve(result.value);
                        // $("#managerId").val("ahf-Verizon");
                        // return false;
                    };

                });
            }
        } else {
            Swal.close();
            Swal.fire({
                icon: "warning",
                title: "Manager Id is empty. ",
                text: "If you have a manager please insert his/her Id No. By clicking ''Proceed'' your default manager will be AR Verzion",
                confirmButtonText: "Proceed",
                confirmButtonColor: "#3CB371",
                allowOutsideClick: false,
            }).then(result => {
                if (result.value) {
                    // return result;
                    resolve(result.value)
                };

            });
        };
    });

}