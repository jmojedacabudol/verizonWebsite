$(() => {
    $("#userContactInfo").submit(function (event) {
        event.preventDefault();

        var formData = new FormData(this);
        var propertySelected = localStorage.getItem('propertySelected');
        formData.append("submit", "contact-submit");
        formData.append("propertyId", propertySelected);
        // // fd.append(this);
        // // fd.append("submit", "propertySubmitBtn");
        // Display the values
        // for (var value of formData.values()) {
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
            url: "includes/insertmessages.inc.php",
            data: formData,
            processData: false,
            contentType: false,
            type: "POST",
            success: function (data) {
                Swal.close();
                $("#userNotification").html('');
                if (data === "Message saved") {
                    Swal.fire({
                        icon: "success",
                        title: "Contact Information  Submitted",
                        text: "Please click 'Ok' button to view Agent`s Info.",
                        allowOutsideClick: false
                    }).then(result => {
                        if (result.value) {
                            $("#userContact").modal('hide');
                            $("#ContactAgent").modal('show');
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
    })

})