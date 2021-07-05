//propertySelected stored here
var propertyIdSelected;
var table;
$(document).ready(function () {
    //<----------------PROPERTIES------------------->
    $('#admiTransactions tfoot th').each(function () {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" />');
    });

    table = $('#admiTransactions').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Transaction Table",
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
            title: "Transaction Table",
            titleAttr: 'Export as XLSX',
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            title: "Transaction Table",
            titleAttr: 'Export as CSV',
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {

            extend: 'print',
            className: 'btn btn-primary ',
            title: "Transaction Table",
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
});


//------------EDITING TRANSACTION-----------
$("#admiTransactions").on("click", "#editTransactionBtn", function (evt) {
    evt.stopPropagation();
    var data = table.row($(this).parents("tr")).data();
    var transactionId = data[0];

    //edit Transaction Information
    editTransaction(transactionId);

});


//------------DELETING TRANSACTION-----------
$("#admiTransactions").on("click", "#deleteTransactionBtn", function (evt) {
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


                if (transactionInformation[0].firstClientId != null) {
                    //clear first the container to prevent multiple entry
                    client0.empty();

                    var primartyId = document.createElement("img");
                    primartyId.src = 'assets/img/user.png'
                    primartyId.style.height = "50px";
                    primartyId.style.width = "50px";
                    primartyId.style.marginLeft = "15px";
                    primartyId.style.cursor = "pointer";
                    primartyId.id = transactionInformation[0].firstClientId;

                    primartyId.setAttribute("onclick", `selectedClient(this.id,'eClient0')`);
                    client0.append(primartyId);
                }


                if (transactionInformation[0].secondClientId != null) {
                    //clear first the container to prevent multiple entry
                    client1.empty();

                    var secondaryId = document.createElement("img");
                    secondaryId.src = 'assets/img/user.png'
                    secondaryId.style.height = "50px";
                    secondaryId.style.width = "50px";
                    secondaryId.style.marginLeft = "15px";
                    secondaryId.style.cursor = "pointer";
                    secondaryId.id = transactionInformation[0].secondClientId;
                    secondaryId.setAttribute("onclick", `selectedClient(this.id,'eClient0')`);
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
            // console.log(error)
            Swal.fire({
                icon: "error",
                title: error.responseText,
                allowOutsideClick: false,
                confirmButtonColor: "#3CB371",
                text: "This transaction is invalid because the Property involved is deleted. Contact Admin. Click ''Ok'' button to refresh the page."
            }).then(result => {
                if (result.value) {
                    location.reload();
                }
            })
        },
    });
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
                            if (data == "Client Deleted") {
                                // //delete the client Id to client object variable
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
                                    $("#addClientNote").addClass("hidden");
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
    return false;


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
    var agentsCommission = formData.get("eAgentCommission");
    var arCommission = formData.get("eArCommission");
    var buyersCommision = formData.get("eBuyersCommssion");
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
                            if (eAgentsCommissionValidation(agentsCommission)) {
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
                                                        //reset the clientObj 
                                                        clientObj = [];
                                                        Swal.close();
                                                        if (data == "Transaction Editted") {
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
        return false;
    } else {
        // if (ePropertyNameValidation(agentProperties)) {
        if (eTermsValidation(terms)) {
            if (eCheckClients(client0, client1)) {
                if (eTransactionDateValidation(transactionDate)) {
                    if (eFinalTCPValidation(finalTcp)) {
                        if (eCommissionValidation(commission)) {
                            if (eAgentsCommissionValidation(agentsCommission)) {
                                if (eARCommissionValidation(arCommission)) {
                                    if (eBuyersCommissionValidation(buyersCommision)) {
                                        // console.log(clientObj);
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
                                                        //reset the clientObj 
                                                        clientObj = [];
                                                        Swal.close();
                                                        if (data == "Transaction Editted") {
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
                // }
            }
        }
        return false;
    }



});



//CLOSING TRANSACTION MODAL FUNCTION

function closeTransaction(img1, img2, modal, element1, element2) {
    console.log(img1)
    Swal.fire({
        icon: "warning",
        title: "Please submit your transaction",
        text: "You are closing without saving your transaction.",
        showCancelButton: true,
        confirmButtonColor: "#3CB371",

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
                var firstClient = document.querySelector(`${element1} img`).id;
                var secondClient = document.querySelector(`${element2} img`).id;
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
                    var firstClient = document.querySelector(`${element1} img`).id;
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
                    var secondClient = document.querySelector(`${element2} img`).id;
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
                    $(`#${modal}`).modal('hide');
                }
            }

        }
    })
}