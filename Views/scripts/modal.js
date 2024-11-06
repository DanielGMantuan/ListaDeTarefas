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

function changeOrder() {}
