<?php
    require_once ( __DIR__  . "/Models/tarefa.php");
    require_once ( __DIR__  . "/utils/dateConvert.inc.php");
    require_once (__DIR__  . "/utils/MoneyConversion.php");

    session_start();

    if(!isset($_SESSION['tarefas']) && !isset($_SESSION['error'])){
        header('Location: '. __DIR__ .'/Controllers/taskController.php?option=1');
        exit;
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
    <link rel="stylesheet" href="./Views/css/style.css">
    <script lang="javascript" src="./Views/scripts/jquery-3.7.1.min.js"></script>
    <script lang="javascript" src="./Views/scripts/datePicker.js"></script>
    <script lang="javascript" src="./Views/scripts/modal.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <?php
        if (isset($_SESSION['error'])){
    ?>
        <script>
            // Exibe o alerta com a mensagem de erro
            alert("<?php echo addslashes(htmlspecialchars($_SESSION['error'])); ?>");

            // Após o alerta ser fechado, faz uma requisição AJAX para remover o erro da sessão
            window.onload = function() {
                alertDismissed();
            };

            function alertDismissed() {
                // Envia uma requisição para limpar a variável de sessão de erro
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../Controllers/taskController.php?option=7", true);
                xhr.send();
            }
        </script>
    <?php
        }
    ?>
    <header>
        <h1>Sistemas de Tarefas</h1>
    </header>

    <main>
        <div class="add">
            <button id="saveOrder">
                <img class="icon" src="../public/assets/diskette.png" alt="">
                <span>Save order</span>
            </button>
            <button onclick="openModal()">
                <img class="icon" src="../public/assets/plus.png" alt="">
                <span>Nova tarefa</span>
            </button>
        </div>
        <?php 
            if(empty($tarefas)){
                include_once('./Views/includes/emptyTable.php');
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
                        include('./Views/includes/cardTarefa.php'); 
                    } 
                ?>
            </tbody>
        </table>
        <?php
            }
        ?>
        <?php include_once('./Views/modals/taskModal.php'); ?>
    </main>
    <footer></footer>
</body>
</html>