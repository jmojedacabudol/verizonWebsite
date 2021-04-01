$(function () {
    $("#posSelect").change(function () {
        var position = $(this).val();

        if (position === "Agent") {
            $("p:nth-of-type(2)").addClass("hidden");

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

        } else if (position === "Manager") {
            $("p:nth-of-type(2)").removeClass("hidden");
            document.getElementById("managerContainer").style.display = "none";
            //reset the select 2 dropdown of managers
            $("#selUser").val('0').trigger('change')
            // console.log($("#selUser").val())
        }
    })

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
//function for selecting profile Img
$("#imgFileUpload").click(function () {
    $("#FileUpload").click();
});

$("#FileUpload").change(function () {
    previewImage(this, "imgFileUpload");

});


//validation for image validity
var validImagetypes = ["image/gif", "image/jpg", "image/png", "image/jpeg"];

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
                    $("#imgFileUpload").attr("src,assets/img/user.png");
                }

            });
        }
    }
}


function birthdayValidation(birthday) {

}

function tinValidation(tin) {

}