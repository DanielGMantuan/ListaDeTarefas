<?php
    require_once ( __DIR__  . "/Models/tarefa.php");
    require_once ( __DIR__  . "/utils/dateConvert.inc.php");
    require_once (__DIR__  . "/utils/MoneyConversion.php");

    // ini_set('session.cookie_domain', '.vercel.app');  // Usando o domínio principal para todos os subdomínios
    // session_set_cookie_params([
    //     'lifetime' => 0,           // Cookie expira quando o navegador é fechado
    //     'path' => '/',             // O cookie está disponível em todo o site
    //     'domain' => '.vercel.app',  // Domínio compartilhado entre subdomínios
    //     'secure' => true,           // Requer HTTPS para enviar o cookie
    //     'httponly' => true,         // O cookie não é acessível via JavaScript
    //     'samesite' => 'None'        // Permite cookies em requisições cross-origin
    // ]);
    // session_start();

    // if(!isset($_SESSION['tarefas']) && !isset($_SESSION['error'])){
    //     header("Access-Control-Allow-Origin: https://lista-de-tarefas-beta.vercel.app");
    //     header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    //     header("Access-Control-Allow-Headers: Content-Type, Authorization");
    //     header("Access-Control-Allow-Credentials: true");
    //     header('Location: https://lista-de-tarefas-beta.vercel.app/api/Controllers/taskController.php?option=1');

    //     exit;
    // }

    // $tarefas = $_SESSION['tarefas'];

    // unset($_SESSION['tarefas']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/scripts/modal.js"></script>
    <script src="/scripts/datePicker.js"></script>
    <script src="/scripts/jquery-3.7.1.min.js"></script>

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
                xhr.open("GET", "<?= __DIR__ ?>/Controllers/taskController.php?option=7", true);
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
            if(empty($tarefas)){
                include_once( __DIR__  . '/Views/includes/emptyTable.php');
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
                        include(__DIR__ .'/Views/includes/cardTarefa.php'); 
                    } 
                ?>
            </tbody>
        </table>
        <?php
            }
        ?>
        <?php include_once(__DIR__  . '/Views/modals/taskModal.php'); ?>
    </main>
    <footer></footer>
</body>
</html>