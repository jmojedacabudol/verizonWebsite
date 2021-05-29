$(document).ready(function () {

  //<----------------PROPERTIES------------------->

  $('#properties tfoot th').each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
  });


  var table = $('#properties').DataTable({
    responsive: true,
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

    //LOAD PROPERTY TO EDIT PROPERTY MODAL

    $.ajax({
      url: "includes/propertyloadedit.inc.php",
      data: {
        "propertyId": propertyid
      },
      type: "POST",
      dataType: "json",
      success: function (propertyInformation) {
        Swal.close();
        //LOAD INFORMATIONS TO MODAL

        //declare the propertytype
        //this property will be used for displaying different property information
        var propertyType = propertyInformation[0].propertytype;

        //declare all inputs
        var listingTitle = document.querySelector("#eListingTitle");
        var listingType = document.querySelector("#eListingType");
        var listingUnitNo = document.querySelector("#eListingUnitNo");
        var listingSubCategory = document.querySelector("#eListingSubCategory");
        var listingOfferType = document.querySelector("#eListingOfferType");
        var listingRentChoice = document.querySelector("#eListingRentChoice");
        var listingPrice = document.querySelector("#eListingPrice");
        var listingLotArea = document.querySelector("#eListingLotArea");
        var listingFloorArea = document.querySelector("#eListingFloorArea");
        var listingBedrooms = document.querySelector("#eListingBedrooms");
        var listingCapacityOfGarage = document.querySelector("#eListingCapacityOfGarage");
        var listingDesc = document.querySelector("#eListingDesc");
        var listingRFUB = document.querySelector("#eListingRFUB");
        var listingHLB = document.querySelector("#eListingHLB");
        var listingStreet = document.querySelector("#eListingStreet");
        var listingSubdivision = document.querySelector("#eListingSubdivision");
        var listingBrgyAddress = document.querySelector("#eListingBrgyAddress");
        var listingCityAddress = document.querySelector("#eListingCityAddress");

        //rent option input
        var listingRentChoice = document.querySelector("listingRentChoice");

        //show edit property modal
        $("#editPropertyModal").modal('show');







        //use modal function to load data into the modal before showing
        $("#editPropertyModal").on('shown.bs.modal', function () {

          //load the property current Images
          $("#propertyImgs").load('includes/propertyloadeditimg.inc.php', {
            propertyId: propertyid
          });

          //insert the value from database to its corresponding value

          listingTitle.value = propertyInformation[0].propertyname;
          listingType.value = propertyType;

          //CONDITIONS FOR EACH PROPERTY TYPE

          if (propertyType === "Building") {
            //building will have 2 sub category (commercial,residential)


            //trigger the onchange in input tag of property type
            var event = new Event('change');
            listingType.dispatchEvent(event);

            listingSubCategory.value = propertyInformation[0].subcategory;


            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);

            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;
            listingDesc.value = propertyInformation[0].propertydesc;

            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();
            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");

          } else if (propertyType === "Condominium") {
            //Condominium have No. of bedrooms and garage capacity
            //also have unitNo

            //trigger the onchange in input tag of property type
            var event = new Event('change');
            listingType.dispatchEvent(event);

            listingUnitNo.value = propertyInformation[0].unitNo;
            listingSubCategory.value = propertyInformation[0].subcategory;

            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);

            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;
            listingBedrooms.value = propertyInformation[0].propertybedrooms;
            listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
            listingDesc.value = propertyInformation[0].propertydesc;


            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();

            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");


          } else if (propertyType === "Lot") {
            listingSubCategory.value = propertyInformation[0].subcategory;

            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);

            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;
            listingDesc.value = propertyInformation[0].propertydesc;

            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();
            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");


          } else if (propertyType === "House and Lot") {
            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);
            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;
            listingBedrooms.value = propertyInformation[0].propertybedrooms;
            listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
            listingDesc.value = propertyInformation[0].propertydesc;


            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();
            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");

          } else if (propertyType === "Warehouse") {
            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);

            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;

            listingDesc.value = propertyInformation[0].propertydesc;


            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();
            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");


          } else if (propertyType === "Office") {
            listingOfferType.value = propertyInformation[0].offertype;
            //trigger the onchange in input tag of offertype
            var event = new Event('change');
            listingOfferType.dispatchEvent(event);

            listingPrice.value = propertyInformation[0].propertyamount;
            //check if property is for Rent 
            if (propertyInformation[0].offertype == "Rent") {
              //RENT BUTTON BEHAVIOR
              //change the color of buttons base from propertyrentchoice
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
              $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

              listingRentChoice.value = propertyInformation[0].propertyrentchoice;

              //trigger on click in rent buttons
              var rentButtons = document.querySelectorAll("#eDailyBtn,#eWeeklyBtn,#eMonthlyBtn");
              var buttonEvent = new Event('click');
              rentButtons.dispatchEvent(buttonEvent);

            }

            listingLotArea.value = propertyInformation[0].propertylotarea;
            listingFloorArea.value = propertyInformation[0].propertyfloorarea;
            listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
            listingDesc.value = propertyInformation[0].propertydesc;


            //display the ATS file
            //NOTE: Javascript dont have glob function so just display file icon and the name of file

            var ATSFile = $("#eATSFile");
            //clear first the container to prevent multiple entry
            ATSFile.empty();

            var ATSImg = document.createElement("img");
            ATSImg.src = 'assets/img/file.png'
            ATSImg.style.height = "100px";
            ATSImg.style.width = "100px";
            ATSImg.style.marginLeft = "15px";
            ATSImg.style.cursor = "pointer";
            ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
            //append the img to container name "ATSFile"
            ATSFile.append(ATSImg);


            var ATSDesc = $("#eATSDesc");
            ATSDesc.empty();
            //get the information of file besid its picture
            var fileInformation = document.createElement("p");
            var fileInformationText = document.createTextNode(`File Name: ${ propertyInformation[0].ATSFile}`);
            fileInformation.append(fileInformationText);
            ATSDesc.append(fileInformation);

            //hide the button for adding file
            $("#eAddATSBtn").addClass("hidden");

            //show the note for changing ATS file
            $("#eAddATSNote").removeClass("hidden");


          }

          //load Complete Address
          listingRFUB.value = propertyInformation[0].RoomFloorUnitNoBuilding;
          listingHLB.value = propertyInformation[0].HouseLotBlockNo;
          listingStreet.value = propertyInformation[0].street;
          listingSubdivision.value = propertyInformation[0].subdivision;


          //append property Brgy address to select tag
          var selectedClientBrgyAddress = document.createElement("OPTION");
          var selectedClientBrgyTextAddress = document.createTextNode(propertyInformation[0].barangay);
          selectedClientBrgyAddress.setAttribute("value", propertyInformation[0].barangay);
          selectedClientBrgyAddress.appendChild(selectedClientBrgyTextAddress);
          listingBrgyAddress.append(selectedClientBrgyAddress);


          //append property City address to select tag
          var selectedCompanyCityAddress = document.createElement("OPTION");
          var selectedCompanyCityTextAddress = document.createTextNode(propertyInformation[0].city);
          selectedCompanyCityAddress.setAttribute("value", propertyInformation[0].city);
          selectedCompanyCityAddress.appendChild(selectedCompanyCityTextAddress);
          listingCityAddress.append(selectedCompanyCityAddress);


          //load the select2 API for brgy address and city address
          $("#eListingBrgyAddress").select2({
            placeholder: "Select a Barangay",
            allowClear: true,
            ajax: {
              url: "includes/selectbrgy.inc.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  searchTerm: params.term // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response

                };
              },
              cache: true
            }
          });


          $("#eListingCityAddress").select2({
            placeholder: "Select a City",
            allowClear: true,
            ajax: {
              url: "includes/selectcity.inc.php",
              type: "post",
              dataType: 'json',
              delay: 250,
              data: function (params) {
                return {
                  searchTerm: params.term // search term
                };
              },
              processResults: function (response) {
                return {
                  results: response

                };
              },
              cache: true
            }
          });

        });
      },
      error: function (data) {
        alert(data);
      },
    });
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



  $("#epropertyForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("ePropertyId", localStorage.getItem('selectedProperty'));

    formData.append("submit", "eListing-submit");

    // for (var value of formData.keys()) {
    //   console.log(value);
    // }

    //no Validation for subdivision, it can be empty

    var listingImg = document.querySelector("#eListingImg");
    var listingTitle = formData.get("eListingTitle");
    var listingType = formData.get("eListingType");
    var listingUnitNo = formData.get("eListingUnitNo");
    var listingSubCategory = formData.get("eListingSubCategory");
    var listingOfferType = formData.get("eListingOfferType");
    var listingRentChoice = formData.get("eListingRentChoice");
    var listingPrice = formData.get("eListingPrice");
    var listingLotArea = formData.get("eListingLotArea");
    var listingFloorArea = formData.get("eListingFloorArea");
    var listingBedrooms = formData.get("eListingBedrooms");
    var listingCapacityOfGarage = formData.get("eListingCapacityOfGarage");
    var listingDesc = formData.get("eListingDesc");
    var listingATS = document.querySelector("#eListingATS");
    var listingRFUB = formData.get("eListingRFUB");
    var listingHLB = formData.get("eListingHLB");
    var listingStreet = formData.get("eListingStreet");
    var listingBrgyAddress = formData.get("eListingBrgyAddress");
    var listingCityAddress = formData.get("eListingCityAddress");

    //rent option input
    var listingRentChoice = formData.get("eListingRentChoice");

    if (ePropertyImgValidation(listingImg)) {
      if (eListingNameValidation(listingTitle)) {
        if (ePropertyTypeValidation(listingType)) {
          if (listingType === "Building" || listingType === "Lot") {
            //if building is the type of property
            //No. of Bedrooms, Capacity of Garage and unitNo are  not included  
            //start with sub category
            if (ePropertySubCategoryValidation(listingSubCategory)) {
              if (ePropertyOfferTypeValidation(listingOfferType)) {
                //check listing offer for rent option(daily,weekly,monthly) validation
                if (listingOfferType === "Rent") {
                  if (ePropertyPriceRentValidation(listingRentChoice)) {
                    if (ePropertyPriceValidation(listingPrice)) {
                      if (ePropertyLotAreaValidation(listingLotArea)) {
                        if (ePropertyFloorAreaValidation(listingFloorArea)) {
                          if (ePropertyDescValidation(listingDesc)) {
                            if (ePropertyATSFileValidation(listingATS)) {
                              if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                if (eStreetValidation(listingStreet)) {
                                  if (eBrgyValidation(listingBrgyAddress)) {
                                    if (eClientCityValidation(listingCityAddress)) {
                                      $("#propertyUploadAlert").html('');
                                      //Building Rent
                                      Swal.fire({
                                        icon: "warning",
                                        title: "Are you sure about all Property details?",
                                        text: "Please double check information before submitting",
                                        showCancelButton: true,
                                        cancelButtonText: "Close",
                                        confirmButtonText: "Submit",
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
                                          //insert the property to database
                                          $.ajax({
                                            url: "includes/propertyupload.inc.php",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            type: "POST",
                                            success: function (data) {
                                              Swal.close();
                                              console.log(data)
                                              // if (data = "Property Submitted") {
                                              //   Swal.fire({
                                              //     icon: "success",
                                              //     title: "Property Uploaded",
                                              //     text: data,
                                              //     showConfirmButton: false,
                                              //     allowOutsideClick: false,
                                              //     timer: 2000
                                              //   }).then(function (result) {
                                              //     location.reload();
                                              //   });
                                              // }
                                            },
                                            error: function (data) {
                                              alert(data);
                                            },
                                          });
                                        }
                                      });
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                } else {
                  //else it is either sell or presell
                  if (ePropertyPriceValidation(listingPrice)) {
                    if (ePropertyLotAreaValidation(listingLotArea)) {
                      if (ePropertyFloorAreaValidation(listingFloorArea)) {
                        if (ePropertyDescValidation(listingDesc)) {
                          if (ePropertyATSFileValidation(listingATS)) {
                            if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                              if (eStreetValidation(listingStreet)) {
                                if (eBrgyValidation(listingBrgyAddress)) {
                                  if (eClientCityValidation(listingCityAddress)) {
                                    $("#propertyUploadAlert").html('');
                                    //Building Rent
                                    Swal.fire({
                                      icon: "warning",
                                      title: "Are you sure about all Property details?",
                                      text: "Please double check information before submitting",
                                      showCancelButton: true,
                                      cancelButtonText: "Close",
                                      confirmButtonText: "Submit",
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
                                        //insert the property to database
                                        $.ajax({
                                          url: "includes/propertyupload.inc.php",
                                          data: formData,
                                          processData: false,
                                          contentType: false,
                                          type: "POST",
                                          success: function (data) {
                                            Swal.close();
                                            console.log(data)
                                            // Swal.fire({
                                            //   icon: "success",
                                            //   title: "Property Uploaded",
                                            //   text: data,
                                            //   showConfirmButton: false,
                                            //   allowOutsideClick: false,
                                            //   timer: 2000
                                            // }).then(function (result) {
                                            //   location.reload();
                                            // });
                                          },
                                          error: function (data) {
                                            alert(data);
                                          },
                                        });
                                      }
                                    });
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          } else if (listingType === "Condominium") {
            //if condominium is the type of property
            //additional "unit No"
            if (ePropertyUnitNoValidation(listingUnitNo)) {
              if (ePropertySubCategoryValidation(listingSubCategory)) {
                if (ePropertyOfferTypeValidation(listingOfferType)) {
                  //check listing offer for "rent" option(daily,weekly,monthly) validation
                  if (listingOfferType === "Rent") {
                    if (ePropertyPriceRentValidation(listingRentChoice)) {
                      if (ePropertyPriceValidation(listingPrice)) {
                        if (ePropertyLotAreaValidation(listingLotArea)) {
                          if (ePropertyFloorAreaValidation(listingFloorArea)) {
                            if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                              if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                                if (ePropertyDescValidation(listingDesc)) {
                                  if (ePropertyATSFileValidation(listingATS)) {
                                    if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                      if (eStreetValidation(listingStreet)) {
                                        if (eBrgyValidation(listingBrgyAddress)) {
                                          if (eClientCityValidation(listingCityAddress)) {
                                            $("#propertyUploadAlert").html('');
                                            //Building Rent
                                            Swal.fire({
                                              icon: "warning",
                                              title: "Are you sure about all Property details?",
                                              text: "Please double check information before submitting",
                                              showCancelButton: true,
                                              cancelButtonText: "Close",
                                              confirmButtonText: "Submit",
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
                                                //insert the property to database
                                                $.ajax({
                                                  url: "includes/propertyupload.inc.php",
                                                  data: formData,
                                                  processData: false,
                                                  contentType: false,
                                                  type: "POST",
                                                  success: function (data) {
                                                    Swal.close();
                                                    console.log(data)
                                                    // Swal.fire({
                                                    //   icon: "success",
                                                    //   title: "Property Uploaded",
                                                    //   text: data,
                                                    //   showConfirmButton: false,
                                                    //   allowOutsideClick: false,
                                                    //   timer: 2000
                                                    // }).then(function (result) {
                                                    //   location.reload();
                                                    // });
                                                  },
                                                  error: function (data) {
                                                    alert(data);
                                                  },
                                                });
                                              }
                                            });
                                          }
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  } else {
                    //else it is either sell or presell
                    if (ePropertyPriceValidation(listingPrice)) {
                      if (ePropertyLotAreaValidation(listingLotArea)) {
                        if (ePropertyFloorAreaValidation(listingFloorArea)) {
                          if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                            if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                              if (ePropertyDescValidation(listingDesc)) {
                                if (ePropertyATSFileValidation(listingATS)) {
                                  if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                    if (eStreetValidation(listingStreet)) {
                                      if (eBrgyValidation(listingBrgyAddress)) {
                                        if (eClientCityValidation(listingCityAddress)) {
                                          $("#propertyUploadAlert").html('');
                                          //Building Rent
                                          Swal.fire({
                                            icon: "warning",
                                            title: "Are you sure about all Property details?",
                                            text: "Please double check information before submitting",
                                            showCancelButton: true,
                                            cancelButtonText: "Close",
                                            confirmButtonText: "Submit",
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
                                              //insert the property to database
                                              $.ajax({
                                                url: "includes/propertyupload.inc.php",
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                type: "POST",
                                                success: function (data) {
                                                  Swal.close();
                                                  console.log(data)
                                                  // Swal.fire({
                                                  //   icon: "success",
                                                  //   title: "Property Uploaded",
                                                  //   text: data,
                                                  //   showConfirmButton: false,
                                                  //   allowOutsideClick: false,
                                                  //   timer: 2000
                                                  // }).then(function (result) {
                                                  //   if (result.value) {
                                                  //     location.reload();
                                                  //   }
                                                  // });
                                                },
                                                error: function (data) {
                                                  alert(data);
                                                },
                                              });
                                            }
                                          });
                                        }
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

          } else if (listingType === "House and Lot") {
            //if house and lot is the type of property
            //no "unit No", sub category
            if (ePropertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (ePropertyPriceRentValidation(listingRentChoice)) {
                  if (ePropertyPriceValidation(listingPrice)) {
                    if (ePropertyLotAreaValidation(listingLotArea)) {
                      if (ePropertyFloorAreaValidation(listingFloorArea)) {
                        if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                          if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                            if (ePropertyDescValidation(listingDesc)) {
                              if (ePropertyATSFileValidation(listingATS)) {
                                if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                  if (eStreetValidation(listingStreet)) {
                                    if (eBrgyValidation(listingBrgyAddress)) {
                                      if (eClientCityValidation(listingCityAddress)) {
                                        $("#propertyUploadAlert").html('');
                                        //Building Rent
                                        Swal.fire({
                                          icon: "warning",
                                          title: "Are you sure about all Property details?",
                                          text: "Please double check information before submitting",
                                          showCancelButton: true,
                                          cancelButtonText: "Close",
                                          confirmButtonText: "Submit",
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
                                            //insert the property to database
                                            $.ajax({
                                              url: "includes/propertyupload.inc.php",
                                              data: formData,
                                              processData: false,
                                              contentType: false,
                                              type: "POST",
                                              success: function (data) {
                                                Swal.close();
                                                console.log(data)
                                                // Swal.fire({
                                                //   icon: "success",
                                                //   title: "Property Uploaded",
                                                //   text: data,
                                                //   showConfirmButton: false,
                                                //   allowOutsideClick: false,
                                                //   timer: 2000
                                                // }).then(function (result) {
                                                //   location.reload();
                                                // });
                                              },
                                              error: function (data) {
                                                alert(data);
                                              },
                                            });
                                          }
                                        });
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }

              } else {
                //else it is either sell or presell
                if (ePropertyPriceValidation(listingPrice)) {
                  if (ePropertyLotAreaValidation(listingLotArea)) {
                    if (ePropertyFloorAreaValidation(listingFloorArea)) {
                      if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                        if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                          if (ePropertyDescValidation(listingDesc)) {
                            if (ePropertyATSFileValidation(listingATS)) {
                              if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                if (eStreetValidation(listingStreet)) {
                                  if (eBrgyValidation(listingBrgyAddress)) {
                                    if (eClientCityValidation(listingCityAddress)) {
                                      $("#propertyUploadAlert").html('');
                                      //Building Rent
                                      Swal.fire({
                                        icon: "warning",
                                        title: "Are you sure about all Property details?",
                                        text: "Please double check information before submitting",
                                        showCancelButton: true,
                                        cancelButtonText: "Close",
                                        confirmButtonText: "Submit",
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
                                          //insert the property to database
                                          $.ajax({
                                            url: "includes/propertyupload.inc.php",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            type: "POST",
                                            success: function (data) {
                                              Swal.close();
                                              console.log(data)
                                              // Swal.fire({
                                              //   icon: "success",
                                              //   title: "Property Uploaded",
                                              //   text: data,
                                              //   showConfirmButton: false,
                                              //   allowOutsideClick: false,
                                              //   timer: 2000
                                              // }).then(function (result) {
                                              //   location.reload();
                                              // });
                                            },
                                            error: function (data) {
                                              alert(data);
                                            },
                                          });
                                        }
                                      });
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }


          } else if (listingType === "Office") {
            //if office is the type of property
            //no "Unit No",no "sub category" and no "No of Bedrooms"
            if (ePropertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (ePropertyPriceRentValidation(listingRentChoice)) {
                  if (ePropertyPriceValidation(listingPrice)) {
                    if (ePropertyLotAreaValidation(listingLotArea)) {
                      if (ePropertyFloorAreaValidation(listingFloorArea)) {
                        if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                          if (ePropertyDescValidation(listingDesc)) {
                            if (ePropertyATSFileValidation(listingATS)) {
                              if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                if (eStreetValidation(listingStreet)) {
                                  if (eBrgyValidation(listingBrgyAddress)) {
                                    if (eClientCityValidation(listingCityAddress)) {
                                      $("#propertyUploadAlert").html('');
                                      //Building Rent
                                      Swal.fire({
                                        icon: "warning",
                                        title: "Are you sure about all Property details?",
                                        text: "Please double check information before submitting",
                                        showCancelButton: true,
                                        cancelButtonText: "Close",
                                        confirmButtonText: "Submit",
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
                                          //insert the property to database
                                          $.ajax({
                                            url: "includes/propertyupload.inc.php",
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            type: "POST",
                                            success: function (data) {
                                              Swal.close();
                                              console.log(data)
                                              // Swal.fire({
                                              //   icon: "success",
                                              //   title: "Property Uploaded",
                                              //   text: data,
                                              //   showConfirmButton: false,
                                              //   allowOutsideClick: false,
                                              //   timer: 2000
                                              // }).then(function (result) {
                                              //   location.reload();
                                              // });
                                            },
                                            error: function (data) {
                                              alert(data);
                                            },
                                          });
                                        }
                                      });
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              } else {
                //else it is either sell or presell
                if (ePropertyPriceValidation(listingPrice)) {
                  if (ePropertyLotAreaValidation(listingLotArea)) {
                    if (ePropertyFloorAreaValidation(listingFloorArea)) {
                      if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                        if (ePropertyDescValidation(listingDesc)) {
                          if (ePropertyATSFileValidation(listingATS)) {
                            if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                              if (eStreetValidation(listingStreet)) {
                                if (eBrgyValidation(listingBrgyAddress)) {
                                  if (eClientCityValidation(listingCityAddress)) {
                                    $("#propertyUploadAlert").html('');
                                    //Building Rent
                                    Swal.fire({
                                      icon: "warning",
                                      title: "Are you sure about all Property details?",
                                      text: "Please double check information before submitting",
                                      showCancelButton: true,
                                      cancelButtonText: "Close",
                                      confirmButtonText: "Submit",
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
                                        //insert the property to database
                                        $.ajax({
                                          url: "includes/propertyupload.inc.php",
                                          data: formData,
                                          processData: false,
                                          contentType: false,
                                          type: "POST",
                                          success: function (data) {
                                            Swal.close();
                                            console.log(daya)
                                            // Swal.fire({
                                            //   icon: "success",
                                            //   title: "Property Uploaded",
                                            //   text: data,
                                            //   showConfirmButton: false,
                                            //   allowOutsideClick: false,
                                            //   timer: 2000
                                            // }).then(function (result) {
                                            //   location.reload();
                                            // });
                                          },
                                          error: function (data) {
                                            alert(data);
                                          },
                                        });
                                      }
                                    });
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }

          } else if (listingType === "Warehouse") {
            //if house and lot is the type of property
            //no "unit No", "sub category","preselling","No of bedrooms",and no "Capacity of garage"
            if (ePropertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (ePropertyPriceRentValidation(listingRentChoice)) {
                  if (ePropertyPriceValidation(listingPrice)) {
                    if (ePropertyLotAreaValidation(listingLotArea)) {
                      if (ePropertyFloorAreaValidation(listingFloorArea)) {
                        if (ePropertyDescValidation(listingDesc)) {
                          if (ePropertyATSFileValidation(listingATS)) {
                            if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                              if (eStreetValidation(listingStreet)) {
                                if (eBrgyValidation(listingBrgyAddress)) {
                                  if (eClientCityValidation(listingCityAddress)) {
                                    $("#propertyUploadAlert").html('');
                                    //Building Rent
                                    Swal.fire({
                                      icon: "warning",
                                      title: "Are you sure about all Property details?",
                                      text: "Please double check information before submitting",
                                      showCancelButton: true,
                                      cancelButtonText: "Close",
                                      confirmButtonText: "Submit",
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
                                        //insert the property to database
                                        $.ajax({
                                          url: "includes/propertyupload.inc.php",
                                          data: formData,
                                          processData: false,
                                          contentType: false,
                                          type: "POST",
                                          success: function (data) {
                                            Swal.close();
                                            console.log(daya)
                                            // Swal.fire({
                                            //   icon: "success",
                                            //   title: "Property Uploaded",
                                            //   text: data,
                                            //   showConfirmButton: false,
                                            //   allowOutsideClick: false,
                                            //   timer: 2000
                                            // }).then(function (result) {
                                            //   location.reload();
                                            // });
                                          },
                                          error: function (data) {
                                            alert(data);
                                          },
                                        });
                                      }
                                    });
                                  }
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              } else {
                if (ePropertyPriceValidation(listingPrice)) {
                  if (ePropertyLotAreaValidation(listingLotArea)) {
                    if (ePropertyFloorAreaValidation(listingFloorArea)) {
                      if (ePropertyDescValidation(listingDesc)) {
                        if (ePropertyATSFileValidation(listingATS)) {
                          if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                            if (eStreetValidation(listingStreet)) {
                              if (eBrgyValidation(listingBrgyAddress)) {
                                if (eClientCityValidation(listingCityAddress)) {
                                  $("#propertyUploadAlert").html('');
                                  //Building Rent
                                  Swal.fire({
                                    icon: "warning",
                                    title: "Are you sure about all Property details?",
                                    text: "Please double check information before submitting",
                                    showCancelButton: true,
                                    cancelButtonText: "Close",
                                    confirmButtonText: "Submit",
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
                                      //insert the property to database
                                      $.ajax({
                                        url: "includes/propertyupload.inc.php",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        type: "POST",
                                        success: function (data) {
                                          Swal.close();
                                          console.log(daya)
                                          // Swal.fire({
                                          //   icon: "success",
                                          //   title: "Property Uploaded",
                                          //   text: data,
                                          //   showConfirmButton: false,
                                          //   allowOutsideClick: false,
                                          //   timer: 2000
                                          // }).then(function (result) {
                                          //   location.reload();
                                          // });
                                        },
                                        error: function (data) {
                                          alert(data);
                                        },
                                      });
                                    }
                                  });
                                }
                              }
                            }
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    return false;
  });


});

//----------------VALIDATION FUNCTIONS-------------------------

function ePropertyImgValidation(img) {

  if (img.files.length !== 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#propertyImgHolder`).removeClass('input-error');
    return true;
  } else {
    $(`#propertyImgHolder`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Image is Empty!</div>');
    return false;
  }
}


function eListingNameValidation(name) {
  if (name != "") {
    $("#ePropertyUploadAlert").html('');
    $(`#listingTitle`).removeClass('input-error');
    return true;
  } else {
    $(`#listingTitle`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Name is Empty!</div>');
    return false;
  }
}


function ePropertyTypeValidation(propertyType) {
  if (propertyType != "default") {
    $("#ePropertyUploadAlert").html('');
    $(`#listingType`).removeClass('input-error');
    return true;
  } else {
    $(`#listingType`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Type is Empty!</div>');
    return false;
  }
}

function ePropertyUnitNoValidation(unitNo) {
  if (unitNo != "") {
    $("#ePropertyUploadAlert").html('');
    $(`#listingUnitNo`).removeClass('input-error');
    return true;
  } else {
    $(`#listingUnitNo`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Unit Number is Empty!</div>');
    return false;
  }
}

function ePropertySubCategoryValidation(subCategory) {
  if (subCategory != "default") {
    $("#ePropertyUploadAlert").html('');
    $(`#listingSubCategory`).removeClass('input-error');
    return true;
  } else {
    $(`#listingSubCategory`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Sub Listing Category is Empty!</div>');
    return false;
  }
}


function ePropertyOfferTypeValidation(propertyOfferType) {
  if (propertyOfferType != "default") {
    $("#ePropertyUploadAlert").html('');
    $(`#offerType`).removeClass('input-error');
    return true;
  } else {
    $(`#offerType`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Offer Type is Empty!</div>');
    return false;
  }
}

function ePropertyPriceValidation(price) {
  if (price != "" || price != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingPrice`).removeClass('input-error');
    return true;
  } else {
    $(`#listingPrice`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Price is Empty!</div>');
    return false;
  }
}

function ePropertyPriceRentValidation(rentOption) {
  if (rentOption != "") {
    $("#ePropertyUploadAlert").html('');
    $(`#rentBtn`).removeClass('input-error');
    return true;
  } else {
    $(`#rentBtn`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Rent Option is Empty!</div>');
    return false;
  }
}


function ePropertyLotAreaValidation(lotArea) {
  if (lotArea != "" || lotArea != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingLotArea`).removeClass('input-error');
    return true;
  } else {
    $(`#listingLotArea`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Lot Area is Empty!</div>');
    return false;
  }
}

function ePropertyFloorAreaValidation(floorArea) {
  if (floorArea != "" || floorArea != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingFloorArea`).removeClass('input-error');
    return true;
  } else {
    $(`#listingFloorArea`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Floor Area is Empty!</div>');
    return false;
  }
}

function ePropertyNoOfBedroomsValidation(bedrooms) {
  if (bedrooms != "" || bedrooms != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingBedrooms`).removeClass('input-error');
    return true;
  } else {
    $(`#listingBedrooms`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Number of Bedrooms is Empty!</div>');
    return false;
  }
}

function ePropertyCapacityOfGarageValidation(capacityOfGarage) {
  if (capacityOfGarage != "" || capacityOfGarage != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingCapacityOfGarage`).removeClass('input-error');
    return true;
  } else {
    $(`#listingCapacityOfGarage`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Capacity of Garage is Empty!</div>');
    return false;
  }
}

function ePropertyDescValidation(desc) {
  if (desc != "" || desc != 0) {
    $("#ePropertyUploadAlert").html('');
    $(`#listingDesc`).removeClass('input-error');
    return true;
  } else {
    $(`#listingDesc`).addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Propety Description is Empty!</div>');
    return false;
  }
}


function ePropertyATSFileValidation(ATS) {
  var result;
  if (primaryIdHolder.files.length !== 0 && secondaryIdHolder.files.length !== 0) {
    //both primary and secondary Id is not empty
    //show the error in img holder
    $(`#${primartyIdTag}`).removeClass('input-error');
    $(`#${secondIdTag}`).removeClass('input-error');

    if (clientId === "client0") {
      arrayOfClients[0].firstValidIdHolder = primaryIdHolder.files[0];
      arrayOfClients[0].secondValidIdHolder = secondaryIdHolder.files[0];

      result = true;
    } else {
      //clientid = "1"
      arrayOfClients[1].firstValidIdHolder = primaryIdHolder.files[0];
      arrayOfClients[1].firstValidIdHolder = secondaryIdHolder.files[0];
      result = true;
    }

    result = true;

  } else {
    //check if primary Id is not empty
    if (primaryIdHolder.files.length !== 0 && secondaryIdHolder.files.length === 0) {
      // check if the img src of secondary id is in default img which is user.png
      //split first the img src link and filter it to delete empty array objects
      //compare the last file name of img src if it is equal to "user.png"
      var secondId = secondaryImg.split("/").filter(secondaryImg => secondaryImg !== "");

      if (secondId[2] === "user.png") {
        $(`#${secondIdTag}`).addClass('input-error');
        $(`#${primartyIdTag}`).removeClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Secondary Id!</div>');
      }
      //then
      //check the clientid to know where to insert the image
      //insert the value to array of clients primary id
      if (clientId === "client0") {
        arrayOfClients[0].firstValidIdHolder = primaryIdHolder.files[0];
        result = true;
      } else {
        //clientid = "1"
        arrayOfClients[1].firstValidIdHolder = primaryIdHolder.files[0];
        result = true;
      }

    } else if (primaryIdHolder.files.length === 0 && secondaryIdHolder.files.length !== 0) {
      // check if the img src of primary id is in default img which is user.png
      //split first the img src link and filter it to delete empty array objects
      //compare the last file name of img src if it is equal to "user.png"
      var primaryId = primaryImg.split("/").filter(primaryImg => primaryImg !== "");
      if (primaryId[2] === "user.png") {
        $(`#${primartyIdTag}`).addClass('input-error');
        $(`#${secondIdTag}`).removeClass('input-error');
        $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Primary Id!</div>');
      }
      //then
      //insert the value of second Id to array of clients using primary id
      if (clientId === "client0") {
        arrayOfClients[0].secondValidIdHolder = secondaryIdHolder.files[0];
        result = true;
      } else {
        //clientid = "1"
        arrayOfClients[1].firstValidIdHolder = secondaryIdHolder.files[0];
        result = true;
      }


      result = false;
    } else {
      //both are empty and no image will be edit
      $(`#${primartyIdTag}`).addClass('input-error');
      $(`#${secondIdTag}`).addClass('input-error');
      $(`#${alertId}`).html('<div class="alert alert-danger" role="alert">Please provide your Ids!</div>');
      result = false;
    }
  }
  return result;
  // if (ATS.files.length != 0) {
  //   $("#ePropertyUploadAlert").html('');
  //   $(`#clientHolders`).removeClass('input-error');
  //   return true;
  // } else {
  //   $(`#clientHolders`).addClass('input-error');
  //   $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Authority to sell File is Empty!</div>');
  //   return false;
  // }
}


//room/unit No/building
function eRoomUnitNoAndHouseLotValidation(RFUB, HLB) {
  if (RFUB !== "" && HLB !== "") {
    //both room/unit No/building and House Lot and Block is not empty
    $("#listingRFUB").removeClass('input-error');
    $("#listingHLB").removeClass('input-error');
    return true;
  } else if (RFUB === "" && HLB !== "") {
    //Lot and Block is not empty
    $("#listingRFUB").removeClass('input-error');
    $("#listingHLB").removeClass('input-error');
    return true;
  } else if (RFUB !== "" && HLB === "") {
    //room/unit No/building is not empty
    $("#listingRFUB").removeClass('input-error');
    $("#listingHLB").removeClass('input-error');
    return true;
  } else {
    // both client RFUB and client HLB is empty
    $("#listingRFUB").addClass('input-error');
    $("#listingHLB").addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Please provide either Room/Unit No & Building or House/Lot and Bloock!</div>');
    return false;
  }
}


function eStreetValidation(street) {
  // console.log(clientStreet !== "")
  if (street === "") {
    //client street input is empty
    $("#listingStreet").addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Street Address is empty!</div>');
    return false;

  } else {
    $("#listingStreet").removeClass('input-error');
    return true;
  }
}

//barangay address validation
function eBrgyValidation(brgyAddress) {
  if (brgyAddress !== null) {
    //barangay street input is not empty
    $(`.form-control#listingBrgyAddress`).next().find('.select2-selection').removeClass('input-error');
    return true;
  } else {
    $(`.form-control#listingBrgyAddress`).next().find('.select2-selection').addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Barangay Address is empty!</div>');
    return false;
  }
}
//city address validation

function eClientCityValidation(clientCityAddress) {
  if (clientCityAddress !== null) {
    //client city address input is not empty
    $(`.form-control#listingCityAddress`).next().find('.select2-selection').removeClass('input-error');
    return true;
  } else {
    $(`.form-control#listingCityAddress`).next().find('.select2-selection').addClass('input-error');
    $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">City Address is empty!</div>');
    return false;
  }
}




//----------------VALIDATION FUNCTIONS ENDS HERE---------------


//----------------BEHAVIORAL FUNCTIONS-------------

function priceVariations(value) {
  //display the options daily,weekly,monthly
  // console.log(value)
  if (value === "Rent") {
    $("#eRentBtn").removeClass('hidden')
  } else {
    $("#eRentBtn").addClass('hidden');
  }
}


function buttonVariations(buttonClicked) {
  if (buttonClicked == "eDailyBtn") {
    document.getElementById("eDailyBtn").classList.remove('btn-secondary');
    document.getElementById("eDailyBtn").classList.add('btn-primary');
    $("#eListingRentChoice").val("Daily")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("eWeeklyBtn").classList.add('btn-secondary');
    document.getElementById("eMonthlyBtn").classList.add('btn-secondary');
  } else if (buttonClicked == "eWeeklyBtn") {
    document.getElementById("eWeeklyBtn").classList.remove('btn-secondary');
    document.getElementById("eWeeklyBtn").classList.add('btn-primary');
    $("#eListingRentChoice").val("Weekly")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("eDailyBtn").classList.add('btn-secondary');
    document.getElementById("eMonthlyBtn").classList.add('btn-secondary');

  } else if (buttonClicked == "eMonthlyBtn") {
    document.getElementById("eMonthlyBtn").classList.remove('btn-secondary');
    document.getElementById("eMonthlyBtn").classList.add('btn-primary');
    $("#eListingRentChoice").val("Monthly")

    // document.getElementById("forrentBtn").classList.remove('gradient-bg');
    document.getElementById("eWeeklyBtn").classList.add('btn-secondary');
    document.getElementById("eDailyBtn").classList.add('btn-secondary');
  }
}


function allVariations(value) {
  // console.log(value)
  //get the property type
  var propertyType = value;
  //building will have 2 sub category (commercial,residential)
  if (propertyType === "Building") {

    //hide unit No for Building
    $("#eUnitNoHolder").addClass("hidden");

    //clear the select parent
    $("#eListingSubCategory").empty();

    //create 1st option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);

    //append commercial to select tag parent
    $("#eListingSubCategory").append(commercialCatergory);

    //create 2nd option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);

    //append residential to select tag parent
    $("#eListingSubCategory").append(residentialCategory);

    // unhide the sub category 
    $("#eSubCategoryHolder").removeClass('hidden');

    //OFFERTYPE VARIATION
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#eListingOfferType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#eListingOfferType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------



    // No. of Bedrooms and capacity of Garage Variation
    //building dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#eNoOfBedroomsHolder").addClass("hidden");
    $("#eCapacityOfGarageHolder").addClass("hidden");

    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Condominium") {

    //clear the select parent
    $("#eListingSubCategory").empty();

    //create 1st option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);

    //append commercial to select tag parent
    $("#eListingSubCategory").append(commercialCatergory);

    //create 2nd option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);

    //append residential to select tag parent
    $("#eListingSubCategory").append(residentialCategory);

    // unhide the sub category 
    $("#eSubCategoryHolder").removeClass('hidden');
    //show unit No for Condominium
    $("#unitNoHolder").removeClass("hidden");

    //OFFERTYPE VARIATION
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#eListingOfferType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#eListingOfferType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------


    // No. of Bedrooms and capacity of Garage Variation
    //Condominium have No. of bedrooms and garage capacity
    //dont hide those inputs
    $("#eNoOfBedroomsHolder").removeClass("hidden");
    $("#eCapacityOfGarageHolder").removeClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here

  } else if (propertyType === "Lot") {

    //lot will have 4 sub category (industrial,commercial,agricultural,residential)

    //hide unit No for Lot
    $("#eUnitNoHolder").addClass("hidden");

    //clear the select parent
    $("#eListingSubCategory").empty();

    //create 1st option "Agricultural"
    var agriculturalCatergory = document.createElement("OPTION");
    var agriculturalCatergoryText = document.createTextNode("Agricultural");
    agriculturalCatergory.setAttribute("value", "Agricultural");
    agriculturalCatergory.appendChild(agriculturalCatergoryText);

    //append agricultural to select tag parent
    $("#eListingSubCategory").append(agriculturalCatergory);


    //create 2nd option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);
    //append commercial to select tag parent
    $("#eListingSubCategory").append(commercialCatergory);

    //create 3rd option "industrial"
    var industrialCatergory = document.createElement("OPTION");
    var industrialCatergoryText = document.createTextNode("Industrial");
    industrialCatergory.setAttribute("value", "Industrial");
    industrialCatergory.appendChild(industrialCatergoryText);

    //append commercial to select tag parent
    $("#eListingSubCategory").append(industrialCatergory);

    //create 4th option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);


    //append residential to select tag parent
    $("#eListingSubCategory").append(residentialCategory);


    // unhide the sub category 
    $("#eSubCategoryHolder").removeClass('hidden');


    //OFFERTYPE VARIATION
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#eListingOfferType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#eListingOfferType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------




    // No. of Bedrooms and capacity of Garage Variation
    //Lot dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#eNoOfBedroomsHolder").addClass("hidden");
    $("#eCapacityOfGarageHolder").addClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here



  } else if (propertyType === "House and Lot") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#eSubCategoryHolder").addClass('hidden');
    //hide unit No
    $("#eUnitNoHolder").addClass("hidden");

    //OFFERTYPE VARIATION
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#eListingOfferType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#eListingOfferType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------

    // No. of Bedrooms and capacity of Garage Variation
    //House and Lot have No. of bedrooms and garage capacity
    //dont hide those inputs
    $("#eNoOfBedroomsHolder").removeClass("hidden");
    $("#eCapacityOfGarageHolder").removeClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Warehouse") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#eSubCategoryHolder").addClass('hidden');
    //hide unit No
    $("#eUnitNoHolder").addClass("hidden");



    //OFFERTYPE VARIATION
    //warehouse dont have preselling offertype
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append residential to select tag parent
    $("#eListingOfferType").append(thirdOption);

    //OFERTYPE VARTION ENDS HERE


    // No. of Bedrooms and capacity of Garage Variation
    //Warehouse dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#eNoOfBedroomsHolder").addClass("hidden");
    $("#eCapacityOfGarageHolder").addClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Office") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#subCategoryHolder").addClass('hidden');
    //hide unit No
    $("#eUnitNoHolder").addClass("hidden");


    //OFFERTYPE VARIATION
    //clear the select parent
    $("#eListingOfferType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#eListingOfferType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#eListingOfferType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#eListingOfferType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#eListingOfferType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------


    // No. of Bedrooms and capacity of Garage Variation
    //Office dont have No. of bedrooms but have garage capacity
    //hide No. of Bedrooms input and dont hide capacity of Garage
    $("#eNoOfBedroomsHolder").addClass("hidden");
    $("#eCapacityOfGarageHolder").removeClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here
  }
}

//calculate the file size
function returnFileSize(number) {
  if (number < 1024) {
    return number + 'bytes';
  } else if (number >= 1024 && number < 1048576) {
    return (number / 1024).toFixed(1) + 'KB';
  } else if (number >= 1048576) {
    return (number / 1048576).toFixed(1) + 'MB';
  }
}



function ATSFile(ATS) {
  var ATSDesc = $("#eATSDesc");
  //get create a preview of the img 
  var ATSFile = $("#eATSFile");
  if (ATS.value == "") {
    //show the button for adding file
    $("#eAddATSBtn").removeClass("hidden");

    //hide the note for changing ATS file
    $("#eAddATSNote").addClass("hidden");
    ATSFile.empty();
    ATSDesc.empty();
    Swal.fire({
      icon: "error",
      title: "No File found!",
      text: "Please select a file for your ATS."
    })
  } else {

    //clear first the container to prevent multiple entry
    ATSDesc.empty();
    //check for file extension
    var fileextension = ATS.files[0].type;
    //since input type only accept pdf and pictures

    if (fileextension === "application/pdf") {
      //if it is pdf display a default img
      var ATSFile = $("#eATSFile");
      //clear first the container to prevent multiple entry
      ATSFile.empty();

      var ATSImg = document.createElement("img");
      ATSImg.src = 'assets/img/file.png'
      ATSImg.style.height = "100px";
      ATSImg.style.width = "100px";
      ATSImg.style.marginLeft = "15px";
      ATSImg.style.cursor = "pointer";
      ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
      //append the img to container name "ATSFile"
      ATSFile.append(ATSImg);
    } else {

      //clear first the container to prevent multiple entry
      ATSFile.empty();

      var ATSImg = document.createElement("img");
      ATSImg.src = URL.createObjectURL(ATS.files[0]);
      ATSImg.style.height = "100px";
      ATSImg.style.width = "100px";
      ATSImg.style.marginLeft = "15px";
      ATSImg.style.cursor = "pointer";
      ATSImg.setAttribute("onclick", `document.querySelector("#eListingATS").click()`);
      //append the img to container name "ATSFile"
      ATSFile.append(ATSImg);
    }


    //get the information of file besid its picture
    var fileInformation = document.createElement("p");
    var fileInformationText = document.createTextNode(`File Name: ${ ATS.files[0].name}`);
    fileInformation.append(fileInformationText);
    ATSDesc.append(fileInformation);

    var fileSize = document.createElement("p");
    var fileSizeText = document.createTextNode(`Size:  ${returnFileSize(ATS.files[0].size)}`);
    fileSize.append(fileSizeText);
    ATSDesc.append(fileSize);

    //hide the button for adding file
    $("#eAddATSBtn").addClass("hidden");

    //show the note for changing ATS file
    $("#eAddATSNote").removeClass("hidden");
  }
}