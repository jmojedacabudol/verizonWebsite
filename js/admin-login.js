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
                    $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}.</div>'`);
                    break;
                  case "No User Found":
                    $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
                    break;
                  case "Wrong logged in Credentials":
                    $("#form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>'`);
                    break;
                  case "Success":
                    Swal.fire({
                      icon: "success",
                      title: data,
                      text: "Click to ''proceed'' to see the dashboard.",
                      showConfirmButton: true,
                      allowOutsideClick: false,
                      confirmButtonText: "Proceed",
                      confirmButtonColor: "#3CB371",
                    }).then(function (result) {
                      if (result.value) {
                        window.location.href = "admin-properties.php";
                      }
                    })
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
              var password = formData.get("pwd");
              var repeatPassword = formData.get("pwdrepeat");

              if (passwordValidation(password, repeatPassword, 6, 12)) {
                $.ajax({
                  url: "includes/adminsignup.inc.php",
                  data: formData,
                  processData: false,
                  contentType: false,
                  type: "POST",
                  success: function (data) {
                    if (data === "Registration Success") {
                      Swal.fire({
                        icon: "success",
                        title: data,
                        text: "The page will now reload.",
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 2000
                      }).then(function (result) {
                        location.reload();
                      })
                    } else {
                      $("$register-form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>`);
                    }


                    // console.log(data)
                  },
                  error: function (data) {
                    alert(data);
                  },
                });
              }
              return false;
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
              $("#form-message").html(`<div class='alert alert-danger'role='alert'>Kindly, fill out the fields</div>'`);
              break;
            case "No User Found":
              $("#form-message").html(`<div class='alert alert-danger'role='alert'>User does not exist</div>'`);
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
      $("#Register").modal("show");
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
            if (data === "Registration Success") {
              Swal.fire({
                icon: "success",
                title: data,
                text: "The page will now reload.",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 2000
              }).then(function (result) {
                location.reload();
              })
            } else {
              $("$register-form-message").html(`<div class='alert alert-danger'role='alert'>${data}</div>`);
            }


            // console.log(data)
          },
          error: function (data) {
            alert(data);
          },
        });
      })
    }
  });
});




//PASSWORD VALIDATION
function passwordValidation(password, confirmpassword, min, max) {
  var passwordformat = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])/
  if (password !== "" && confirmpassword !== "") {
    if (password.length >= min && password.length < max && confirmpassword.length >= min && confirmpassword.length < max) {
      if (password === confirmpassword) {
        if (password.match(passwordformat) && confirmpassword.match(passwordformat)) {
          $("#register-form-message").html('');
          $("#pwd").removeClass("input-error");
          $("#pwdrepeat").removeClass("input-error");
          return true;
        } else {
          $("#register-form-message").html('<div class="alert alert-danger" role="alert">Your Password must contain at least 1 capital Letter, at leat 1 small letter, at least 1 number, and at least 1 special character/s.</div>');
          $("#pwd").addClass("input-error");
          $("#pwdrepeat").addClass("input-error");
          return false;
        }
      } else {
        $("#register-form-message").html('<div class="alert alert-danger" role="alert">Password and Confirm password must be the same. Try checking "show password" if it matches.</div>');
        $("#pwd").addClass("input-error");
        $("#pwdrepeat").addClass("input-error");
        return false;
      }
    } else {
      $("#register-form-message").html('<div class="alert alert-danger" role="alert">Password and Confirm password must have 6 or more unique characters.</div>');
      $("#pwd").addClass("input-error");
      $("#pwdrepeat").addClass("input-error");
      return false;
    }
  } else {
    $("#register-form-message").html('<div class="alert alert-danger" role="alert">The "New Password"" field is empty. Please try creating a unique one.</div>');
    $("#pwd").addClass("input-error");
    $("#pwdrepeat").addClass("input-error");
    return false;
  }
}