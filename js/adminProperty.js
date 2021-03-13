$(document).ready(function () {

  //<----------------PROPERTIES------------------->
  var table = $('#properties').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Property Listing",
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
      title: "Property Listing",
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
      title: "Property Listing",
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

  $("#properties").on("click", "#approveBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];
    Swal.fire({
      icon: "warning",
      title: "Do you want to approve this Property?",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.post('includes/approveproperty.inc.php', {
            propertyId: propertyid,
          },
          function (returnedData) {
            switch (returnedData) {
              case "Already Approved":
                Swal.fire({
                  icon: "info",
                  title: "Property already Approved",
                })
                break;
              case "Listing Approved":
                Swal.fire({
                  icon: "success",
                  title: "Listing Approved"
                }).then(result => {
                  if (result.value) {
                    location.reload();
                  }
                })
                break;
            }
          }).fail(function () {
          console.log("error");
        });
      }
    });
  });



  $("#properties").on("click", "#denyBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];
    Swal.fire({
      icon: "error",
      title: "Do you want to deny this Property?",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }).then((result) => {
      if (result.value) {
        $.post('includes/denyproperty.inc.php', {
            propertyId: propertyid,
          },
          function (returnedData) {
            // console.log(returnedData)
            switch (returnedData) {
              case "Already Denied":
                Swal.fire({
                  icon: "info",
                  title: "Property already Denied",
                  text: "You can delete this Listing.",
                  showCancelButton: true,
                  confirmButtonColor: "#d33",
                  cancelButtonColor: "#3085d6",
                  confirmButtonText: "Delete",
                }).then((result) => {
                  if (result.value) {
                    $.post('includes/deleteproperty.inc.php', {
                        propertyId: propertyid,
                      },
                      function (returnedData) {
                        Swal.fire({
                          icon: "success",
                          title: returnedData
                        }).then((result) => {
                          if (result.value) {
                            location.reload();
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
                }).then(result => {
                  if (result.value) {
                    location.reload();
                  }
                })
                break;
            }
          }).fail(function () {
          console.log("error");
        });
      }
    });
  });



  $("#properties").on("click", "#viewBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];


    $("#propertyContainer").load("includes/adminpropertyimgload.inc.php", {
      propertyId: propertyid,
    }, function (callback) {
      // console.log("HGHGHGHGHGH"+callback)
    });

    $("#property-title").load('includes/loadpropertynameandprice.inc.php', {
      propertyId: propertyid,
    })
    $("#property-info").load('includes/loadpropertyinfo.inc.php', {
      propertyId: propertyid,
    })

    $("#propertiesModal").modal('show');

    $("#approvelisting").click(function () {
      Swal.fire({
        icon: "warning",
        title: "Do you want to approve this Property?",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          $.post('includes/approveproperty.inc.php', {
              propertyId: propertyid,
            },
            function (returnedData) {
              switch (returnedData) {
                case "Already Approved":
                  Swal.fire({
                    icon: "info",
                    title: "Property already Approved",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                  })
                  break;
                case "Listing Approved":
                  Swal.fire({
                    icon: "success",
                    title: "Listing Approved",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "Close",
                  })
                  break;
              }
            }).fail(function () {
            console.log("error");
          });
        }
      });
    })

    $("#denylisting").click(function () {
      Swal.fire({
        icon: "error",
        title: "Do you want to deny this Property?",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.value) {
          $.post('includes/denyproperty.inc.php', {
              propertyId: propertyid,
            },
            function (returnedData) {
              // console.log(returnedData)
              switch (returnedData) {
                case "Already Denied":
                  Swal.fire({
                    icon: "info",
                    title: "Listing already Denied",
                    text: "You can delete this Listing.",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Delete",
                  }).then((result) => {
                    if (result.value) {
                      $.post('includes/deleteproperty.inc.php', {
                          propertyId: propertyid,
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
    })
  })

})