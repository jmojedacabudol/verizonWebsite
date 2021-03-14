$(function () {
  $("#adminloginform").submit(function (event) {
    event.preventDefault();
    //console.log("Error")
    if ($("#admin").val() === "" || $("#admin").val() === "") {
      //check if there is a registered admin
      $.post('includes/checkAdmin.inc.php',
        function (returnedData) {
          if (returnedData === "Admin Exists") {
            //admin exists proceed to login
            var formData = new FormData(document.getElementById('adminloginform'));
            formData.append("submit", "login");
            // for (var value of fd.values()) {
            //   console.log(value);
            // }
            $.ajax({
              url: "includes/admin-login.inc.php",
              data: formData,
              processData: false,
              contentType: false,
              type: "POST",
              success: function (data) {
                // $("#form-message").html(data);
                // // console.log(data)
                switch (data) {
                  case "Please Fill out the fields.":
                    $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
                    break;
                  case "No User Found":
                    $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
                    break;
                  case "Success":
                    $("#form-message").html(`<div class='alert alert-success'role='alert'>${data}</div>'`);
                    break;
                }
              },
              error: function (data) {
                console.log(data);
              },
            });
          } else {
            //there is no admin and need to create 1
            $("#Register").modal('show');

            $("#adminRegister").submit(function (event) {
              event.preventDefault();
              // console.log("register")
              var formData = new FormData(this);
              formData.append("submit", "");
              // for (var value of formData.values()) {
              //   console.log(value);
              // }
              $.ajax({
                url: "includes/adminsignup.inc.php",
                data: formData,
                processData: false,
                contentType: false,
                type: "POST",
                success: function (data) {
                  $("#form-message").html(data);

                  // console.log(data)
                },
                error: function (data) {
                  alert(data);
                },
              });
            })
          }

        }).fail(function () {
        console.log("error");
      });


    } else {
      var formData = new FormData(this);
      formData.append("submit", "login");
      // for (var value of fd.values()) {
      //   console.log(value);
      // }
      $.ajax({
        url: "includes/admin-login.inc.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function (data) {
          switch (data) {
            case "Please Fill out the fields.":
              $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
              break;
            case "No User Found":
              $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
              break;
            case "Success":
              $("#form-message").html(`<div class='alert alert-success'role='alert'>${data}</div>'`);
              window.location.href = "admin-properties.php";
              break;
          }
        },
        error: function (data) {
          alert(data);
        },
      });
    }

  });

  var cnt = 0;
  $("#admin").click(function () {
    cnt++;
    if (cnt === 15) {
      alert("You can now create Admin Accounts");
      $("#createAdmin").css("display", "block");
    }
  });
});