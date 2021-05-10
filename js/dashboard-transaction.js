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
                    $("#dateOf").removeClass("hidden");
                } else {
                    $("#agentCommission").attr('disabled', false);
                    $("#arCommission").attr('disabled', false);
                    $("#buyersCommssion").attr('disabled', false);
                    $("#finalReceivable").attr('disabled', false);
                    $("#receivable").attr('disabled', false);
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
    // $('#addTransaction').modal('hide')
    $('#addClient').modal('show')
    // Swal.fire({
    //     text: "Please Wait....",
    //     allowOutsideClick: false,
    //     showConfirmButton: false,

    //     willOpen: () => {
    //         Swal.showLoading();
    //     },
    // });

    // // load all users who contacted to that property
    // $("#buyersHolder").load('includes/selectbuyers.inc.php', {
    //     propertySelected: propertyIdSelected
    // }, function (callback) {
    //     Swal.close();
    //     $("#buyersHolder").select2({
    //         placeholder: "Select a Buyer",
    //         allowClear: true,
    //     });
    //     $('#addTransaction').modal('hide')
    //     $('#addClient').modal('show')
    // });

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
    if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
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


//For passing transaction
$("#addTransactionForm").submit(function (event) {
    event.preventDefault();

    console.log("yeah")
});

//handle events on closing the modal
var arrayOfClients = [];
$("#addClientForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    //check the length of Clients array of Objects
    var clientCount = arrayOfClients.length;

    if (clientCount !== 2) {
        var clientObj = {
            clientNo: clientCount,
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
    clientImg.setAttribute("onclick", `deleteClient('client${clientObj.clientNo}')`);

    //append the img to div with clientCotainer ID
    $(`#client${clientObj.clientNo}`).append(clientImg);

    $("#addClient").modal('hide');

    console.log(arrayOfClients);


});


$('#addClient').on('hidden.bs.modal', function () {
    //reset the form
    $('#addClientForm').find("input").val("");
    $('#addClientForm').find("select").val("default");
    //hide "add client" button if the there are 2 clients
    if (arrayOfClients.length == 2) {
        $("#addClientBtn").addClass("hidden");
    } else {
        $("#addClientBtn").removeClass("hidden");
    }

});


function deleteClient(id) {
    Swal.fire({
        icon: "warning",
        title: `Are you sure you want to delete this Client?`
    }).then(result => {
        if (result.value) {
            console.log(arrayOfClients);
        }
    })
}