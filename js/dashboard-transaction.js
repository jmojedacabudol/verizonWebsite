//propertySelected stored here
var propertyIdSelected;

$(document).ready(function () {
    //<----------------PROPERTIES------------------->
    $('#transaction tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    var table = $('#transaction').DataTable({
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
                    text: "Please Wait....",
                    allowOutsideClick: false,
                    showConfirmButton: false,

                    willOpen: () => {
                        Swal.showLoading();
                    },
                });



                //load all agents property name
                $("#allPropertyHolder").load('includes/selectproperty.inc.php', {
                    usersId: localStorage.getItem("userlogged")
                }, function (callback) {
                    $('#allPropertyHolder option:eq(0)').prop('selected', true);
                    $("#allPropertyHolder ").select2({
                        placeholder: "Select a Property",
                        allowClear: true,
                    });

                    Swal.close();
                    // //open add property modal
                    $("#addTransaction").modal('show');
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


    //get the value of the propertyname dropdown and get its full information to fill some of details of the property
    $("#allPropertyHolder").change(function () {
        propertyIdSelected = this.value;


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
                var propertyLocation = data[0].propertyLocation;
                var propertyOffertType = data[0].propertyOffertType;
                var propertyApprovalStatus = data[0].propertyApprovalStatus;

                $("#propertyType").val(propertyType);
                $('#propertyType').attr('readonly', true);

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

                if (propertyOffertType == "Preselling") {
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
    });


    //geting the mobile number of the buyer

    $("#buyersHolder").change(function () {
        var buyersNumber = this.value;
        $("#clientMobileNumber").val(buyersNumber);
        $('#clientMobileNumber').attr('readonly', true);
    });



});



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
            text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
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
                text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
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
var arrayOfClients = [];
var clientObj;
$("#addClientForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    //check the length of Clients array of Objects
    var clientCount = arrayOfClients.length;
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

    if (compeleteNameValidation(fName, mName, lName, 'fName', 'mName', 'lName', 'addClientAlert')) {
        if (mobileNumberValidation(clientMobileNumber, 'clientMobileNumber', 'addClientAlert')) {
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
                                                                                text: "Please double check information before submitting",
                                                                                showCancelButton: true,
                                                                                cancelButtonText: "Close",
                                                                                confirmButtonText: "Submit",
                                                                                confirmButtonColor: "#3CB371",
                                                                                cancelButtonColor: "#70945A"
                                                                            }).then(result => {
                                                                                if (result.value) {
                                                                                    if (clientCount !== 2) {
                                                                                        clientObj = {
                                                                                            clientNo: "client" + clientCount,
                                                                                            fName: formData.get("fName"),
                                                                                            mName: formData.get("mName"),
                                                                                            lName: formData.get("lName"),
                                                                                            clientMobileNumber: formData.get("clientMobileNumber"),
                                                                                            clientLandlineNumber: formData.get("clientLandlineNumber"),
                                                                                            emailAddress: formData.get("emailAddress"),
                                                                                            birthday: formData.get("birthday"),
                                                                                            gender: formData.get("gender"),
                                                                                            clientAge: formData.get("clientAge"),
                                                                                            civilStatus: formData.get("civilStatus"),
                                                                                            firstValidIdHolder: formData.get("firstValidIdHolder"),
                                                                                            secondValidIdHolder: formData.get("secondValidIdHolder"),
                                                                                            clientRFUB: formData.get("clientRFUB"),
                                                                                            clientHLB: formData.get("clientHLB"),
                                                                                            clientStreet: formData.get("clientStreet"),
                                                                                            subdivision: formData.get("subdivision"),
                                                                                            clientBrgyAddress: formData.get("clientBrgyAddress"),
                                                                                            clientCityAddress: formData.get("clientCityAddress"),
                                                                                            companyName: formData.get("companyName"),
                                                                                            companyInitalAddress: formData.get("companyInitalAddress"),
                                                                                            companyStreet: formData.get("companyStreet"),
                                                                                            companyBrgyAddress: formData.get("companyBrgyAddress"),
                                                                                            companyCityAddress: formData.get("companyCityAddress")
                                                                                        };

                                                                                        arrayOfClients.push(clientObj);
                                                                                    }


                                                                                    //create an element img 
                                                                                    var clientImg = document.createElement("img");
                                                                                    clientImg.src = `assets/img/user.png`;
                                                                                    clientImg.style.height = "50px";
                                                                                    clientImg.style.width = "50px";
                                                                                    clientImg.style.marginLeft = "15px";
                                                                                    clientImg.id = clientObj.clientNo;
                                                                                    clientImg.style.cursor = "pointer";
                                                                                    // clientImg.setAttribute("onclick", `deleteClient('${clientObj.clientNo}')`);


                                                                                    var holder1 = $("#client0");
                                                                                    var holder2 = $("#client1");

                                                                                    if (holder1.children().length === 0) {
                                                                                        //create onclick function with id of client object and where it is stored
                                                                                        clientImg.setAttribute("onclick", `selectedClient('${clientObj.clientNo}','client0')`);
                                                                                        holder1.append(clientImg);

                                                                                    } else {
                                                                                        //create onclick function with id of client object and where it is stored
                                                                                        clientImg.setAttribute("onclick", `selectedClient('${clientObj.clientNo}','client1')`);
                                                                                        holder2.append(clientImg);

                                                                                    }
                                                                                    // // $(".col-4#client0").each(function () {
                                                                                    // //     if ($(this).children().length == 0) {
                                                                                    // //         $(this).append(clientImg);
                                                                                    // //     }

                                                                                    // // });
                                                                                    // //append the img to div with clientCotainer ID
                                                                                    // $(`#client${clientObj.clientNo}`).append(clientImg);

                                                                                    $("#addClient").modal('hide');
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

    //hide "add client" button if the there are 2 clients
    if (arrayOfClients.length == 2) {
        $("#addClientBtn").addClass("hidden");
        //add note for editing client information
    } else if (arrayOfClients.length == 1) {
        $("#addClientBtn").removeClass("hidden");
        $("#addClientNote").removeClass("hidden");
    } else {
        $("#addClientBtn").removeClass("hidden");
        $("#addClientNote").addClass("hidden");
    }

});


function selectedClient(id, item) {
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
            var clientToEdit = arrayOfClients.find((clientObj) => clientObj.clientNo === id);
            updateClient(clientToEdit, id);
        } else if (result.isDenied) {
            Swal.fire({
                icon: "warning",
                title: "What do you want to do to this Client?",
                text: "You can click outside this box to disregard this popup.",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonColor: "#ff0000 ",
            }).then(result => {
                if (result.value) {
                    // //delete client information
                    arrayOfClients = arrayOfClients.filter(function (returnableObjects) {
                        return returnableObjects.clientNo !== id;
                    });
                    //delete the img tag using its parent 
                    //empty()  method removes the child elements of the selected element(s).
                    $(`#${item}`).empty("img");
                    //hide "add client" button if the there are 2 clients
                    if (arrayOfClients.length === 2) {
                        $("#addClientBtn").addClass("hidden");
                        //add note for editing client information
                    } else if (arrayOfClients.length == 0) {
                        $("#addClientNote").addClass("hidden");
                    } else {
                        $("#addClientBtn").removeClass("hidden");
                        $("#addClientNote").removeClass("hidden");
                    }
                }
            });
        }
    });
}


//edit the client information
function updateClient(clientObjToEdit, clientId) {
    console.log(clientObjToEdit)
    // //set the values to form

    $("#clientId").text(clientId)

    $("#eFName").val(clientObjToEdit.fName);
    $("#eMName").val(clientObjToEdit.mName);
    $("#eLName").val(clientObjToEdit.lName);
    $("#eClientMobileNumber").val(clientObjToEdit.clientMobileNumber);
    $("#eClientLandlineNumber").val(clientObjToEdit.clientLandlineNumber);
    $("#eEmailAddress").val(clientObjToEdit.emailAddress);
    $("#eBirthday").val(clientObjToEdit.birthday);
    $("#eGender").val(clientObjToEdit.gender);
    $("#eClientAge").val(clientObjToEdit.clientAge);
    $("#eCivilStatus").val(clientObjToEdit.civilStatus);

    // $("#firstValidIdHolder").val(clientObjToEdit.firstValidIdHolder[0]);
    // $("#secondValidIdHolder").val(clientObjToEdit.secondValidIdHolder[0]);
    $("#eFirstValidId").attr('src', URL.createObjectURL(clientObjToEdit.firstValidIdHolder));
    $("#eSecondValidId").attr('src', URL.createObjectURL(clientObjToEdit.secondValidIdHolder));



    $("#eClientRFUB").val(clientObjToEdit.clientRFUB);
    $("#eClientHLB").val(clientObjToEdit.clientHLB);
    $("#eClientStreet").val(clientObjToEdit.clientStreet);
    $("#eSubdivision").val(clientObjToEdit.subdivision);


    //load the initial value of brgy address and load select2 API afterwards 
    var selectedClientBrgyAddress = document.createElement("OPTION");
    var selectedClientBrgyTextAddress = document.createTextNode(clientObjToEdit.clientBrgyAddress);
    selectedClientBrgyAddress.setAttribute("value", clientObjToEdit.clientBrgyAddress);
    selectedClientBrgyAddress.appendChild(selectedClientBrgyTextAddress);
    $("#eClientBrgyAddress").append(selectedClientBrgyAddress);


    var selectedCompanyBrgyAddress = document.createElement("OPTION");
    var selectedCompanyBrgyTextAddress = document.createTextNode(clientObjToEdit.companyBrgyAddress);
    selectedCompanyBrgyAddress.setAttribute("value", clientObjToEdit.companyBrgyAddress);
    selectedCompanyBrgyAddress.appendChild(selectedCompanyBrgyTextAddress);
    $("#eCompanyBrgyAddress").append(selectedCompanyBrgyAddress);


    //load the initial value of City address and load select2 API afterwards 

    var selectedClientCityAddress = document.createElement("OPTION");
    var selectedClientCityTextAddress = document.createTextNode(clientObjToEdit.clientCityAddress);
    selectedClientCityAddress.setAttribute("value", clientObjToEdit.clientCityAddress);
    selectedClientCityAddress.appendChild(selectedClientCityTextAddress);
    $("#eClientCityAddress").append(selectedClientCityAddress);

    var selectedCompanyCityAddress = document.createElement("OPTION");
    var selectedCompanyCityTextAddress = document.createTextNode(clientObjToEdit.companyCityAddress);
    selectedCompanyCityAddress.setAttribute("value", clientObjToEdit.companyCityAddress);
    selectedCompanyCityAddress.appendChild(selectedCompanyCityTextAddress);
    $("#eCompanyCityAddress").append(selectedCompanyCityAddress);



    $("#eCompanyName").val(clientObjToEdit.companyName);
    $("#eCompanyInitalAddress").val(clientObjToEdit.companyInitalAddress);
    $("#eCompanyStreet").val(clientObjToEdit.companyStreet);


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



    // load modal for editing the client
    $("#editClient").modal('show');
}

//submit button for editting the client information
$("#editClientForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);

    //get the client Id from the modal
    var clientId = document.querySelector("#clientId").innerHTML;
    var fName = formData.get("eFName");
    var mName = formData.get("eMName");
    var lName = formData.get("eLName");
    var clientMobileNumber = formData.get("eClientMobileNumber");
    var clientLandlineNumber = formData.get("eClientLandlineNumber");
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

    if (compeleteNameValidation(fName, mName, lName, 'eFName', 'eMName', 'eLName', 'editClientAlert')) {
        if (mobileNumberValidation(clientMobileNumber, 'eClientMobileNumber', 'editClientAlert')) {
            if (landlineValidation(clientLandlineNumber, 'eClientLandlineNumber', 'editClientAlert')) {
                if (emailValidation(emailAddress, 'eEmailAddress', 'editClientAlert')) {
                    if (birthdayValidation(birthday, 'eBirthday', 'editClientAlert')) {
                        if (genderValidation(gender, 'eGender', 'editClientAlert')) {
                            if (ageValidation(clientAge, 'eClientAge', 'editClientAlert')) {
                                if (civilStatusValidation(civilStatus, 'eCivilStatus', 'editClientAlert')) {
                                    if (checkIdImgIsChanged(primaryId, secondId, 'eFirstValidId', 'eSecondValidId', eFirstValidId, eSecondValidId, 'editClientAlert', clientId)) {
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
                                                                                    //edit the client object using the client Id from edit Modal
                                                                                    //client id = client0 therefore clientid is "0"
                                                                                    if (clientId === "client0") {
                                                                                        arrayOfClients[0].fName = formData.get("eFName");
                                                                                        arrayOfClients[0].mName = formData.get("eMName");
                                                                                        arrayOfClients[0].lName = formData.get("eLName");
                                                                                        arrayOfClients[0].clientMobileNumber = formData.get("eClientMobileNumber");
                                                                                        arrayOfClients[0].clientLandlineNumber = formData.get("eClientLandlineNumber");
                                                                                        arrayOfClients[0].emailAddress = formData.get("eEmailAddress");
                                                                                        arrayOfClients[0].birthday = formData.get("eBirthday");
                                                                                        arrayOfClients[0].gender = formData.get("eGender");

                                                                                        arrayOfClients[0].clientAge = formData.get("eClientAge");
                                                                                        arrayOfClients[0].civilStatus = formData.get("eCivilStatus");


                                                                                        arrayOfClients[0].clientRFUB = formData.get("eClientRFUB");
                                                                                        arrayOfClients[0].clientHLB = formData.get("eClientHLB");
                                                                                        arrayOfClients[0].clientStreet = formData.get("eClientStreet");
                                                                                        arrayOfClients[0].subdivision = formData.get("eSubdivision");
                                                                                        arrayOfClients[0].clientBrgyAddress = formData.get("eClientBrgyAddress");

                                                                                        arrayOfClients[0].clientCityAddress = formData.get("eClientCityAddress");
                                                                                        arrayOfClients[0].companyName = formData.get("eCompanyName");
                                                                                        arrayOfClients[0].companyInitalAddress = formData.get("eCompanyInitalAddress");
                                                                                        arrayOfClients[0].companyStreet = formData.get("eCompanyStreet");
                                                                                        arrayOfClients[0].companyBrgyAddress = formData.get("eCompanyBrgyAddress");
                                                                                        arrayOfClients[0].companyCityAddress = formData.get("eCompanyCityAddress");
                                                                                    } else {
                                                                                        //client id =client1 therefore the id is "1"
                                                                                        arrayOfClients[1].mName = formData.get("eMName");
                                                                                        arrayOfClients[1].fName = formData.get("eFName");
                                                                                        arrayOfClients[1].lName = formData.get("eLName");
                                                                                        arrayOfClients[1].clientMobileNumber = formData.get("eClientMobileNumber");
                                                                                        arrayOfClients[1].clientLandlineNumber = formData.get("eClientLandlineNumber");
                                                                                        arrayOfClients[1].emailAddress = formData.get("eEmailAddress");
                                                                                        arrayOfClients[1].birthday = formData.get("eBirthday");
                                                                                        arrayOfClients[1].gender = formData.get("eGender");

                                                                                        arrayOfClients[1].clientAge = formData.get("eClientAge");
                                                                                        arrayOfClients[1].civilStatus = formData.get("eCivilStatus");


                                                                                        arrayOfClients[1].clientRFUB = formData.get("eClientRFUB");
                                                                                        arrayOfClients[1].clientHLB = formData.get("eClientHLB");
                                                                                        arrayOfClients[1].clientStreet = formData.get("eClientStreet");
                                                                                        arrayOfClients[1].subdivision = formData.get("eSubdivision");
                                                                                        arrayOfClients[1].clientBrgyAddress = formData.get("eClientBrgyAddress");

                                                                                        arrayOfClients[1].clientCityAddress = formData.get("eClientCityAddress");
                                                                                        arrayOfClients[1].companyName = formData.get("eCompanyName");
                                                                                        arrayOfClients[1].companyInitalAddress = formData.get("eCompanyInitalAddress");
                                                                                        arrayOfClients[1].companyStreet = formData.get("eCompanyStreet");
                                                                                        arrayOfClients[1].companyBrgyAddress = formData.get("eCompanyBrgyAddress");
                                                                                        arrayOfClients[1].companyCityAddress = formData.get("eCompanyCityAddress");
                                                                                    }
                                                                                    // hide the edit Modal
                                                                                    $("#editClient").modal('hide');
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
    return false;


});


//-------------------------------------------------------------------ADDING THE TRANSACTION TO THE DATABASE-----------------------------------------------------

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
                                                        //transfer the id of inserted transaction to another ajax call
                                                        $.ajax({
                                                            url: "includes/insertclients.inc.php",
                                                            type: "POST",
                                                            processData: false,
                                                            contentType: false,
                                                            data: {
                                                                "clients": JSON.stringify(arrayOfClients),
                                                            },
                                                            success: function (data) {
                                                                Swal.close();
                                                                console.log(data)

                                                            },
                                                            error: function (data) {
                                                                Swal.close();
                                                                console.log(data);
                                                            },
                                                        });

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
                                                            console.log(data)
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
    //regex for mobule number ex. 09123456789
    var regex = /^(8)\d{9}$/;
    //mobile number is not empty
    if (clientLandlineNumber !== "") {
        //meet the requiret number lenght of mobile number
        if (clientLandlineNumber.length === 10) {
            if (clientLandlineNumber.match(regex)) {
                $(`#${landLineTag}`).removeClass('input-error');
                return true;
            } else {
                //not match the regex for mobule number ex 09123456789
                $(`#${landLineTag}`).addClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Invalid Landline Number!</div>');
                return false;
            }
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
//if img/s src is/are empty bring up an error
//if imgs is/are by default img/s
//else the img is not default and pass the function
function checkIdImgIsChanged(primaryIdHolder, secondaryIdHolder, primartyIdTag, secondIdTag, primaryImg, secondaryImg, alertId, clientId) {
    var result;
    if (primaryIdHolder.files.length !== 0 && secondaryIdHolder.files.length !== 0) {
        //both primary and secondary Id is not empty
        //show the error in img holder
        $(`#${primartyIdTag}`).removeClass('input-error');
        $(`#${secondIdTag}`).removeClass('input-error');

        if (clientId === "client0") {
            arrayOfClients[0].firstValidIdHolder = primaryIdHolder.files[0];
            arrayOfClients[0].secondValidIdHolder = secondaryIdHolder.files[0];

            result = true;
        } else {
            //clientid = "1"
            arrayOfClients[1].firstValidIdHolder = primaryIdHolder.files[0];
            arrayOfClients[1].firstValidIdHolder = secondaryIdHolder.files[0];
            result = true;
        }

        result = true;

    } else {
        //check if primary Id is not empty
        if (primaryIdHolder.files.length !== 0 && secondaryIdHolder.files.length === 0) {
            // check if the img src of secondary id is in default img which is user.png
            //split first the img src link and filter it to delete empty array objects
            //compare the last file name of img src if it is equal to "user.png"
            var secondId = secondaryImg.split("/").filter(secondaryImg => secondaryImg !== "");

            if (secondId[2] === "user.png") {
                $(`#${secondIdTag}`).addClass('input-error');
                $(`#${primartyIdTag}`).removeClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Secondary Id!</div>');
            }
            //then
            //check the clientid to know where to insert the image
            //insert the value to array of clients primary id
            if (clientId === "client0") {
                arrayOfClients[0].firstValidIdHolder = primaryIdHolder.files[0];
                result = true;
            } else {
                //clientid = "1"
                arrayOfClients[1].firstValidIdHolder = primaryIdHolder.files[0];
                result = true;
            }

        } else if (primaryIdHolder.files.length === 0 && secondaryIdHolder.files.length !== 0) {
            // check if the img src of primary id is in default img which is user.png
            //split first the img src link and filter it to delete empty array objects
            //compare the last file name of img src if it is equal to "user.png"
            var primaryId = primaryImg.split("/").filter(primaryImg => primaryImg !== "");
            if (primaryId[2] === "user.png") {
                $(`#${primartyIdTag}`).addClass('input-error');
                $(`#${secondIdTag}`).removeClass('input-error');
                $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Primary Id!</div>');
            }
            //then
            //insert the value of second Id to array of clients using primary id
            if (clientId === "client0") {
                arrayOfClients[0].secondValidIdHolder = secondaryIdHolder.files[0];
                result = true;
            } else {
                //clientid = "1"
                arrayOfClients[1].firstValidIdHolder = secondaryIdHolder.files[0];
                result = true;
            }


            result = false;
        } else {
            //both are empty and no image will be edit
            $(`#${primartyIdTag}`).addClass('input-error');
            $(`#${secondIdTag}`).addClass('input-error');
            $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Ids!</div>');
            result = false;
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