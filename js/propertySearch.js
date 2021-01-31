function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 31 && charCode < 48) || charCode > 57) {
        return false;
    }
    return true;
}

// $("#lotAreaBtn").click(function () {
//     document.getElementById("onlyNumbers2").disabled = true;
//     document.getElementById("onlyNumbers1").disabled = false;
//     var area = $("#onlyNumbers1").val();
//     $("#areaSelected").val(area);

// })

// $("#floorAreaBtn").click(function () {
//     document.getElementById("onlyNumbers1").disabled = true;
//     document.getElementById("onlyNumbers2").disabled = false;
//     var area = $("#onlyNumbers2").val();
//     $("#areaSelected").val(area);
// })

$("#propertySearch").submit(function (event) {
    event.preventDefault();

    var formData = new FormData(this);
    // formData.append("searchSubmit", "");
    // // // fd.append(this);
    // // // fd.append("submit", "propertySubmitBtn");
    // // // Display the values
    // for (var value of formData.values()) {
    //     console.log(value);
    // }
    $.ajax({
        url: "includes/fullpropertysearch.inc.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function (data) {
            // $("#alert").remove();
            // $("#form-message").append(data);
            $("#propertiesContainer").html(data);
            // console.log(data)
        },
        error: function (data) {
            alert(data);
        },
    });

})


// $.get('includes/searchaddon.inc.php',
//     function (returnedData) {
//         console.log(returnedData)
//     }).fail(function () {
//     console.log("error");
// });