function subCategoryDisplay(value) {
    var subCategory = $("#subCategory");
    if (value === "Building" || value === "Condominium") {
        //show building sub category
        //append property Brgy address to select tag
        subCategory.empty();
        var selectedCommercialSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Commercial");
        selectedCommercialSubCategory.setAttribute("value", "Commercial");
        selectedCommercialSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedCommercialSubCategory);

        var selectedResidentialSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Residential");
        selectedResidentialSubCategory.setAttribute("value", "Residential");
        selectedResidentialSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedResidentialSubCategory);

        //unhide the sub category holder
        $("#subCategoryHolder").removeClass("hidden");

    } else if (value === "Lot") {
        //show lot sub category
        subCategory.empty();
        var selectedAgriculturalSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Agricultural");
        selectedAgriculturalSubCategory.setAttribute("value", "Agricultural");
        selectedAgriculturalSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedAgriculturalSubCategory);


        var selectedCommercialSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Commercial");
        selectedCommercialSubCategory.setAttribute("value", "Commercial");
        selectedCommercialSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedCommercialSubCategory);

        var selectedResidentialSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Residential");
        selectedResidentialSubCategory.setAttribute("value", "Residential");
        selectedResidentialSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedResidentialSubCategory);



        var selectedIndustrialSubCategory = document.createElement("OPTION");
        var selectedSubCategoryText = document.createTextNode("Industrial");
        selectedIndustrialSubCategory.setAttribute("value", "Industrial");
        selectedIndustrialSubCategory.appendChild(selectedSubCategoryText);
        subCategory.append(selectedIndustrialSubCategory);

        //unhide the sub category holder
        $("#subCategoryHolder").removeClass("hidden");
    } else {
        //hide the sub category holder
        $("#subCategoryHolder").addClass("hidden");
    }
}






// $("#propertySearchForm").submit(function (event) {
//     event.preventDefault();
//     var formData = new FormData(this);

//     formData.append("submit", "ePropertySubmit");
//     // for (var value of formData.keys()) {
//     //     console.log(value);
//     // }

//     $.ajax({
//         url: "includes/fullpropertysearch.inc.php",
//         data: formData,
//         processData: false,
//         contentType: false,
//         success: function (propertyInformation) {

//             console.log(propertyInformation);
//         },
//         error: function (data) {

//         }
//     });
// })