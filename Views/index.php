<?php
    require_once "../Classes/tarefa.php";
    require_once "../utils/dateConvert.inc.php";
    require_once "../utils/MoneyConversion.php";

    session_start();

    if(!isset($_SESSION['tarefas'])){
        header('Location: ../Controllers/taskController.php?option=1');
    }

    $tarefas = $_SESSION['tarefas'];

    unset($_SESSION['tarefas']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <link rel="stylesheet" href="./css/style.css">
    <script lang="javascript" src="./scripts/jquery-3.7.1.min.js"></script>
    
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
    <script lang="javascript" src="./scripts/datePicker.js"></script>
    <script lang="javascript" src="./scripts/modal.js"></script>
</head>
<body>
    <header>
        <h1>Sistemas de Tarefas</h1>
    </header>

    <main>
        <div class="add">
            <button onclick="openModal()">
                <img class="icon" src="../assets/plus.png" alt="">
                <span>Nova tarefa</span>
            </button>
            <button id="saveOrder">
                <img class="icon" src="../assets/plus.png" alt="">
                <span>Save order</span>
            </button>
        </div>
        <?php 
            if(empty($tarefas)){
                include_once('./includes/emptyTable.php');
            }
            else{
        ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Cost</th>
                    <th>Date limit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($tarefas as $index => $tarefa){
                        include('./includes/cardTarefa.php'); 
                    } 
                ?>
            </tbody>
        </table>
        <?php
            }
        ?>
        <?php include_once('./modals/taskModal.php'); ?>
    </main>
    <footer></footer>
</body>
</html>