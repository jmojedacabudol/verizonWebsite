$("#fileImg").change(function () {
  previewImage(this, "propertyImg");
});

//validation for image validity
var validImagetypes = ["image/gif", "image/jpg", "image/png", "image/jpeg"];

//FOR IMAGE PRELOAD
function previewImage(image_blog, container) {
  var reader = new FileReader();
  reader.onload = function (e) {
    $(`#${container}`).attr("src", e.target.result);
  };
  if (typeof (image_blog.files[0]) === 'undefined') {
    Swal.fire({
      icon: "error",
      title: "No Image Found",
      text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
    }).then(function (result) {
      if (result.value) {
        $(`#${container}`).attr("src", 'assets/img/user.png');
        $("#propertyImg").value = null;
      }
    });
  } else {
    var readImage = image_blog.files[0];
    var filetype = readImage["type"];
    //if Image is Valid
    if ($.inArray(filetype, validImagetypes) > 0) {
      reader.readAsDataURL(image_blog.files[0]);
      $(`#${container}`).value = readImage;
    }
    //else Image is Invalid
    else {
      Swal.fire({
        icon: "error",
        title: "Invalid Image",
        text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
      }).then(function (result) {
        if (result.value) {
          reader.readAsDataURL(image_blog.files[0]);
          $("#propertyImg").value = null;
        }
      });
    }
  }
}

$("#viewImg").click(function () {
  $("#check").click();
})

$("#check").change(function () {
  previewImage(this, "userImg");
})



$("#validId").change(function () {
  validIdCheck(this);
})

function validIdCheck(image_blog) {
  //validation for image validity
  var validImagetypes = ["image/gif", "image/jpg", "image/png", "image/jpeg"];
  var reader = new FileReader();
  if (typeof (image_blog.files[0]) === 'undefined') {
    Swal.fire({
      icon: "error",
      title: "No Image Found",
      text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
    }).then(function (result) {
      if (result.value) {
        document.getElementById("validId").value = "";
      }
    });
  } else {
    var readImage = image_blog.files[0];
    var filetype = readImage["type"];
    //if Image is Valid
    if ($.inArray(filetype, validImagetypes) > 0) {
      reader.readAsDataURL(image_blog.files[0]);
    }
    //else Image is Invalid
    else {
      Swal.fire({
        icon: "error",
        title: "Invalid Image",
        text: "Please Select a valid image. Valid Image formats are jpg, png, and jpeg file formats.",
      }).then(function (result) {
        if (result.value) {
          document.getElementById("validId").value = "";
        }
      });
    }
  }
}