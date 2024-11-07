$(document).ready(function () {
  function updateButtonVisibility() {
    $("table tbody tr").each(function (index) {
      var totalRows = $("table tbody tr").length;
      var moveUpButton = $(this).find(".moveUp");
      var moveDownButton = $(this).find(".moveDown");

      // Esconder o botão "Move Up" se for a primeira linha
      if (index === 0) {
        moveUpButton.hide();
      } else {
        moveUpButton.show();
      }

      // Esconder o botão "Move Down" se for a última linha
      if (index === totalRows - 1) {
        moveDownButton.hide();
      } else {
        moveDownButton.show();
      }
    });
  }

  updateButtonVisibility();

  // Mover para cima
  $(".moveUp").click(function () {
    var row = $(this).closest("tr");
    var prevRow = row.prev();
    if (prevRow.length) {
      row.insertBefore(prevRow); // Mover a linha para cima
      updateButtonVisibility();
    }
  });

  // Mover para baixo
  $(".moveDown").click(function () {
    var row = $(this).closest("tr");
    var nextRow = row.next();
    if (nextRow.length) {
      row.insertAfter(nextRow); // Mover a linha para baixo
      updateButtonVisibility();
    }
  });

  // Salvar a nova ordem
  $("#saveOrder").click(function () {
    var order = [];
    $("tbody tr").each(function (index) {
      var id = $(this).data("id");
      order.push({ id: id });
    });
    // Enviar a nova ordem via AJAX
    $.ajax({
      url: "../Controllers/taskController.php?option=6",
      type: "POST",
      data: { order: JSON.stringify(order) },
      success: function (response) {
        alert("Ordem salva com sucesso!");
      },
      error: function () {
        alert("Ocorreu um erro ao salvar a ordem.");
      },
    });
  });
});

function openModal(id) {
  document.querySelector("#modal").style.display = "flex";
  console.log("requisitacao");
  if (id == undefined || id == null) {
    document.querySelector("#modal form > p").textContent = "Add Task";
    document.querySelector(".buttons > button[type=submit]").textContent =
      "Submit";
    document.querySelector(".buttons > input[name=option]").value = "2";
    return;
  }

  console.log("requisitacao");
  fetch("../Controllers/taskController.php?option=5&id=" + id)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      document.querySelector("#modal form input[name=name]").value = data.name;
      document.querySelector("#modal form input[name=cost]").value = data.cost;
      document.querySelector(".buttons > input[name=id]").value = data.id;
      document.querySelector("#modal form input[name=dateLimit]").value =
        data.dateLimit;
    });
  document.querySelector("#modal form > p").textContent = "Edit Task";
  document.querySelector(".buttons > button[type=submit]").textContent = "Save";
  document.querySelector(".buttons > input[name=option]").value = "3";
}

function closeModal() {
  document.querySelector("#modal").style.display = "none";
  document.querySelector("#modal form input[name=name]").value = "";
  document.querySelector("#modal form input[name=cost]").value = "";
  document.querySelector("#modal form input[name=dateLimit]").value = "";
}

function deleteTask(id) {
  fetch("../Controllers/taskController.php?option=4&id=" + id);
}
