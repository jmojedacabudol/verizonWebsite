$(() => {
    var table = $('#messages').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: "Messages",
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
            titleAttr: 'Export as XLSX',
            title: "Messages",
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            titleAttr: 'Export as CSV',
            title: "Messages",
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
                columns: ':not(.notexport)'
            },

        }, {

            extend: 'print',
            className: 'btn btn-primary ',
            titleAttr: 'PRINT',
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


    $("#messages").on("click", "#deleteBtn", function () {
        var data = table.row($(this).parents("tr")).data();
        var messagesid = data[0];
        Swal.fire({
            icon: "warning",
            title: "Are you sure you want to delete this message?",
            text: "This message will be permanently deleted.",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
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

                $.ajax({
                    url: "includes/admindeletemessage.inc.php",
                    data: {
                        messageId: messagesid,
                    },
                    type: "POST",
                    success: function (data) {
                        Swal.close();
                        // console.log(data)
                        if (data == "Success") {
                            Swal.fire({
                                icon: "success",
                                title: "Message Deleted",
                                text: "The page will be reloaded.",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 2000
                            }).then(function (result) {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "There is an error deleting the message",
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