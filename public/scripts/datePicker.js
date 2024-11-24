$(document).ready(function () {
  $("#datepicker").datepicker({
    dateFormat: "dd/mm/yy",
    onclose: function (date) {
      dateValidator(date);
    },
  });
});
