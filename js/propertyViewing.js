function viewProperty(propertyid) {
  $("#propertiesModal1").modal("show");

  // $("#propertyContainer").load("includes/loadproperty.inc.php", {
  //   campaignId: campaignId,
  // });

  // $("#propertyContainer").load("includes/loadproperty.inc.php", {
  //   campaignId: campaignId,
  // });
  $("#propertyContainer").load("includes/loadpropertyImgs.inc.php", {
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
}