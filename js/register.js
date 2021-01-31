$(function () {
    $("#posSelect").change(function () {
        var position = $(this).val();

        if (position === "Agent") {
            document.getElementById("managerContainer").style.display = "block";

            $("#selUser").select2({
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
            document.getElementById("managerContainer").style.display = "none";
            //reset the select 2 dropdown of managers
            $("#selUser").val('0').trigger('change')
            console.log($("#selUser").val())
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
                text: "By not selecting any Manager your default Manager will be AR Verizon."
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
        }

    })


    $("#terms").click(function () {
        $("#Register").modal('hide');
        $("#termscondition").modal('show');

    })


})