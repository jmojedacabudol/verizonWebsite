//validation for image validity
var validImagetypes = ["image/gif", "image/jpg", "image/png", "image/jpeg"];

//FOR IMAGE PRELOAD
function previewImage(image_blog, container) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(`#${container}`).attr("src", e.target.result);
    };
    if (typeof (image_blog.files[0]) === 'undefined') {
        Swal.fire({
            icon: "error",
            title: "No Image Found",
            text: "Please upload an image.",
            allowOutsideClick: false
        }).then(function (result) {
            if (result.value) {
                $(`#${container}`).attr("src", 'assets/img/user.png');
                $("#propertyImg").value = null;
            }
        });
    } else {
        var readImage = image_blog.files[0];
        var filetype = readImage["type"];
        //if Image is Valid
        if ($.inArray(filetype, validImagetypes) > 0) {
            reader.readAsDataURL(image_blog.files[0]);
            $(`#${container}`).value = readImage;
        }
        //else Image is Invalid
        else {
            Swal.fire({
                icon: "error",
                title: "Invalid Image",
                text: "Kindly, upload a valid image format. These are jpg, png, and jpeg file formats.",
                allowOutsideClick: false
            }).then(function (result) {
                if (result.value) {
                    reader.readAsDataURL(image_blog.files[0]);
                    $("#propertyImg").value = null;
                    $("#imgFileUpload").attr("src", "assets/img/user.png");
                }

            });
        }
    }
}

//preventing numbers to names 
function allowOnlyLetters(evt) {
    var inputValue = evt.charCode;
    if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) {
        evt.preventDefault();
    }
}

//for limiting to only number in input text
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}

$('input.CurrencyInput').on('change', function () {
    this.value = numeral(this.value).format('0,0');
});



//TRANSACTION  INFORMATION VALIDATION



function checkClients(client1Holder, client2Holder) {
    var result;
    if (client1Holder.children().length !== 0 && client2Holder.children().length !== 0) {
        //if both have children
        $(`#clientHolders`).removeClass('input-error');
        result = true;
    } else {
        //if there are at least 1 client added
        if (client1Holder.children().length !== 0 && client2Holder.children().length === 0) {
            $(`#clientHolders`).removeClass('input-error');
            result = true;
            //1st have client 2nd dont have client
        } else if (client1Holder.children().length === 0 && client1Holder.children().length !== 0) {
            $(`#clientHolders`).removeClass('input-error');
            result = true;
        } else {
            //there is not client added , add error
            $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Please add a Client!</div>');
            $(`#clientHolders`).addClass('input-error');
            result = false;
        }
    }
    return result;
}


//validating property name 
function termsValidation(terms) {
    if (terms !== "" && terms !== "default") {
        //if there is property selected
        $(`#terms`).removeClass('input-error');
        return true;
    } else {
        //there is no property name selected
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Terms is empty!</div>');
        $(`#terms`).addClass('input-error');
        return false;
    }
}


//validating property name 
function propertyNameValidation(propertyName) {
    if (propertyName !== "") {
        //if there is property selected
        $(`.form-control#allPropertyHolder`).next().find('.select2-selection').removeClass('input-error');
        return true;
    } else {
        //there is no property name selected
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Property Name is empty!</div>');
        $(`.form-control#allPropertyHolder`).next().find('.select2-selection').addClass('input-error');
        return false;
    }
}

//check if date of transaction is not empty
function transactionDateValidation(date) {
    if (date !== "" && date !== null) {
        //transaction date is not empty
        $(`#transactionDate`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#transactionDate`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Transaction Date is empty!</div>');
        return false;
    }
}


//check if finalTCP is not empty
function finalTCPValidation(tcp) {
    if (tcp !== "" && tcp != 0) {
        //fincalTCP is not empty
        $(`#finalTcp`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#finalTcp`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Final TCP is empty!</div>');
        return false;
    }
}

//check if commission is not empty
function commissionValidation(commision) {
    if (commision !== "" && commision !== 0) {
        //commission is not empty
        $(`#commission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#commission`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Commission is empty!</div>');
        return false;
    }
}


//check if agent commission is not empty
function agentCommissionValidation(agentCommission) {
    if (agentCommission !== "" && agentCommission !== 0) {
        //agentCommission is not empty
        $(`#agentCommission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#agentCommission`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Agent`s Commission is empty!</div>');
        return false;
    }
}

//check if arVerizon Commission is not empty
function ARCommissionValidation(ARCommission) {
    if (ARCommission !== "" && ARCommission !== 0) {
        //AR Verizon Commission is not empty
        $(`#arCommission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#arCommission`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">AR Verizon`s Commission is empty!</div>');
        return false;
    }
}


//check if buyers Commission is not empty
function buyersCommissionValidation(buyersCommission) {
    if (buyersCommission !== "" && buyersCommission !== 0) {
        //AR Verizon Commission is not empty
        $(`#buyersCommssion`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#buyersCommssion`).addClass('input-error');
        $("#transactionAlert").html('<div class="alert alert-danger" role="alert">Buyers`s Commission is empty!</div>');
        return false;
    }
}




//CLIENT INFORMATION VALIDATION

//complete Name Validation
function compeleteNameValidation(fName, mName, lName, fNameTag, mNameTag, lNameTag, alertTag) {
    if (lName === "" && fName === "" && mName == "") {
        //if all input is empty
        $(`#${fNameTag}, #${mNameTag}, #${lNameTag}`).addClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">Full Name is empty!</div>')
    } else if (fName === "" && mName !== "" && lName !== "") {
        //if Fname is empty
        $(`#${fNameTag}`).addClass('input-error');
        $(`#${mNameTag}`).removeClass('input-error');
        $(`#${lNameTag}`).removeClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">First Name is empty!</div>')
        return false;
    } else if (fName !== "" && mName === "" && lName === "") {
        //if fname is the only not empty
        $(`#${fNameTag}`).removeClass('input-error');
        $(`#${mNameTag}`).addClass('input-error');
        $(`#${lNameTag}`).addClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">Middle Name and Last Name is empty!</div>')
        return false;
    } else if (mName === "" && fName !== "" && lName !== "") {
        //if mnName is empty
        $(`#${fNameTag}`).removeClass('input-error');
        $(`#${mNameTag}`).addClass('input-error');
        $(`#${lNameTag}`).removeClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">Middle Name is empty!</div>')
        return false;
    } else if (mName !== "" && fName === "" && lName === "") {
        //if mName is the only not empty
        $(`#${fNameTag}`).addClass('input-error');
        $(`#${mNameTag}`).removeClass('input-error');
        $(`#${lNameTag}`).addClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">First Name and Last Name is empty!</div>')
        return false;
    } else if (lName === "" && fName !== "" && mName !== "") {
        //if lName is the only not empty
        $(`#${fNameTag}`).removeClass('input-error');
        $(`#${mNameTag}`).removeClass('input-error');
        $(`#${lNameTag}`).addClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">Last Name is empty! </div>')
        return false;
    } else if (lName !== "" && fName === "" && mName === "") {
        //if lName is empty
        $(`#${fNameTag}`).addClass('input-error');
        $(`#${mNameTag}`).addClass('input-error');
        $(`#${lNameTag}`).removeClass('input-error');
        $(`#${alertTag}`).html('<div class="alert alert-danger" role="alert">First Name and Middle Name is empty!</div>')
        return false;
    } else {
        //all is not empty
        //clear added class if have
        $(`#${fNameTag}, #${mNameTag}, #${lNameTag}`).removeClass('input-error');
        $(`#${alertTag}`).html('')
        return true;
    }
}

//mobile number validation

function mobileNumberValidation(clientMobileNumber, mobileNumberTag, alertId) {
    //regex for mobule number ex. 09123456789
    var regex = /^(09|\+639)\d{9}$/;
    //mobile number is not empty
    if (clientMobileNumber !== "") {
        //meet the requiret number lenght of mobile number
        if (clientMobileNumber.length === 11) {
            if (clientMobileNumber.match(regex)) {
                $(`#${mobileNumberTag}`).removeClass('input-error');
                return true;
            } else {
                //not match the regex for mobile number ex 09123456789
                $(`#${mobileNumberTag}`).addClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
                return false;
            }
        } else {
            //error for not meeting the min length
            $(`#${mobileNumberTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Mobile Number!</div>');
            return false;
        }

    } else {
        //error for mobile number empty
        $(`#${mobileNumberTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Mobile Number Empty!</div>');
        return false;
    }
}

// //landline validation
// function landlineValidation(clientLandlineNumber, landLineTag, alertId) {
//     //regex for landline number ex. 09123456789
//     //mobile number is not empty
//     if (clientLandlineNumber !== "") {
//         //meet the requiret number lenght of mobile number
//         if (clientLandlineNumber.length == 7 || clientLandlineNumber.length == 8) {
//             $(`#${landLineTag}`).removeClass('input-error');
//             return true;
//             // if (clientLandlineNumber.match(regex)) {

//             // } else {
//             //     //not match the regex for mobule number ex 09123456789
//             //     $(`#${landLineTag}`).addClass('input-error');
//             //     $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
//             //     return false;
//             // }
//         } else {
//             //error for not meeting the min length
//             $(`#${landLineTag}`).addClass('input-error');
//             $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
//             return false;
//         }

//     } else {
//         //error for mobile number empty
//         $(`#${landLineTag}`).addClass('input-error');
//         $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Landline Number Empty!</div>');
//         return false;
//     }
// }

//local number validation

// function localNumberValidation(localNumber, localNumberTag, alertId) {
//     //regex for mobule number ex. 09123456789
//     //local number is not empty
//     if (localNumber !== "") {
//         //meet the requiret number lenght of mobile number
//         if (localNumber.length != 1) {
//             $(`#${localNumberTag}`).removeClass('input-error');
//             return true;
//             // if (localNumber.match(regex)) {
//             //     $(`#${localNumberTag}`).removeClass('input-error');
//             //     return true;
//             // } else {
//             //     //not match the regex for mobule number ex 09123456789
//             //     $(`#${localNumberTag}`).addClass('input-error');
//             //     $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
//             //     return false;
//             // }
//         } else {
//             //error for not meeting the min length
//             $(`#${localNumberTag}`).addClass('input-error');
//             $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Local Number!</div>');
//             return false;
//         }

//     } else {
//         //error for mobile number empty
//         $(`#${localNumberTag}`).addClass('input-error');
//         $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Local Number Empty!</div>');
//         return false;
//     }
// }


//emailValidation

function emailValidation(emailAddress, emailTag, alertId) {
    if (emailAddress !== "") {
        $(`#${emailTag}`).removeClass('input-error');
        return true;
    } else {
        $(`#${emailTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Email Address is empty!</div>');
        return false;
    }
}

//bithday validation
//display the value of age for validation of age provided
var age = 0;

function birthdayValidation(birthday, birthdayTag, alertId) {
    if (birthday !== "") {
        var today = moment();
        var userdate = moment(birthday);
        var difference = today.diff(userdate, 'years')
        if (difference < 18) {
            //error for bithday is less that 18 years old 
            $(`#${birthdayTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Should be at least 18 and above!</div>');
            return false;
        } else {
            //birthdat is above 18
            //asign to a variable the value of difference
            age = difference;
            $(`#${birthdayTag}`).removeClass('input-error');
            return true;
        }

    } else {
        //error for bithday is empty
        $(`#${birthdayTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Birthdate cannot be empty!</div>');
        return false;
    }
}

//gender validation
function genderValidation(gender, genderTag, alertId) {
    //default= no selected
    if (gender !== "default") {
        $(`#${genderTag}`).removeClass('input-error');
        return true;
    } else {
        $(`#${genderTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Gender is not selected!</div>');
        return false;
    }
}


//gender validation
function ageValidation(clientAge, clientAgeTag, alertId) {
    //client age is not empty
    if (clientAge !== "") {
        //client age is equal to the age the provide in bithdate
        if (clientAge == Math.floor(parseInt(age))) {
            $(`#${clientAgeTag}`).removeClass('input-error');
            return true;
        } else {
            //error in age is not equal to birthday
            $(`#${clientAgeTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Age is not relevant to birthdate!</div>');
            return false;
        }
    } else {
        //error in empty age
        $(`#${clientAgeTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Age is empty!</div>');
        return false;
    }
}


//civil status validation
function civilStatusValidation(civilStatus, civilStatusTag, alertId) {
    //default = no selected
    if (civilStatus !== "default") {
        $(`#${civilStatusTag}`).removeClass('input-error');
        return true;
    } else {
        $(`#${civilStatusTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Civil Status is not selected!</div>');
        return false;
    }
}


//img Validation
//this function check if the valid ids are not empty and show an alert with desination modal using alert Id
function validIdImgValidation(firstValidIdHolder, secondValidIdHolder, primartyIdTag, secondIdTag, alertId) {

    if (firstValidIdHolder.files.length !== 0 && secondValidIdHolder.files.length !== 0) {
        //both primary and secondary Id is not empty
        //show the error in img holder
        $(`#${primartyIdTag}`).removeClass('input-error');
        $(`#${secondIdTag}`).removeClass('input-error');
        return true;
    } else if (firstValidIdHolder.files.length === 0 && secondValidIdHolder.files.length !== 0) {
        //primary Id is empty
        $(`#${primartyIdTag}`).addClass('input-error');
        $(`#${secondIdTag}`).removeClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Primary Id!</div>');
        return false;
    } else if (firstValidIdHolder.files.length !== 0 && secondValidIdHolder.files.length === 0) {
        //secondary Id is empty
        $(`#${primartyIdTag}`).removeClass('input-error');
        $(`#${secondIdTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Secondary Id!</div>');
        return false;
    } else {
        //all is empty
        $(`#${primartyIdTag}`).addClass('input-error');
        $(`#${secondIdTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Ids!</div>');
        return false;
    }
}





//imgs in editting modal
//because input fille cannot be initiliaze and the only way to input a file is through user`s navigation
//link to stackoverflow explaning why
//https://stackoverflow.com/questions/1696877/how-to-set-a-value-to-a-file-input-in-html
//check if the input files is/are empty
//if imgs is/are by default img/s
//else the img is not default and pass the function
function checkIdImgIsChanged(primaryIdHolder, secondaryIdHolder, primartyIdTag, secondIdTag, primaryImg, secondaryImg, alertId) {
    var result;
    if (primaryIdHolder.files.length !== 0 && secondaryIdHolder.files.length != 0) {

        $(`#${primartyIdTag}`).removeClass('input-error');
        $(`#${secondIdTag}`).removeClass('input-error');

        result = true;

    } else {

        //check if primary Id is not empty
        if (primaryIdHolder.files.length === 0) {
            // check if the img src of primary id is in default img which is user.png
            //split first the img src link and filter it to delete empty array objects
            //compare the last file name of img src if it is equal to "user.png"

            var firstId = primaryImg.split("/").filter(primaryImg => primaryImg !== "");
            if (firstId[2] === "user.png") {
                $(`#${secondIdTag}`).removeClass('input-error');
                $(`#${primartyIdTag}`).addClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Primary Id!</div>');
                result = false;
            } else {
                $(`#${secondIdTag}`).removeClass('input-error');
                $(`#${primartyIdTag}`).removeClass('input-error');
                $(`#${alertId}`).html('');
                result = true;
            }
        } else if (secondaryIdHolder.files.length === 0) {
            // check if the img src of secondary id is in default img which is user.png
            //split first the img src link and filter it to delete empty array objects
            //compare the last file name of img src if it is equal to "user.png"
            var secondId = secondaryImg.split("/").filter(secondaryImg => secondaryImg !== "");

            if (secondId[2] === "user.png") {
                $(`#${secondIdTag}`).addClass('input-error');
                $(`#${primartyIdTag}`).removeClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Secondary Id!</div>');
                result = false;
            } else {
                $(`#${secondIdTag}`).removeClass('input-error');
                $(`#${primartyIdTag}`).removeClass('input-error');
                $(`#${alertId}`).html('');
                result = true;
            }

        } else {
            //both are not empty and no image will be edit
            $(`#${primartyIdTag}`).removeClass('input-error');
            $(`#${secondIdTag}`).removeClass('input-error');
            $(`#${alertId}`).html('');
            result = true;
        }
    }
    return result;
}




//COMPLETE ADDRESS Validation

//room/unit No/building
function RFUNAndHLBValidation(clientRFUB, clientHLB, clientRFUBTag, clientHLBTag, alertId) {
    if (clientRFUB !== "" && clientHLB !== "") {
        //both room/unit No/building and House Lot and Block is not empty
        $(`#${clientRFUBTag}`).removeClass('input-error');
        $(`#${clientHLBTag}`).removeClass('input-error');
        return true;
    } else if (clientRFUB === "" && clientHLB !== "") {
        //Lot and Block is not empty
        $(`#${clientRFUBTag}`).removeClass('input-error');
        $(`#${clientHLBTag}`).removeClass('input-error');
        return true;
    } else if (clientRFUB !== "" && clientHLB === "") {
        //room/unit No/building is not empty
        $(`#${clientRFUBTag}`).removeClass('input-error');
        $(`#${clientHLBTag}`).removeClass('input-error');
        return true;
    } else {
        // both client RFUB and client HLB is empty
        $(`#${clientRFUBTag}`).addClass('input-error');
        $(`#${clientHLBTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide either Room/Unit No & Building or House/Lot and Bloock!</div>');
        return false;
    }
}


//streeet address validation

function strtValidation(clientStreet, Tag, alertId) {
    // console.log(clientStreet !== "")
    if (clientStreet === "") {
        //client street input is empty
        $(`#${Tag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Street Address is empty!</div>');
        return false;

    } else {
        $(`#${Tag}`).removeClass('input-error');
        return true;
    }
}


//subdivision can be filled or not


//barangay address validation
function clientBrgyValidation(clientBrgyAddress, Tag, alertId) {
    if (clientBrgyAddress !== null) {
        //barangay street input is not empty
        $(`.form-control#${Tag}`).next().find('.select2-selection').removeClass('input-error');
        return true;
    } else {
        $(`.form-control#${Tag}`).next().find('.select2-selection').addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Barangay Address is empty!</div>');
        return false;
    }
}
//city address validation

function cityValidation(clientCityAddress, Tag, alertId) {
    if (clientCityAddress !== null) {
        //client city address input is not empty
        $(`.form-control#${Tag}`).next().find('.select2-selection').removeClass('input-error');
        return true;
    } else {
        $(`.form-control#${Tag}`).next().find('.select2-selection').addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">City Address is empty!</div>');
        return false;
    }
}

//company name Validation
function companyNameValidation(companyName) {
    if (companyName !== "") {
        //clienn street input is not empty
        $("#companyName").removeClass('input-error');
        return true;
    } else {
        $("#companyName").addClass('input-error');
        $("#addClientAlert").html('<div class="alert alert-danger" role="alert">Company Name is empty!</div>');
        return false;
    }
}


//Room / Floor / Unit No. & Building Name can be validated thru complete address validation

//Street, Barangay, City can be validated thru complete address validation



//FUNCTION FOR COMPLETE ADDRESS

function completeAddress(RFUB, HLB, street, subdivision, barangay, city) {
    var result = ""
    if (RFUB != null && HLB != null && street != null && subdivision != null && barangay != null && city != null) {
        //all is not empty
        result = RFUB + " " + HLB + " " + street + " " + subdivision + " " + barangay + ", " + city;
    } else if (RFUB == null && HLB != null && street != null && subdivision != null && barangay != null && city != null) {
        //RFUB is  empty
        result = HLB + " " + street + " " + $subdivision + " " + barangay + ", " + city;

    } else if (RFUB != null && HLB == null && street != null && subdivision != null && barangay != null && city != null) {
        //HLB is  empty
        result = RFUB + " " + street + " " + subdivision + " " + barangay + ", " + city;

    } else if (RFUB == null && HLB != null && street != null && subdivision == null && barangay != null && city != null) {
        //RFUB and subdivision is  empty
        result = HLB + " " + street + " " + barangay + ", " + city;

    } else if (RFUB != null && HLB == null && street != null && subdivision == null && barangay != null && city != null) {
        //HLB and subdivision is  empty
        result = RFUB + " " + street + " " + barangay + ", " + city;

    }
    return result;

}



//------------EDITING TRANSACTION-----------
$("#transaction").on("click", "#editTransactionBtn", function (evt) {
    evt.stopPropagation();
    var data = table.row($(this).parents("tr")).data();
    var transactionId = data[0];

    //edit Transaction Information
    editTransaction(transactionId);
});



function ePropertyNameBehavior(value) {
    //get the value of the propertyname dropdown and get its full information to fill some of details of the property
    propertyIdSelected = value;
    Swal.fire({
        text: "Please Wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });

    //ajax call for the property information

    $.ajax({
        url: "includes/getpropertyinformation.inc.php",
        data: {
            "propertyId": propertyIdSelected
        },
        type: "POST",
        dataType: "json",
        success: function (data) {

            //insert the value of the property into input texts and disable
            var propertyType = data[0].propertyType;
            var unitNo = data[0].unitNo;
            var propertyPrice = data[0].propertyPrice;
            var propertyLocation = completeAddress(data[0].RoomFloorUnitNoBuilding, data[0].HouseLotBlockNo, data[0].street, data[0].subdivision, data[0].barangay, data[0].city);
            var propertyOffertType = data[0].propertyOffertType;
            var propertyApprovalStatus = data[0].propertyApprovalStatus;

            $("#ePropertyType").val(propertyType);
            $('#ePropertyType').attr('readonly', true);

            $("#eUnitNo").val(unitNo);
            $('#eUnitNo').attr('readonly', true);

            $("#ePropertyTcp").val(numeral(propertyPrice).format('0,0'));
            $('#ePropertyTcp').attr('readonly', true);

            $("#ePropertyAddress").val(propertyLocation);
            $('#ePropertyAddress').attr('readonly', true);


            $("#ePropertyOfferType").val(propertyOffertType);
            $('#ePropertyOfferType').attr('readonly', true);

            $("#eStatus").val(propertyApprovalStatus);


            //IF THE PROPERTY OFFER TYPE IS PRESELLING DISABLE ALL BELOW RECEIVABLE

            if (propertyOffertType == "Presell") {
                $("#eAgentCommission").attr('disabled', true);
                $("#eARCommission").attr('disabled', true);
                $("#eBuyersCommssion").attr('disabled', true);
                $("#eFinalReceivable").attr('disabled', true);
                $("#eReceivable").attr('disabled', true);



                //addclass to hide the input fields
                $("#eReceivableHolder").addClass("hidden");
                $("#eAgentCommissionHolder").addClass("hidden");
                $("#eARCommissionHolder").addClass("hidden");
                $("#eBuyersCommissionHolder").addClass("hidden");
                $("#eFinalTcpHolder").addClass("hidden");




                $("#eDateOf").removeClass("hidden");
            } else {
                $("#eAgentCommission").attr('disabled', false);
                $("#eArCommission").attr('disabled', false);
                $("#eBuyersCommssion").attr('disabled', false);
                $("#eFinalReceivable").attr('disabled', false);
                $("#eReceivable").attr('disabled', false);

                //remove class that hides the input fields
                $("#eReceivableHolder").removeClass("hidden");
                $("#eAgentCommissionHolder").removeClass("hidden");
                $("#eARCommissionHolder").removeClass("hidden");
                $("#eBuyersCommissionHolder").removeClass("hidden");
                $("#eFinalTcpHolder").removeClass("hidden");



                $("#eDateOf").addClass("hidden");
            }

            Swal.close();


        },
        error: function (error) {
            Swal.close();
            //property is deleted and this transaction is invalid
            console.log(error)
            Swal.fire({
                icon: "error",
                title: error.responseText,
                allowOutsideClick: false,
                confirmButtonColor: "#3CB371",
                text: "This transaction is invalid because the Property involved is deleted. Contact Admin. Close ''Ok'' button to refresh the page."
            }).then(result => {
                if (result.value) {
                    location.reload();
                }
            })
        },
    });
}

//------------EDITING TRANSACTION ENDS HERE-----------



//---------EDITTING TRANSACTION VALIDATION-----------
function eCheckClients(client1Holder, client2Holder) {
    var result;
    if (client1Holder.children().length !== 0 && client2Holder.children().length !== 0) {
        //if both have children
        $(`#eClientHolders`).removeClass('input-error');
        result = true;
    } else {
        //if there are at least 1 client added
        if (client1Holder.children().length !== 0 && client2Holder.children().length === 0) {
            $(`#eClientHolders`).removeClass('input-error');
            result = true;
            //1st have client 2nd dont have client
        } else if (client1Holder.children().length === 0 && client1Holder.children().length !== 0) {
            $(`#eClientHolders`).removeClass('input-error');
            result = true;
        } else {
            //there is not client added , add error
            $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Please add a Client!</div>');
            $(`#eClientHolders`).addClass('input-error');
            result = false;
        }
    }
    return result;
}


//preventing numbers to names 
function eAllowOnlyLetters(evt) {
    var inputValue = evt.charCode;
    if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) {
        evt.preventDefault();
    }
}

//for limiting to only number in input text
function eIsNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    return !(charCode > 31 && (charCode < 48 || charCode > 57));
}





function eCalculateReceivable() {
    var finalTcp = numeral($("#eFinalTcp").val()).value();
    var commission = numeral($("#eCommission").val()).value();

    //calculate the amount of receivable
    if (finalTcp !== "" && commission !== "") {
        $("#eReceivable").val(numeral(parseInt(finalTcp) * (commission / 100)).format('0,0'));
        $('#eReceivable').attr('readonly', true);
    } else {
        $("#eReceivable").val('');
        $('#eReceivable').attr('readonly', true);
    }


}




function eCalculateFinalReceivable() {
    var receivable = numeral($("#eReceivable").val()).value();
    var agentCommission = numeral($("#eAgentCommission").val()).value();

    //calculate the amount of receivable
    if (receivable !== "" && agentCommission !== "") {
        $("#eFinalReceivable").val(numeral(parseInt(receivable) * parseFloat(agentCommission / 100)).format('0,0'));
        $('#eFinalReceivable').attr('readonly', true);
    } else {
        $("#eFinalReceivable").val('');
        $('#eFinalReceivable').attr('readonly', true);
    }
}



//validating property name 
function eTermsValidation(terms) {
    if (terms !== "" && terms !== "default") {
        //if there is property selected
        $(`#eTerms`).removeClass('input-error');
        return true;
    } else {
        //there is no property name selected
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Terms is empty!</div>');
        $(`#eTerms`).addClass('input-error');
        return false;
    }
}


//validating property name 
function ePropertyNameValidation(propertyName) {
    if (propertyName !== "") {
        //if there is property selected
        $(`.form-control#eAllPropertyHolder`).next().find('.select2-selection').removeClass('input-error');
        return true;
    } else {
        //there is no property name selected
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Property Name is empty!</div>');
        $(`.form-control#eAllPropertyHolder`).next().find('.select2-selection').addClass('input-error');
        return false;
    }
}

//check if date of transaction is not empty
function eTransactionDateValidation(date) {
    if (date !== "" && date !== null) {
        //transaction date is not empty
        $(`#eTransactionDate`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eTransactionDate`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Transaction Date is empty!</div>');
        return false;
    }
}


//check if finalTCP is not empty
function eFinalTCPValidation(tcp) {
    if (tcp !== "" && tcp != 0) {
        //fincalTCP is not empty
        $(`#eFinalTcp`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eFinalTcp`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Final TCP is empty!</div>');
        return false;
    }
}

//check if commission is not empty
function eCommissionValidation(commision) {
    if (commision !== "" && commision !== 0) {
        //commission is not empty
        $(`#eCommission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eCommission`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Commission is empty!</div>');
        return false;
    }
}


//check if agent commission is not empty
function eAgentsCommissionValidation(agentCommission) {
    if (agentCommission !== "" && agentCommission !== 0) {
        //agentCommission is not empty
        $(`#eAgentCommission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eAgentCommission`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Agent`s Commission is empty!</div>');
        return false;
    }
}

//check if arVerizon Commission is not empty
function eARCommissionValidation(ARCommission) {
    if (ARCommission !== "" && ARCommission !== 0) {
        //AR Verizon Commission is not empty
        $(`#eArCommission`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eArCommission`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">AR Verizon`s Commission is empty!</div>');
        return false;
    }
}


//check if buyers Commission is not empty
function eBuyersCommissionValidation(buyersCommission) {
    if (buyersCommission !== "" && buyersCommission !== 0) {
        //AR Verizon Commission is not empty
        $(`#eBuyersCommssion`).removeClass('input-error');
        return true;
    } else {
        //is empty
        $(`#eBuyersCommssion`).addClass('input-error');
        $("#eTransactionAlert").html('<div class="alert alert-danger" role="alert">Buyers`s Commission is empty!</div>');
        return false;
    }
}