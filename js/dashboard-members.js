$(document).ready(function () {

  //<----------------PROPERTIES------------------->
  $('#members tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  });

  var table = $('#members').DataTable({
    responsive: true,
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Team Members",
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
      title: "Team Members",
      titleAttr: 'Export as XLSX',
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      titleAttr: 'Export as CSV',
      title: "Team Members",
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      title: "Team Members",
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

      var r = $('#members tfoot tr');
      r.find('th').each(function () {
        $(this).css('padding', 8);
      });
      $('#members thead').append(r);
      $('#search_0').css('text-align', 'center')
    }
  });




  var schedulesTable = $('#schedules').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Team Members",
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
      title: "Team Members",
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      title: "Team Members",
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      title: "Team Members",
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

  var propertiesTable = $('#properties').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Team Members",
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
      title: "Team Members",
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      title: "Team Members",
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      title: "Team Members",
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







  $("#members").on("click", "#viewMessagesBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var memberid = data[0];
    Swal.fire({
      text: "Please Wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });


    $.ajax({
      url: "includes/loadmembermessage.inc.php",
      type: "POST",
      dataType: 'json',
      cache: false,
      data: {
        memberId: memberid
      },

    }).done(function (data) {
      if (data != "") {
        Swal.close();
        // console.log(data)
        // $("#managerAgents").dataTable().fnDestroy()
        $('#messages').dataTable({
          destroy: true,
          "aaData": data,
          "columns": [{
              "data": "Id"
            },
            {
              "data": "Client"
            },
            {
              "data": "Number"
            },
            {
              "data": "Property"
            },
            {
              "data": "Date"
            }
          ]

        })
      }

      $("#viewMessages").modal('show');

    }).fail(function (jqXHR, textStatus) {
      Swal.close();
      Swal.fire({
        icon: "info",
        title: "No Messages/s",
        text: "This agent does not have any message/s yet.",
        confirmButtonColor: "#3CB371",
      })
    });

  })

  $("#members").on("click", "#viewSchedulesBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var memberid = data[0];
    Swal.fire({
      text: "Please Wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });


    $.ajax({
      url: "includes/loadmemberschedules.inc.php",
      type: "POST",
      dataType: 'json',
      cache: false,
      data: {
        memberId: memberid
      },

    }).done(function (data) {
      if (data != "") {
        Swal.close();
        // console.log(data)
        $("#managerAgents").dataTable().fnDestroy()
        $('#schedules').dataTable({
          destroy: true,
          "aaData": data,
          "columns": [{
              "data": "Id"
            },
            {
              "data": "Client"
            },
            {
              "data": "Number"
            },
            {
              "data": "Property"
            },
            {
              "data": "Date"
            }
          ]

        })
      }


      $("#viewSchedules").modal('show');

    }).fail(function (jqXHR, textStatus) {
      Swal.close();
      Swal.fire({
        icon: "info",
        title: "No Schedules/s",
        text: "This agent does not have any schedules/s yet.",
        confirmButtonColor: "#3CB371",
      })
    });
  })


  $("#members").on("click", "#viewPropertiesBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var memberid = data[0];

    Swal.fire({
      text: "Please wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });


    $.ajax({
      url: "includes/loadmembersproperties.inc.php",
      type: "POST",
      dataType: 'json',
      cache: false,
      data: {
        memberId: memberid
      },

    }).done(function (data) {
      if (data != "") {
        Swal.close();
        // console.log(data)
        // $("#managerAgents").dataTable().fnDestroy()
        $('#properties').dataTable({
          destroy: true,
          "aaData": data,
          "columns": [{
              "data": "Id"
            },
            {
              "data": "Property"
            },
            {
              "data": "OfferType"
            },
            {
              "data": "Location"
            },
            {
              "data": "Price"
            }
          ]

        })
      }


      $("#viewProperties").modal('show');

    }).fail(function (jqXHR, textStatus) {
      Swal.close();
      Swal.fire({
        icon: "info",
        title: "No Property/s",
        text: "This agent does not have any property/s yet.",
        confirmButtonColor: "#3CB371",

      })
    });
  });


  $("#members").on("click", "#viewTransactionBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var memberid = data[0];
    var agentName = data[1] + " " + data[2];
    // console.log(memberid);

    Swal.fire({
      text: "Please wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });

    $.ajax({
      url: "includes/loadmembertransactions.inc.php",
      type: "POST",
      dataType: 'json',
      cache: false,
      data: {
        memberId: memberid
      },

    }).done(function (data) {
      if (data != "") {
        Swal.close();
        // console.log(data)
        // $("#managerAgents").dataTable().fnDestroy()
        $('#transactionss').dataTable({
          destroy: true,
          "aaData": data,
          dom: 'Bfrtip',
          buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary ',
            title: agentName + "'s Transaction/s",
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
            title: agentName + "'s Transaction/s",
            titleAttr: 'Export as XLSX',
            text: '<i class="fas fa-file-excel"></i>',
            exportOptions: {
              columns: ':not(.notexport)'
            },

          }, {
            extend: 'csvHtml5',
            className: 'btn btn-primary ',
            title: agentName + "'s Transaction/s",
            titleAttr: 'Export as CSV',
            text: '<i class="fas fa-file-csv"></i>',
            exportOptions: {
              columns: ':not(.notexport)'
            },

          }, {

            extend: 'print',
            className: 'btn btn-primary ',
            title: agentName + "'s Transaction/s",
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
          "columns": [{
              "data": "Id"
            },
            {
              "data": "Property Name"
            },
            {
              "data": "Property Type"
            },
            {
              "data": "Category"
            },
            {
              "data": "Unit No"
            }, {
              "data": "TCP"
            }, {
              "data": "Terms Of Payment"
            },
            {
              "data": "Address"
            },
            {
              "data": "Status"
            }, {
              "data": "Date of Transaction"
            },
            {
              "data": "Date of Reservation"
            },
            {
              "data": "Final TCP"
            },
            {
              "data": "Commission"
            },
            {
              "data": "Receivable"
            }, {
              "data": "Agent`s Commission"
            }, {
              "data": "AR`s Commision"
            }, {
              "data": "Buyer`s Commission"
            }, {
              "data": "Final Receivable"
            }
          ]

        })
      }

      $("#viewTransaction").modal('show');

    }).fail(function (jqXHR, textStatus) {
      console.log(textStatus)
      Swal.close();
      Swal.fire({
        icon: "info",
        title: "No Transaction/s",
        text: "This agent does not have any transaction/s yet.",
        confirmButtonColor: "#3CB371",

      });
    });
  });

});