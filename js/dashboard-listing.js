$(document).ready(function () {

  //<----------------PROPERTIES------------------->
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
      text: "Add Property",
      orientation: 'portrait',
      action: function () {
        //open add property modal
        $("#AddPropertyList").modal('show');
      }
    }]
  });

  $("#properties").on("click", "#editProperty", function () {
    var data = table.row($(this).parents("tr")).data();
    var propertyid = data[0];
    //create a localStorage for propertyClickeds
    localStorage.setItem('selectedProperty', propertyid);

    Swal.fire({
      text: "Please Wait....",
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



    // $("#editPropertyModal").on('shown.bs.modal', function () {
    //   //delete the past property information of property to reload
    //   var propertyHolder = document.getElementById("propertyHolder");
    //   propertyHolder.innerHTML = '';


    // });
  });




  $("#properties").on("click", "#viewProperty", function () {
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


  });


});