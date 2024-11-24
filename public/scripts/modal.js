$(document).ready(function () {
  $("#modal form").submit(function (event) {
    event.preventDefault();
    if (!validateForm()) {
      alert("Formulario invalido");
      return;
    }
    this.submit();
  });

  function updateButtonVisibility() {
    $("table tbody tr").each(function (index) {
      var totalRows = $("table tbody tr").length;
      var moveUpButton = $(this).find(".moveUp");
      var moveDownButton = $(this).find(".moveDown");

      if (index === 0) {
        moveUpButton.hide();
      } else {
        moveUpButton.show();
      }

      if (index === totalRows - 1) {
        moveDownButton.hide();
      } else {
        moveDownButton.show();
      }
    });
  }

  updateButtonVisibility();

  $("#modal form input[name=cost]").on("input", function () {
    let currentValue = this.value;

    let cursorPosition = this.selectionStart;

    this.value = currentValue.replace(/[^0-9,]/g, "");

    this.setSelectionRange(cursorPosition, cursorPosition);
  });

  $("#modal form input[name=cost]").on("blur", function () {
    formatCurrency($(this));
  });

  $("#modal form input[name=name]").on("blur", function () {
    validateName();
  });

  $("#datepicker").on("blur", function () {
    dateValidator($("#datepicker").val());
  });

  $(".moveUp").click(function () {
    var row = $(this).closest("tr");
    var prevRow = row.prev();
    if (prevRow.length) {
      row.insertBefore(prevRow);
      updateButtonVisibility();
    }
    showSaveOrder();
  });

  $(".moveDown").click(function () {
    var row = $(this).closest("tr");
    var nextRow = row.next();
    if (nextRow.length) {
      row.insertAfter(nextRow);
      updateButtonVisibility();
    }
    showSaveOrder();
  });

  $("#saveOrder").click(function () {
    var order = [];
    $("tbody tr").each(function (index) {
      var id = $(this).data("id");
      order.push({ id: id });
    });
    $.ajax({
      url: "../taskController.php?option=6",
      type: "POST",
      data: { order: JSON.stringify(order) },
      success: function (response) {
        alert("Ordem salva com sucesso!");
        $("#saveOrder").css("display", "none");
      },
      error: function () {
        alert("Ocorreu um erro ao salvar a ordem.");
      },
    });
  });

  $("main table tbody").sortable({
    items: "tr",
    placeholder: "ui-sortable-placeholder",
    update: function (event, ui) {
      updateButtonVisibility();
      showSaveOrder();
    },
  });
});

function showSaveOrder() {
  $("#saveOrder").css("display", "flex");
}

function openModal(id) {
  $("#modal").css("display", "flex");
  $("html, body").addClass("modal-open");

  if (id == undefined || id == null) {
    $("#modal form > p").text("Add Task");
    $(".buttons > button[type=submit]").text("Submit");
    $(".buttons > input[name=option]").val("2");
    $("#modal form input[name=name]").focus();
    return;
  }

  fetch("../taskController.php?option=5&id=" + id)
    .then((response) => response.json())
    .then((data) => {
      $("#modal form input[name=name]").val(data.name);
      $("#modal form input[name=name]").focus();
      $("#modal form input[name=cost]").val(data.cost);
      $(".buttons > input[name=id]").val(data.id);
      $("#modal form input[name=dateLimit]").val(data.dateLimit);

      formatCurrency($("#modal form input[name=cost]"));
    });

  $("#modal form > p").text("Edit Task");
  $(".buttons > button[type=submit]").text("Save");
  $(".buttons > input[name=option]").val("3");
}

function closeModal() {
  $("#modal").css("display", "none");
  $("html, body").removeClass("modal-open");
  $("#modal form input[name=name]").val("");
  $("#modal form input[name=cost]").val("");
  $("#modal form input[name=dateLimit]").val("");
}

function deleteTask(id) {
  fetch("../taskController.php?option=4&id=" + id);
}

function formatCurrency(input) {
  validateCost(input);
  if (input.val()) {
    let value = input.val().replace(/[^\d,]/g, "");
    value = value.replace(",", ".");

    let formattedValue = parseFloat(value).toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL",
    });

    input.val(formattedValue);
  }
}

function validateForm() {
  validName = validateName();
  validCost = validateCost($("#modal form input[name=cost]"));
  validDate = dateValidator($("#modal form input[name=dateLimit]").val());

  if (validName && validCost && validDate) {
    return true;
  } else {
    return false;
  }
}

function validateName() {
  if (
    $("#modal form input[name=name]").val() == "" ||
    $("#modal form input[name=name]").val() == null
  ) {
    $("#modal form input[name=name]")
      .siblings(".error")
      .css("display", "block");
    return false;
  }
  $("#modal form input[name=name]").siblings(".error").css("display", "none");
  return true;
}

function validateCost(input) {
  if (input.val()) {
    let value = input.val().replace(/[^\d,]/g, "");
    value = value.replace(",", ".");
    if (value.length <= 12) {
      $("#modal form input[name=cost]")
        .siblings(".error")
        .css("display", "none");
      return true;
    }
  }
  $("#modal form input[name=cost]").siblings(".error").css("display", "block");
  return false;
}
