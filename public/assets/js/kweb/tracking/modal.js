var MODAL_DIV_TRACKING_LABEL = $("#modalDivTrackingLabel");
var MODAL_DIV_TRACKING = $("#modalDivTracking");

$("#add-item-tracking").on("click", function() {
  MODAL_DIV_TRACKING_LABEL.text("Add Tracking");
  MODAL_DIV_TRACKING.modal("show");
});