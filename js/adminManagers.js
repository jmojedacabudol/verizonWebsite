$(() => {
    var table = $('#managers').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Messages",
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
            title: "Messages",
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            title: "Messages",
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {

            extend: 'print',
            className: 'btn btn-primary ',
            title: "Messages",
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






    $("#managers").on("click", "#approveBtn", function () {
        var data = table.row($(this).parents("tr")).data();
        var managerid = data[0];
        Swal.fire({
            icon: "warning",
            title: "Are you sure you want to Approve this Manager?",
            text: "This Manager will be approved.",
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
                    url: "includes/adminmanagerapprove.inc.php",
                    data: {
                        managerId: managerid,
                    },
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        // console.log(data)
                        if (data == "Success") {
                            Swal.fire({
                                icon: "success",
                                title: "Manager Updated",
                                text: "The page will now reload.",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error Deleting Message",
                                text: data,
                                showCancelButton: true,
                                cancelButtonText: "Close",
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


    $("#managers").on("click", "#denyBtn", function () {
        var data = table.row($(this).parents("tr")).data();
        var managerid = data[0];
        // console.log(managerid);

        Swal.fire({
            icon: "warning",
            title: "Are you sure you want to Deny this Manager?",
            text: "This Manager will be Denied.",
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
                    url: "includes/admindenymanager.inc.php",
                    data: {
                        managerId: managerid,
                    },
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        console.log(data)
                        if (data == "Success") {
                            Swal.fire({
                                icon: "success",
                                title: "Manager Updated",
                                text: "The page will now reload.",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error Deleting Message",
                                text: data,
                                showCancelButton: true,
                                cancelButtonText: "Close",
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


    $("#managers").on("click", "#viewBtn", function () {
        var data = table.row($(this).parents("tr")).data();
        var managerid = data[0];
        // console.log(managerid);

        Swal.fire({
            text: "Please Wait....",
            allowOutsideClick: false,
            showConfirmButton: false,

            willOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            url: "includes/loadmanageragents.inc.php",
            type: "POST",
            dataType: 'json',
            cache: false,
            data: {
                managerId: managerid
            },

        }).done(function (data) {
            if (data != "") {
                Swal.close();
                // console.log(data)
                // $("#managerAgents").dataTable().fnDestroy()
                $('#managerAgents').dataTable({
                    destroy: true,
                    "aaData": data,
                    "columns": [{
                            "data": "id"
                        },
                        {
                            "data": "Agent"
                        },
                        {
                            "data": "Number"
                        },
                        {
                            "data": "Email"
                        }
                    ]

                })
            }

            $("#viewManagerAgents").modal('show');

        }).fail(function (jqXHR, textStatus) {
            Swal.close();
            Swal.fire({
                icon: "info",
                title: "No Agent/s",
                text: "This Manager does not have any agent/s yet.",
                showCancelButton: true,
                cancelButtonText: "Close",
            })
        });
    })
})