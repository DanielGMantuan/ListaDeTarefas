<?php
    require_once "../Classes/tarefa.php";
    require_once "../DAOs/tarefaDAO.php";
    require_once "../utils/dateConvert.inc.php";
    require_once "../utils/MoneyConversion.php";
    
    class TaskController{        
        public function getAll(){
            $dao = new TarefaDAO();
            $list = $dao->getAll();
            $_SESSION['tarefas'] = $list;
    
            $this->backToHome();
        }

        public function insert(){
            try{
                $this->validateEntries();
                $dao = new TarefaDAO();
                $list = $dao->getAll();
        
                $order = count($list) + 1;
    
                $tarefa = new Tarefa();
                $tarefa->name = $_REQUEST['name'];
                $tarefa->cost = formatFromBR($_REQUEST['cost']);
                $tarefa->dateLimit = ConverterDataToMySQL($_REQUEST['dateLimit']);
                $tarefa->order = $order;
                
                $dao->insert($tarefa);
            }
            catch(Exception $e){
                $_SESSION['error'] = $e->getMessage();
            }
    
            $this->backToHome();
        }

        public function update(){
            try{
                $this->validateEntries();
                $tarefa = new Tarefa();
                $tarefa->buildTarefa($_REQUEST['id'], $_REQUEST['name'], formatFromBR($_REQUEST['cost']), ConverterDataToMySQL($_REQUEST['dateLimit']) );
                $dao = new TarefaDAO();
                $dao->update($tarefa);
            }
            catch(Exception $e){
                $_SESSION['error'] = $e->getMessage();
            }
    
            $this->backToHome();
        }

        public function delete(){
            $id = $_REQUEST['id'];

            $dao = new TarefaDAO();
            $dao->delete($id);

            $this->backToHome();
        }

        public function getById(){
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

        public function changePosition(){
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

        public function clearError(){
            session_start();

            unset($_SESSION['error']);
            exit;
        }

        function backToHome(){
            header('Location: ../Views/index.php');
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
    }
?>