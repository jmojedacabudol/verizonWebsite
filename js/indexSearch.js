$(() => {
    $("#forsaleBtn").click(function () {
        document.getElementById("forsaleBtn").classList.remove('btn-secondary');
        document.getElementById("forsaleBtn").classList.add('btn-primary');
        $("#offertype").val("sell")

        // document.getElementById("forrentBtn").classList.remove('gradient-bg');
        document.getElementById("forrentBtn").classList.add('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-secondary');
    })

    $("#forrentBtn").click(function () {
        document.getElementById("forrentBtn").classList.remove('btn-secondary');
        document.getElementById("forrentBtn").classList.add('btn-primary');
        $("#offertype").val("rent")

        // document.getElementById("forsaleBtn").classList.remove('btn-primary');
        document.getElementById("forsaleBtn").classList.add('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-secondary');

    })


    $("#presellingBtn").click(function () {
        document.getElementById("presellingBtn").classList.remove('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-primary');
        $("#offertype").val("presell")

        // document.getElementById("forsaleBtn").classList.remove('btn-primary');
        document.getElementById("forsaleBtn").classList.add('btn-secondary');
        document.getElementById("forrentBtn").classList.add('btn-secondary');
    })



    $("#propBuilding").click(function () {
        $("#propType").val($(this).val());
    })

    $("#propCondominium").click(function () {
        $("#propType").val($(this).val());
    })
    $("#propHouse").click(function () {
        $("#propType").val($(this).val());
    })
    $("#propIndustrial").click(function () {
        $("#propType").val($(this).val());
    })
    $("#propOffices").click(function () {
        $("#propType").val($(this).val());
    })
    $("#propWarehouse").click(function () {
        $("#propType").val($(this).val());
    })
    $("#propFarmLots").click(function () {
        $("#propType").val($(this).val());
    })








    // $("#searchForm").submit(function (event) {
    //     event.preventDefault();
    //     var formData = new FormData(this);
    //     // formData.append("submit", "searchSubmit");
    //     for (var value of formData.values()) {
    //         console.log(value);
    //     }
    //     $.ajax({
    //         url: "includes/propertyload.inc.php",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         type: "POST",
    //         success: function (data) {
    //             localStorage.setItem('propertyResult', data);
    //             window.location.href = "properties.php";
    //         },
    //         error: function (data) {
    //             alert(data);
    //         },
    //     });

    // })

    // $("#navForm").submit(function (event) {
    //     event.preventDefault();
    //     var formData = new FormData(this);
    //     // console.log(formData);
    //     //formData.append("submit", propertyType);
    //     // for (var value of formData.values()) {
    //     //     console.log(value);
    //     // }
    //     $.ajax({
    //         url: "includes/propertyload.inc.php",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         type: "POST",
    //         success: function (data) {
    //             // console.log(data)
    //             localStorage.setItem('propertyResult', data);
    //             window.location.href = "properties.php";
    //         },
    //         error: function (data) {
    //             alert(data);
    //         },
    //     });
    // })


})