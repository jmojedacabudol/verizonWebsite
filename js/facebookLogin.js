 $(() => {

     window.fbAsyncInit = function () {
         FB.init({
             appId: '1074702266372575',
             cookie: true, // Enable cookies to allow the server to access the session.
             version: 'v9.0' // Use this Graph API version for this call.
         });


         FB.getLoginStatus(function (response) { // Called after the JS SDK has been initialized.
             statusChangeCallback(response); // Returns the login status.
         });
     };

 })




 var providerId;

 function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().

     if (response.status === 'connected') { // Logged into your webpage and Facebook.
         //get the providerId
         providerId = response.authResponse.graphDomain;
         localStorage.setItem("providerId", providerId);
     }
 }


 // Facebook login with JavaScript SDK
 function fbLogin() {
     FB.login(function (response) {
         if (response.authResponse) {
             // Get and display the user profile data
             getUserInformation();
         } else {
             console.log("User cancelled login or did not fully authorize.");
         }
     }, {
         scope: 'email'
     });
 }


 function checkLoginState() { // Called when a person is finished with the Login Button.
     FB.getLoginStatus(function (response) { // See the onlogin handler
         statusChangeCallback(response);
     });
 }

 function getUserInformation() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
     // console.log('Welcome!  Fetching your information.... ');
     FB.api('/me', {
         locale: 'en_PH',
         fields: 'id,first_name,last_name,email'
     }, function (response) {
         //check if the user`s account is created using facebook  


         $.post("includes/checkaccounttag.inc.php", {
             "userEmail": response.email
         }, function (data) {
             if (data == providerId) {
                 //   console.log("User Exists Under Facebook");
                 $.post("includes/facebookgooglelogin.inc.php", {
                     "email": response.email
                 }, function (data) {
                     if (data == "Success") {
                         Swal.fire({
                             text: "Please Wait....",
                             allowOutsideClick: false,
                             showConfirmButton: false,

                             willOpen: () => {
                                 Swal.showLoading();
                             },
                         });

                         Swal.fire({
                             icon: "success",
                             title: "Login Success",
                             allowOutsideClick: false
                         }).then(result => {
                             if (result.value) {
                                 fbLogout();
                                 location.reload();

                             }
                         })
                     }

                 })
             } else if (data != "No User") {
                 Swal.fire({
                     icon: "error",
                     title: "Your email is already taken.",
                     text: "Your email is not available because it is registered to other account."
                 })
             } else {
                 console.log("No User Found");
                 //show register modal with modified registration inputs
                 $('#Login').modal('hide');
                 $('#fbGoogleRegister').modal({
                     backdrop: 'static',
                     keyboard: false
                 });

                 //insert the value of facebook credentials into form inputs and disable
                 $("#userEmail").val(response.email);
                 $("#first-name").val(response.first_name);
                 $("#last-name").val(response.last_name);

                 $("#email,#first-name,#last-name").attr('readonly', true);
             }

         });
     });
 }

 // Logout from facebook
 function fbLogout() {
     FB.getLoginStatus(function (response) {
         if (response && response.status === 'connected') {
             FB.logout(function (response) {
                 document.location.reload();
             });
         }
     });
 }

 $("#closeBtn").click(() => {
     Swal.fire({
         icon: "warning",
         title: "Cancel Registration?",
     }).then(result => {
         if (result.value) {
             fbLogout()
             var auth2 = gapi.auth2.getAuthInstance();
             auth2.signOut().then(function () {
                 auth2.disconnect();
                 document.location.reload();
             });
         }
     })
 })