<?php
    require_once __DIR__ . "/utils/dateConvert.inc.php";
    require_once __DIR__ . "/utils/MoneyConversion.php";
    require_once __DIR__ . "/Models/tarefa.php";

    // Configurações de cookie
    ini_set('session.cookie_domain', '.lista-de-tarefas-beta.vercel.app');  // Permite que o cookie seja válido para todos os subdomínios
    ini_set('session.cookie_path', '/');  // O caminho do cookie, '/' indica que o cookie é válido para todo o site
    ini_set('session.cookie_secure', '1');  // Garante que o cookie só será enviado via HTTPS
    ini_set('session.cookie_samesite', 'None');

    // Função para configurar cookies com o nome e valor
    function setCookieData($name, $value, $expire = 0) {
        setcookie($name, $value, $expire, '/', '.lista-de-tarefas-beta.vercel.app', true, true);
    }

    // Função para pegar os dados de cookies
    function getCookieData($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    // Verifica se o cookie 'tarefas' ou 'error' existe
    if (!getCookieData('tarefas') && !getCookieData('error')) {
        // Redireciona para o controlador da tarefa com a opção 1 (listar todas as tarefas)
        header('Location: /api/taskController.php?option=1');
        exit;
    }

    // Obtém as tarefas do cookie
    $tarefas = Tarefa::fromArray(json_decode(getCookieData('tarefas'), true));
    var_dump($tarefas);
    // Limpa o cookie de tarefas (configura o cookie para expirar no passado)
    setCookieData('tarefas', '', time() - 3600);

    // Limpa o cookie de erro, se existir
    if (isset($_COOKIE['error'])) {
        setCookieData('error', '', time() - 3600);  // Exclui o cookie de erro
    }
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
        // Exibe o erro do cookie caso exista
        if (isset($_COOKIE['error'])) {
    ?>
        <script>
            // Exibe o alerta com a mensagem de erro
            alert("<?php echo addslashes(htmlspecialchars($_COOKIE['error'])); ?>");

            // Após o alerta ser fechado, faz uma requisição AJAX para remover o erro do cookie
            window.onload = function() {
                alertDismissed();
            };

            function alertDismissed() {
                // Envia uma requisição para limpar o cookie de erro
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "/taskController.php?option=7", true); // URL para limpar o erro
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

