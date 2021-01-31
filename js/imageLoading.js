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

$("#viewImg").click(function () {
  $("#check").click();
})

$("#check").change(function () {
  previewImage(this, "userImg");
})