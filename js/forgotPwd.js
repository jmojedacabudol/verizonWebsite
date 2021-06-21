$(() => {

    $("#forgotPwdForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("submit", "forgotPwdBtn");
        // for (var value of formData.keys()) {
        //     console.log(value);
        // }

        Swal.fire({
            text: "Please wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: "includes/forgotPwd.inc.php",
            data: formData,
            processData: false,
            contentType: false,
            type: "POST",
            success: function (data) {
                Swal.close();
                if (data === "Please check your email!") {
                    Swal.fire({
                        icon: "success",
                        title: "Your account has been updated",
                        text: data,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2000
                    }).then(function (result) {
                        location.reload();
                    });
                } else if (data === "Error found in Sending the email, Please contact the Developer!") {
                    Swal.fire({
                        icon: "error",
                        title: data,
                        text: "No changes has been made",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2000
                    }).then(function (result) {
                        location.reload();
                    });

                } else if ("No User Found!") {
                    Swal.fire({
                        icon: "error",
                        title: data,
                        text: "No changes has been made",
                        allowOutsideClick: false,
                        confirmButtonColor: "#3CB371",
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: data,
                        text: "No changes has been made",
                        allowOutsideClick: false,
                        confirmButtonColor: "#3CB371",
                    });
                }
            },
            error: function (data) {
                alert(data);
            },
        });
    })

})