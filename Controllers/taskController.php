<?php
    require_once "../Classes/tarefa.php";
    require_once "../DAOs/tarefaDAO.php";
    require_once "../utils/dateConvert.inc.php";
    require_once "../utils/MoneyConversion.php";

    session_start();
    
    $option = $_REQUEST['option'];

    if($option == 1){ // List all
        $dao = new TarefaDAO();
        $list = $dao->getAll();
        $_SESSION['tarefas'] = $list;

        backToHome();
    }
    else if($option == 2){ // Insert
        $dao = new TarefaDAO();
        $list = $dao->getAll();

        $order = count($list) + 1;

        $tarefa = new Tarefa();
        $tarefa->name = $_REQUEST['name'];
        $tarefa->cost = floatval(formatFromBR($_REQUEST['cost']));
        $tarefa->dateLimit = ConverterDataToMySQL($_REQUEST['dateLimit']);
        $tarefa->order = $order;

        var_dump($tarefa);
        $dao->insert($tarefa);

        backToHome();
    }
    else if($option == 3){ // Update
        
        $tarefa = new Tarefa();
        $tarefa->buildTarefa($_REQUEST['id'], $_REQUEST['name'], floatval(formatFromBR($_REQUEST['cost'])), ConverterDataToMySQL($_REQUEST['dateLimit']) );
        $dao = new TarefaDAO();
        $dao->update($tarefa);

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
                'cost' => $task->cost,
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

    function backToHome(){
        header('Location: ../Views/index.php');
    }
?>