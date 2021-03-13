$(function () {
    $("#updateForm").submit(function (event) {
        event.preventDefault();
        var formData = new FormData(this);
        //   for (var value of formData.keys()) {
        //   console.log(value);
        // }

        Swal.fire({
            icon: "info",
            title: "Do you want to save the changes you made?",
            text: "Please check your credentials before saving",
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelBUttonText: "No"
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
                    url: "includes/dashboard-User.inc.php",
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        if (data == 1) {
                            $("#update-error").html(``);
                            Swal.fire({
                                icon: "success",
                                title: "Account Updated",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            $("#update-error").html(`<div class='alert alert-success' id='alert' role='alert'>${data}</div>`);
                        }
                    },
                    error: function (data) {
                        alert(data);
                    },
                });
            }
        })
    })
})