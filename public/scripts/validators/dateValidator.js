function dateValidator(date) {
  if (date) {
    const dateParts = date.split("/");
    const day = parseInt(dateParts[0], 10);
    const month = parseInt(dateParts[1], 10) - 1;
    const year = parseInt(dateParts[2], 10);

    if (isNaN(day) || isNaN(month) || isNaN(year)) return false;

    const dataObject = new Date(year, month, day);
    if (
      dataObject.getFullYear() === year &&
      dataObject.getMonth() === month &&
      dataObject.getDate() === day
    ) {
      $("#datepicker").siblings(".error").css("display", "none");
      return true;
    }
  }
  $("#datepicker").siblings(".error").css("display", "block");
  return false;
}
