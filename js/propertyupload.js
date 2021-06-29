$(function () {


  //brgy,city SELECT2 dropdown
  $("#listingBrgyAddress").select2({
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

  $("#listingCityAddress").select2({
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



  $("#propertyForm").submit(function (event) {
    event.preventDefault();
    var formData = new FormData(this);
    // for (var value of formData.keys()) {
    //   console.log(value);
    // }
    //append a button for submission of property
    formData.append("submit", "listing-submit");

    var listingImg = document.querySelector("#listingImg");
    var listingTitle = formData.get("listingTitle");
    var listingType = formData.get("listingType");
    var listingUnitNo = formData.get("listingUnitNo");
    var listingSubCategory = formData.get("listingSubCategory");
    var listingOfferType = formData.get("listingOfferType");
    var listingRentChoice = formData.get("listingRentChoice");
    var listingPrice = formData.get("listingPrice");
    var listingLotArea = formData.get("listingLotArea");
    var listingFloorArea = formData.get("listingFloorArea");
    var listingBedrooms = formData.get("listingBedrooms");
    var listingCapacityOfGarage = formData.get("listingCapacityOfGarage");
    var listingDesc = formData.get("listingDesc");
    var listingATS = document.querySelector("#listingATS");
    var listingRFUB = formData.get("listingRFUB");
    var listingHLB = formData.get("listingHLB");
    var listingStreet = formData.get("listingStreet");
    var listingBrgyAddress = formData.get("listingBrgyAddress");
    var listingCityAddress = formData.get("listingCityAddress");

    //rent option input
    var listingRentChoice = formData.get("listingRentChoice");

    if (propertyImgValidation(listingImg)) {
      if (listingNameValidation(listingTitle)) {
        if (propertyTypeValidation(listingType)) {
          if (listingType === "Building" || listingType === "Lot") {
            //if building is the type of property
            //No. of Bedrooms, Capacity of Garage and unitNo are  not included  
            //start with sub category
            if (propertySubCategoryValidation(listingSubCategory)) {
              if (propertyOfferTypeValidation(listingOfferType)) {
                //check listing offer for rent option(daily,weekly,monthly) validation
                if (listingOfferType === "Rent") {
                  if (propertyPriceRentValidation(listingRentChoice)) {
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
                                    text: "Kindly, double check the information before submitting",
                                    showCancelButton: true,
                                    cancelButtonText: "Cancel",
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
                                          if (data == "Property Submitted") {
                                            Swal.fire({
                                              icon: "success",
                                              title: "This property has successfully uploaded",
                                              text: data,
                                              showConfirmButton: false,
                                              allowOutsideClick: false,
                                              timer: 2000,
                                              timerProgressBar: true,
                                            }).then(function (result) {
                                              location.reload();
                                            });
                                          } else {
                                            // console.log(data)
                                            $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                          }
                                        },
                                        error: function (data) {
                                          console.log("ERROR: " + data);
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
                                        if (data == "Property Submitted") {
                                          Swal.fire({
                                            icon: "success",
                                            title: "This property has successfully uploaded",
                                            text: data,
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            timer: 2000,
                                            timerProgressBar: true,
                                          }).then(function (result) {
                                            location.reload();
                                          });
                                        } else {
                                          // console.log(data)
                                          $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                        }
                                      },
                                      error: function (data) {
                                        console.log("ERROR: " + data);
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
            if (propertyUnitNoValidation(listingUnitNo)) {
              if (propertySubCategoryValidation(listingSubCategory)) {
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
                                        text: "Please wait....",
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
                                          if (data == "Property Submitted") {
                                            Swal.fire({
                                              icon: "success",
                                              title: "This property has successfully uploaded",
                                              text: data,
                                              showConfirmButton: false,
                                              allowOutsideClick: false,
                                              timer: 2000,
                                              timerProgressBar: true,
                                            }).then(function (result) {
                                              location.reload();
                                            });
                                          } else {
                                            // console.log(data)
                                            $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                          }
                                        },
                                        error: function (data) {
                                          console.log("ERROR: " + data);
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
                  if (propertyOfferTypeValidation(listingOfferType)) {
                    //check listing offer for "rent" option(daily,weekly,monthly) validation
                    if (listingOfferType === "Rent") {
                      if (propertyPriceRentValidation(listingRentChoice)) {
                        if (propertyPriceValidation(listingPrice)) {
                          if (propertyLotAreaValidation(listingLotArea)) {
                            if (propertyFloorAreaValidation(listingFloorArea)) {
                              if (propertyNoOfBedroomsValidation(listingBedrooms)) {
                                if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                                  if (propertyDescValidation(listingDesc)) {
                                    if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                      if (streetValidation(listingStreet)) {
                                        if (brgyValidation(listingBrgyAddress)) {
                                          if (clientCityValidation(listingCityAddress)) {
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
                                                  text: "Please wait....",
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
                                                    if (data == "Property Submitted") {
                                                      Swal.fire({
                                                        icon: "success",
                                                        title: "This property has successfully uploaded",
                                                        text: data,
                                                        showConfirmButton: false,
                                                        allowOutsideClick: false,
                                                        timer: 2000,
                                                        timerProgressBar: true,
                                                      }).then(function (result) {
                                                        location.reload();
                                                      });
                                                    } else {
                                                      // console.log(data)
                                                      $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                                    }
                                                  },
                                                  error: function (data) {
                                                    console.log("ERROR: " + data);
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
                      if (propertyPriceValidation(listingPrice)) {
                        if (propertyLotAreaValidation(listingLotArea)) {
                          if (propertyFloorAreaValidation(listingFloorArea)) {
                            if (propertyNoOfBedroomsValidation(listingBedrooms)) {
                              if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                                if (propertyDescValidation(listingDesc)) {
                                  if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                    if (streetValidation(listingStreet)) {
                                      if (brgyValidation(listingBrgyAddress)) {
                                        if (clientCityValidation(listingCityAddress)) {
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
                                                  if (data == "Property Submitted") {
                                                    Swal.fire({
                                                      icon: "success",
                                                      title: "This property has successfully uploaded",
                                                      text: data,
                                                      showConfirmButton: false,
                                                      allowOutsideClick: false,
                                                      timer: 2000,
                                                      timerProgressBar: true,
                                                    }).then(function (result) {
                                                      location.reload();
                                                    });
                                                  } else {
                                                    // console.log(data)
                                                    $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                                  }
                                                },
                                                error: function (data) {
                                                  console.log("ERROR: " + data);
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
            if (propertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (propertyPriceRentValidation(listingRentChoice)) {
                  if (propertyPriceValidation(listingPrice)) {
                    if (propertyLotAreaValidation(listingLotArea)) {
                      if (propertyFloorAreaValidation(listingFloorArea)) {
                        if (propertyNoOfBedroomsValidation(listingBedrooms)) {
                          if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                            if (propertyDescValidation(listingDesc)) {
                              if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                                if (streetValidation(listingStreet)) {
                                  if (brgyValidation(listingBrgyAddress)) {
                                    if (clientCityValidation(listingCityAddress)) {
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
                                              if (data == "Property Submitted") {
                                                Swal.fire({
                                                  icon: "success",
                                                  title: "This property has successfully uploaded",
                                                  text: data,
                                                  showConfirmButton: false,
                                                  allowOutsideClick: false,
                                                  timer: 2000,
                                                  timerProgressBar: true,
                                                }).then(function (result) {
                                                  location.reload();
                                                });
                                              } else {
                                                // console.log(data)
                                                $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                              }
                                            },
                                            error: function (data) {
                                              console.log("ERROR: " + data);
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
                if (propertyPriceValidation(listingPrice)) {
                  if (propertyLotAreaValidation(listingLotArea)) {
                    if (propertyFloorAreaValidation(listingFloorArea)) {
                      if (propertyNoOfBedroomsValidation(listingBedrooms)) {
                        if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                          if (propertyDescValidation(listingDesc)) {
                            if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                              if (streetValidation(listingStreet)) {
                                if (brgyValidation(listingBrgyAddress)) {
                                  if (clientCityValidation(listingCityAddress)) {
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
                                            if (data == "Property Submitted") {
                                              Swal.fire({
                                                icon: "success",
                                                title: "This property has successfully uploaded",
                                                text: data,
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                timer: 2000,
                                                timerProgressBar: true,
                                              }).then(function (result) {
                                                location.reload();
                                              });
                                            } else {
                                              // console.log(data)
                                              $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                            }
                                          },
                                          error: function (data) {
                                            console.log("ERROR: " + data);
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
            if (propertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (propertyPriceRentValidation(listingRentChoice)) {
                  if (propertyPriceValidation(listingPrice)) {
                    if (propertyLotAreaValidation(listingLotArea)) {
                      if (propertyFloorAreaValidation(listingFloorArea)) {
                        if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                          if (propertyDescValidation(listingDesc)) {
                            if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                              if (streetValidation(listingStreet)) {
                                if (brgyValidation(listingBrgyAddress)) {
                                  if (clientCityValidation(listingCityAddress)) {
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
                                          text: "Please wait....",
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
                                            if (data == "Property Submitted") {
                                              Swal.fire({
                                                icon: "success",
                                                title: "This property has successfully uploaded",
                                                text: data,
                                                showConfirmButton: false,
                                                allowOutsideClick: false,
                                                timer: 2000,
                                                timerProgressBar: true,
                                              }).then(function (result) {
                                                location.reload();
                                              });
                                            } else {
                                              // console.log(data)
                                              $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                            }
                                          },
                                          error: function (data) {
                                            console.log("ERROR: " + data);
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
                if (propertyPriceValidation(listingPrice)) {
                  if (propertyLotAreaValidation(listingLotArea)) {
                    if (propertyFloorAreaValidation(listingFloorArea)) {
                      if (propertyCapacityOfGarageValidation(listingCapacityOfGarage)) {
                        if (propertyDescValidation(listingDesc)) {
                          if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                            if (streetValidation(listingStreet)) {
                              if (brgyValidation(listingBrgyAddress)) {
                                if (clientCityValidation(listingCityAddress)) {
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
                                        text: "Please wait....",
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
                                          if (data == "Property Submitted") {
                                            Swal.fire({
                                              icon: "success",
                                              title: "This property has successfully uploaded",
                                              text: data,
                                              showConfirmButton: false,
                                              allowOutsideClick: false,
                                              timer: 2000,
                                              timerProgressBar: true,
                                            }).then(function (result) {
                                              location.reload();
                                            });
                                          } else {
                                            // console.log(data)
                                            $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                          }
                                        },
                                        error: function (data) {
                                          console.log("ERROR: " + data)
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
            if (propertyOfferTypeValidation(listingOfferType)) {
              if (listingOfferType === "Rent") {
                if (propertyPriceRentValidation(listingRentChoice)) {
                  if (propertyPriceValidation(listingPrice)) {
                    if (propertyLotAreaValidation(listingLotArea)) {
                      if (propertyFloorAreaValidation(listingFloorArea)) {
                        if (propertyDescValidation(listingDesc)) {
                          if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                            if (streetValidation(listingStreet)) {
                              if (brgyValidation(listingBrgyAddress)) {
                                if (clientCityValidation(listingCityAddress)) {
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
                                          if (data == "Property Submitted") {
                                            Swal.fire({
                                              icon: "success",
                                              title: "This property has successfully uploaded",
                                              text: data,
                                              showConfirmButton: false,
                                              allowOutsideClick: false,
                                              timer: 2000,
                                              timerProgressBar: true,
                                            }).then(function (result) {
                                              location.reload();
                                            });
                                          } else {
                                            // console.log(data)
                                            $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                          }
                                        },
                                        error: function (data) {
                                          console.log("ERROR: " + data)
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
              } else {
                if (propertyPriceValidation(listingPrice)) {
                  if (propertyLotAreaValidation(listingLotArea)) {
                    if (propertyFloorAreaValidation(listingFloorArea)) {
                      if (propertyDescValidation(listingDesc)) {
                        if (roomUnitNoAndHouseLotValidation(listingRFUB, listingHLB)) {
                          if (streetValidation(listingStreet)) {
                            if (brgyValidation(listingBrgyAddress)) {
                              if (clientCityValidation(listingCityAddress)) {
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
                                      text: "Please wait....",
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
                                        if (data == "Property Submitted") {
                                          Swal.fire({
                                            icon: "success",
                                            title: "This property has successfully uploaded",
                                            text: data,
                                            showConfirmButton: false,
                                            allowOutsideClick: false,
                                            timer: 2000,
                                            timerProgressBar: true,
                                          }).then(function (result) {
                                            location.reload();
                                          });
                                        } else {
                                          // console.log(data)
                                          $("#propertyUploadAlert").html('<div class = "alert alert-danger" role = "alert" >' + data + '</div>');
                                        }
                                      },
                                      error: function (data) {
                                        console.log("ERROR: " + data);
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
    return false;



  })


});

//----------------VALIDATION FUNCTIONS-------------------------

function propertyImgValidation(img) {

  if (img.files.length !== 0) {
    $("#propertyUploadAlert").html('');
    $(`#propertyImgHolder`).removeClass('input-error');
    return true;
  } else {
    $(`#propertyImgHolder`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Image is empty</div>');
    return false;
  }
}


function listingNameValidation(name) {
  if (name != "") {
    $("#propertyUploadAlert").html('');
    $(`#listingTitle`).removeClass('input-error');
    return true;
  } else {
    $(`#listingTitle`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Name is empty</div>');
    return false;
  }
}


function propertyTypeValidation(propertyType) {
  if (propertyType != "default") {
    $("#propertyUploadAlert").html('');
    $(`#listingType`).removeClass('input-error');
    return true;
  } else {
    $(`#listingType`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Type is empty</div>');
    return false;
  }
}

function propertyUnitNoValidation(unitNo) {
  if (unitNo != "") {
    $("#propertyUploadAlert").html('');
    $(`#listingUnitNo`).removeClass('input-error');
    return true;
  } else {
    $(`#listingUnitNo`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Unit Number is empty</div>');
    return false;
  }
}

function propertySubCategoryValidation(subCategory) {
  if (subCategory != "default") {
    $("#propertyUploadAlert").html('');
    $(`#listingSubCategory`).removeClass('input-error');
    return true;
  } else {
    $(`#listingSubCategory`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Sub Listing Category is Empty!</div>');
    return false;
  }
}


function propertyOfferTypeValidation(propertyOfferType) {
  if (propertyOfferType != "default") {
    $("#propertyUploadAlert").html('');
    $(`#offerType`).removeClass('input-error');
    return true;
  } else {
    $(`#offerType`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Offer Type is Empty!</div>');
    return false;
  }
}

function propertyPriceValidation(price) {
  if (price != "" || price != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingPrice`).removeClass('input-error');
    return true;
  } else {
    $(`#listingPrice`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Price is Empty!</div>');
    return false;
  }
}

function propertyPriceRentValidation(rentOption) {
  if (rentOption != "") {
    $("#propertyUploadAlert").html('');
    $(`#rentBtn`).removeClass('input-error');
    return true;
  } else {
    $(`#rentBtn`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Rent Option is Empty!</div>');
    return false;
  }
}


function propertyLotAreaValidation(lotArea) {
  if (lotArea != "" || lotArea != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingLotArea`).removeClass('input-error');
    return true;
  } else {
    $(`#listingLotArea`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Lot Area is Empty!</div>');
    return false;
  }
}

function propertyFloorAreaValidation(floorArea) {
  if (floorArea != "" || floorArea != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingFloorArea`).removeClass('input-error');
    return true;
  } else {
    $(`#listingFloorArea`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Floor Area is Empty!</div>');
    return false;
  }
}

function propertyNoOfBedroomsValidation(bedrooms) {
  if (bedrooms != "" || bedrooms != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingBedrooms`).removeClass('input-error');
    return true;
  } else {
    $(`#listingBedrooms`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Number of Bedrooms is Empty!</div>');
    return false;
  }
}

function propertyCapacityOfGarageValidation(capacityOfGarage) {
  if (capacityOfGarage != "" || capacityOfGarage != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingCapacityOfGarage`).removeClass('input-error');
    return true;
  } else {
    $(`#listingCapacityOfGarage`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Property Capacity of Garage is Empty!</div>');
    return false;
  }
}

function propertyDescValidation(desc) {
  if (desc != "" || desc != 0) {
    $("#propertyUploadAlert").html('');
    $(`#listingDesc`).removeClass('input-error');
    return true;
  } else {
    $(`#listingDesc`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Propety Description is Empty!</div>');
    return false;
  }
}


function propertyATSFileValidation(ATS) {
  if (ATS.files.length != 0) {
    $("#propertyUploadAlert").html('');
    $(`#clientHolders`).removeClass('input-error');
    return true;
  } else {
    $(`#clientHolders`).addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Authority to sell File is Empty!</div>');
    return false;
  }
}


//room/unit No/building
function roomUnitNoAndHouseLotValidation(RFUB, HLB) {
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
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Please provide either Room/Unit No & Building or House/Lot and Bloock!</div>');
    return false;
  }
}


function streetValidation(street) {
  // console.log(clientStreet !== "")
  if (street === "") {
    //client street input is empty
    $("#listingStreet").addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Street Address is empty!</div>');
    return false;

  } else {
    $("#listingStreet").removeClass('input-error');
    return true;
  }
}

//barangay address validation
function brgyValidation(brgyAddress) {
  if (brgyAddress !== null) {
    //barangay street input is not empty
    $(`.form-control#listingBrgyAddress`).next().find('.select2-selection').removeClass('input-error');
    return true;
  } else {
    $(`.form-control#listingBrgyAddress`).next().find('.select2-selection').addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">Barangay Address is empty!</div>');
    return false;
  }
}
//city address validation

function clientCityValidation(clientCityAddress) {
  if (clientCityAddress !== null) {
    //client city address input is not empty
    $(`.form-control#listingCityAddress`).next().find('.select2-selection').removeClass('input-error');
    return true;
  } else {
    $(`.form-control#listingCityAddress`).next().find('.select2-selection').addClass('input-error');
    $("#propertyUploadAlert").html('<div class="alert alert-danger" role="alert">City Address is empty!</div>');
    return false;
  }
}




//----------------VALIDATION FUNCTIONS ENDS HERE---------------






// ------------------BEHAVIORAL FUNCTIONS-----------

function allVariation(value) {
  //get the property type
  var propertyType = value;
  //building will have 2 sub category (commercial,residential)
  if (propertyType === "Building") {

    //hide unit No for Building
    $("#unitNoHolder").addClass("hidden");

    //clear the select parent
    $("#listingSubCategory").empty();

    //create 1st option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);

    //append commercial to select tag parent
    $("#listingSubCategory").append(commercialCatergory);

    //create 2nd option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);

    //append residential to select tag parent
    $("#listingSubCategory").append(residentialCategory);

    // unhide the sub category 
    $("#subCategoryHolder").removeClass('hidden');

    //OFFERTYPE VARIATION
    //clear the select parent
    $("#offerType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#offerType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#offerType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#offerType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#offerType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------



    // No. of Bedrooms and capacity of Garage Variation
    //building dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#noOfBedroomsHolder").addClass("hidden");
    $("#capacityOfGarageHolder").addClass("hidden");

    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Condominium") {

    //clear the select parent
    $("#listingSubCategory").empty();

    //create 1st option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);

    //append commercial to select tag parent
    $("#listingSubCategory").append(commercialCatergory);

    //create 2nd option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);

    //append residential to select tag parent
    $("#listingSubCategory").append(residentialCategory);



    //create 3rd option "Parking"
    var ParkingCategory = document.createElement("OPTION");
    var ParkingCatergoryText = document.createTextNode("Parking");
    ParkingCategory.setAttribute("value", "Parking");
    ParkingCategory.appendChild(ParkingCatergoryText);

    //append residential to select tag parent
    $("#listingSubCategory").append(ParkingCategory);

    //create a separate function for condominium bahavior
    //and append it to onchange 
    // $("#listingSubCategory").attr("onchange", 'condominiumBehavior(this.value)');


    // unhide the sub category 
    $("#subCategoryHolder").removeClass('hidden');


    //show unit No for Condominium
    $("#unitNoHolder").removeClass("hidden");

    //get the value of sub category select each time it changes

    $('#listingSubCategory').change(function () {
      var value = this.value;
      //get the sub category value
      //IF IT IS PARKING display only Unit Not,Price,Floor Area, and Description

      if (value === "Parking") {
        //OFFERTYPE VARIATION

        //PARKING will have offertype of Sell and Presell only
        //clear the select parent
        $("#offerType").empty();

        //create all options 
        var firstOption = document.createElement("OPTION");
        var firstOptionText = document.createTextNode("Select Offer Type");
        firstOption.setAttribute("value", "default");
        firstOption.appendChild(firstOptionText);


        //append firstOption to select tag parent
        $("#offerType").append(firstOption);


        var secondOption = document.createElement("OPTION");
        var secondOptionText = document.createTextNode("Sell");
        secondOption.setAttribute("value", "Sell");
        secondOption.appendChild(secondOptionText);

        //append secondOption to select tag parent
        $("#offerType").append(secondOption);


        var fourthOption = document.createElement("OPTION");
        var fourthOptionText = document.createTextNode("Presell");
        fourthOption.setAttribute("value", "Presell");
        fourthOption.appendChild(fourthOptionText);


        //append fourthOption to select tag parent
        $("#offerType").append(fourthOption);

        // -----OFFERTYPE VARIATION ENDS HERE------

        // No. of Bedrooms and capacity of Garage Variation
        //Condominium that has parking as sub category dont No. of bedrooms, garage capacity(separate input), and floor area
        //parking als
        $("#noOfBedroomsHolder").addClass("hidden");
        $("#capacityOfGarageHolder").addClass("hidden");
        //No. of Bedrooms and capacity of Garage Variation Ends Here


        //floor area variation
        $("#floorAreaHolder").addClass("hidden");

      } else {
        //OFFERTYPE VARIATION

        //create all options 
        var firstOption = document.createElement("OPTION");
        var firstOptionText = document.createTextNode("Select Offer Type");
        firstOption.setAttribute("value", "default");
        firstOption.appendChild(firstOptionText);


        //append firstOption to select tag parent
        $("#offerType").append(firstOption);


        var secondOption = document.createElement("OPTION");
        var secondOptionText = document.createTextNode("Sell");
        secondOption.setAttribute("value", "Sell");
        secondOption.appendChild(secondOptionText);

        //append secondOption to select tag parent
        $("#offerType").append(secondOption);


        var thirdOption = document.createElement("OPTION");
        var thirdOptionText = document.createTextNode("Rent");
        thirdOption.setAttribute("value", "Rent");
        thirdOption.appendChild(thirdOptionText);


        //append thirdOption to select tag parent
        $("#offerType").append(thirdOption);


        var fourthOption = document.createElement("OPTION");
        var fourthOptionText = document.createTextNode("Presell");
        fourthOption.setAttribute("value", "Presell");
        fourthOption.appendChild(fourthOptionText);


        //append fourthOption to select tag parent
        $("#offerType").append(fourthOption);

        // -----OFFERTYPE VARIATION ENDS HERE------


        // No. of Bedrooms and capacity of Garage Variation
        //Condominium that is not parking have No. of bedrooms and garage capacity
        //dont hide those inputs
        $("#noOfBedroomsHolder").removeClass("hidden");
        $("#capacityOfGarageHolder").removeClass("hidden");
        //No. of Bedrooms and capacity of Garage Variation Ends Here

      }

    });







  } else if (propertyType === "Lot") {

    //lot will have 4 sub category (industrial,commercial,agricultural,residential)

    //hide unit No for Lot
    $("#unitNoHolder").addClass("hidden");

    //clear the select parent
    $("#listingSubCategory").empty();

    //create 1st option "Agricultural"
    var agriculturalCatergory = document.createElement("OPTION");
    var agriculturalCatergoryText = document.createTextNode("Agricultural");
    agriculturalCatergory.setAttribute("value", "Agricultural");
    agriculturalCatergory.appendChild(agriculturalCatergoryText);

    //append agricultural to select tag parent
    $("#listingSubCategory").append(agriculturalCatergory);


    //create 2nd option "Commercial"
    var commercialCatergory = document.createElement("OPTION");
    var commercialCatergoryText = document.createTextNode("Commercial");
    commercialCatergory.setAttribute("value", "Commercial");
    commercialCatergory.appendChild(commercialCatergoryText);
    //append commercial to select tag parent
    $("#listingSubCategory").append(commercialCatergory);

    //create 3rd option "industrial"
    var industrialCatergory = document.createElement("OPTION");
    var industrialCatergoryText = document.createTextNode("Industrial");
    industrialCatergory.setAttribute("value", "Industrial");
    industrialCatergory.appendChild(industrialCatergoryText);

    //append commercial to select tag parent
    $("#listingSubCategory").append(industrialCatergory);

    //create 4th option "Residential"
    var residentialCategory = document.createElement("OPTION");
    var residentialCatergoryText = document.createTextNode("Residential");
    residentialCategory.setAttribute("value", "Commercial");
    residentialCategory.appendChild(residentialCatergoryText);


    //append residential to select tag parent
    $("#listingSubCategory").append(residentialCategory);


    // unhide the sub category 
    $("#subCategoryHolder").removeClass('hidden');


    //OFFERTYPE VARIATION
    //clear the select parent
    $("#offerType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#offerType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#offerType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#offerType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#offerType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------




    // No. of Bedrooms and capacity of Garage Variation
    //Lot dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#noOfBedroomsHolder").addClass("hidden");
    $("#capacityOfGarageHolder").addClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here



  } else if (propertyType === "House and Lot") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#subCategoryHolder").addClass('hidden');
    //hide unit No
    $("#unitNoHolder").addClass("hidden");

    //OFFERTYPE VARIATION
    //clear the select parent
    $("#offerType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#offerType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#offerType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#offerType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#offerType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------

    // No. of Bedrooms and capacity of Garage Variation
    //House and Lot have No. of bedrooms and garage capacity
    //dont hide those inputs
    $("#noOfBedroomsHolder").removeClass("hidden");
    $("#capacityOfGarageHolder").removeClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Warehouse") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#subCategoryHolder").addClass('hidden');
    //hide unit No
    $("#unitNoHolder").addClass("hidden");



    //OFFERTYPE VARIATION
    //warehouse dont have preselling offertype
    //clear the select parent
    $("#offerType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#offerType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#offerType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append residential to select tag parent
    $("#offerType").append(thirdOption);

    //OFERTYPE VARTION ENDS HERE


    // No. of Bedrooms and capacity of Garage Variation
    //Warehouse dont have No. of bedrooms and garage capacity
    //hide thos inputs
    $("#noOfBedroomsHolder").addClass("hidden");
    $("#capacityOfGarageHolder").addClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here


  } else if (propertyType === "Office") {

    //there is no property type with sub category selected
    // hide the sub category 
    $("#subCategoryHolder").addClass('hidden');
    //hide unit No
    $("#unitNoHolder").addClass("hidden");


    //OFFERTYPE VARIATION
    //clear the select parent
    $("#offerType").empty();

    //create all options 
    var firstOption = document.createElement("OPTION");
    var firstOptionText = document.createTextNode("Select Offer Type");
    firstOption.setAttribute("value", "default");
    firstOption.appendChild(firstOptionText);


    //append firstOption to select tag parent
    $("#offerType").append(firstOption);


    var secondOption = document.createElement("OPTION");
    var secondOptionText = document.createTextNode("Sell");
    secondOption.setAttribute("value", "Sell");
    secondOption.appendChild(secondOptionText);

    //append secondOption to select tag parent
    $("#offerType").append(secondOption);


    var thirdOption = document.createElement("OPTION");
    var thirdOptionText = document.createTextNode("Rent");
    thirdOption.setAttribute("value", "Rent");
    thirdOption.appendChild(thirdOptionText);


    //append thirdOption to select tag parent
    $("#offerType").append(thirdOption);


    var fourthOption = document.createElement("OPTION");
    var fourthOptionText = document.createTextNode("Presell");
    fourthOption.setAttribute("value", "Presell");
    fourthOption.appendChild(fourthOptionText);


    //append fourthOption to select tag parent
    $("#offerType").append(fourthOption);

    // -----OFFERTYPE VARIATION ENDS HERE------


    // No. of Bedrooms and capacity of Garage Variation
    //Office dont have No. of bedrooms but have garage capacity
    //hide No. of Bedrooms input and dont hide capacity of Garage
    $("#noOfBedroomsHolder").addClass("hidden");
    $("#capacityOfGarageHolder").removeClass("hidden");
    //No. of Bedrooms and capacity of Garage Variation Ends Here
  }
}

// function condominiumBehavior(value) {



//   //get the sub category value
//   //IF IT IS PARKING display only Unit Not,Price,Floor Area, and Description

//   if (value === "Parking") {
//     //OFFERTYPE VARIATION

//     //PARKING will have offertype of Sell and Presell only
//     //clear the select parent
//     $("#offerType").empty();

//     //create all options 
//     var firstOption = document.createElement("OPTION");
//     var firstOptionText = document.createTextNode("Select Offer Type");
//     firstOption.setAttribute("value", "default");
//     firstOption.appendChild(firstOptionText);


//     //append firstOption to select tag parent
//     $("#offerType").append(firstOption);


//     var secondOption = document.createElement("OPTION");
//     var secondOptionText = document.createTextNode("Sell");
//     secondOption.setAttribute("value", "Sell");
//     secondOption.appendChild(secondOptionText);

//     //append secondOption to select tag parent
//     $("#offerType").append(secondOption);


//     var fourthOption = document.createElement("OPTION");
//     var fourthOptionText = document.createTextNode("Presell");
//     fourthOption.setAttribute("value", "Presell");
//     fourthOption.appendChild(fourthOptionText);


//     //append fourthOption to select tag parent
//     $("#offerType").append(fourthOption);

//     // -----OFFERTYPE VARIATION ENDS HERE------

//     // No. of Bedrooms and capacity of Garage Variation
//     //Condominium that has parking as sub category dont No. of bedrooms, garage capacity(separate input), and floor area
//     //parking als
//     $("#noOfBedroomsHolder").addClass("hidden");
//     $("#capacityOfGarageHolder").addClass("hidden");
//     //No. of Bedrooms and capacity of Garage Variation Ends Here


//     //floor area variation
//     $("#floorAreaHolder").addClass("hidden");

//   } else {
//     //OFFERTYPE VARIATION

//     //create all options 
//     var firstOption = document.createElement("OPTION");
//     var firstOptionText = document.createTextNode("Select Offer Type");
//     firstOption.setAttribute("value", "default");
//     firstOption.appendChild(firstOptionText);


//     //append firstOption to select tag parent
//     $("#offerType").append(firstOption);


//     var secondOption = document.createElement("OPTION");
//     var secondOptionText = document.createTextNode("Sell");
//     secondOption.setAttribute("value", "Sell");
//     secondOption.appendChild(secondOptionText);

//     //append secondOption to select tag parent
//     $("#offerType").append(secondOption);


//     var thirdOption = document.createElement("OPTION");
//     var thirdOptionText = document.createTextNode("Rent");
//     thirdOption.setAttribute("value", "Rent");
//     thirdOption.appendChild(thirdOptionText);


//     //append thirdOption to select tag parent
//     $("#offerType").append(thirdOption);


//     var fourthOption = document.createElement("OPTION");
//     var fourthOptionText = document.createTextNode("Presell");
//     fourthOption.setAttribute("value", "Presell");
//     fourthOption.appendChild(fourthOptionText);


//     //append fourthOption to select tag parent
//     $("#offerType").append(fourthOption);

//     // -----OFFERTYPE VARIATION ENDS HERE------


//     // No. of Bedrooms and capacity of Garage Variation
//     //Condominium that is not parking have No. of bedrooms and garage capacity
//     //dont hide those inputs
//     $("#noOfBedroomsHolder").removeClass("hidden");
//     $("#capacityOfGarageHolder").removeClass("hidden");
//     //No. of Bedrooms and capacity of Garage Variation Ends Here

//   }



// }



function priceVariation(value) {
  //display the options daily,weekly,monthly
  // console.log(value)
  if (value === "Rent") {
    $("#rentBtn").removeClass('hidden')
  } else {
    $("#rentBtn").addClass('hidden');
  }
}


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


//ADDING ATS (Authorization to Sell)
$("#addATSBtn").click(() => {
  $("#listingATS").click();
})

//check if there is an img for ATS
$("#listingATS").change("value", function () {
  var ATSDesc = $("#ATSDesc");
  //get create a preview of the img 
  var ATSFile = $("#ATSFile");
  if (this.value == "") {
    //show the button for adding file
    $("#addATSBtn").removeClass("hidden");

    //hide the note for changing ATS file
    $("#addATSNote").addClass("hidden");
    ATSFile.empty();
    Swal.fire({
      icon: "error",
      title: "No File found!",
      text: "Please select a file for your ATS."
    })
  } else {

    //clear first the container to prevent multiple entry
    ATSDesc.empty();
    //check for file extension
    var fileextension = this.files[0].type;
    //since input type only accept pdf and pictures

    if (fileextension === "application/pdf") {
      //if it is pdf display a default img
      var ATSFile = $("#ATSFile");
      //clear first the container to prevent multiple entry
      ATSFile.empty();

      var ATSImg = document.createElement("img");
      ATSImg.src = 'assets/img/file.png'
      ATSImg.style.height = "100px";
      ATSImg.style.width = "100px";
      ATSImg.style.marginLeft = "15px";
      ATSImg.style.cursor = "pointer";
      ATSImg.setAttribute("onclick", `document.querySelector("#listingATS").click()`);
      //append the img to container name "ATSFile"
      ATSFile.append(ATSImg);
    } else {

      //clear first the container to prevent multiple entry
      ATSFile.empty();

      var ATSImg = document.createElement("img");
      ATSImg.src = URL.createObjectURL(this.files[0]);
      ATSImg.style.height = "100px";
      ATSImg.style.width = "100px";
      ATSImg.style.marginLeft = "15px";
      ATSImg.style.cursor = "pointer";
      ATSImg.setAttribute("onclick", `document.querySelector("#listingATS").click()`);
      //append the img to container name "ATSFile"
      ATSFile.append(ATSImg);
    }


    //get the information of file besid its picture
    var fileInformation = document.createElement("p");
    var fileInformationText = document.createTextNode(`File Name: ${ this.files[0].name}`);
    fileInformation.append(fileInformationText);
    ATSDesc.append(fileInformation);

    var fileSize = document.createElement("p");
    var fileSizeText = document.createTextNode(`Size:  ${returnFileSize(this.files[0].size)}`);
    fileSize.append(fileSizeText);
    ATSDesc.append(fileSize);

    //hide the button for adding file
    $("#addATSBtn").addClass("hidden");

    //show the note for changing ATS file
    $("#addATSNote").removeClass("hidden");
  }
})


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


// ------------------BEHAVIORAL FUNCTIONS ENDS HERE-----------------------