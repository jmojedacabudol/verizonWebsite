function viewPropertyCalendar(userid, propertyid, propertyname,agentId) {

    // $("#date-container").load('includes/loadschedules.inc.php', {
    //     propertyId: propertyid
    // }, function (callback) {
    //     console.log(callback)
    // })

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        // displayEventTime: false,
        // dateClick: function (arg) {
        //     console.log(arg)
        //     let m = moment(arg.date, calendar); // calendar is required
        //     console.log('clicked on ' + m.format());
        // },
        // eventDrop: function (arg) {
        //     let d = momentDuration(arg.delta);
        //     console.log('event moved ' + d.humanize());
        // },
        validRange: function (nowDate) {
            return {
                start: nowDate,
                end: moment(nowDate).clone().add(1, 'months')
            };
        },
        selectable: true,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        events: {
            url: 'includes/loadschedules.inc.php',
            method: 'POST',
            extraParams: {
                propertyId: propertyid,
                userId: userid
            },
            failure: function () {
                Swal.fire({
                    icon: "info",
                    title: "This Property dont have any schedules",
                    text: "The agent welcomes you."
                })
            },
        },
        selectOverlap: function (event) {
            return event.rendering === 'background';
        },
    });

    $("#bookaTourModal").modal('show');

    $("#bookaTourModal").on('shown.bs.modal', function () {
        calendar.render();
    });




    calendar.on('select', function (info) {
        if (userid === 'no-user') {
            $("#userInfo").modal('show'); //show contact form for user
            $("#userInfoForm").submit(function (e) {
                e.preventDefault();
                var userForm = new FormData(this);
                var username = userForm.get('userName');
                var userNumber = userForm.get('userNumber');

                // for (var value of userForm.values()) {
                //     console.log(value);
                // }

                if (checkuserinformations(username, userNumber)) {
                    //     console.log("Piolo")
                    userForm.append("start", moment().format(info.startStr, "Y-MM-DD"));
                    userForm.append("end", moment().format(info.endStr, "Y-MM-DD"));
                    userForm.append("propertyid", propertyid);
                    userForm.append("propertyname", propertyname);
                    userForm.append("userId", userid);
                    userForm.append("agentId", agentId);
                    // userForm.append("name", username);
                    // userForm.append("number", userNumber);

                    Swal.fire({
                        text: "Please Wait....",
                        allowOutsideClick: false,
                        showConfirmButton: false,

                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // for (var value of userForm.values()) {
                    //     console.log(value);
                    // }

                    $.ajax({
                        url: 'includes/inserttoschedules.inc.php',
                        data: userForm,
                        processData: false,
                        contentType: false,
                        type: "POST",
                        success: function (data) {
                            if (data === "Statement Success") {
                                calendar.addEvent({
                                    title: username,
                                    start: info.startStr,
                                    end: info.endStr,
                                    selectable: true,
                                });
                                Swal.close();
                                username = "";
                                userNumber = "";
                                $("#userInfo").modal('hide');
                            } else {
                                Swal.close();
                                $("#contact-error").html(`<div class = "alert alert-danger" role = "alert" >${data}</div>`)
                            }
                            // console.log(data)
                        },
                        error: function (data) {
                            alert(data);
                        },
                    });



                }
                return false;

            })

        } else {
            // console.log(userid)
            Swal.fire({
                icon: 'info',
                title: "Do you want to set schedule in this date?"
            }).then(result => {
                if (result.value) {
                    Swal.fire({
                        text: "Please Wait....",
                        allowOutsideClick: false,
                        showConfirmButton: false,

                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: 'includes/inserttoschedules.inc.php',
                        data: {
                            "userId": userid,
                            "start": moment().format(info.startStr, "Y-MM-DD"),
                            "end": moment().format(info.endStr, "Y-MM-DD"),
                            "propertyid": propertyid,
                            "propertyname": propertyname,
                            "agentId": agentId
                        },
                        type: "POST",
                        success: function (data) {
                            if (data === "Statement Success") {
                                calendar.addEvent({
                                    title: "Your Schedule",
                                    start: info.startStr,
                                    end: info.endStr,
                                    selectable: true,
                                });
                                Swal.close();
                                username = "";
                                userNumber = "";
                                $("#userInfo").modal('hide');
                            } else {
                                Swal.close();
                                Swal.fire({
                                    icon: "info",
                                    title: data
                                })
                            }
                            // console.log(data)
                        },
                        error: function (data) {
                            alert(data);
                        },
                    });
                }
            })
        }


    });




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









function checkuserinformations(name, phonenumber) {
    if (name !== "" || phonenumber !== "") {
        if (name.length < 5) {

            $("#contact-error").html("<div class='alert alert-danger' role='alert'>Please provide a more readable Name.</div>");
            return false;
        } else {
            if (phonenumber.length === 11) {
                $("#contact-error").html('');
                return true;
            } else {
                $("#contact-error").html("<div class='alert alert-danger' role='alert'>Please provide a valid Phone Number.</div>");
            }
        }
    } else {

        $("#contact-error").html("<div class='alert alert-danger' role='alert'>Please Provide your Name and Number.</div>");
        return false;
    }
}