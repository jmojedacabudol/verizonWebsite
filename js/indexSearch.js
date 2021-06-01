$(() => {
    $("#forsaleBtn").click(function () {
        document.getElementById("forsaleBtn").classList.remove('btn-secondary');
        document.getElementById("forsaleBtn").classList.add('btn-primary');
        $("#offertype").val("Sell")

        // document.getElementById("forrentBtn").classList.remove('gradient-bg');
        document.getElementById("forrentBtn").classList.add('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-secondary');
    })

    $("#forrentBtn").click(function () {
        document.getElementById("forrentBtn").classList.remove('btn-secondary');
        document.getElementById("forrentBtn").classList.add('btn-primary');
        $("#offertype").val("Rent")

        // document.getElementById("forsaleBtn").classList.remove('btn-primary');
        document.getElementById("forsaleBtn").classList.add('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-secondary');

    })


    $("#presellingBtn").click(function () {
        document.getElementById("presellingBtn").classList.remove('btn-secondary');
        document.getElementById("presellingBtn").classList.add('btn-primary');
        $("#offertype").val("Presell")

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







});