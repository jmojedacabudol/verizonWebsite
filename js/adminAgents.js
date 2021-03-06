// <--------------------------USERS-------------------------------->
//agent table
var table2;
//feature table
var table3;
$(document).ready(function () {
    table2 = $('#Agents').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Agent Listing",
            titleAttr: 'Export as PDF',
            orientation: 'portrait',
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
            title: "Agent Listing",
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
            title: "Agent Listing",
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

        }]
    });


    // FEATURED AGENT TABLE

    table3 = $('#featured').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Agent Listing",
            orientation: 'portrait',
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
            title: "Agent Listing",
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            title: "Property Listing",
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {

            extend: 'print',
            className: 'btn btn-primary ',
            title: "Agent Listing",
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

        }]
    });


});


//---------Agent BUTTONS EVENTS------


$("#Agents").on("click", "#approveBtn", function (evt) {
    evt.stopPropagation();
    var data = table2.row($(this).parents("tr")).data();
    var agentId = data[0];

    //approve agent
    approveAgent(agentId);

});


$("#Agents").on("click", "#denyBtn", function () {
    var data = table2.row($(this).parents("tr")).data();
    var agentId = data[0];
    //deny agent
    denyAgent(agentId);
});


$("#Agents").on("click", "#viewBtn", function () {
    var data = table2.row($(this).parents("tr")).data();
    var agentId = data[0];

    //view agent information
    viewAgent(agentId);

});

$("#Agents").on("click", "#featureBtn", function () {
    var data = table2.row($(this).parents("tr")).data();
    var agentId = data[0];
    //feature agent
    featureModal(agentId);

});


// ---------Agent Feature BUTTON EVENTS---------



$("#featured").on("click", "#deleteFeatured", function () {
    var data = table3.row($(this).parents("tr")).data();
    var userid = data[0];

    Swal.fire({
        icon: "warning",
        title: "Do you want to delete this featured Agent?",
        text: "Deleting from this table will also remove him/her from the main page`s 'TOP AGENTS'.",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No"
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


            //delete the user from featured
            $.ajax({
                url: "includes/deleteagentfromfeatured.inc.php",
                data: {
                    userId: userid,
                },
                type: "POST",
                success: function (data) {
                    Swal.close();
                    // console.log(data)
                    if (data == "Success") {
                        Swal.fire({
                            icon: "success",
                            title: "Agent Uploaded",
                            text: "You can now see the featured User in Website`s Main Page.",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000
                        }).then(function (result) {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error Updating Featured User",
                            text: data
                        }).then(function (result) {
                            location.reload();
                        })
                    }
                },
                error: function (data) {
                    alert(data);
                },
            });


        }
    })


})


$("#featured").on("click", "#viewFeatured", function () {
    var data = table3.row($(this).parents("tr")).data();
    var userid = data[0];
    // console.log(userid)

    Swal.fire({
        text: "Please Wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });

    $("#editFeatureImg").load("includes/adminagentprofileimgload.inc.php", {
        userId: userid,
        featuredAgent: "already-featured"
    }, function (callback) {
        $("#editFeatureAgentInfo").load("includes/adminloadagentinfo.inc.php", {
            userId: userid,
            feature: "Featured"
        }, function (callback) {
            Swal.close();
            $("#editFeatureModal").modal('show');
        });
    });

    $("#editFeatBtn").click(function () {
        Swal.fire({
            icon: "warning",
            title: "Do you want to save changes?",
            text: "Kindly, check the changes you made.",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            showCancelButton: true
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
                    url: "includes/updatefeaturedagentstatement.inc.php",
                    data: {
                        userId: userid,
                        newdescription: $("#editListing-desc").val()
                    },
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        // console.log(data)
                        if (data == "Success") {
                            Swal.fire({
                                icon: "success",
                                title: "This agent has been uploaded successfully",
                                text: "You may now see the featured agent in the Website`s Main Page.",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error updating the featured user",
                                text: data
                            }).then(function (result) {
                                location.reload();
                            })
                        }
                    },
                    error: function (data) {
                        alert(data);
                    },
                });

            }
        })
    })

})




function changeUserPassword(userId) {
    var password = document.querySelector("#adminchangePassword").value;
    if (password !== "") {
        Swal.fire({
            icon: "warning",
            title: "Do you want to save the changes?",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonColor: "#3CB371",
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: "includes/userchangepassword.inc.php",
                    data: {
                        userpassword: password,
                        agentId: userId
                    },
                    type: "POST",
                    success: function (data) {
                        if (data === "Success") {
                            Swal.fire({
                                icon: "success",
                                title: "This user is updated",
                                text: "The page will be reloaded",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        }
                    }
                })
            }
        })
    }



}



//-------ALL AGENT EVENTS------


function approveAgent(agentId) {
    // console.log(userid)
    Swal.fire({
        icon: "warning",
        title: "Do you want to approve this user?",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
        confirmButtonColor: "#3CB371",
        cancelButtonColor: "#70945A"
    }).then((result) => {
        if (result.value) {
            $.post('includes/approveuser.inc.php', {
                    userId: agentId,
                },
                function (returnedData) {
                    switch (returnedData) {
                        case "Already Approved":
                            Swal.fire({
                                icon: "info",
                                title: "This user has been already approved",
                                confirmButtonColor: "#3CB371",
                            })
                            break;
                        case "User Approved":
                            Swal.fire({
                                icon: "success",
                                title: "This user is approve",
                                confirmButtonColor: "#3CB371"
                            })
                            break;
                    }
                }).fail(function () {
                console.log("error");
            });
        }
    });
}


function denyAgent(agentId) {

    Swal.fire({
        icon: "error",
        title: "Do you want to deny this user?",
        text: "You can deny a user so that he/she cannot post a Property.",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        showCancelButton: true,
        confirmButtonColor: "#3CB371",
        cancelButtonColor: "#70945A"
    }).then((result) => {
        if (result.value) {
            $.post('includes/denyuser.inc.php', {
                    userId: agentId,
                },
                function (returnedData) {
                    // console.log(returnedData)
                    switch (returnedData) {
                        case "Already Denied":
                            Swal.fire({
                                icon: "info",
                                title: "This user has been already denied",
                                text: "You may delete this user.",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Delete",
                            }).then((result) => {
                                if (result.value) {
                                    $.post('includes/deleteuser.inc.php', {
                                            userId: agentId,
                                        },
                                        function (returnedData) {
                                            Swal.fire({
                                                icon: "success",
                                                title: returnedData,
                                                confirmButtonColor: "#3CB371",
                                            }).then((result) => {
                                                if (result.value) {
                                                    window.location.reload();
                                                }
                                            })
                                        }).fail(function () {
                                        console.log("error");
                                    });
                                }
                            })
                            break;
                        case "User Denied":
                            Swal.fire({
                                icon: "success",
                                title: "This user is denied",
                                confirmButtonColor: "#3CB371",
                            })
                            break;
                    }
                }).fail(function () {
                console.log("error");
            });
        }
    });
}


function viewAgent(agentId) {
    Swal.fire({
        text: "Please wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });
    //load the agent information
    //load agent images

    $("#agentProfileImg").load("includes/adminagentprofileimgload.inc.php", {
        userId: agentId,
    }, function (callback) {
        $("#agentInfo").load("includes/adminloadagentinfo.inc.php", {
            userId: agentId,
        }, function (callback) {
            Swal.close();
            $("#agentModal").modal('show');
        });
    });


    $("#featureUserBtn").click(function () {
        //show feature Modal
        featureModal(agentId);
    });

    $("#approveAgentBtn").click(function () {
        //approve the agent
        approveAgent(agentId);
    })


    $("#denyAgentBtn").click(function () {
        denyAgent(agentId);
    })
}


function featureAgent(agentId) {
    Swal.fire({
        icon: "warning",
        title: "Do you want this agent to be featured?",
        text: "The agent will now be posted in your Home page.",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
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

            //insert the user to featured
            $.ajax({
                url: "includes/insertagenttofeatured.inc.php",
                data: {
                    userId: agentId,
                    featureMessage: $("#listing-desc").val()
                },
                type: "POST",
                success: function (data) {
                    Swal.close();
                    // console.log(data)
                    if (data == "Success") {
                        Swal.fire({
                            icon: "success",
                            title: "The agent is successfully uploaded",
                            text: "You can now see the featured User in Website`s Main Page.",
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            timerProgressBar: true
                        }).then(function (result) {
                            location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error Updating Featured User",
                            text: data,
                            confirmButtonColor: "#3CB371",
                        })
                    }

                },
                error: function (data) {
                    console.log(data);
                },
            });
        }
    })
}


function featureModal(agentId) {
    Swal.fire({
        text: "Please wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
            Swal.showLoading();
        },
    });
    Swal.close();
    $("#agentModal").modal('hide');

    $("#featureImg").load("includes/adminagentprofileimgload.inc.php", {
        userId: agentId,
    }, function (callback) {
        $("#featureAgentInfo").load("includes/adminloadagentinfo.inc.php", {
            userId: agentId,
            feature: agentId
        }, function (callback) {
            Swal.close();
            $("#featureModal").modal('show');
        });
    });

    //feature the user to index page of the website
    $("#featBtn").click(function () {
        //feature the agent
        featureAgent(agentId);
    });
}