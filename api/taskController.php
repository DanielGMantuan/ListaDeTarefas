<?php
    // Configuração do cookie
    ini_set('session.cookie_domain', 'lista-de-tarefas-beta.vercel.app');  // Permite que o cookie seja válido para todos os subdomínios
    ini_set('session.cookie_path', '/');  // O caminho do cookie, '/' indica que o cookie é válido para todo o site
    ini_set('session.cookie_secure', '1');  // Garante que o cookie só será enviado via HTTPS
    ini_set('session.cookie_samesite', 'None'); // Garante que o cookie seja enviado em contextos cross-site

    require_once __DIR__ . "/Models/tarefa.php";
    require_once __DIR__ . "/DAOs/tarefaDAO.php";
    require_once __DIR__ . "/utils/dateConvert.inc.php";
    require_once __DIR__ . "/utils/MoneyConversion.php";

    // Inicializar a sessão (mantido aqui caso precise para outras variáveis ou segurança)
    session_start();

    // Função para configurar cookies com o nome e valor
    function setCookieData($name, $value, $expire = 0) {
        setcookie($name, $value, $expire, '/', '.lista-de-tarefas-beta.vercel.app', true, true);
    }

    // Função para pegar os dados de cookies
    function getCookieData($name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    $option = $_REQUEST['option'];

    if($option == 1){ // List all
        try{
            $dao = new TarefaDAO();
            $list = $dao->getAll();
            setCookieData('tarefas', json_encode($list), time() + 3600);  // Armazenando as tarefas no cookie por 1 hora
        }
        catch(Exception $e){
            setCookieData('error', $e->getMessage(), time() + 3600);
        }
        backToHome();
    }
    else if($option == 2){ // Insert
        try{
            validateEntries();
            $dao = new TarefaDAO();
            $list = $dao->getAll();
    
            $order = count($list) + 1;

            $tarefa = new Tarefa();
            $tarefa->name = $_REQUEST['name'];
            $tarefa->cost = formatFromBR($_REQUEST['cost']);
            $tarefa->dateLimit = ConverterDataToMySQL($_REQUEST['dateLimit']);
            $tarefa->order = $order;

            if($dao->verifyNameInUse($tarefa->name)){
                throw new Exception("Ja existe uma tarefa com esse nome.");
            }
            
            $dao->insert($tarefa);
        }
        catch(Exception $e){
            setCookieData('error', $e->getMessage(), time() + 3600);
        }

        backToHome();
    }
    else if($option == 3){ // Update
        try{
            validateEntries();
            $tarefa = new Tarefa();
            $tarefa->buildTarefa($_REQUEST['id'], $_REQUEST['name'], formatFromBR($_REQUEST['cost']), ConverterDataToMySQL($_REQUEST['dateLimit']));
            $dao = new TarefaDAO();
            if($dao->verifyNameInUse($tarefa->name, $tarefa->id)){
                throw new Exception("Ja existe uma tarefa com esse nome.");
            }
            $dao->update($tarefa);
        }
        catch(Exception $e){
            setCookieData('error', $e->getMessage(), time() + 3600);
        }

        backToHome();
    }
    else if($option == 4){ // Delete
        $id = $_REQUEST['id'];

        $dao = new TarefaDAO();
        $dao->delete($id);
        
        backToHome();
    }
    else if($option == 5){ // Get by id
        $dao = new TarefaDao();
        $task = $dao->getById($_REQUEST['id']);
        
        if ($task) {
            header('Content-Type: application/json');
            echo json_encode([
                'id' => $task->id,
                'name' => $task->name,
                'cost' => formatToBR($task->cost),
                'dateLimit' => formatarData($task->dateLimit)
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Task not found']);
        }
        
        exit;
    }
    else if($option == 6){ // Change position
        $dao = new TarefaDao();
        $order = json_decode($_REQUEST['order'], true);

        $orderIds = array_map(function($item) {
            return $item['id']; 
        }, $order);

        $orderIds = array_unique($orderIds);
        
        $list = $dao->getAll();
        
        foreach($list as $index => $dbTask){
            if(!in_array($dbTask->id, $orderIds)){
                array_splice($orderIds, $index, 0, $dbTask->id);
            }
        }
        
        $dao->updateOrder($orderIds);

        exit;
    }
    else if($option == 7){  // Clear error
        setCookieData('error', '', time() - 3600);  // Excluir o cookie de erro
        exit;
     }

    function backToHome(){
        header('Location: /');
        exit;
    }

    function validateEntries(){
        $exceptions = array();

        if(!isset($_REQUEST['name']) && !isset($_REQUEST['cost']) && !isset($_REQUEST['dateLimit'])){
            throw new Exception("Error na requisicao favor concactar os admininistradores.");
        }

        if(empty($_REQUEST['name'])){
            $exceptions[] = "O campo nome nao pode ser vazio.";
        }

        if(empty($_REQUEST['cost'])){
            $exceptions[] = "O campo custo nao pode ser vazio.";
        }

        if(empty($_REQUEST['dateLimit'])){
            $exceptions[] = "O campo data limite nao pode ser vazio.";
        }

        if(count($exceptions) > 0){
            throw new Exception(implode("", $exceptions));
        }
    }
?>
