$(document).ready(function () {

  //<----------------PROPERTIES------------------->
  $('#properties tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  });

  var table = $('#properties').DataTable({

    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Property Listing",
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
      title: "Property Listing",
      titleAttr: 'Export as XLSX',
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      titleAttr: 'Export as CSV',
      title: "Property Listing",
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      titleAttr: 'PRINT',
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

  $("#properties").on("click", "#approveBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];
    Swal.fire({
      icon: "warning",
      title: "Do you want to approve this property?",
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
                  title: "This property has been already approved",
                })
                break;
              case "Listing Approved":
                Swal.fire({
                  icon: "success",
                  title: "This listing is approve"
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
      title: "Do you want to deny this property?",
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
                  title: "This property has bee already denied",
                  text: "You may delete this property.",
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
        title: "Do you want to approve this property?",
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
                    title: "This property has been already approved",
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
        title: "Do you want to deny this property?",
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
                    title: "This property has been denied",
                    text: "You may delete this property.",
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
  });

  $("#properties").on("click", "#editBtn", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];

    localStorage.setItem('selectedProperty', propertyid);

    Swal.fire({
      text: "Please wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });

    //load property information
    $("#propertyHolder").load('includes/propertyloadedit.inc.php', {
      propertyId: propertyid
    }, function (callback) {
      // console.log(callback)
      //load property Imgs
      $("#propertyImgs").load('includes/propertyloadeditimg.inc.php', {
        propertyId: propertyid
      }, function (callback) {
        // console.log(callback)
        //call the editModal
        Swal.close();
        $("#editPropertyModal").modal('show');
      })
    })
  });

});


function showRentOptions(value) {
  console.log(value)
  if (value == "Rent") {
    document.getElementById("erentBtn").style.display = "block";
  } else {
    document.getElementById("erentBtn").style.display = "none";
  }
}


function checkRentChoice(buttonClicked) {
  if (buttonClicked == "edailyBtn") {
    document.getElementById("edailyBtn").classList.remove('btn-secondary');
    document.getElementById("edailyBtn").classList.add('btn-primary');
    $("#eofferchoice").val("Daily")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("eweeklyBtn").classList.add('btn-secondary');
    document.getElementById("emonthlyBtn").classList.add('btn-secondary');
  } else if (buttonClicked == "eweeklyBtn") {
    document.getElementById("eweeklyBtn").classList.remove('btn-secondary');
    document.getElementById("eweeklyBtn").classList.add('btn-primary');
    $("#eofferchoice").val("Weekly")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("edailyBtn").classList.add('btn-secondary');
    document.getElementById("emonthlyBtn").classList.add('btn-secondary');

  } else if (buttonClicked == "emonthlyBtn") {
    document.getElementById("emonthlyBtn").classList.remove('btn-secondary');
    document.getElementById("emonthlyBtn").classList.add('btn-primary');
    $("#eofferchoice").val("Monthly")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("eweeklyBtn").classList.add('btn-secondary');
    document.getElementById("edailyBtn").classList.add('btn-secondary');
  }
}


function deleteProperty(id, propertyid) {
  Swal.fire({
    icon: "warning",
    title: "Do you want to delete this picture?",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No"
  }).then(result => {
    if (result.value) {
      //delete the image of property to reload
      var imageContainer = document.getElementById("propertyImgs");
      imageContainer.innerHTML = '';
      //ajax request to delete the image selected and show again the updated images
      Swal.fire({
        text: "Please Wait....",
        allowOutsideClick: false,
        showConfirmButton: false,

        willOpen: () => {
          Swal.showLoading();
        },
      });


      $.ajax({
        url: "includes/propertyimgdelete.inc.php",
        data: {
          "file_name": id
        },
        type: "POST",
        success: function (data) {
          Swal.close();
          if (data == "Picture Deleted") {
            //load property Imgs
            $("#propertyImgs").load('includes/propertyloadeditimg.inc.php', {
              propertyId: propertyid
            }, function (callback) {
              // console.log(callback)
            })
          }
        },
        error: function (data) {
          alert(data);
        },
      });
    }
  })
}


$("#epropertyForm").submit(function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  formData.append("propertyId", localStorage.getItem('selectedProperty'));
  for (var value of formData.values()) {
    console.log(value);
  }
  Swal.fire({
    icon: "warning",
    title: "Do you want to save the changes you made?",
    text: "Please check all the changes you made before saving.",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No"


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
        url: "includes/insertpropertyedit.inc.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function (data) {
          Swal.close();
          console.log(data)
          if (data == "Successfully updated your with Images." || data == "Successfully updated your Property without Images.") {
            // console.log("Yahoo")
            // $("#form-message").html(``);
            Swal.fire({
              icon: "success",
              title: "Property has successfully updated",
              text: data,
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2000
            }).then(function (result) {
              location.reload();
            })
          }
          // } else {
          //   // console.log(data)
          //   $("#form-message").html(`<div class='alert alert-danger' id='alert' role='alert'>${data}</div>`);
          // }

        },
        error: function (data) {
          alert(data);
        },
      });
    }
  })





})