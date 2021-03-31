$(() => {
    // $('#uid,#pwd').keypress(function (e) {

    //     if (e.which == 13) {
    //         $("#loginBtn").click();
    //         return false; //<---- Add this line
    //     }


    // });
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
                if (data == "Success") {
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
                alert(data);
            },
        });
    })
})