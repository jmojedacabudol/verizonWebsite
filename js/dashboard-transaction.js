//propertySelected stored here
var propertyIdSelected;
var table;
$(document).ready(function () {
    //<----------------PROPERTIES------------------->
    $('#transaction tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    table = $('#transaction').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Property Listing",
            titleAttr: 'Export as PDF',
            orientation: 'landscape',
            pageSize: 'LEGAL',
            exportOptions: {
                columns: ':visible'
            },
            text: '<i class="fas fa-file-pdf"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },
            customize: function (doc) {
                doc.pageMargins = [50, 50, 10, 10];
                doc.defaultStyle.fontSize = 7;
                doc.styles.tableHeader.fontSize = 10;
                doc.styles.title.fontSize = 15;
                // Remove spaces around page title
                doc.content[0].text = doc.content[0].text.trim();
                // Create a footer
                doc['footer'] = (function (page, pages) {
                    return {
                        columns: [
                            'Copyright © Verizon 2020',
                            {
                                // This is the right column
                                alignment: 'right',
                                text: ['page ', {
                                    text: page.toString()
                                }, ' of ', {
                                    text: pages.toString()
                                }]
                            }
                        ],
                        margin: [10, 0]
                    }
                });
                // Styling the table: create style object
                var objLayout = {};
                // Horizontal line thickness
                objLayout['hLineWidth'] = function (i) {
                    return .5;
                };
                // Vertikal line thickness
                objLayout['vLineWidth'] = function (i) {
                    return .5;
                };
                // Horizontal line color
                objLayout['hLineColor'] = function (i) {
                    return '#aaa';
                };
                // Vertical line color
                objLayout['vLineColor'] = function (i) {
                    return '#aaa';
                };
                // Left padding of the cell
                objLayout['paddingLeft'] = function (i) {
                    return 4;
                };
                // Right padding of the cell
                objLayout['paddingRight'] = function (i) {
                    return 4;
                };
                // Inject the object in the document
                doc.content[1].layout = objLayout;
            }


        }, {
            extend: 'excelHtml5',
            className: 'btn btn-primary',
            title: "Property Listing",
            titleAttr: 'Export as XLSX',
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            title: "Property Listing",
            titleAttr: 'Export as CSV',
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {

            extend: 'print',
            className: 'btn btn-primary ',
            title: "Property Listing",
            titleAttr: 'PRINT',
            text: '<i class="fas fa-print"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },
            customize: function (win) {
                $(win.document.body)
                    .css('font-size', '10pt')
                    .prepend(
                        '<img src="https://linkpicture.com/q/logo_295.png" style="position:absolute; margin: auto; top: 0; left: 0; bottom: 0; right: 0;" />'
                    );

                $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }

        }, {
            className: 'btn btn-primary ',
            text: "Add Transaction",
            orientation: 'portrait',
            action: function () {


                Swal.fire({
                    text: "Please wait....",
                    allowOutsideClick: false,
                    showConfirmButton: false,

                    willOpen: () => {
                        Swal.showLoading();
                    },
                });
                $("#addTransaction").modal('show');

                //use modal function to load data into the modal before showing
                $("#addTransaction").on('shown.bs.modal', function () {

                    $("#allPropertyHolder").select2({
                        placeholder: "Select a Property",
                        allowClear: true,
                        ajax: {
                            url: "includes/selecteditproperty.inc.php",
                            type: "post",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    searchTerm: params.term // search term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response

                                };
                            },
                            cache: true
                        }
                    });
                    $(this).off('shown.bs.modal');

                    Swal.close();
                });

                //handle events on closing the modal
                $('#addTransaction').on('hidden.bs.modal', function () {
                    //reset the form
                    $('#addTransactionForm').find("input[class=important]").attr('readonly', true);
                    $('#addTransactionForm').find("input").val("");
                    $('#addTransactionForm').find("select").val("default");
                    $("#buyersHolder").select2({
                        placeholder: "Select a Buyer",
                        allowClear: true,
                    });
                });
            }
        }],
        initComplete: function () {
            // Apply the search
            this.api().columns().every(function () {
                var that = this;

                $('input', this.footer()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        }
    });


    //geting the mobile number of the buyer

    $("#buyersHolder").change(function () {
        var buyersNumber = this.value;
        $("#clientMobileNumber").val(buyersNumber);
        $('#clientMobileNumber').attr('readonly', true);
    });



});

function propertyNameBehavior(value) {
    //get the value of the propertyname dropdown and get its full information to fill some of details of the property
    propertyIdSelected = value;

    Swal.fire({
        text: "Please wait....",
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
            var subcategory = data[0].subcategory;

            $("#propertyType").val(propertyType);
            $('#propertyType').attr('readonly', true);

            $("#subcategory").val(subcategory);
            $('#subcategory').attr('readonly', true);

            $("#unitNo").val(unitNo);
            $('#unitNo').attr('readonly', true);

            $("#propertyTcp").val(numeral(propertyPrice).format('0,0'));
            $('#propertyTcp').attr('readonly', true);

            $("#propertyAddress").val(propertyLocation);
            $('#propertyAddress').attr('readonly', true);


            $("#offertType").val(propertyOffertType);
            $('#offertType').attr('readonly', true);

            $("#status").val(propertyApprovalStatus);


            //IF THE PROPERTY OFFER TYPE IS PRESELLING DISABLE ALL BELOW RECEIVABLE

            if (propertyOffertType == "Presell") {
                $("#agentCommission").attr('disabled', true);
                $("#arCommission").attr('disabled', true);
                $("#buyersCommssion").attr('disabled', true);
                $("#finalReceivable").attr('disabled', true);
                $("#receivable").attr('disabled', true);



                //addclass to hide the input fields
                $("#receivableHolder").addClass("hidden");
                $("#agentCommissionHolder").addClass("hidden");
                $("#ARCommissionHolder").addClass("hidden");
                $("#buyersCommission").addClass("hidden");
                $("#FinalTcpHolder").addClass("hidden");


                $("#dateOf").removeClass("hidden");
            } else {
                $("#agentCommission").attr('disabled', false);
                $("#arCommission").attr('disabled', false);
                $("#buyersCommssion").attr('disabled', false);
                $("#finalReceivable").attr('disabled', false);
                $("#receivable").attr('disabled', false);

                //remove class that hides the input fields
                $("#receivableHolder").removeClass("hidden");
                $("#agentCommissionHolder").removeClass("hidden");
                $("#ARCommissionHolder").removeClass("hidden");
                $("#buyersCommission").removeClass("hidden");
                $("#FinalTcpHolder").removeClass("hidden");



                $("#dateOf").addClass("hidden");
            }

            Swal.close();
        },
        error: function (error) {
            Swal.close();
            console.log(error)
        },
    });
}





//show modal for adding buyers information
function addClientInfo() {
    $('#addClient').modal('show')
}



function calculateReceivable() {
    var finalTcp = numeral($("#finalTcp").val()).value();
    var commission = numeral($("#commission").val()).value();

    //calculate the amount of receivable
    if (finalTcp !== "" && commission !== "") {
        $("#receivable").val(numeral(parseInt(finalTcp) * (commission / 100)).format('0,0'));
        $('#receivable').attr('readonly', true);
    } else {
        $("#receivable").val('');
        $('#receivable').attr('readonly', true);
    }


}




function calculateFinalReceivable() {
    var receivable = numeral($("#receivable").val()).value();
    var agentCommission = numeral($("#agentCommission").val()).value();

    //calculate the amount of receivable
    if (receivable !== "" && agentCommission !== "") {
        $("#finalReceivable").val(numeral(parseInt(receivable) * parseFloat(agentCommission / 100)).format('0,0'));
        $('#finalReceivable').attr('readonly', true);
    } else {
        $("#finalReceivable").val('');
        $('#finalReceivable').attr('readonly', true);
    }
}



//ADDING CLIENT INFORMATION

//for selecting 1st valid Imgs
$("#firstValidId").click(function () {
    $("#firstValidIdHolder").click();
});

$("#firstValidIdHolder").change(function () {
    previewImage(this, "firstValidId");

});


//for selecting 2nd valid Imgs
$("#secondValidId").click(function () {
    $("#secondValidIdHolder").click();
});

$("#secondValidIdHolder").change(function () {
    previewImage(this, "secondValidId");

});


//EDITTING CLIENT INFORMATION

//for selecting 1st valid Imgs
$("#eFirstValidId").click(function () {
    $("#eFirstValidIdHolder").click();
});

$("#eFirstValidIdHolder").change(function () {
    previewImage(this, "eFirstValidId");

});


//for selecting 2nd valid Imgs
$("#eSecondValidId").click(function () {
    $("#eSecondValidIdHolder").click();
});

$("#eSecondValidIdHolder").change(function () {
    previewImage(this, "eSecondValidId");

});

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



//brgy,city SELECT2 dropdown
$("#companyBrgyAddress,#clientBrgyAddress").select2({
    placeholder: "Select a Barangay",
    allowClear: true,
    ajax: {
        url: "includes/selectbrgy.inc.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
    }
});


$("#companyCityAddress,#clientCityAddress").select2({
    placeholder: "Select a City",
    allowClear: true,
    ajax: {
        url: "includes/selectcity.inc.php",
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
    }
});



//use all validation to validate all inputs in form
// var arrayOfClients = [];
var clientObj = [];
$("#addClientForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    //check the length of Clients array of Objects
    // var clientCount = arrayOfClients.length;
    var fName = formData.get("fName");
    var mName = formData.get("mName");
    var lName = formData.get("lName");
    var clientMobileNumber = formData.get("clientMobileNumber");
    var clientLandlineNumber = formData.get("clientLandlineNumber");
    var emailAddress = formData.get("emailAddress");
    var birthday = formData.get("birthday");
    var gender = formData.get("gender");
    var clientAge = formData.get("clientAge");
    var civilStatus = formData.get("civilStatus");
    //select imgs using ids for validating
    var primaryId = document.querySelector("#firstValidIdHolder");
    var secondId = document.querySelector("#secondValidIdHolder");

    var clientRFUB = formData.get("clientRFUB");
    var clientHLB = formData.get("clientHLB");
    var clientStreet = formData.get("clientStreet");
    //subdivision can be empty
    var subdivision = formData.get("subdivision");
    var clientBrgyAddress = formData.get("clientBrgyAddress");
    var clientCityAddress = formData.get("clientCityAddress");
    var companyName = formData.get("companyName");
    var companyInitalAddress = formData.get("companyInitalAddress");
    var companyStreet = formData.get("companyStreet");
    var companyBrgyAddress = formData.get("companyBrgyAddress");
    var companyCityAddress = formData.get("companyCityAddress");

    var clientLocalNumber = formData.get("clientLocalLandlineNumber");

    //append addClientBtn
    formData.append("addClientBtn", "btnClientSubmit");

    // for (var value of formData.keys()) {
    //     console.log(value);
    // }

    if (compeleteNameValidation(fName, mName, lName, 'fName', 'mName', 'lName', 'addClientAlert')) {
        if (mobileNumberValidation(clientMobileNumber, 'clientMobileNumber', 'addClientAlert')) {
            if (localNumberValidation(clientLocalNumber, 'clientLocalLandlineNumber', 'addClientAlert')) {
                if (landlineValidation(clientLandlineNumber, 'clientLandlineNumber', 'addClientAlert')) {
                    if (emailValidation(emailAddress, 'emailAddress', 'addClientAlert')) {
                        if (birthdayValidation(birthday, 'birthday', 'addClientAlert')) {
                            if (genderValidation(gender, 'gender', 'addClientAlert')) {
                                if (ageValidation(clientAge, 'clientAge', 'addClientAlert')) {
                                    if (civilStatusValidation(civilStatus, 'civilStatus', 'addClientAlert')) {
                                        if (validIdImgValidation(primaryId, secondId, 'firstValidId', 'secondValidId', 'addClientAlert')) {
                                            if (roomUnitNoAndHouseLotValidation(clientRFUB, clientHLB, 'clientRFUB', 'clientHLB', 'addClientAlert')) {
                                                if (streetValidation(clientStreet, "clientStreet", 'addClientAlert')) {
                                                    //subdivision can be empty
                                                    if (clientBrgyValidation(clientBrgyAddress, "clientBrgyAddress", 'addClientAlert')) {
                                                        if (clientCityValidation(clientCityAddress, "clientCityAddress", 'addClientAlert')) {
                                                            if (companyNameValidation(companyName, 'companyName', 'addClientAlert')) {
                                                                if (roomUnitNoAndHouseLotValidation(companyInitalAddress, 'companyInitalAddress', 'addClientAlert')) {
                                                                    if (streetValidation(companyStreet, 'companyStreet', 'addClientAlert')) {
                                                                        if (clientBrgyValidation(companyBrgyAddress, 'companyBrgyAddress', 'addClientAlert')) {
                                                                            if (clientCityValidation(companyCityAddress, 'companyCityAddress', 'addClientAlert')) {
                                                                                Swal.fire({
                                                                                    icon: "warning",
                                                                                    title: "Are you sure about all Client details?",
                                                                                    text: "Kindly, double check information before submitting",
                                                                                    showCancelButton: true,
                                                                                    cancelButtonText: "Close",
                                                                                    confirmButtonText: "Submit",
                                                                                    confirmButtonColor: "#3CB371",
                                                                                    cancelButtonColor: "#70945A"
                                                                                }).then(result => {
                                                                                    if (result.value) {

                                                                                        Swal.fire({
                                                                                            text: "Please wait....",
                                                                                            allowOutsideClick: false,
                                                                                            showConfirmButton: false,

                                                                                            willOpen: () => {
                                                                                                Swal.showLoading();
                                                                                            },
                                                                                        });

                                                                                        //insert the client to database
                                                                                        $.ajax({
                                                                                            url: "includes/insertclients.inc.php",
                                                                                            type: "POST",
                                                                                            processData: false,
                                                                                            contentType: false,
                                                                                            data: formData,
                                                                                            success: function (clientId) {
                                                                                                Swal.close();
                                                                                                //data can be zero if there is no insertted client
                                                                                                if (typeof clientId != 0) {
                                                                                                    //add the client Id to client object variable
                                                                                                    clientObj.push({
                                                                                                        "client": clientId
                                                                                                    });
                                                                                                    //create ang Img element with tool tip of the client Name 

                                                                                                    //create an element img 
                                                                                                    var clientImg = document.createElement("img");
                                                                                                    clientImg.src = `assets/img/user.png`;
                                                                                                    clientImg.style.height = "50px";
                                                                                                    clientImg.style.width = "50px";
                                                                                                    clientImg.style.marginLeft = "15px";
                                                                                                    clientImg.id = clientId;
                                                                                                    clientImg.style.cursor = "pointer";
                                                                                                    clientImg.setAttribute('data-toggle', 'tooltip');
                                                                                                    clientImg.setAttribute('data-placement', 'top');
                                                                                                    clientImg.setAttribute('title', `${fName + " " + mName + " " + lName}`);

                                                                                                    var holder1 = $("#client0");
                                                                                                    var holder2 = $("#client1");

                                                                                                    if (holder1.children().length === 0) {
                                                                                                        //create onclick function with id of client object and where it is stored
                                                                                                        clientImg.setAttribute("onclick", `selectedClient(this.id,'client0')`);
                                                                                                        holder1.append(clientImg);

                                                                                                    } else {
                                                                                                        //create onclick function with id of client object and where it is stored
                                                                                                        clientImg.setAttribute("onclick", `selectedClient(this.id,'client1')`);
                                                                                                        holder2.append(clientImg);

                                                                                                    }

                                                                                                    $("#addClient").modal('hide');
                                                                                                } else {
                                                                                                    //elses display the data to console log
                                                                                                    console.log(data)
                                                                                                }

                                                                                            },
                                                                                            error: function (data) {
                                                                                                Swal.close();
                                                                                                console.log(data);
                                                                                            },
                                                                                        });
                                                                                    }
                                                                                });
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
    }
    return false;


});

//reset client information after modal hide

$('#addClient').on('hidden.bs.modal', function () {

    //reset the form
    $('#addClientForm').find("input").val("");
    $('#addClientForm').find("select").val("default");

    //reset the imgs

    $("#firstValidId,#secondValidId").attr("src", "assets/img/user.png");

    //brgy,city SELECT2 dropdown
    $("#companyBrgyAddress,#clientBrgyAddress").select2({
        placeholder: "Select a Barangay",
        allowClear: true,
        ajax: {
            url: "includes/selectbrgy.inc.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });


    $("#companyCityAddress,#clientCityAddress").select2({
        placeholder: "Select a City",
        allowClear: true,
        ajax: {
            url: "includes/selectcity.inc.php",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function (response) {

                return {
                    results: response
                };
            },
            cache: true
        }
    });

    var holder1 = $("#client0");
    var holder2 = $("#client1");
    //hide "add client" button if the there are 2 clients
    if (holder1.children().length !== 0 && holder2.children().length !== 0) {
        $("#addClientBtn").addClass("hidden");
        $("#addClientNote").removeClass("hidden");
    } else {
        //else show the button and note
        $("#addClientBtn").removeClass("hidden");
        $("#addClientNote").removeClass("hidden");
    }
    $(this).off('hidden.bs.modal');
});




function selectedClient(id, item) {

    //create a localStorage for selected client
    localStorage.setItem('selectedClient', id);

    Swal.fire({
        icon: "warning",
        title: `What do you want to do with this Client?`,
        text: "You can click outside this box to disregard this popup.",
        showDenyButton: true,
        denyButtonColor: "#ff0000 ",
        showCancelButton: true,
        confirmButtonText: `Edit`,
        confirmButtonColor: "#3CB371",
        denyButtonText: `Delete`,


    }).then(result => {
        if (result.isConfirmed) {
            //edit the client information
            updateClient(id);
        } else if (result.isDenied) {
            Swal.fire({
                icon: "warning",
                title: "Do you want to delete this Client?",
                text: "You can click outside this box to disregard this popup.",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonColor: "#ff0000 ",
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

                    //ajax call to delete client
                    $.ajax({
                        url: "includes/deleteclientinformation.inc.php",
                        type: "POST",
                        data: {
                            "clientId": id
                        },
                        success: function (data) {
                            Swal.close();
                            if (data == "Client information Deleted") {
                                //delete the client Id to client object variable
                                clientObj = clientObj.filter(function (returnableObjects) {
                                    return returnableObjects.client !== id;
                                });
                                //delete the img tag using its parent 
                                //empty()  method removes the child elements of the selected element(s).
                                $(`#${item}`).empty("img");

                                var holder1 = $("#client0");
                                var holder2 = $("#client1");
                                //hide "add client" button if the there are 2 clients
                                if (holder1.children().length !== 0 && holder2.children().length !== 0) {
                                    $("#addClientBtn").addClass("hidden");
                                    $("#addClientNote").removeClass("hidden");
                                } else if (holder1.children().length !== 0 || holder2.children().length !== 0) {
                                    //else show the button hide the note
                                    $("#addClientBtn").removeClass("hidden");
                                    $("#addClientNote").addClass("hidden");
                                } else {
                                    //else show the button and note
                                    $("#addClientBtn").removeClass("hidden");
                                    $("#addClientNote").remove("hidden");
                                }
                            } else {
                                //display the error code
                                console.log(data)
                            }
                        },
                        error: function (data) {
                            Swal.close();
                            console.log(data);
                        },
                    });







                }
            });
        }
    });
}


//edit the client information
function updateClient(clientIdToEdit) {

    Swal.fire({
        text: "Please Wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });
    //ajax call
    $.ajax({
        url: "includes/clientloadedit.inc.php",
        data: {
            "clientId": clientIdToEdit
        },
        type: "POST",
        dataType: "json",
        success: function (clientInformation) {
            if (clientInformation === "No Client Found!") {
                Swal.close();
                console.log("No Client!");
            } else {
                Swal.close();

                $("#editClient").modal('show');
                //use modal function to load data into the modal before showing
                $("#editClient").on('shown.bs.modal', function () {
                    //load the information of the client to inputs in edit modal
                    $("#eFName").val(clientInformation[0].firstName);
                    $("#eMName").val(clientInformation[0].middleName);
                    $("#eLName").val(clientInformation[0].lastName);

                    $("#eClientMobileNumber").val(clientInformation[0].mobileNumber);
                    $("#eClientLocalLandlineNumber").val(clientInformation[0].areaCode)
                    $("#eClientLandlineNumber").val(clientInformation[0].landlineNumber);
                    $("#eEmailAddress").val(clientInformation[0].email);
                    $("#eBirthday").val(clientInformation[0].birthday);
                    $("#eGender").val(clientInformation[0].gender);
                    $("#eClientAge").val(clientInformation[0].age);
                    $("#eCivilStatus").val(clientInformation[0].civilStatus);

                    $("#eFirstValidId").attr('src', "uploads/" + clientInformation[0].primaryId);
                    $("#eSecondValidId").attr('src', "uploads/" + clientInformation[0].secondaryId);


                    $("#eClientRFUB").val(clientInformation[0].RoomFloorUnitNoBuilding);
                    $("#eClientHLB").val(clientInformation[0].HouseLotBlockNo);
                    $("#eClientStreet").val(clientInformation[0].street);
                    $("#eSubdivision").val(clientInformation[0].subdivision);



                    //load the initial value of brgy address and load select2 API afterwards 
                    var selectedClientBrgyAddress = document.createElement("OPTION");
                    var selectedClientBrgyTextAddress = document.createTextNode(clientInformation[0].barangay);
                    selectedClientBrgyAddress.setAttribute("value", clientInformation[0].barangay);
                    selectedClientBrgyAddress.appendChild(selectedClientBrgyTextAddress);
                    $("#eClientBrgyAddress").append(selectedClientBrgyAddress);


                    var selectedCompanyBrgyAddress = document.createElement("OPTION");
                    var selectedCompanyBrgyTextAddress = document.createTextNode(clientInformation[0].companyBarangay);
                    selectedCompanyBrgyAddress.setAttribute("value", clientInformation[0].companyBarangay);
                    selectedCompanyBrgyAddress.appendChild(selectedCompanyBrgyTextAddress);
                    $("#eCompanyBrgyAddress").append(selectedCompanyBrgyAddress);



                    //load the initial value of City address and load select2 API afterwards 
                    var selectedClientCityAddress = document.createElement("OPTION");
                    var selectedClientCityTextAddress = document.createTextNode(clientInformation[0].city);
                    selectedClientCityAddress.setAttribute("value", clientInformation[0].city);
                    selectedClientCityAddress.appendChild(selectedClientCityTextAddress);
                    $("#eClientCityAddress").append(selectedClientCityAddress);

                    var selectedCompanyCityAddress = document.createElement("OPTION");
                    var selectedCompanyCityTextAddress = document.createTextNode(clientInformation[0].companyCity);
                    selectedCompanyCityAddress.setAttribute("value", clientInformation[0].companyCity);
                    selectedCompanyCityAddress.appendChild(selectedCompanyCityTextAddress);
                    $("#eCompanyCityAddress").append(selectedCompanyCityAddress);

                    //LOAD SELECT2
                    $("#eClientCityAddress,#eCompanyCityAddress").select2({
                        placeholder: "Select a City",
                        allowClear: true,
                        ajax: {
                            url: "includes/selectcity.inc.php",
                            type: "post",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    searchTerm: params.term // search term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response

                                };
                            },
                            cache: true
                        }
                    });


                    $("#eClientBrgyAddress,#eCompanyBrgyAddress").select2({
                        placeholder: "Select a Barangay",
                        allowClear: true,
                        ajax: {
                            url: "includes/selectbrgy.inc.php",
                            type: "post",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    searchTerm: params.term // search term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response

                                };
                            },
                            cache: true
                        }
                    });

                    $("#eCompanyName").val(clientInformation[0].companyName);
                    $("#eCompanyInitalAddress").val(clientInformation[0].companyRoomFloorUnitNoBuilding);
                    $("#eCompanyStreet").val(clientInformation[0].companyStreet)

                    $(this).off('shown.bs.modal');
                });
            }
        },
        error: function (data) {
            Swal.close();
            console.log(data.responseText);
        }
    });

}

//submit button for editting the client information
$("#editClientForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    //get the client Id from the modal
    var fName = formData.get("eFName");
    var mName = formData.get("eMName");
    var lName = formData.get("eLName");
    var clientMobileNumber = formData.get("eClientMobileNumber");
    var clientLandlineNumber = formData.get("eClientLandlineNumber");
    var clientLocalNumber = formData.get("eClientLocalLandlineNumber");
    var emailAddress = formData.get("eEmailAddress");
    var birthday = formData.get("eBirthday");
    var gender = formData.get("eGender");
    var clientAge = formData.get("eClientAge");
    var civilStatus = formData.get("eCivilStatus");
    //select imgs using ids for validating
    var primaryId = document.querySelector("#eFirstValidIdHolder");
    var secondId = document.querySelector("#eSecondValidIdHolder");

    //imgs
    var eFirstValidId = $("#eFirstValidId").attr('src');
    var eSecondValidId = $("#eSecondValidId").attr('src');

    var clientRFUB = formData.get("eClientRFUB");
    var clientHLB = formData.get("eClientHLB");
    var clientStreet = formData.get("eClientStreet");
    //subdivision can be empty
    var subdivision = formData.get("eSubdivision");
    var clientBrgyAddress = formData.get("eClientBrgyAddress");
    var clientCityAddress = formData.get("eClientCityAddress");
    var companyName = formData.get("eCompanyName");
    var companyInitalAddress = formData.get("eCompanyInitalAddress");
    var companyStreet = formData.get("eCompanyStreet");
    var companyBrgyAddress = formData.get("eCompanyBrgyAddress");
    var companyCityAddress = formData.get("eCompanyCityAddress");


    //append the client id that will be editted
    formData.append("eClientId", localStorage.getItem('selectedClient'));


    // for (var value of formData.keys()) {
    //     console.log(value);
    // }

    if (compeleteNameValidation(fName, mName, lName, 'eFName', 'eMName', 'eLName', 'editClientAlert')) {
        if (mobileNumberValidation(clientMobileNumber, 'eClientMobileNumber', 'editClientAlert')) {
            if (landlineValidation(clientLandlineNumber, 'eClientLandlineNumber', 'editClientAlert')) {
                if (localNumberValidation(clientLocalNumber, 'eClientLocalLandlineNumber', 'editClientAlert')) {
                    if (emailValidation(emailAddress, 'eEmailAddress', 'editClientAlert')) {
                        if (birthdayValidation(birthday, 'eBirthday', 'editClientAlert')) {
                            if (genderValidation(gender, 'eGender', 'editClientAlert')) {
                                if (ageValidation(clientAge, 'eClientAge', 'editClientAlert')) {
                                    if (civilStatusValidation(civilStatus, 'eCivilStatus', 'editClientAlert')) {
                                        if (checkIdImgIsChanged(primaryId, secondId, 'eFirstValidId', 'eSecondValidId', eFirstValidId, eSecondValidId, 'editClientAlert')) {
                                            if (roomUnitNoAndHouseLotValidation(clientRFUB, clientHLB, 'eClientRFUB', 'eClientHLB', 'editClientAlert')) {
                                                if (streetValidation(clientStreet, "eClientStreet", 'editClientAlert')) {
                                                    //subdivision can be empty
                                                    if (clientBrgyValidation(clientBrgyAddress, "eClientBrgyAddress", 'editClientAlert')) {
                                                        if (clientCityValidation(clientCityAddress, "eClientCityAddress", 'editClientAlert')) {
                                                            if (companyNameValidation(companyName, 'eCompanyName', 'editClientAlert')) {
                                                                if (roomUnitNoAndHouseLotValidation(companyInitalAddress, 'eCompanyInitalAddress', 'editClientAlert')) {
                                                                    if (streetValidation(companyStreet, 'eCompanyStreet', 'editClientAlert')) {
                                                                        if (clientBrgyValidation(companyBrgyAddress, 'eCompanyBrgyAddress', 'editClientAlert')) {
                                                                            if (clientCityValidation(companyCityAddress, 'eCompanyCityAddress', 'editClientAlert')) {
                                                                                Swal.fire({
                                                                                    icon: "warning",
                                                                                    title: "Are you sure about all Client details?",
                                                                                    text: "Please double check information before submitting",
                                                                                    showCancelButton: true,
                                                                                    cancelButtonText: "Close",
                                                                                    confirmButtonText: "Submit",
                                                                                    confirmButtonColor: "#3CB371",
                                                                                    cancelButtonColor: "#70945A"
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
                                                                                        //insert the property to database
                                                                                        $.ajax({
                                                                                            url: "includes/insertclientedit.inc.php",
                                                                                            data: formData,
                                                                                            processData: false,
                                                                                            contentType: false,
                                                                                            type: "POST",
                                                                                            success: function (data) {
                                                                                                Swal.close();
                                                                                                console.log(data)
                                                                                                if (data === "Success, Client Updated") {
                                                                                                    Swal.fire({
                                                                                                        icon: "success",
                                                                                                        title: "Client Uploaded",
                                                                                                        text: data,
                                                                                                        showConfirmButton: true,
                                                                                                        allowOutsideClick: false,
                                                                                                    }).then(function (result) {
                                                                                                        if (result.value) {
                                                                                                            $("#editClient").modal('hide');
                                                                                                        }
                                                                                                    });
                                                                                                } else if (data === "No edit/s Found") {
                                                                                                    Swal.fire({
                                                                                                        icon: "warning",
                                                                                                        title: data,
                                                                                                        text: "No detected change/s in Client`s Information",
                                                                                                        showConfirmButton: true,
                                                                                                        allowOutsideClick: false,
                                                                                                    }).then(function (result) {
                                                                                                        if (result.value) {
                                                                                                            $("#editClient").modal('hide');
                                                                                                        }
                                                                                                    });
                                                                                                } else {
                                                                                                    //display other data
                                                                                                    console.log(data);
                                                                                                }
                                                                                            },
                                                                                            error: function (data) {
                                                                                                console.log(data);
                                                                                            },
                                                                                        });
                                                                                    }
                                                                                });
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }
        }
    }
    return false;


});


//--------------------------------------ADDING THE TRANSACTION TO THE DATABASE-----------------------------------------------------

//For passing transaction
$("#addTransactionForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    //append submit button
    formData.append("submit", "transactionSubmit");
    //append propertyName
    var agentProperties = $("#allPropertyHolder option:selected").text();
    formData.append("propertyName", agentProperties);
    // Display the values
    // for (var value of formData.keys()) {
    //     console.log(value);
    // }

    var agentProperties = $("#allPropertyHolder option:selected").text();
    var propertyType = formData.get("propertyType");
    var propertyOfferType = formData.get("propertyOfferType");
    var unitNo = formData.get("unitNo");
    var tcp = formData.get("tcp");
    var Address = formData.get("Address");
    var terms = formData.get("terms");
    var status = formData.get("status");
    var transactionDate = formData.get("transactionDate");
    var saleDate = formData.get("saleDate");
    var finalTcp = formData.get("finalTcp");
    var commission = formData.get("commission");
    var receivable = formData.get("receivable")
    var agentsCommission = formData.get("agentsCommission");
    var arCommission = formData.get("arCommission");
    var buyersCommision = formData.get("buyersCommision");
    var finalReceivable = formData.get("finalReceivable")
    //client/s holders

    var client0 = $("#client0");
    var client1 = $("#client1");

    // console.log(clientObj[0].client, clientObj[1].client);

    if (propertyOfferType === "Preselling") {
        if (propertyNameValidation(agentProperties)) {
            if (termsValidation(terms)) {
                if (checkClients(client0, client1)) {
                    if (transactionDateValidation(transactionDate)) {
                        if (finalTCPValidation(finalTcp)) {
                            if (agentCommissionValidation(agentsCommission)) {
                                if (ARCommissionValidation(arCommission)) {
                                    if (buyersCommissionValidation(buyersCommision)) {
                                        $("#transactionAlert").html('');

                                        //find transaction clients based on diplayed user icon
                                        if (clientObj.length === 1) {
                                            formData.append("firstClient", clientObj[0].client);
                                        } else if (clientObj.length === 2) {
                                            formData.append("firstClient", clientObj[0].client);
                                            formData.append("secondClient", clientObj[1].client);
                                        }
                                        Swal.fire({
                                            icon: "warning",
                                            title: "Are you sure about all Transaction details?",
                                            text: "Please double check information before submitting",
                                            showCancelButton: true,
                                            cancelButtonText: "Close",
                                            confirmButtonText: "Submit",
                                            confirmButtonColor: "#3CB371",
                                            cancelButtonColor: "#70945A"
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

                                                //add the transaction details to database
                                                $.ajax({
                                                    url: "includes/inserttransactions.inc.php",
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    type: "POST",
                                                    success: function (data) {
                                                        Swal.close();
                                                        console.log(data)
                                                        if (data == "Transaction Created") {
                                                            Swal.fire({
                                                                icon: "success",
                                                                title: data,
                                                                text: "Please wait! Website will now reload",
                                                                showConfirmButton: false,
                                                                allowOutsideClick: false,
                                                                timer: 2000
                                                            }).then(function (result) {
                                                                location.reload();
                                                            });
                                                        } else {
                                                            console.log(data)
                                                        }

                                                    },
                                                    error: function (data) {
                                                        alert(data);
                                                    },
                                                });
                                            }
                                        })
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    } else {
        if (propertyNameValidation(agentProperties)) {
            if (termsValidation(terms)) {
                if (checkClients(client0, client1)) {
                    if (transactionDateValidation(transactionDate)) {
                        if (finalTCPValidation(finalTcp)) {
                            if (commissionValidation(commission)) {
                                if (agentCommissionValidation(agentsCommission)) {
                                    if (ARCommissionValidation(arCommission)) {
                                        if (buyersCommissionValidation(buyersCommision)) {

                                            //find transaction clients based on diplayed user icon
                                            if (clientObj.length === 1) {
                                                formData.append("firstClient", clientObj[0].client);
                                            } else if (clientObj.length === 2) {
                                                formData.append("firstClient", clientObj[0].client);
                                                formData.append("secondClient", clientObj[1].client);
                                            }

                                            $("#transactionAlert").html('');
                                            Swal.fire({
                                                icon: "warning",
                                                title: "Are you sure about all Transaction details?",
                                                text: "Please double check information before submitting",
                                                showCancelButton: true,
                                                cancelButtonText: "Close",
                                                confirmButtonText: "Submit",
                                                confirmButtonColor: "#3CB371",
                                                cancelButtonColor: "#70945A"
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

                                                    //add the transaction details to database
                                                    $.ajax({
                                                        url: "includes/inserttransactions.inc.php",
                                                        data: formData,
                                                        processData: false,
                                                        contentType: false,
                                                        type: "POST",
                                                        success: function (data) {
                                                            Swal.close();
                                                            if (data == "Transaction Created") {
                                                                Swal.fire({
                                                                    icon: "success",
                                                                    title: data,
                                                                    text: "Please wait! Website will now reload",
                                                                    showConfirmButton: false,
                                                                    allowOutsideClick: false,
                                                                    timer: 2000
                                                                }).then(function (result) {
                                                                    location.reload();
                                                                });
                                                            } else {
                                                                console.log(data);
                                                            }

                                                        },
                                                        error: function (data) {
                                                            alert(data);
                                                        },
                                                    });
                                                }
                                            })
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }



});


//CLOSING TRANSACTION MODAL FUNCTION

function closeTransaction(img1, img2) {

    Swal.fire({
        icon: "warning",
        title: "Please submit your transaction",
        text: "You are closing without saving your transaction."
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
            if (img1.children.length !== 0 && img2.children.length !== 0) {
                //get the img
                var firstClient = document.querySelector("div#client0 img").id;
                var secondClient = document.querySelector("div#client1 img").id;
                $.ajax({
                    url: "includes/deleteclientinformation.inc.php",
                    type: "POST",
                    data: {
                        "clientId": firstClient
                    },
                    success: function (data) {
                        if (data === "Client information Deleted") {
                            //delete 2nd client
                            $.ajax({
                                url: "includes/deleteclientinformation.inc.php",
                                type: "POST",
                                data: {
                                    "clientId": secondClient
                                },
                                success: function (data) {
                                    if (data === "Client information Deleted") {
                                        Swal.close();
                                        Swal.fire({
                                            icon: "info",
                                            title: "Please wait!",
                                            text: "Website will now reload",
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            timer: 2000,
                                            timerProgressBar: true
                                        }).then(function (result) {
                                            location.reload();
                                        });
                                    } else {
                                        console.log(data);
                                    }
                                },
                                error: function (data) {
                                    console.log(data);
                                },
                            })
                        } else {
                            console.log(data);
                        }

                    },
                    error: function (data) {
                        console.log(data);
                    },
                })
            } else {
                //else 1 client is present
                if (img1.children.length !== 0) {
                    var firstClient = document.querySelector("div#client0 img").id;
                    $.ajax({
                        url: "includes/deleteclientinformation.inc.php",
                        type: "POST",
                        data: {
                            "clientId": firstClient
                        },
                        success: function (data) {
                            if (data === "Client information Deleted") {
                                Swal.close();
                                Swal.fire({
                                    icon: "info",
                                    title: "Please wait!",
                                    text: "Website will now reload",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(function (result) {
                                    location.reload();
                                });
                            } else {
                                console.log(data);
                            }
                        }
                    });
                } else if (img2.children.length !== 0) {
                    //delete 2nd client
                    var secondClient = document.querySelector("div#client1 img").id;
                    $.ajax({
                        url: "includes/deleteclientinformation.inc.php",
                        type: "POST",
                        data: {
                            "clientId": secondClient
                        },
                        success: function (data) {
                            if (data === "Client information Deleted") {
                                Swal.close();
                                Swal.fire({
                                    icon: "info",
                                    title: "Please wait!",
                                    text: "Website will now reload",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(function (result) {
                                    location.reload();
                                });
                            } else {
                                console.log(data);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        },
                    })
                } else {
                    //else there are no client 
                    //hide the modal
                    Swal.close();
                    $("#addTransaction").modal('hide');
                }
            }

        }
    })
}







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

//landline validation
function landlineValidation(clientLandlineNumber, landLineTag, alertId) {
    //regex for landline number ex. 09123456789
    //mobile number is not empty
    if (clientLandlineNumber !== "") {
        //meet the requiret number lenght of mobile number
        if (clientLandlineNumber.length == 7 || clientLandlineNumber.length == 8) {
            $(`#${landLineTag}`).removeClass('input-error');
            return true;
            // if (clientLandlineNumber.match(regex)) {

            // } else {
            //     //not match the regex for mobule number ex 09123456789
            //     $(`#${landLineTag}`).addClass('input-error');
            //     $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
            //     return false;
            // }
        } else {
            //error for not meeting the min length
            $(`#${landLineTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
            return false;
        }

    } else {
        //error for mobile number empty
        $(`#${landLineTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Landline Number Empty!</div>');
        return false;
    }
}

//local number validation

function localNumberValidation(localNumber, localNumberTag, alertId) {
    //regex for mobule number ex. 09123456789
    //local number is not empty
    if (localNumber !== "") {
        //meet the requiret number lenght of mobile number
        if (localNumber.length != 1) {
            $(`#${localNumberTag}`).removeClass('input-error');
            return true;
            // if (localNumber.match(regex)) {
            //     $(`#${localNumberTag}`).removeClass('input-error');
            //     return true;
            // } else {
            //     //not match the regex for mobule number ex 09123456789
            //     $(`#${localNumberTag}`).addClass('input-error');
            //     $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
            //     return false;
            // }
        } else {
            //error for not meeting the min length
            $(`#${localNumberTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Local Number!</div>');
            return false;
        }

    } else {
        //error for mobile number empty
        $(`#${localNumberTag}`).addClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Local Number Empty!</div>');
        return false;
    }
}


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
function roomUnitNoAndHouseLotValidation(clientRFUB, clientHLB, clientRFUBTag, clientHLBTag, alertId) {
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

function streetValidation(clientStreet, Tag, alertId) {
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

function clientCityValidation(clientCityAddress, Tag, alertId) {
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



//For passing transaction
$("#editTransactionForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    //append submit button
    formData.append("eSubmit", "eTransactionSubmit");
    //append the transactionId
    formData.append("transactionId", localStorage.getItem("transactionId"));
    //append propertyName
    // var agentProperties = $("#eAllPropertyHolder option:selected").text();
    // formData.append("ePropertyName", agentProperties);
    // Display the values
    var propertyType = formData.get("ePropertyType");
    var propertyOfferType = formData.get("ePropertyOfferType");
    var unitNo = formData.get("eUnitNo");
    var tcp = formData.get("ePropertyTcp");
    var Address = formData.get("ePropertyAddress");
    var terms = formData.get("eTerms");
    var status = formData.get("eStatus");
    var transactionDate = formData.get("eTransactionDate");
    var saleDate = formData.get("eSaleDate");
    var finalTcp = formData.get("eFinalTcp");
    var commission = formData.get("eCommission");
    var receivable = formData.get("eReceivable");
    var agentsCommission = formData.get("eAgentsCommission");
    var arCommission = formData.get("eArCommission");
    var buyersCommision = formData.get("eBuyersCommision");
    var finalReceivable = formData.get("eFinalReceivable");

    // for (var value of formData.values()) {
    //     console.log(value);
    // }

    //client/s holders

    var client0 = $("#eClient0");
    var client1 = $("#eClient1");


    if (propertyOfferType === "Preselling") {
        if (ePropertyNameValidation(agentProperties)) {
            if (eTermsValidation(terms)) {
                if (eCheckClients(client0, client1)) {
                    if (eTransactionDateValidation(transactionDate)) {
                        if (eFinalTCPValidation(finalTcp)) {
                            if (eAgentCommissionValidation(agentsCommission)) {
                                if (eARCommissionValidation(arCommission)) {
                                    if (eBuyersCommissionValidation(buyersCommision)) {
                                        $("#transactionAlert").html('');

                                        //find transaction clients based on diplayed user icon
                                        if (clientObj.length === 1) {
                                            formData.append("firstClient", clientObj[0].client);
                                        } else if (clientObj.length === 2) {
                                            formData.append("firstClient", clientObj[0].client);
                                            formData.append("secondClient", clientObj[1].client);
                                        }

                                        Swal.fire({
                                            icon: "warning",
                                            title: "Are you sure about all Transaction details?",
                                            text: "Please double check information before submitting",
                                            showCancelButton: true,
                                            cancelButtonText: "Close",
                                            confirmButtonText: "Submit",
                                            confirmButtonColor: "#3CB371",
                                            cancelButtonColor: "#70945A"
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

                                                //add the transaction details to database
                                                $.ajax({
                                                    url: "includes/inserttransactionedit.inc.php",
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    type: "POST",
                                                    success: function (data) {
                                                        Swal.close();
                                                        // for (var value of formData.keys()) {
                                                        //     console.log(value);
                                                        // }
                                                        console.log(data)
                                                        // if (data == "Transaction Created") {
                                                        //     Swal.fire({
                                                        //         icon: "success",
                                                        //         title: data,
                                                        //         text: "Please wait! Website will now reload",
                                                        //         showConfirmButton: false,
                                                        //         allowOutsideClick: false,
                                                        //         timer: 2000
                                                        //     }).then(function (result) {
                                                        //         location.reload();
                                                        //     });
                                                        // }

                                                    },
                                                    error: function (data) {
                                                        alert(data);
                                                    },
                                                });
                                            }
                                        })
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    } else {
        // if (ePropertyNameValidation(agentProperties)) {
        if (eTermsValidation(terms)) {
            if (eCheckClients(client0, client1)) {
                if (eTransactionDateValidation(transactionDate)) {
                    if (eFinalTCPValidation(finalTcp)) {
                        if (eCommissionValidation(commission)) {
                            if (eAgentCommissionValidation(agentsCommission)) {
                                if (eARCommissionValidation(arCommission)) {
                                    if (eBuyersCommissionValidation(buyersCommision)) {

                                        //find transaction clients based on diplayed user icon
                                        if (clientObj.length === 1) {
                                            formData.append("firstClient", clientObj[0].client);
                                        } else if (clientObj.length === 2) {
                                            formData.append("firstClient", clientObj[0].client);
                                            formData.append("secondClient", clientObj[1].client);
                                        }

                                        $("#transactionAlert").html('');
                                        Swal.fire({
                                            icon: "warning",
                                            title: "Are you sure about all Transaction details?",
                                            text: "Please double check information before submitting",
                                            showCancelButton: true,
                                            cancelButtonText: "Close",
                                            confirmButtonText: "Submit",
                                            confirmButtonColor: "#3CB371",
                                            cancelButtonColor: "#70945A"
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

                                                //add the transaction details to database
                                                $.ajax({
                                                    url: "includes/inserttransactionedit.inc.php",
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    type: "POST",
                                                    success: function (data) {
                                                        Swal.close();
                                                        // for (var value of formData.keys()) {
                                                        //     console.log(value);
                                                        // }
                                                        console.log(data)
                                                        // Swal.fire({
                                                        //     icon: "success",
                                                        //     title: data,
                                                        //     text: "Please wait! Website will now reload",
                                                        //     showConfirmButton: false,
                                                        //     allowOutsideClick: false,
                                                        //     timer: 2000
                                                        // }).then(function (result) {
                                                        //     location.reload();
                                                        // });
                                                    },
                                                    error: function (data) {
                                                        alert(data);
                                                    },
                                                });
                                            }
                                        })
                                    }
                                }
                            }
                        }
                    }
                }
                // }
            }
        }
        return false;
    }



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
            console.log(error)
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
function eAgentCommissionValidation(agentCommission) {
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


//-------EDITTING TRANSACTION VALIDATION ENDS HERE------


function editTransaction(transactionid) {
    Swal.fire({
        text: "Please Wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });
    localStorage.setItem("transactionId", transactionid);

    //ajax call
    $.ajax({
        url: "includes/transactionloadedit.inc.php",
        data: {
            "transactionId": transactionid
        },
        type: "POST",
        dataType: "json",
        success: function (transactionInformation) {
            Swal.close();
            $("#editTransaction").modal('show');
            //use modal function to load data into the modal before showing
            $("#editTransaction").on('shown.bs.modal', function () {

                var agentProperties = document.querySelector("#eAllPropertyHolder");
                var propertyType = document.querySelector("#ePropertyType");
                var subcategory = document.querySelector('#eSubcategory');
                var propertyOfferType = document.querySelector("#ePropertyOfferType");
                var unitNo = document.querySelector("#eUnitNo");
                var tcp = document.querySelector("#ePropertyTcp");
                var Address = document.querySelector("#ePropertyAddress");
                var terms = document.querySelector("#eTerms");
                var status = document.querySelector("#eStatus");
                var transactionDate = document.querySelector("#eTransactionDate");
                var saleDate = document.querySelector("#eSaleDate");
                var finalTcp = document.querySelector("#eFinalTcp");
                var commission = document.querySelector("#eCommission");
                var receivable = document.querySelector("#eReceivable")
                var agentsCommission = document.querySelector("#eAgentCommission");
                var arCommission = document.querySelector("#eArCommission");
                var buyersCommision = document.querySelector("#eBuyersCommssion");
                var finalReceivable = document.querySelector("#eFinalReceivable");
                //client/s holders

                var client0 = $("#eClient0");
                var client1 = $("#eClient1");

                //get the client ids and insert to  clientObj
                clientObj = [];
                if (transactionInformation[0].firstClientId !== null && transactionInformation[0].secondClientId !== null) {

                    clientObj.push({
                        "client": transactionInformation[0].firstClientId
                    });
                    clientObj.push({
                        "client": transactionInformation[0].secondClientId
                    });
                } else {
                    //either firstCLiend Id is present or secondclient Id
                    if (transactionInformation[0].firstClientId !== null) {
                        clientObj.push({
                            "client": transactionInformation[0].firstClientId
                        });
                    } else {
                        clientObj.push({
                            "client": transactionInformation[0].secondClientId
                        });
                    }
                }



                //append transaction  name to select tag
                var selectedPropertyName = document.createElement("OPTION");
                var selectedPropertyTextName = document.createTextNode(transactionInformation[0].propertyName);
                selectedPropertyName.setAttribute("value", transactionInformation[0].propertyId);
                selectedPropertyName.appendChild(selectedPropertyTextName);
                agentProperties.append(selectedPropertyName);

                $("#eAllPropertyHolder").select2({
                    placeholder: "Select a Property",
                    allowClear: true,
                    ajax: {
                        url: "includes/selecteditproperty.inc.php",
                        type: "post",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                searchTerm: params.term // search term
                            };
                        },
                        processResults: function (response) {
                            return {
                                results: response

                            };
                        },
                        cache: true
                    }
                });
                //trigger the onchange in input tag of offertype
                var event = new Event('change');
                agentProperties.dispatchEvent(event);

                //disable selecting property
                $("#eAllPropertyHolder").select2({
                    disabled: "readonly"
                });


                propertyType.value = transactionInformation[0].propertyType;
                subcategory.value = transactionInformation[0].subcategory;
                propertyOfferType.value = transactionInformation[0].category;

                unitNo.value = transactionInformation[0].unitNo;
                tcp.value = transactionInformation[0].TCP;
                Address.value = transactionInformation[0].address;
                terms.value = transactionInformation[0].termsOfPayment;


                if (transactionInformation[0].firstClientId !== null) {
                    //clear first the container to prevent multiple entry
                    client0.empty();

                    var primartyId = document.createElement("img");
                    primartyId.src = 'assets/img/user.png'
                    primartyId.style.height = "50px";
                    primartyId.style.width = "50px";
                    primartyId.style.marginLeft = "15px";
                    primartyId.style.cursor = "pointer";
                    primartyId.id = transactionInformation[0].firstClientId;

                    primartyId.setAttribute("onclick", `selectedClient(this.id,'client0')`);
                    client0.append(primartyId);
                }


                if (transactionInformation[0].secondClientId !== null) {
                    //clear first the container to prevent multiple entry
                    client1.empty();

                    var secondaryId = document.createElement("img");
                    secondaryId.src = 'assets/img/user.png'
                    secondaryId.style.height = "50px";
                    secondaryId.style.width = "50px";
                    secondaryId.style.marginLeft = "15px";
                    secondaryId.style.cursor = "pointer";
                    secondaryId.id = transactionInformation[0].secondClientId;
                    secondaryId.setAttribute("onclick", `selectedClient(this.id,'client0')`);
                    client1.append(secondaryId);
                }

                //hide "add client" button if the there are 2 clients
                if (client0.children().length !== 0 && client1.children().length !== 0) {
                    $("#eAddClientBtn").removeClass("hidden");
                    $("#eAddClientNote").removeClass("hidden");
                } else {
                    if (client0.children().length !== 0) {
                        //if client 0 is have img tag child
                        $("#eAddClientBtn").removeClass("hidden");
                        $("#eAddClientNote").removeClass("hidden");
                    } else if (client1.children().length !== 0) {
                        //if client 1 have img tag child
                        $("#eAddClientBtn").removeClass("hidden");
                        $("#eAddClientNote").removeClass("hidden");
                    }
                }


                status.value = transactionInformation[0].status;
                transactionDate.value = transactionInformation[0].dateOfTransaction;
                saleDate.value = transactionInformation[0].dataOfReservation;

                finalTcp.value = transactionInformation[0].finalTCP;
                //trigger the blur and keypress in input tag of finalTcp
                var eventBlur = new Event('blur');
                var eventKeyPress = new Event('keypress');
                finalTcp.dispatchEvent(eventBlur);
                finalTcp.dispatchEvent(eventKeyPress);


                commission.value = transactionInformation[0].commission;
                receivable.value = transactionInformation[0].receivable;
                agentsCommission.value = transactionInformation[0].commissionAgent;

                //trigger the onchange and keyup in input tag of agentsCommission
                var eventChange = new Event('change');
                var eventKeyUp = new Event('keyup');
                agentsCommission.dispatchEvent(eventChange);
                agentsCommission.dispatchEvent(eventKeyUp);

                arCommission.value = transactionInformation[0].commissionAR;
                buyersCommision.value = transactionInformation[0].commissionBuyer;
                finalReceivable.value = transactionInformation[0].receivable2;

                $(this).off('shown.bs.modal');
            });

        },
        error: function (data) {
            console.log(data);
        }
    });
}






//------------DELETING TRANSACTION-----------
$("#transaction").on("click", "#deleteTransactionBtn", function (evt) {
    evt.stopPropagation();
    var data = table.row($(this).parents("tr")).data();
    var transactionId = data[0];

    Swal.fire({
        icon: "warning",
        title: "Delete this Transaction?",
        text: "Deleting this transaction will 'alter' the status of the property involved.",
        showCancelButton: true,
        confirmButtonColor: "#ff0000 ",
        confirmButtonText: "Delete"
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
                url: "includes/deletetransaction.inc.php",
                data: {
                    "transactionId": transactionId
                },
                type: "POST",
                success: function (data) {
                    Swal.close();
                    if (data === "Client information Deleted") {
                        Swal.fire({
                            icon: "success",
                            title: "Transaction Deleted!",
                            text: "Website will now reload",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(function (result) {
                            location.reload();
                        });
                    } else {
                        console.log(data)
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    })
});
//------------DELETING TRANSACTION ENDS HERE-----------



///HANDLING ROW CLICKING
$('#transaction').on('click', 'tbody tr', function () {

    var data = table.row(this).data();
    var transactionid = data[0];

    Swal.fire({
        icon: "question",
        title: `What do you want to do with this Property?`,
        text: "You can click outside this box to disregard this popup.",
        showDenyButton: true,
        denyButtonColor: "#ff0000 ",
        showCancelButton: true,
        confirmButtonText: `Edit`,
        confirmButtonColor: "#3CB371",
        denyButtonText: `Delete`,


    }).then(result => {
        if (result.isConfirmed) {

            //edit the transaction information
            editTransaction(transactionid);

        } else if (result.isDenied) {
            Swal.fire({
                icon: "warning",
                title: "Delete this Transaction?",
                text: "Deleting this transaction will 'alter' the status of the property involved.",
                showCancelButton: true,
                confirmButtonColor: "#ff0000 ",
                confirmButtonText: "Delete"
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
                        url: "includes/deletetransaction.inc.php",
                        data: {
                            "transactionId": transactionid
                        },
                        type: "POST",
                        success: function (data) {
                            Swal.close();
                            if (data === "Client information Deleted") {
                                Swal.fire({
                                    icon: "success",
                                    title: "Transaction Deleted!",
                                    text: "Website will now reload",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(function (result) {
                                    location.reload();
                                });
                            } else {
                                console.log(data)
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            })

        }
    });



})