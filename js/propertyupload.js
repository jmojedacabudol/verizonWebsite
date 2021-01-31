$(function () {
  $("#propertyForm").submit(function (event) {
    event.preventDefault();

    // var propertyName = $("#listing-title").val();
    // var propertyOfferType = $("#listing-offer-type").val();
    // var propertyLocation = $("#listing-location").val();
    // var propertyType = $("#listing-type").val();
    // var propertyLotArea = $("#listing-lot-area").val();
    // var propertyFloorArea = $("#listing-floor-area").val();
    // var propertyBedroom = $("#listing-bedroom").val();
    // var propertyCarpark = $("#listing-carpark").val();
    // var Img = $("#fileImg")[0].files[0];
    // var propertySubmitBtn = $("#listing-submit").val();
    // var form = document.getElementById("propertyForm");
    var formData = new FormData(this);
    formData.append("submit", "listing-submit");
    // // fd.append(this);
    // // fd.append("submit", "propertySubmitBtn");
    // // Display the values
    // for (var value of formData.keys()) {
    //   console.log(value);
    // }
    Swal.fire({
      text: "Please Wait....",
      allowOutsideClick: false,
      showConfirmButton: false,

      willOpen: () => {
        Swal.showLoading();
      },
    });


    $.ajax({
      url: "includes/propertyupload.inc.php",
      data: formData,
      processData: false,
      contentType: false,
      type: "POST",
      success: function (data) {
        Swal.close();
        if (data === "Property Uploaded." || data === "Your listing is now uploaded. Awaiting for Admin`s Approval.") {
          Swal.fire({
            icon: "success",
            title: "Property Uploaded",
            text: data,
            showConfirmButton: false,
            allowOutsideClick: false,
            timer: 2000
          }).then(function (result) {
            location.reload();
          })
        } else {
          // console.log(data)
          $("#form-message").html(data);
        }

      },
      error: function (data) {
        alert(data);
      },
    });

    // $("#form-message").load("includes/propertyupload.inc.php", {
    //   propertyName: propertyName,
    //   propertyOfferType: propertyOfferType,
    //   propertyLocation: propertyLocation,
    //   propertyType: propertyType,
    //   propertyLotArea: propertyLotArea,
    //   propertyFloorArea: propertyFloorArea,
    //   propertyBedroom: propertyBedroom,
    //   propertyCarpark: propertyCarpark,
    //   // propertyImg: propertyImg,
    //   propertySubmitBtn: propertySubmitBtn,
    // });
  });
});


function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if ((charCode > 31 && charCode < 48) || charCode > 57) {
    return false;
  }
  return true;
}


// $("#listing-price").change(function () {

// })


// const formatter = new Intl.NumberFormat('en-PH');

// // $('#listing-price').keyup(function (e) {

// //   console.log(formatter.format($("#listing-price").val()));
// //   // console.log(numeral($("#listing-price").val()))


// // })

// const source = document.getElementById('listing-price');
// // const result = document.getElementById('result');

// const inputHandler = function (e) {
//   console.log(formatter.format(e.target.value));
//   source.value = formatter.format(e.target.value);
//   // console.log(formatter.format(e.target.value))
// }

// source.addEventListener('input', inputHandler);


$("#listing-offer-type").change(function () {

  if ($(this).val() === "Rent") {
    document.getElementById("rentBtn").style.display = "block";
  } else {
    document.getElementById("rentBtn").style.display = "none";
  }
})



$("#dailyBtn").click(function () {
  document.getElementById("dailyBtn").classList.remove('btn-secondary');
  document.getElementById("dailyBtn").classList.add('btn-primary');
  $("#offerchoice").val("Daily")

  // document.getElementById("forrentBtn").classList.remove('gradient-bg');
  document.getElementById("weeklyBtn").classList.add('btn-secondary');
  document.getElementById("monthlyBtn").classList.add('btn-secondary');
})

$("#weeklyBtn").click(function () {
  document.getElementById("weeklyBtn").classList.remove('btn-secondary');
  document.getElementById("weeklyBtn").classList.add('btn-primary');
  $("#offerchoice").val("Weekly")

  // document.getElementById("forrentBtn").classList.remove('gradient-bg');
  document.getElementById("dailyBtn").classList.add('btn-secondary');
  document.getElementById("monthlyBtn").classList.add('btn-secondary');

})


$("#monthlyBtn").click(function () {
  document.getElementById("monthlyBtn").classList.remove('btn-secondary');
  document.getElementById("monthlyBtn").classList.add('btn-primary');
  $("#offerchoice").val("Monthly")

  // document.getElementById("forrentBtn").classList.remove('gradient-bg');
  document.getElementById("weeklyBtn").classList.add('btn-secondary');
  document.getElementById("dailyBtn").classList.add('btn-secondary');
})