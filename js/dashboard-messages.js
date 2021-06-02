var table;
$(document).ready(function () {

  //<----------------PROPERTIES------------------->
  $('#messages tfoot th').each(function () {
    var title = $(this).text();
    console.log(title);
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  });
  table = $('#messages').DataTable({
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
      title: "Messages",
      titleAttr: 'Export as XLSX',
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      title: "Messages",
      titleAttr: 'Export as CSV',
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      title: "Messages",
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
    }
  });


  $("#messages").on("click", "#btn-delete", function (evt) {
    evt.stopPropagation();
    var data = table.row($(this).parents("tr")).data();
    var messageId = data[0];
    Swal.fire({
      icon: "warning",
      title: "Do you want to delete this Message?",
      text: "This message will be permanently deleted.",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      confirmButtonColor: "#3CB371",
      cancelButtonColor: "#70945A"
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
          url: "includes/dashboardDeleteMessage.inc.php",
          data: {
            "messageId": messageId
          },
          type: "POST",
          success: function (data) {
            Swal.close();

            if (data == 'Success') {
              Swal.fire({
                icon: "success",
                title: "Message Deleted",
                text: "Reloading page....",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 2000,
                timerProgressBar: true
              }).then(function (result) {
                location.reload();
              })
            } else {
              console.log(data)
            }
          },
          error: function (data) {
            console.log(data);
          },
        });


      }
    })
  });
});

$('#messages').on('click', 'tbody tr', function () {

  var data = table.row(this).data();
  var messageId = data[0];
  Swal.fire({
    icon: "warning",
    title: "Do you want to delete this Message?",
    text: "This message will be permanently deleted.",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    confirmButtonColor: "#3CB371",
    cancelButtonColor: "#70945A"
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
        url: "includes/dashboardDeleteMessage.inc.php",
        data: {
          "messageId": messageId
        },
        type: "POST",
        success: function (data) {
          Swal.close();

          if (data == 'Success') {
            Swal.fire({
              icon: "success",
              title: "Message Deleted",
              text: "Reloading page....",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2000,
              timerProgressBar: true
            }).then(function (result) {
              location.reload();
            })
          } else {
            console.log(data);
          }
        },
        error: function (data) {
          console.log(data);
        },
      });


    }
  })
});