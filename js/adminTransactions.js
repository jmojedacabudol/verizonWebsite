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


                // //load all agents property name
                // $("#allPropertyHolder").load('includes/selectproperty.inc.php', {
                //     usersId: localStorage.getItem("userlogged")
                // }, function (callback) {
                //     $('#allPropertyHolder option:eq(0)').prop('selected', true);
                //     $("#allPropertyHolder ").select2({
                //         placeholder: "Select a Property",
                //         allowClear: true,
                //     });

                //     Swal.close();
                //     // //open add property modal

                // });




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
});