$(() => {

    $("#forgotPwdForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        formData.append("submit", "forgotPwdBtn");
        // for (var value of formData.keys()) {
        //     console.log(value);
        // }

        Swal.fire({
            text: "Please Wait....",
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
                // console.log(data)
                if (data == "Success") {
                    $("#forgotPwd-Alert").html("");
                    Swal.fire({
                        icon: "success",
                        title: "Account Updated!",
                        text: data,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2000
                    }).then(function (result) {
                        location.reload();
                    })
                } else {
                    $("#forgotPwd-Alert").html(`<div class='alert alert-danger' id='alert' role='alert'>${data}</div>`);
                }

            },
            error: function (data) {
                alert(data);
            },
        });
    })

})