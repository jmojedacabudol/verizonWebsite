$(() => {
    var data = localStorage.getItem('propertyResult');
    if (data !== undefined) {
        // console.log(data)
        $("#propertiesContainer").html(data);

    }
})