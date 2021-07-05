 var table;

 $(document).ready(function () {

   //<----------------PROPERTIES------------------->
   $('#properties tfoot th').each(function () {
     var title = $(this).text();
     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
   });

   var table = $('#properties').DataTable({

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
       titleAttr: 'Export as CSV',
       title: "Property Listing",
       text: '<i class="fas fa-file-csv"></i>',
       exportOptions: {
         columns: ':not(.notexport)'
       },

     }, {

       extend: 'print',
       className: 'btn btn-primary ',
       titleAttr: 'PRINT',
       title: "Property Listing",
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

       var r = $('#members tfoot tr');
       r.find('th').each(function () {
         $(this).css('padding', 8);
       });
       $('#members thead').append(r);
       $('#search_0').css('text-align', 'center')
     }
   });

   $("#properties").on("click", "#approveBtn", function () {
     var data = table.row($(this).parents("tr")).data();
     var propertyid = data[0];

     approveProperty(propertyid);

   });



   $("#properties").on("click", "#denyBtn", function () {
     var data = table.row($(this).parents("tr")).data();
     var propertyid = data[0];
     Swal.fire({
       icon: "error",
       title: "Do you want to deny this property?",
       showCancelButton: true,
       confirmButtonText: "Yes",
       cancelButtonText: "No",
     }).then((result) => {
       if (result.value) {
         $.post('includes/denyproperty.inc.php', {
             propertyId: propertyid,
           },
           function (returnedData) {
             // console.log(returnedData)
             switch (returnedData) {
               case "Already Denied":
                 Swal.fire({
                   icon: "info",
                   title: "This property has bee already denied",
                   text: "You may delete this property.",
                   showCancelButton: true,
                   confirmButtonColor: "#d33",
                   cancelButtonColor: "#3085d6",
                   confirmButtonText: "Delete",
                 }).then((result) => {
                   if (result.value) {
                     $.post('includes/deleteproperty.inc.php', {
                         propertyId: propertyid,
                       },
                       function (returnedData) {
                         Swal.fire({
                           icon: "success",
                           title: returnedData
                         }).then((result) => {
                           if (result.value) {
                             location.reload();
                           }
                         })
                       }).fail(function () {
                       console.log("error");
                     });
                   }
                 })
                 break;
               case "Listing Denied":
                 Swal.fire({
                   icon: "success",
                   title: "Listing Denied"
                 }).then(result => {
                   if (result.value) {
                     location.reload();
                   }
                 })
                 break;
             }
           }).fail(function () {
           console.log("error");
         });
       }
     });
   });



   $("#properties").on("click", "#viewBtn", function () {
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

     $("#approvelisting").click(function () {
       Swal.fire({
         icon: "warning",
         title: "Do you want to approve this property?",
         showCancelButton: true,
         confirmButtonText: "Yes",
         cancelButtonText: "No",
       }).then((result) => {
         if (result.value) {
           $.post('includes/approveproperty.inc.php', {
               propertyId: propertyid,
             },
             function (returnedData) {
               switch (returnedData) {
                 case "Already Approved":
                   Swal.fire({
                     icon: "info",
                     title: "This property has been already approved",
                     showCancelButton: true,
                     confirmButtonText: "Yes",
                     cancelButtonText: "No",
                   })
                   break;
                 case "Listing Approved":
                   Swal.fire({
                     icon: "success",
                     title: "Listing Approved",
                     showCancelButton: true,
                     confirmButtonText: "Yes",
                     cancelButtonText: "Close",
                   })
                   break;
               }
             }).fail(function () {
             console.log("error");
           });
         }
       });
     })

     $("#denylisting").click(function () {
       Swal.fire({
         icon: "error",
         title: "Do you want to deny this property?",
         showCancelButton: true,
         confirmButtonText: "Yes",
         cancelButtonText: "No",
       }).then((result) => {
         if (result.value) {
           $.post('includes/denyproperty.inc.php', {
               propertyId: propertyid,
             },
             function (returnedData) {
               // console.log(returnedData)
               switch (returnedData) {
                 case "Already Denied":
                   Swal.fire({
                     icon: "info",
                     title: "This property has been denied",
                     text: "You may delete this property.",
                     showCancelButton: true,
                     confirmButtonColor: "#d33",
                     cancelButtonColor: "#3085d6",
                     confirmButtonText: "Delete",
                   }).then((result) => {
                     if (result.value) {
                       $.post('includes/deleteproperty.inc.php', {
                           propertyId: propertyid,
                         },
                         function (returnedData) {
                           Swal.fire({
                             icon: "success",
                             title: returnedData
                           }).then((result) => {
                             if (result.value) {
                               window.location.reload();
                             }
                           })
                         }).fail(function () {
                         console.log("error");
                       });
                     }
                   })
                   break;
                 case "Listing Denied":
                   Swal.fire({
                     icon: "success",
                     title: "Listing Denied"
                   })
                   break;
               }
             }).fail(function () {
             console.log("error");
           });
         }
       });
     })
   });

   $("#properties").on("click", "#editBtn", function () {
     var data = table.row($(this).parents("tr")).data();
     var propertyid = data[0];

     localStorage.setItem('selectedProperty', propertyid);
     editProperty(propertyid);

   });

 });

 function editProperty(propertyid) {
   Swal.fire({
     text: "Please wait....",
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
       // var listingOfferType = document.querySelector("#eListingOfferType");
       // var listingRentChoice = document.querySelector("#eListingRentChoice");
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
       var listingRentChoice = document.querySelector("#eListingRentChoice");

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

         //trigger the onchange in input tag of property type
         var event = new Event('change');
         listingType.dispatchEvent(event);


         //CONDITIONS FOR EACH PROPERTY TYPE

         if (propertyType === "Building") {
           //building will have 2 sub category (commercial,residential)

           listingSubCategory.value = propertyInformation[0].subcategory;

           var holder = $("#ePropertyOfferType");
           holder.empty();
           var selectList = document.createElement("select");
           selectList.id = "eListingOfferType";
           selectList.name = "eListingOfferType";
           selectList.classList.add('form-control');
           selectList.options[0] = new Option('Sell', 'Sell');
           selectList.options[1] = new Option('Rent', 'Rent');
           selectList.options[2] = new Option('Presell', 'Presell');
           selectList.setAttribute("onchange", 'priceVariations(this.value)');
           holder.append(selectList);


           $("#eListingOfferType").val(propertyInformation[0].offertype).change()


           listingPrice.value = propertyInformation[0].propertyamount;
           // //check if property is for Rent 
           if (propertyInformation[0].offertype == "Rent") {
             $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
             // //RENT BUTTON BEHAVIOR
             // //change the color of buttons base from propertyrentchoice
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

             // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

           }

           listingLotArea.value = propertyInformation[0].propertylotarea;
           listingFloorArea.value = propertyInformation[0].propertyfloorarea;
           listingDesc.value = propertyInformation[0].propertydesc;


           if (propertyInformation[0].ATSFile !== null) {
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
           } else {
             //clear the ATS File if there is no ATS for Property
             var ATSFile = $("#eATSFile");
             var ATSDesc = $("#eATSDesc");
             ATSFile.empty();
             ATSDesc.empty();
           }



         } else if (propertyType === "Condominium") {
           //Condominium have No. of bedrooms and garage capacity
           //also have unitNo


           listingUnitNo.value = propertyInformation[0].unitNo;

           // listingSubCategory.value = 
           $("#eListingSubCategory").val(propertyInformation[0].subcategory).change();

           //check sub category 
           if (propertyInformation[0].subcategory === "Parking") {

             var holder = $("#ePropertyOfferType");
             holder.empty();
             var selectList = document.createElement("select");
             selectList.id = "eListingOfferType";
             selectList.name = "eListingOfferType";
             selectList.classList.add('form-control');
             selectList.options[0] = new Option('Sell', 'Sell');
             selectList.options[1] = new Option('Presell', 'Presell');
             holder.append(selectList);

             $("#eListingOfferType").val(propertyInformation[0].offertype).change()

             listingPrice.value = propertyInformation[0].propertyamount;
             listingLotArea.value = propertyInformation[0].propertylotarea;
             listingDesc.value = propertyInformation[0].propertydesc;



             if (propertyInformation[0].ATSFile !== null) {
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
             } else {
               //clear the ATS File if there is no ATS for Property
               var ATSFile = $("#eATSFile");
               var ATSDesc = $("#eATSDesc");

               ATSFile.empty();
               ATSDesc.empty();

               //hide the button for adding file
               $("#eAddATSBtn").removeClass("hidden");

               //show the note for changing ATS file
               $("#eAddATSNote").addClass("hidden");
             }

           } else {
             //other sub category

             var holder = $("#ePropertyOfferType");
             holder.empty();
             var selectList = document.createElement("select");
             selectList.id = "eListingOfferType";
             selectList.name = "eListingOfferType";
             selectList.classList.add('form-control');
             selectList.options[0] = new Option('Sell', 'Sell');
             selectList.options[1] = new Option('Rent', 'Rent');
             selectList.options[2] = new Option('Presell', 'Presell');
             selectList.setAttribute("onchange", 'priceVariations(this.value)');
             holder.append(selectList);


             $("#eListingOfferType").val(propertyInformation[0].offertype).change()


             listingPrice.value = propertyInformation[0].propertyamount;
             // //check if property is for Rent 
             if (propertyInformation[0].offertype == "Rent") {
               $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
               // //RENT BUTTON BEHAVIOR
               // //change the color of buttons base from propertyrentchoice
               // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
               // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

               // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

             }

             listingLotArea.value = propertyInformation[0].propertylotarea;
             listingFloorArea.value = propertyInformation[0].propertyfloorarea;
             listingBedrooms.value = propertyInformation[0].propertybedrooms;
             listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
             listingDesc.value = propertyInformation[0].propertydesc;


             if (propertyInformation[0].ATSFile !== null) {
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
             } else {
               //clear the ATS File if there is no ATS for Property
               var ATSFile = $("#eATSFile");
               var ATSDesc = $("#eATSDesc");

               ATSFile.empty();
               ATSDesc.empty();

               //hide the button for adding file
               $("#eAddATSBtn").removeClass("hidden");

               //show the note for changing ATS file
               $("#eAddATSNote").addClass("hidden");
             }
           }
         } else if (propertyType === "Lot") {

           listingSubCategory.value = propertyInformation[0].subcategory;

           var holder = $("#ePropertyOfferType");
           holder.empty();
           var selectList = document.createElement("select");
           selectList.id = "eListingOfferType";
           selectList.name = "eListingOfferType";
           selectList.classList.add('form-control');
           selectList.options[0] = new Option('Sell', 'Sell');
           selectList.options[1] = new Option('Rent', 'Rent');
           selectList.options[2] = new Option('Presell', 'Presell');
           selectList.setAttribute("onchange", 'priceVariations(this.value)');
           holder.append(selectList);


           $("#eListingOfferType").val(propertyInformation[0].offertype).change()


           listingPrice.value = propertyInformation[0].propertyamount;
           // //check if property is for Rent 
           if (propertyInformation[0].offertype == "Rent") {
             $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
             // //RENT BUTTON BEHAVIOR
             // //change the color of buttons base from propertyrentchoice
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

             // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

           }

           listingLotArea.value = propertyInformation[0].propertylotarea;
           listingFloorArea.value = propertyInformation[0].propertyfloorarea;
           listingDesc.value = propertyInformation[0].propertydesc;

           if (propertyInformation[0].ATSFile !== null) {
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
           } else {
             //clear the ATS File if there is no ATS for Property
             var ATSFile = $("#eATSFile");
             var ATSDesc = $("#eATSDesc");

             ATSFile.empty();
             ATSDesc.empty();

             //hide the button for adding file
             $("#eAddATSBtn").removeClass("hidden");

             //show the note for changing ATS file
             $("#eAddATSNote").addClass("hidden");
           }

         } else if (propertyType === "House and Lot") {
           var holder = $("#ePropertyOfferType");
           holder.empty();
           var selectList = document.createElement("select");
           selectList.id = "eListingOfferType";
           selectList.name = "eListingOfferType";
           selectList.classList.add('form-control');
           selectList.options[0] = new Option('Sell', 'Sell');
           selectList.options[1] = new Option('Rent', 'Rent');
           selectList.options[2] = new Option('Presell', 'Presell');
           selectList.setAttribute("onchange", 'priceVariations(this.value)');
           holder.append(selectList);


           $("#eListingOfferType").val(propertyInformation[0].offertype).change()


           listingPrice.value = propertyInformation[0].propertyamount;
           // //check if property is for Rent 
           if (propertyInformation[0].offertype == "Rent") {
             $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
             // //RENT BUTTON BEHAVIOR
             // //change the color of buttons base from propertyrentchoice
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

             // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

           }

           listingLotArea.value = propertyInformation[0].propertylotarea;
           listingFloorArea.value = propertyInformation[0].propertyfloorarea;
           listingBedrooms.value = propertyInformation[0].propertybedrooms;
           listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
           listingDesc.value = propertyInformation[0].propertydesc;


           if (propertyInformation[0].ATSFile !== null) {
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
           } else {
             //clear the ATS File if there is no ATS for Property
             var ATSFile = $("#eATSFile");
             var ATSDesc = $("#eATSDesc");

             ATSFile.empty();
             ATSDesc.empty();

             //hide the button for adding file
             $("#eAddATSBtn").removeClass("hidden");

             //show the note for changing ATS file
             $("#eAddATSNote").addClass("hidden");
           }

         } else if (propertyType === "Warehouse") {

           var holder = $("#ePropertyOfferType");
           holder.empty();
           var selectList = document.createElement("select");
           selectList.id = "eListingOfferType";
           selectList.name = "eListingOfferType";
           selectList.classList.add('form-control');
           selectList.options[0] = new Option('Sell', 'Sell');
           selectList.options[1] = new Option('Rent', 'Rent');
           selectList.setAttribute("onchange", 'priceVariations(this.value)');
           holder.append(selectList);


           $("#eListingOfferType").val(propertyInformation[0].offertype).change()


           listingPrice.value = propertyInformation[0].propertyamount;
           // //check if property is for Rent 
           if (propertyInformation[0].offertype == "Rent") {
             $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
             // //RENT BUTTON BEHAVIOR
             // //change the color of buttons base from propertyrentchoice
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

             // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

           }

           listingLotArea.value = propertyInformation[0].propertylotarea;
           listingFloorArea.value = propertyInformation[0].propertyfloorarea;

           listingDesc.value = propertyInformation[0].propertydesc;


           if (propertyInformation[0].ATSFile !== null) {
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
           } else {
             //clear the ATS File if there is no ATS for Property
             var ATSFile = $("#eATSFile");
             var ATSDesc = $("#eATSDesc");

             ATSFile.empty();
             ATSDesc.empty();

             //hide the button for adding file
             $("#eAddATSBtn").removeClass("hidden");

             //show the note for changing ATS file
             $("#eAddATSNote").addClass("hidden");
           }

         } else if (propertyType === "Office") {

           var holder = $("#ePropertyOfferTypeHolder");
           holder.empty();
           var selectList = document.createElement("select");
           selectList.id = "eListingOfferType";
           selectList.name = "eListingOfferType";
           selectList.classList.add('form-control');
           selectList.options[0] = new Option('Sell', 'Sell');
           selectList.options[1] = new Option('Rent', 'Rent');
           selectList.options[2] = new Option('Presell', 'Presell');
           selectList.setAttribute("onchange", 'priceVariations(this.value)');
           holder.append(selectList);


           $("#eListingOfferType").val(propertyInformation[0].offertype).change()


           listingPrice.value = propertyInformation[0].propertyamount;
           // //check if property is for Rent 
           if (propertyInformation[0].offertype == "Rent") {
             $("#eListingRentChoice").val(propertyInformation[0].propertyrentchoice).change()
             // //RENT BUTTON BEHAVIOR
             // //change the color of buttons base from propertyrentchoice
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).removeClass('btn-secondary');
             // $(`#e${ propertyInformation[0].propertyrentchoice}Btn`).addClass('btn-primary');

             // listingRentChoice.value = propertyInformation[0].propertyrentchoice;

           }

           listingLotArea.value = propertyInformation[0].propertylotarea;
           listingFloorArea.value = propertyInformation[0].propertyfloorarea;
           listingCapacityOfGarage.value = propertyInformation[0].propertycarpark;
           listingDesc.value = propertyInformation[0].propertydesc;


           if (propertyInformation[0].ATSFile !== null) {
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
           } else {
             //clear the ATS File if there is no ATS for Property
             var ATSFile = $("#eATSFile");
             var ATSDesc = $("#eATSDesc");

             ATSFile.empty();
             ATSDesc.empty();

             //hide the button for adding file
             $("#eAddATSBtn").removeClass("hidden");

             //show the note for changing ATS file
             $("#eAddATSNote").addClass("hidden");
           }
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

         $(this).off('shown.bs.modal');

       });
     },
     error: function (data) {
       alert(data);
     },
   });
 }

 function approveProperty(propertyid) {
   Swal.fire({
     icon: "warning",
     title: "Do you want to approve this property?",
     showCancelButton: true,
     confirmButtonText: "Yes",
     cancelButtonText: "No",
   }).then((result) => {
     if (result.value) {
       $.post('includes/approveproperty.inc.php', {
           propertyId: propertyid,
         },
         function (returnedData) {
           switch (returnedData) {
             case "Already Approved":
               Swal.fire({
                 icon: "info",
                 title: "This property has been already approved",
               })
               break;
             case "Listing Approved":
               Swal.fire({
                 icon: "success",
                 title: "This listing is approve"
               }).then(result => {
                 if (result.value) {
                   location.reload();
                 }
               })
               break;
           }
         }).fail(function () {
         console.log("error");
       });
     }
   });
 }









 function deleteProperty(id, propertyid) {
   Swal.fire({
     icon: "warning",
     title: "Do you want to delete this picture?",
     showCancelButton: true,
     confirmButtonText: "Yes",
     cancelButtonText: "No"
   }).then(result => {
     if (result.value) {
       //delete the image of property to reload
       var imageContainer = document.getElementById("propertyImgs");
       imageContainer.innerHTML = '';
       //ajax request to delete the image selected and show again the updated images
       Swal.fire({
         text: "Please Wait....",
         allowOutsideClick: false,
         showConfirmButton: false,

         willOpen: () => {
           Swal.showLoading();
         },
       });


       $.ajax({
         url: "includes/propertyimgdelete.inc.php",
         data: {
           "file_name": id
         },
         type: "POST",
         success: function (data) {
           Swal.close();
           if (data == "Picture Deleted") {
             //load property Imgs
             $("#propertyImgs").load('includes/propertyloadeditimg.inc.php', {
               propertyId: propertyid
             }, function (callback) {
               // console.log(callback)
             })
           }
         },
         error: function (data) {
           alert(data);
         },
       });
     }
   })
 }



 function priceVariations(value) {
   //display the options daily,weekly,monthly
   // console.log(value)
   if (value === "Rent") {
     $("#eRentBtn").removeClass('hidden')
   } else {
     $("#eRentBtn").addClass('hidden');
   }
 }


 $("#epropertyForm").submit(function (event) {
   event.preventDefault();
   var formData = new FormData(this);
   formData.append("ePropertyId", localStorage.getItem('selectedProperty'));



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
   //ATS FILE
   var eATSFile = $("#eATSFile");

   // for (var value of formData.keys()) {
   //   console.log(value);
   // }

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
                     if (ePropertyDescValidation(listingDesc)) {
                       if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                         if (eStreetValidation(listingStreet)) {
                           if (eBrgyValidation(listingBrgyAddress)) {
                             if (eClientCityValidation(listingCityAddress)) {
                               $("#propertyUploadAlert").html('');
                               //Building Rent
                               Swal.fire({
                                 icon: "warning",
                                 title: "Are you sure about all the property details?",
                                 text: "Kindly, check the information before submitting.",
                                 showCancelButton: true,
                                 cancelButtonText: "Cancel",
                                 confirmButtonText: "Submit",
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
                                   //insert the property to database
                                   $.ajax({
                                     url: "includes/insertpropertyedit.inc.php",
                                     data: formData,
                                     processData: false,
                                     contentType: false,
                                     type: "POST",
                                     success: function (data) {
                                       Swal.close();
                                       if (data == "Success, Property Updated!") {
                                         Swal.fire({
                                           icon: "success",
                                           title: "Property has been uploaded successfully",
                                           text: data,
                                           showConfirmButton: false,
                                           allowOutsideClick: false,
                                           timer: 2000
                                         }).then(function (result) {
                                           location.reload();
                                         });
                                       } else {
                                         $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                       }
                                     },
                                     error: function (data) {
                                       console.log(data);
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
             } else {
               //else it is either sell or presell
               if (ePropertyPriceValidation(listingPrice)) {
                 if (ePropertyLotAreaValidation(listingLotArea)) {
                   if (ePropertyDescValidation(listingDesc)) {
                     if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                       if (eStreetValidation(listingStreet)) {
                         if (eBrgyValidation(listingBrgyAddress)) {
                           if (eClientCityValidation(listingCityAddress)) {
                             $("#propertyUploadAlert").html('');
                             //Building Rent
                             Swal.fire({
                               icon: "warning",
                               title: "Are you sure about all the property details?",
                               text: "Kindly, check the information before submitting.",
                               showCancelButton: true,
                               cancelButtonText: "Close",
                               confirmButtonText: "Submit",
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
                                 //insert the property to database
                                 $.ajax({
                                   url: "includes/insertpropertyedit.inc.php",
                                   data: formData,
                                   processData: false,
                                   contentType: false,
                                   type: "POST",
                                   success: function (data) {
                                     Swal.close();
                                     console.log(data)
                                     if (data == "Success, Property Updated!") {
                                       Swal.fire({
                                         icon: "success",
                                         title: "Property has been uploaded successfully",
                                         text: data,
                                         showConfirmButton: false,
                                         allowOutsideClick: false,
                                         timer: 2000
                                       }).then(function (result) {
                                         location.reload();
                                       });
                                     } else {
                                       $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                     }
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
       } else if (listingType === "Condominium") {
         //if condominium is the type of property
         //additional "unit No"
         if (ePropertyUnitNoValidation(listingUnitNo)) {
           if (ePropertySubCategoryValidation(listingSubCategory)) {
             //parking sub Category Upload
             if (listingSubCategory === "Parking") {
               if (propertyOfferTypeValidation(listingOfferType)) {
                 if (propertyPriceValidation(listingPrice)) {
                   if (propertyLotAreaValidation(listingLotArea)) {
                     if (propertyDescValidation(listingDesc)) {
                       if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                         if (streetValidation(listingStreet)) {
                           if (brgyValidation(listingBrgyAddress)) {
                             if (clientCityValidation(listingCityAddress)) {
                               $("#propertyUploadAlert").html('');
                               //Building Rent
                               Swal.fire({
                                 icon: "warning",
                                 title: "Are you sure about all the property details?",
                                 text: "Kindly, check the information before submitting.",
                                 showCancelButton: true,
                                 cancelButtonText: "Close",
                                 confirmButtonText: "Submit",
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
                                   //insert the property to database
                                   $.ajax({
                                     url: "includes/insertpropertyedit.inc.php",
                                     data: formData,
                                     processData: false,
                                     contentType: false,
                                     type: "POST",
                                     success: function (data) {
                                       Swal.close();
                                       console.log(data)
                                       if (data == "Success, Property Updated!") {
                                         Swal.fire({
                                           icon: "success",
                                           title: "Property has been uploaded successfully",
                                           text: data,
                                           showConfirmButton: false,
                                           allowOutsideClick: false,
                                           timer: 2000
                                         }).then(function (result) {
                                           location.reload();
                                         });
                                       } else {
                                         $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                       }
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
             } else {
               if (ePropertyOfferTypeValidation(listingOfferType)) {
                 //check listing offer for "rent" option(daily,weekly,monthly) validation
                 if (listingOfferType === "Rent") {
                   if (ePropertyPriceRentValidation(listingRentChoice)) {
                     if (ePropertyPriceValidation(listingPrice)) {
                       if (ePropertyLotAreaValidation(listingLotArea)) {
                         if (ePropertyFloorAreaValidation(listingFloorArea)) {
                           if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                             if (ePropertyDescValidation(listingDesc)) {
                               if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                 if (eStreetValidation(listingStreet)) {
                                   if (eBrgyValidation(listingBrgyAddress)) {
                                     if (eClientCityValidation(listingCityAddress)) {
                                       $("#propertyUploadAlert").html('');
                                       //Building Rent
                                       Swal.fire({
                                         icon: "warning",
                                         title: "Are you sure about all the property details?",
                                         text: "Kindly, check the information before submitting.",
                                         showCancelButton: true,
                                         cancelButtonText: "Close",
                                         confirmButtonText: "Submit",
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
                                           //insert the property to database
                                           $.ajax({
                                             url: "includes/insertpropertyedit.inc.php",
                                             data: formData,
                                             processData: false,
                                             contentType: false,
                                             type: "POST",
                                             success: function (data) {
                                               Swal.close();
                                               console.log(data)
                                               if (data == "Success, Property Updated!") {
                                                 Swal.fire({
                                                   icon: "success",
                                                   title: "Property has been uploaded successfully",
                                                   text: data,
                                                   showConfirmButton: false,
                                                   allowOutsideClick: false,
                                                   timer: 2000
                                                 }).then(function (result) {
                                                   location.reload();
                                                 });
                                               } else {
                                                 $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                               }
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
                         if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                           if (ePropertyDescValidation(listingDesc)) {
                             if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                               if (eStreetValidation(listingStreet)) {
                                 if (eBrgyValidation(listingBrgyAddress)) {
                                   if (eClientCityValidation(listingCityAddress)) {
                                     $("#propertyUploadAlert").html('');
                                     //Building Rent
                                     Swal.fire({
                                       icon: "warning",
                                       title: "Are you sure about all the property details?",
                                       text: "Kindly, check the information before submitting.",
                                       showCancelButton: true,
                                       cancelButtonText: "Close",
                                       confirmButtonText: "Submit",
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
                                         //insert the property to database
                                         $.ajax({
                                           url: "includes/insertpropertyedit.inc.php",
                                           data: formData,
                                           processData: false,
                                           contentType: false,
                                           type: "POST",
                                           success: function (data) {
                                             Swal.close();
                                             console.log(data)
                                             if (data == "Success, Property Updated!") {
                                               Swal.fire({
                                                 icon: "success",
                                                 title: "Property has been uploaded successfully",
                                                 text: data,
                                                 showConfirmButton: false,
                                                 allowOutsideClick: false,
                                                 timer: 2000
                                               }).then(function (result) {
                                                 location.reload();
                                               });
                                             } else {
                                               $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                             }
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
                           if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                             if (eStreetValidation(listingStreet)) {
                               if (eBrgyValidation(listingBrgyAddress)) {
                                 if (eClientCityValidation(listingCityAddress)) {
                                   $("#propertyUploadAlert").html('');
                                   //Building Rent
                                   Swal.fire({
                                     icon: "warning",
                                     title: "Are you sure about all the property details?",
                                     text: "Kindly, check the information before submitting.",
                                     showCancelButton: true,
                                     cancelButtonText: "Close",
                                     confirmButtonText: "Submit",
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
                                       //insert the property to database
                                       $.ajax({
                                         url: "includes/insertpropertyedit.inc.php",
                                         data: formData,
                                         processData: false,
                                         contentType: false,
                                         type: "POST",
                                         success: function (data) {
                                           Swal.close();
                                           console.log(data)
                                           if (data == "Success, Property Updated!") {
                                             Swal.fire({
                                               icon: "success",
                                               title: "Property has been uploaded successfully",
                                               text: data,
                                               showConfirmButton: false,
                                               allowOutsideClick: false,
                                               timer: 2000
                                             }).then(function (result) {
                                               location.reload();
                                             });
                                           } else {
                                             $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                           }
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
                   if (ePropertyNoOfBedroomsValidation(listingBedrooms)) {
                     if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                       if (ePropertyDescValidation(listingDesc)) {
                         if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                           if (eStreetValidation(listingStreet)) {
                             if (eBrgyValidation(listingBrgyAddress)) {
                               if (eClientCityValidation(listingCityAddress)) {
                                 $("#propertyUploadAlert").html('');
                                 //Building Rent
                                 Swal.fire({
                                   icon: "warning",
                                   title: "Are you sure about all Property details?",
                                   text: "Kindly, check the information before submitting.",
                                   showCancelButton: true,
                                   cancelButtonText: "Close",
                                   confirmButtonText: "Submit",
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
                                     //insert the property to database
                                     $.ajax({
                                       url: "includes/insertpropertyedit.inc.php",
                                       data: formData,
                                       processData: false,
                                       contentType: false,
                                       type: "POST",
                                       success: function (data) {
                                         Swal.close();
                                         console.log(data)
                                         if (data == "Success, Property Updated!") {
                                           Swal.fire({
                                             icon: "success",
                                             title: "Property has been uploaded successfully",
                                             text: data,
                                             showConfirmButton: false,
                                             allowOutsideClick: false,
                                             timer: 2000
                                           }).then(function (result) {
                                             location.reload();
                                           });
                                         } else {
                                           $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                         }
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
                         if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                           if (eStreetValidation(listingStreet)) {
                             if (eBrgyValidation(listingBrgyAddress)) {
                               if (eClientCityValidation(listingCityAddress)) {
                                 $("#propertyUploadAlert").html('');
                                 //Building Rent
                                 Swal.fire({
                                   icon: "warning",
                                   title: "Are you sure about all the property details?",
                                   text: "Kindly, check the information before submitting.",
                                   showCancelButton: true,
                                   cancelButtonText: "Close",
                                   confirmButtonText: "Submit",
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
                                     //insert the property to database
                                     $.ajax({
                                       url: "includes/insertpropertyedit.inc.php",
                                       data: formData,
                                       processData: false,
                                       contentType: false,
                                       type: "POST",
                                       success: function (data) {
                                         Swal.close();
                                         Swal.close();
                                         console.log(data)
                                         if (data == "Success, Property Updated!") {
                                           Swal.fire({
                                             icon: "success",
                                             title: "Property has been uploaded successfully",
                                             text: data,
                                             showConfirmButton: false,
                                             allowOutsideClick: false,
                                             timer: 2000
                                           }).then(function (result) {
                                             location.reload();
                                           });
                                         } else {
                                           $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                         }
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
                   if (ePropertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                     if (ePropertyDescValidation(listingDesc)) {
                       if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                         if (eStreetValidation(listingStreet)) {
                           if (eBrgyValidation(listingBrgyAddress)) {
                             if (eClientCityValidation(listingCityAddress)) {
                               $("#propertyUploadAlert").html('');
                               //Building Rent
                               Swal.fire({
                                 icon: "warning",
                                 title: "Are you sure about all the property details?",
                                 text: "Kindly, check the information before submitting.",
                                 showCancelButton: true,
                                 cancelButtonText: "Close",
                                 confirmButtonText: "Submit",
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
                                   //insert the property to database
                                   $.ajax({
                                     url: "includes/insertpropertyedit.inc.php",
                                     data: formData,
                                     processData: false,
                                     contentType: false,
                                     type: "POST",
                                     success: function (data) {
                                       Swal.close();
                                       Swal.close();
                                       console.log(data)
                                       if (data == "Success, Property Updated!") {
                                         Swal.fire({
                                           icon: "success",
                                           title: "Property has been uploaded successfully",
                                           text: data,
                                           showConfirmButton: false,
                                           allowOutsideClick: false,
                                           timer: 2000
                                         }).then(function (result) {
                                           location.reload();
                                         });
                                       } else {
                                         $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                       }
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

       } else if (listingType === "Warehouse") {
         //if house and lot is the type of property
         //no "unit No", "sub category","preselling","No of bedrooms",and no "Capacity of garage"
         if (ePropertyOfferTypeValidation(listingOfferType)) {
           if (listingOfferType === "Rent") {
             if (ePropertyPriceRentValidation(listingRentChoice)) {
               if (ePropertyPriceValidation(listingPrice)) {
                 if (ePropertyLotAreaValidation(listingLotArea)) {
                   if (ePropertyDescValidation(listingDesc)) {
                     if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                       if (eStreetValidation(listingStreet)) {
                         if (eBrgyValidation(listingBrgyAddress)) {
                           if (eClientCityValidation(listingCityAddress)) {
                             $("#propertyUploadAlert").html('');
                             //Building Rent
                             Swal.fire({
                               icon: "warning",
                               title: "Are you sure about all the property details?",
                               text: "Kindly, check the information before submitting.",
                               showCancelButton: true,
                               cancelButtonText: "Close",
                               confirmButtonText: "Submit",
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
                                 //insert the property to database
                                 $.ajax({
                                   url: "includes/insertpropertyedit.inc.php",
                                   data: formData,
                                   processData: false,
                                   contentType: false,
                                   type: "POST",
                                   success: function (data) {
                                     Swal.close();
                                     console.log(data)
                                     Swal.close();
                                     console.log(data)
                                     if (data == "Success, Property Updated!") {
                                       Swal.fire({
                                         icon: "success",
                                         title: "Property Uploaded",
                                         text: data,
                                         showConfirmButton: false,
                                         allowOutsideClick: false,
                                         timer: 2000
                                       }).then(function (result) {
                                         location.reload();
                                       });
                                     } else {
                                       $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                     }
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
           } else {
             if (ePropertyPriceValidation(listingPrice)) {
               if (ePropertyLotAreaValidation(listingLotArea)) {
                 if (ePropertyDescValidation(listingDesc)) {
                   if (eRoomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                     if (eStreetValidation(listingStreet)) {
                       if (eBrgyValidation(listingBrgyAddress)) {
                         if (eClientCityValidation(listingCityAddress)) {
                           $("#propertyUploadAlert").html('');
                           //Building Rent
                           Swal.fire({
                             icon: "warning",
                             title: "Are you sure about all the property details?",
                             text: "Kindly, check the information before submitting.",
                             showCancelButton: true,
                             cancelButtonText: "Close",
                             confirmButtonText: "Submit",
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
                               //insert the property to database
                               $.ajax({
                                 url: "includes/insertpropertyedit.inc.php",
                                 data: formData,
                                 processData: false,
                                 contentType: false,
                                 type: "POST",
                                 success: function (data) {
                                   Swal.close();
                                   console.log(data)
                                   if (data == "Success, Property Updated!") {
                                     Swal.fire({
                                       icon: "success",
                                       title: "Property has been uploaded successfully",
                                       text: data,
                                       showConfirmButton: false,
                                       allowOutsideClick: false,
                                       timer: 2000
                                     }).then(function (result) {
                                       location.reload();
                                     });
                                   } else {
                                     $("#ePropertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                   }
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
   return false;
 });





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
     residentialCategory.setAttribute("value", "Residential");
     residentialCategory.appendChild(residentialCatergoryText);

     //append residential to select tag parent
     $("#eListingSubCategory").append(residentialCategory);

     //create 3rd option "Parking"
     var ParkingCategory = document.createElement("OPTION");
     var ParkingCatergoryText = document.createTextNode("Parking");
     ParkingCategory.setAttribute("value", "Parking");
     ParkingCategory.appendChild(ParkingCatergoryText);

     //append residential to select tag parent
     $("#eListingSubCategory").append(ParkingCategory);



     // unhide the sub category 
     $("#eSubCategoryHolder").removeClass('hidden');
     //show unit No for Condominium
     $("#eUnitNoHolder").removeClass("hidden");



     //get the value of sub category select each time it changes
     // console.log($("#eListingSubCategory").val())

     $('#eListingSubCategory').change(function () {
       var value = this.value;
       //get the sub category value
       //IF IT IS PARKING display only Unit Not,Price,Floor Area, and Description

       if (value === "Parking") {
         //OFFERTYPE VARIATION

         //PARKING will have offertype of Sell and Presell only
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


         var fourthOption = document.createElement("OPTION");
         var fourthOptionText = document.createTextNode("Presell");
         fourthOption.setAttribute("value", "Presell");
         fourthOption.appendChild(fourthOptionText);


         //append fourthOption to select tag parent
         $("#eListingOfferType").append(fourthOption);

         // -----OFFERTYPE VARIATION ENDS HERE------

         // No. of Bedrooms and capacity of Garage Variation
         //Condominium that has parking as sub category dont No. of bedrooms, garage capacity(separate input), and floor area
         //parking als
         $("#eNoOfBedroomsHolder").addClass("hidden");
         $("#eCapacityOfGarageHolder").addClass("hidden");
         //No. of Bedrooms and capacity of Garage Variation Ends Here


         //floor area variation
         $("#eFloorAreaHolder").addClass("hidden");

       } else {
         //OFFERTYPE VARIATION

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
         //Condominium that is not parking have No. of bedrooms and garage capacity
         //dont hide those inputs
         $("#eNoOfBedroomsHolder").removeClass("hidden");
         $("#eCapacityOfGarageHolder").removeClass("hidden");
         //No. of Bedrooms and capacity of Garage Variation Ends Here

       }

     });
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



 //----------------VALIDATIONS----------

 //preventing numbers to names 
 function allowOnlyLetters(evt) {
   var inputValue = evt.charCode;
   if (!(inputValue >= 65 && inputValue <= 122) && (inputValue != 32 && inputValue != 0)) {
     evt.preventDefault();
   }
 }

 //for limiting to only number in input text
 function isNumberKey(evt) {
   var charCode = (evt.which) ? evt.which : evt.keyCode
   return !(charCode > 31 && (charCode < 48 || charCode > 57));
 }

 $('input.CurrencyInput').on('change', function () {
   this.value = numeral(this.value).format('0,0');
 });





 function eListingNameValidation(name) {
   if (name != "") {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingTitle`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingTitle`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Name is empty</div>');
     return false;
   }
 }


 function ePropertyTypeValidation(propertyType) {
   if (propertyType != "default") {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingType`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingType`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Type is empty</div>');
     return false;
   }
 }

 function ePropertyUnitNoValidation(unitNo) {
   if (unitNo != "") {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingUnitNo`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingUnitNo`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Unit Number is empty</div>');
     return false;
   }
 }

 function ePropertySubCategoryValidation(subCategory) {
   if (subCategory != "default") {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingSubCategory`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingSubCategory`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Sub Listing Category is empty</div>');
     return false;
   }
 }


 function ePropertyOfferTypeValidation(propertyOfferType) {
   if (propertyOfferType != "default") {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingOfferType`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingOfferType`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Offer Type is empty</div>');
     return false;
   }
 }

 function ePropertyPriceValidation(price) {
   if (price != "" && price != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingPrice`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingPrice`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Price is empty</div>');
     return false;
   }
 }

 function ePropertyPriceRentValidation(rentOption) {
   if (rentOption != "") {
     $("#ePropertyUploadAlert").html('');
     $(`#eRentBtn`).removeClass('input-error');
     return true;
   } else {
     $(`#eRentBtn`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Rent Option is empty</div>');
     return false;
   }
 }


 function ePropertyLotAreaValidation(lotArea) {
   if (lotArea != "" || lotArea != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingLotArea`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingLotArea`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Lot Area is empty</div>');
     return false;
   }
 }

 function ePropertyFloorAreaValidation(floorArea) {
   if (floorArea != "" && floorArea != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingFloorArea`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingFloorArea`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Floor Area is empty</div>');
     return false;
   }
 }

 function ePropertyNoOfBedroomsValidation(bedrooms) {
   if (bedrooms != "" && bedrooms != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingBedrooms`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingBedrooms`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Number of Bedrooms is empty</div>');
     return false;
   }
 }

 function ePropertyCapacityOfGarageValidation(capacityOfGarage) {
   if (capacityOfGarage != "" && capacityOfGarage != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingCapacityOfGarage`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingCapacityOfGarage`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Capacity of Garage is empty</div>');
     return false;
   }
 }

 function ePropertyDescValidation(desc) {
   if (desc != "" && desc != 0) {
     $("#ePropertyUploadAlert").html('');
     $(`#eListingDesc`).removeClass('input-error');
     return true;
   } else {
     $(`#eListingDesc`).addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Propety Description is empty</div>');
     return false;
   }
 }


 function ePropertyATSFileValidation(ATSInput, ATSimg) {
   var result;
   if (ATSInput.files.length !== 0) {
     //both primary and secondary Id is not empty
     //show the error in img holder
     $("#eLropertyUploadAlert").html('');
     $(`#eClientHolders`).removeClass('input-error');
     result = true;

   } else {

     //check if ATSFile holder have a child
     if (ATSimg.children().length !== 0) {
       //show the error in img holder
       $("#eLropertyUploadAlert").html('');
       $(`#eClientHolders`).removeClass('input-error');
       result = true;
     } else {
       $(`#eClientHolders`).addClass('input-error');
       $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Authority to sell File is empty</div>');
       result = false;
     }
   }
   return result;
 }


 //room/unit No/building
 function eRoomUnitNoAndHouseLotValidation(RFUB, HLB) {
   if (RFUB !== "" && HLB !== "") {
     //both room/unit No/building and House Lot and Block is not empty
     $("#eListingRFUB").removeClass('input-error');
     $("#eListingHLB").removeClass('input-error');
     return true;
   } else if (RFUB === "" && HLB !== "") {
     //Lot and Block is not empty
     $("#eListingRFUB").removeClass('input-error');
     $("#eListingHLB").removeClass('input-error');
     return true;
   } else if (RFUB !== "" && HLB === "") {
     //room/unit No/building is not empty
     $("#eListingRFUB").removeClass('input-error');
     $("#eListingHLB").removeClass('input-error');
     return true;
   } else {
     // both client RFUB and client HLB is empty
     $("#eListingRFUB").addClass('input-error');
     $("#eListingHLB").addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Either Room/Unit No & Building or House/Lot and Block is empty</div>');
     return false;
   }
 }


 function eStreetValidation(street) {
   // console.log(clientStreet !== "")
   if (street === "") {
     //client street input is empty
     $("#listingStreet").addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Street Address is empty</div>');
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
     $(`.form-control#eListingBrgyAddress`).next().find('.select2-selection').removeClass('input-error');
     return true;
   } else {
     $(`.form-control#eListingBrgyAddress`).next().find('.select2-selection').addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">Barangay Address is empty!</div>');
     return false;
   }
 }
 //city address validation

 function eClientCityValidation(clientCityAddress) {
   if (clientCityAddress !== null) {
     //client city address input is not empty
     $(`.form-control#eListingCityAddress`).next().find('.select2-selection').removeClass('input-error');
     return true;
   } else {
     $(`.form-control#eListingCityAddress`).next().find('.select2-selection').addClass('input-error');
     $("#ePropertyUploadAlert").html('<div class="alert alert-danger" role="alert">City Address is empty</div>');
     return false;
   }
 }



 function deletePropertyImg(imgId, propertyId) {
   Swal.fire({
     icon: "warning",
     title: "Do you want to delete this property?",
     text: "Note: A property must have at least 1 image.",
     confirmButtonColor: "#ff0000",
     showCancelButton: true,
     confirmButtonText: "Yes",
     cancelButtonText: "No"
   }).then(result => {
     if (result.value) {

       var imageContainer = document.getElementById("propertyImgs");

       //ajax request to delete the image selected and show again the updated images
       Swal.fire({
         text: "Please wait....",
         allowOutsideClick: false,
         showConfirmButton: false,

         willOpen: () => {
           Swal.showLoading();
         },
       });
       $.ajax({
         url: "includes/propertyimgdelete.inc.php",
         data: {
           "file_name": imgId,
           "propertyId": propertyId
         },
         type: "POST",
         success: function (data) {
           Swal.close();
           console.log(data)
           if (data == "Property Image Deleted") {
             imageContainer.innerHTML = '';
             //reload property Imgs
             $("#propertyImgs").load('includes/propertyloadeditimg.inc.php', {
               propertyId: propertyId
             });
           } else {
             Swal.fire({
               icon: "error",
               title: data,
               text: "Note: A property must have at least 1 image.",
               showCancelButton: true,
               showConfirmButton: false
             })
           }
         },
         error: function (data) {
           console.log(data);
         },
       });
     }
   })
 }