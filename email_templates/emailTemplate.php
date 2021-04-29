<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEMO</title>
</head>
<style>
p {
    font-family: Arial, Helvetica, sans-serif;
}
</style>

<body>
    <div style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width: 40%; margin:auto; border-radius:5px">
        <img src="../assets/img/banner_userAccount.png" style="width:100%;">
        <div style="padding: 2px 16px;">
            <p> Dear {USER_NAME},</p>
            <p>Congratulations! You have successfully registered to our system. Please dont share this email because it
                contains your login information. You can change your password after you login to our website.</p>

            <p>
                <strong>Email:</strong>
                {EMAIL_ADDRESS}
            </p>

            <p>
                <strong>Password:</strong>
                {EMAIL_PASSWORD}
            </p>

            <p>Thank you!</p>
            <p>Warmest regards,</p>
            <p>AR Verizon Team</p>

            <hr style="border-style:dashed; color:grey;">
            <div style="float:left;">
                <small style="color:grey;">Copyright © AR Verizon 2021</small>
            </div>
            <div style="float:right;">
                <a href="https://www.facebook.com/MRVerizonRealEstateServices"><img src="../assets/img/fbLogo.png"
                        style="width:25px;height:25px;"></a>
                <a href=""><img src="../assets/img/instaLogo.png" style="width:25px;height:25px;"></a>
                <a href=""><img src="../assets/img/twitterLogo.png" style="width:25px;height:25px;"></a>
            </div>

            <div style="clear: both;"></div>​

        </div>
    </div>

    </div>
</body>

</html>