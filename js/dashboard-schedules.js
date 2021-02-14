$(document).ready(function () {

    //<----------------PROPERTIES------------------->
    var table = $('#schedules').DataTable({
      dom: 'Bfrtip',
      buttons: [
        {
        extend: 'pdfHtml5',
        className: 'btn btn-primary ',
        title: "Schedules",
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
        text: '<i class="fas fa-file-excel"></i>',
        exportOptions: {
          columns: ':not(.notexport)'
        },
  
      }, {
        extend: 'csvHtml5',
        className: 'btn btn-primary ',
        title: "Schedules",
        text: '<i class="fas fa-file-csv"></i>',
        exportOptions: {
          columns: ':not(.notexport)'
        },
  
      }, {
  
        extend: 'print',
        className: 'btn btn-primary ',
        title: "Schedules",
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
  
      },  {
        className: 'btn btn-primary ',
        text: "View Calendar",
        orientation: 'portrait',
        action: function ( ) {

          viewPropertyCalendar();
        }
    }]
    });

    $("#schedules").on("click", "#delete-btn", function () {
      var data = table.row($(this).parents("tr")).data();
      var schedulesId = data[0];
      Swal.fire({
        icon: "warning",
        title: "Delete this Schedule?",
        text: "This Schedule will no longer be retrievable."
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
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 2000
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
var userlogged=localStorage.getItem('userlogged');
  // $("#date-container").load('includes/loadDashboardSchedules.inc.php', {
  //     userId: userlogged
  // }, function (callback) {
  //     console.log(callback)
  // })

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
                  title: "You dont have any Schedules",
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




  // calendar.on('select', function (info) {
  //     if (userid === 'no-user') {
  //         $("#userInfo").modal('show'); //show contact form for user
  //         $("#userInfoForm").submit(function (e) {
  //             e.preventDefault();
  //             var userForm = new FormData(this);
  //             var username = userForm.get('userName');
  //             var userNumber = userForm.get('userNumber');

  //             // for (var value of userForm.values()) {
  //             //     console.log(value);
  //             // }

  //             if (checkuserinformations(username, userNumber)) {
  //                 //     console.log("Piolo")
  //                 userForm.append("start", moment().format(info.startStr, "Y-MM-DD"));
  //                 userForm.append("end", moment().format(info.endStr, "Y-MM-DD"));
  //                 userForm.append("propertyid", propertyid);
  //                 userForm.append("propertyname", propertyname);
  //                 userForm.append("userId", userid);
  //                 // userForm.append("name", username);
  //                 // userForm.append("number", userNumber);

  //                 Swal.fire({
  //                     text: "Please Wait....",
  //                     allowOutsideClick: false,
  //                     showConfirmButton: false,

  //                     willOpen: () => {
  //                         Swal.showLoading();
  //                     }
  //                 });

  //                 // for (var value of userForm.values()) {
  //                 //     console.log(value);
  //                 // }

  //                 $.ajax({
  //                     url: 'includes/inserttoschedules.inc.php',
  //                     data: userForm,
  //                     processData: false,
  //                     contentType: false,
  //                     type: "POST",
  //                     success: function (data) {
  //                         if (data === "Statement Success") {
  //                             calendar.addEvent({
  //                                 title: username,
  //                                 start: info.startStr,
  //                                 end: info.endStr,
  //                                 selectable: true,
  //                             });
  //                             Swal.close();
  //                             username = "";
  //                             userNumber = "";
  //                             $("#userInfo").modal('hide');
  //                         } else {
  //                             Swal.close();
  //                             $("#contact-error").html(`<div class = "alert alert-danger" role = "alert" >${data}</div>`)
  //                         }
  //                         // console.log(data)
  //                     },
  //                     error: function (data) {
  //                         alert(data);
  //                     },
  //                 });



  //             }
  //             return false;

  //         })

  //     } else {
  //         // console.log(userid)
  //         Swal.fire({
  //             icon: 'info',
  //             title: "Do you want to set schedule in this date?"
  //         }).then(result => {
  //             if (result.value) {
  //                 Swal.fire({
  //                     text: "Please Wait....",
  //                     allowOutsideClick: false,
  //                     showConfirmButton: false,

  //                     willOpen: () => {
  //                         Swal.showLoading();
  //                     }
  //                 });

  //                 $.ajax({
  //                     url: 'includes/inserttoschedules.inc.php',
  //                     data: {
  //                         "userId": userid,
  //                         "start": moment().format(info.startStr, "Y-MM-DD"),
  //                         "end": moment().format(info.endStr, "Y-MM-DD"),
  //                         "propertyid": propertyid,
  //                         "propertyname": propertyname
  //                     },
  //                     type: "POST",
  //                     success: function (data) {
  //                         if (data === "Statement Success") {
  //                             calendar.addEvent({
  //                                 title: "Your Schedule",
  //                                 start: info.startStr,
  //                                 end: info.endStr,
  //                                 selectable: true,
  //                             });
  //                             Swal.close();
  //                             username = "";
  //                             userNumber = "";
  //                             $("#userInfo").modal('hide');
  //                         } else {
  //                             Swal.close();
  //                             Swal.fire({
  //                                 icon: "info",
  //                                 title: data
  //                             })
  //                         }
  //                         // console.log(data)
  //                     },
  //                     error: function (data) {
  //                         alert(data);
  //                     },
  //                 });
  //             }
  //         })
  //     }


  // });




}



// select: function (info) {







//         })
//         // var name = prompt('Enter Your Name');
//         // if (name) {
//         //     // console.log(name, info.startStr, info.endStr)
//         //     var start = moment().format(info.startStr, "Y-MM-DD");
//         //     var end = moment().format(info.endStr, "Y-MM-DD");

//         //     $.ajax({
//         //         url: 'includes/inserttoschedules.inc.php',
//         //         type: 'POST',
//         //         data: {
//         //             name: name,
//         //             start: start,
//         //             end: end,
//         //             campaignid: campaignId,
//         //             campaignname: campaignname,
//         //             userid: userId
//         //         },
//         //         success: function (data) {
//         //             // calendar.refetchEvents()
//         //             // alert('Added Successfully');
//         //             calendar.addEvent({
//         //                 id: data,
//         //                 title: name,
//         //                 start: start,
//         //                 end: end,
//         //                 editable: true,
//         //                 start
//         //             });

//         //         }
//         //     })
//         // }
//     },
//     eventClick: function (info) {
//         // if (confirm('Delete "' + info.event.title + '"?')) {
//         //     info.event.remove();
//         // }
//         if (confirm('Edit "' + info.event.title + '"?')) {
//             info.event.remove();
//         }

//     },







