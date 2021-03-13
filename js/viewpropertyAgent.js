function viewAgent(user, propertyid) {
    if (user !== "no-user") {
        // $("#ContactAgent").modal("show");
        Swal.fire({
            icon: "info",
            title: "Do you want to contact this Agent?",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No"
        }).then(result => {
            if (result.value) {
                // console.log(user)

                Swal.fire({
                    text: "Please Wait....",
                    allowOutsideClick: false,
                    showConfirmButton: false,

                    willOpen: () => {
                        Swal.showLoading();
                    },
                });


                $.ajax({
                    url: "includes/insertmessages.inc.php",
                    data: {
                        "userlogged": user,
                        "propertyId": propertyid
                    },
                    type: "POST",
                    success: function (data) {
                        // console.log(data)
                        // $("#userNotification").html('');
                        if (data === "Message saved") {
                            Swal.close();
                            Swal.fire({
                                icon: "success",
                                title: "Contact Information  Submitted",
                                text: "Please click 'Ok' button to view Agent`s Info.",
                                allowOutsideClick: false
                            }).then(result => {
                                if (result.value) {
                                    $("#agentContainer").load("includes/loadAgent.inc.php", {
                                        propertyId: propertyid,
                                    }, function (data, status) {
                                        if (status === "success") {
                                            // $("#userContact").modal('hide');
                                            $("#ContactAgent").modal('show');
                                        }
                                    });
                                }
                            })
                        } else {

                            // $("#userNotification").html(`<div class = "alert alert-danger" role = "alert" >${data}</div>`)
                            Swal.fire({
                                icon: "info",
                                title: data,
                                text: "You can now View the Agent of the Property",
                                allowOutsideClick: false
                            }).then(result => {
                                if (result.value) {
                                    Swal.close();
                                    $("#agentContainer").load("includes/loadAgent.inc.php", {
                                        propertyId: propertyid,
                                    }, function (data, status) {
                                        if (status === "success") {
                                            // $("#userContact").modal('hide');
                                            $("#ContactAgent").modal('show');
                                        }
                                    });
                                }
                            })
                        }
                    },
                    error: function (data) {
                        alert(data);
                    },
                });
            }
        })

    } else {
        //no-user
        $("#userContact").modal("show");

        $("#userContactInfo").submit(function (event) {
            event.preventDefault();

            var formData = new FormData(this);
            // var propertySelected = localStorage.getItem('propertySelected');
            formData.append("propertyId", propertyid);
            formData.append("userlogged", user);
            // // fd.append(this);
            // // fd.append("submit", "propertySubmitBtn");
            // Display the values
            // for (var value of formData.keys()) {
            //     console.log(value);
            // }

            //check if the user input a value to the input fields

            var userName = formData.get('name');
            var userNumber = formData.get('userNo');

            // console.log(userName, userNumber)
            if (checkuserinformation(userName, userNumber)) {

                Swal.fire({
                    text: "Please Wait....",
                    allowOutsideClick: false,
                    showConfirmButton: false,

                    willOpen: () => {
                        Swal.showLoading();
                    },
                });
                $.ajax({
                    url: "includes/insertmessages.inc.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        // console.log(data)
                        $("#userNotification").html('');
                        if (data === "Message saved") {
                            Swal.fire({
                                icon: "success",
                                title: "Contact Information  Submitted",
                                text: "Please click 'Ok' button to view Agent`s Info.",
                                allowOutsideClick: false
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
                                    $("#agentContainer").load("includes/loadAgent.inc.php", {
                                        propertyId: propertyid,
                                    }, function (data, status) {
                                        if (status === "success") {
                                            Swal.close();
                                            $("#userContact").modal('hide');
                                            $("#ContactAgent").modal('show');
                                        }
                                    });

                                }
                            })
                        } else {
                            Swal.close();
                            $("#userNotification").html(`<div class = "alert alert-danger" role = "alert" >${data}</div>`)
                        }
                    },
                    error: function (data) {
                        alert(data);
                    },
                });
            }
            return false;



        })
    }
}


function checkuserinformation(name, phonenumber) {
    if (name !== "" || phonenumber !== "") {
        if (name.length < 5) {
            $("#userNotification").html("<div class='alert alert-danger' role='alert'>Please provide a more readable Name.</div>");
            return false;
        } else {
            if (phonenumber.length === 11) {
                $("#contact-error").html('');
                return true;
            } else {
                $("#contact-error").html("<div class='alert alert-danger' role='alert'>Please provide a valid Phone Number.</div>");
            }
        }
    } else {
        $("#userNotification").html("<div class='alert alert-danger' role='alert'>Please Provide your Name and Number.</div>");
        return false;
    }
}