// <--------------------------USERS-------------------------------->
$(document).ready(function () {
    var table2 = $('#Agents').DataTable({
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


    $("#Agents").on("click", "#approveBtn", function () {
        var data = table2.row($(this).parents("tr")).data();
        var userid = data[0];

        // console.log(userid)
        Swal.fire({
            icon: "warning",
            title: "Do you want to Approve this User?",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            showCancelButton: true
        }).then((result) => {
            if (result.value) {
                $.post('includes/approveuser.inc.php', {
                        userId: userid,
                    },
                    function (returnedData) {
                        switch (returnedData) {
                            case "Already Approved":
                                Swal.fire({
                                    icon: "info",
                                    title: "User already Approved"
                                })
                                break;
                            case "User Approved":
                                Swal.fire({
                                    icon: "success",
                                    title: "User Approved"
                                })
                                break;
                        }
                    }).fail(function () {
                    console.log("error");
                });
            }
        });
    });


    $("#Agents").on("click", "#denyBtn", function () {
        var data = table2.row($(this).parents("tr")).data();
        var userid = data[0];

        Swal.fire({
            icon: "error",
            title: "Do you want to deny this User?",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            showCancelButton: true
        }).then((result) => {
            if (result.value) {
                $.post('includes/denyuser.inc.php', {
                        userId: userid,
                    },
                    function (returnedData) {
                        // console.log(returnedData)
                        switch (returnedData) {
                            case "Already Denied":
                                Swal.fire({
                                    icon: "info",
                                    title: "User already Denied",
                                    text: "You can delete this User.",
                                    showCancelButton: true,
                                    confirmButtonColor: "#d33",
                                    cancelButtonColor: "#3085d6",
                                    confirmButtonText: "Delete",
                                }).then((result) => {
                                    if (result.value) {
                                        $.post('includes/deleteuser.inc.php', {
                                                userId: userid,
                                            },
                                            function (returnedData) {
                                                Swal.fire({
                                                    icon: "success",
                                                    title: returnedData
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
                                    title: "User Denied"
                                })
                                break;
                        }
                    }).fail(function () {
                    console.log("error");
                });
            }
        });
    });


    $("#Agents").on("click", "#viewBtn", function () {
        var data = table2.row($(this).parents("tr")).data();
        var userid = data[0];


        Swal.fire({
            text: "Please Wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        //load the agent information
        //load agent images

        $("#agentProfileImg").load("includes/adminagentprofileimgload.inc.php", {
            userId: userid,
        }, function (callback) {
            $("#agentInfo").load("includes/adminloadagentinfo.inc.php", {
                userId: userid,
            }, function (callback) {
                Swal.close();
                $("#agentModal").modal('show');
            });
        });


        $("#featureUserBtn").click(function () {

            Swal.fire({
                text: "Please Wait....",
                allowOutsideClick: false,
                showConfirmButton: false,

                willOpen: () => {
                    Swal.showLoading();
                },
            });
            Swal.close();
            $("#agentModal").modal('hide');

            $("#featureImg").load("includes/adminagentprofileimgload.inc.php", {
                userId: userid,
            }, function (callback) {
                $("#featureAgentInfo").load("includes/adminloadagentinfo.inc.php", {
                    userId: userid,
                    feature: userid
                }, function (callback) {
                    Swal.close();
                    $("#featureModal").modal('show');
                });
            });




            //feature the user to index page of the website
            $("#featBtn").click(function () {
                Swal.fire({
                    icon: "warning",
                    title: "Do you want to feature this Agent?",
                    text: "This agent will be posted in your Home page.",
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

                        //insert the user to featured
                        $.ajax({
                            url: "includes/insertagenttofeatured.inc.php",
                            data: {
                                userId: userid,
                                featureMessage: $("#listing-desc").val()
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

        $("#approveAgentBtn").click(function () {
            Swal.fire({
                icon: "warning",
                title: "Do you want to Approve this User?",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    $.post('includes/approveuser.inc.php', {
                            userId: userid,
                        },
                        function (returnedData) {
                            switch (returnedData) {
                                case "Already Approved":
                                    Swal.fire({
                                        icon: "info",
                                        title: "User already Approved"
                                    })
                                    break;
                                case "User Approved":
                                    Swal.fire({
                                        icon: "success",
                                        title: "User Approved"
                                    })
                                    break;
                            }
                        }).fail(function () {
                        console.log("error");
                    });
                }
            });
        })


        $("#denyAgentBtn").click(function () {
            Swal.fire({
                icon: "error",
                title: "Do you want to deny this User?",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                showCancelButton: true
            }).then((result) => {
                if (result.value) {
                    $.post('includes/denyuser.inc.php', {
                            userId: userid,
                        },
                        function (returnedData) {
                            // console.log(returnedData)
                            switch (returnedData) {
                                case "Already Denied":
                                    Swal.fire({
                                        icon: "info",
                                        title: "User already Denied",
                                        text: "You can delete this User.",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        cancelButtonColor: "#3085d6",
                                        confirmButtonText: "Delete",
                                    }).then((result) => {
                                        if (result.value) {
                                            $.post('includes/deleteuser.inc.php', {
                                                    userId: userid,
                                                },
                                                function (returnedData) {
                                                    Swal.fire({
                                                        icon: "success",
                                                        title: returnedData
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
                                        title: "User Denied"
                                    })
                                    break;
                            }
                        }).fail(function () {
                        console.log("error");
                    });
                }
            });
        })





    });

    $("#Agents").on("click", "#featureBtn", function () {
        var data = table2.row($(this).parents("tr")).data();
        var userid = data[0];

        Swal.fire({
            text: "Please Wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        //load the agent information
        //load agent images

        $("#featureImg").load("includes/adminagentprofileimgload.inc.php", {
            userId: userid,
        }, function (callback) {
            $("#featureAgentInfo").load("includes/adminloadagentinfo.inc.php", {
                userId: userid,
                feature: userid
            }, function (callback) {
                Swal.close();
                $("#featureModal").modal('show');
            });
        });


        //feature the user to index page of the website
        $("#featBtn").click(function () {
            Swal.fire({
                icon: "warning",
                title: "Do you want to feature  this Agent?",
                text: "This agent will be posted in Homepage.",
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

                    //insert the user to featured
                    $.ajax({
                        url: "includes/insertagenttofeatured.inc.php",
                        data: {
                            userId: userid,
                            featureMessage: $("#listing-desc").val()
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

    })


    // FEATURED AGENT TABLE

    var table3 = $('#featured').DataTable({
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
                text: "Please check your changes.",
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

    })

});


function changeUserPassword(userId) {
    var password = document.querySelector("#adminchangePassword").value;
    if (password !== "") {
        Swal.fire({
            icon: "warning",
            title: "Do you want to save your changes?",
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
                                title: "User Updated!",
                                text: "Page will now Reload",
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