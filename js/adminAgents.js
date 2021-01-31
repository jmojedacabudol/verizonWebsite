// <--------------------------USERS-------------------------------->
$(document).ready(function () {
    var table2 = $('#Agents').DataTable({
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


    $("#Agents").on("click", "#approveBtn", function () {
        var data = table2.row($(this).parents("tr")).data();
        var userid = data[0];

        // console.log(userid)
        Swal.fire({
            icon: "warning",
            title: "Approve This User?",
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
            title: "Deny This User?",
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
                            case "Listing Denied":
                                Swal.fire({
                                    icon: "success",
                                    title: "Listing Denied"
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

        console.log(userid)
    });

});