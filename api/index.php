<?php
    ini_set('session.cookie_domain', '.vercel.app');  // Permite que o cookie seja válido para todos os subdomínios
    ini_set('session.cookie_path', '/');  // O caminho do cookie, '/' indica que o cookie é válido para todo o site
    ini_set('session.cookie_secure', '1');  // Garante que o cookie só será enviado via HTTPS
    ini_set('session.cookie_samesite', 'None');
    session_start();  // Sempre após configurar os cookies
    
    require_once __DIR__ . "/utils/dateConvert.inc.php";
    require_once __DIR__ . "/utils/MoneyConversion.php";
    require_once __DIR__ . "/Models/tarefa.php";

    // // Verifica se a variável de sessão 'tarefas' ou 'error' está setada
    // if (!isset($_SESSION['tarefas']) && !isset($_SESSION['error'])) {
    //     // Redireciona para o controlador da tarefa com a opção 1 (listar todas as tarefas)
    //     header('Location: /api/taskController.php?option=1');
    //     exit;
    // }

    // // Obtém as tarefas da sessão
    // $tarefas = $_SESSION['tarefas'];

    // // Limpa a variável de sessão 'tarefas'
    // unset($_SESSION['tarefas']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <script src="/scripts/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/scripts/modal.js"></script>
    <script src="/scripts/datePicker.js"></script>
</head>
<body>
    <?php
        // Exibe o erro da sessão caso exista
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
                xhr.open("GET", "/api/taskController.php?option=7", true); // URL para limpar o erro
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
                <img class="icon" src="/assets/diskette.png" alt="">
                <span>Save order</span>
            </button>
            <button onclick="openModal()">
                <img class="icon" src="/assets/plus.png" alt="">
                <span>Nova tarefa</span>
            </button>
        </div>
        <?php 
            if (empty($tarefas)) {
                include_once( __DIR__ . '/Views/includes/emptyTable.php');
            } else {
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
                    // Loop através das tarefas e inclui o template do cartão de tarefa
                    foreach ($tarefas as $index => $tarefa) {
                        include(__DIR__ . '/Views/includes/cardTarefa.php');
                    }
                ?>
            </tbody>
        </table>
        <?php
            }
        ?>
        <?php include_once(__DIR__ . '/Views/modals/taskModal.php'); ?>
    </main>
    <footer></footer>
</body>
</html>
