var table;
$(document).ready(function () {
  //<----------------PROPERTIES------------------->
  $('#schedules tfoot th').each(function () {
    var title = $(this).text();
    console.log(title);
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  });

  table = $('#schedules').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      extend: 'pdfHtml5',
      className: 'btn btn-primary ',
      title: "Schedules",
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
      title: "Schedules",
      titleAttr: 'Export as XLSX',
      text: '<i class="fas fa-file-excel"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {
      extend: 'csvHtml5',
      className: 'btn btn-primary ',
      title: "Schedules",
      titleAttr: 'Export as CSV',
      text: '<i class="fas fa-file-csv"></i>',
      exportOptions: {
        columns: ':not(.notexport)'
      },

    }, {

      extend: 'print',
      className: 'btn btn-primary ',
      title: "Schedules",
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
      text: "View Calendar",
      orientation: 'portrait',
      action: function () {

        viewPropertyCalendar();
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

  $("#schedules").on("click", "#delete-btn", function (evt) {
    evt.stopPropagation();
    var data = table.row($(this).parents("tr")).data();
    var schedulesId = data[0];
    Swal.fire({
      icon: "warning",
      title: "Do you want to delete this schedule?",
      text: "This schedule will be permanently deleted",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      confirmButtonColor: "#3CB371",
      cancelButtonColor: "#70945A"
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
          url: "includes/dashboardDeleteSchedule.inc.php",
          data: {
            "scheduleId": schedulesId
          },
          type: "POST",
          success: function (data) {
            Swal.close();

            if (data == 'Success') {
              Swal.fire({
                icon: "success",
                title: "Schedule Deleted",
                text: "Reloading page....",
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 2000,
                timerProgressBar: true
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



function viewPropertyCalendar() {
  var userlogged = localStorage.getItem('userlogged');
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth'
    },
    events: {
      url: 'includes/loadDashboardSchedules.inc.php',
      method: 'POST',
      extraParams: {
        userId: userlogged,
      },
      failure: function () {
        Swal.fire({
          icon: "info",
          title: "You dont have any schedules",
          confirmButtonColor: "#3CB371",
        })
      },
    },
    selectOverlap: function (event) {
      return event.rendering === 'background';
    },
  });

  $("#viewSchedule").modal('show');

  $("#viewSchedule").on('shown.bs.modal', function () {
    calendar.render();
  });

}

///HANDLING ROW CLICKING

$('#schedules').on('click', 'tbody tr', function () {

  var data = table.row(this).data();
  var scheduleId = data[0];

  Swal.fire({
    icon: "warning",
    title: "Do you want to delete this schedule?",
    text: "This schedule will be permanently deleted",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    confirmButtonColor: "#3CB371",
    cancelButtonColor: "#70945A"
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
        url: "includes/dashboardDeleteSchedule.inc.php",
        data: {
          "scheduleId": scheduleId
        },
        type: "POST",
        success: function (data) {
          Swal.close();

          if (data == 'Success') {
            Swal.fire({
              icon: "success",
              title: "Schedule Deleted",
              text: "Reloading page....",
              showConfirmButton: false,
              allowOutsideClick: false,
              timer: 2000,
              timerProgressBar: true
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
});