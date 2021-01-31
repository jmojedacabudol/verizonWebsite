function viewCampaign(campaignId) {
  $("#propertiesModal1").modal("show");

  // $("#propertyContainer").load("includes/loadproperty.inc.php", {
  //   campaignId: campaignId,
  // });

  // $("#propertyContainer").load("includes/loadproperty.inc.php", {
  //   campaignId: campaignId,
  // });
  $("#propertyContainer").load("includes/loadpropertyImgs.inc.php", {
    campaignId: campaignId,
  }, function (callback) {
    // console.log("HGHGHGHGHGH"+callback)
  });

  $("#property-title").load('includes/loadpropertynameandprice.inc.php', {
    campaignId: campaignId,
  })
  $("#property-info").load('includes/loadpropertyinfo.inc.php', {
    campaignId: campaignId,
  })
}