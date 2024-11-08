<?php
    require_once __DIR__ . "/../Models/tarefa.php";
    require_once __DIR__ . "/conection.inc.php";
    require_once __DIR__ . "/../utils/dateConvert.inc.php";

    class TarefaDAO{
        private $con;

        public function __construct(){
            $c = new Conection();   
            $this->con = $c->getConexao();
        }

        public function getAll(){
            $sql = $this->con->prepare("SELECT * FROM tarefas ORDER BY presentation_order");
            $sql->execute();

            $list = array();

            while($row = $sql->fetch(PDO::FETCH_OBJ)){
                // $tarefa = new Tarefa();
                // $tarefa->buildTarefa($row->id, $row->name, $row->cost, strtotime($row->date_limit), $row->presentation_order);

                $list[] = $row;
            }

            return $list;
        }

        public function getById(int $id){
            $sql = $this->con->prepare("SELECT * FROM tarefas where id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($row = $sql->fetch(PDO::FETCH_OBJ)){
                $tarefa = new Tarefa();
                $tarefa->buildTarefa($row->id, $row->name, $row->cost, strtotime($row->date_limit), $row->presentation_order);

                return $tarefa;
            }

            return null;
        }

        public function insert(Tarefa $tarefa){
            $sql = $this->con->prepare("INSERT INTO tarefas (name, cost, date_limit, presentation_order) VALUES (:name, :cost, :dateLimit, :order)");
            $sql->bindValue(":name", $tarefa->name);
            $sql->bindValue(":cost", $tarefa->cost);
            $sql->bindValue(":dateLimit", $tarefa->dateLimit);
            $sql->bindValue(":order", $tarefa->order);
            $sql->execute();
        }

        public function update(Tarefa $tarefa){
            $sql = $this->con->prepare("UPDATE tarefas SET name = :name, cost = :cost, date_limit = :dateLimit WHERE id = :id");
            $sql->bindValue(":name", $tarefa->name);
            $sql->bindValue(":cost", $tarefa->cost);
            $sql->bindValue(":dateLimit", $tarefa->dateLimit);
            $sql->bindValue(":id", $tarefa->id);
            $sql->execute();
        }

        public function updateOrder($orderIds){
            foreach($orderIds as $index => $id){
                $sql = $this->con->prepare("UPDATE tarefas SET presentation_order = :order WHERE id = :id");
                $sql->bindValue(":order", $index + 1);
                $sql->bindValue(":id", $id);
                $sql->execute();
            }
        }

        public function delete(int $id){
            $sql = $this->con->prepare("DELETE FROM tarefas WHERE id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }

        public function verifyNameInUse(string $name, int $id = null ){
            // Cria a consulta SQL
            $sql = "SELECT COUNT(*) FROM tarefas WHERE name = :name";
                
            // Se estamos atualizando, não verificamos o próprio nome
            if ($id) {
                $sql .= " AND id != :excludeId";
            }

            // Prepara a consulta
            $stmt = $this->con->prepare($sql);

            // Vincula os parâmetros
            $stmt->bindValue(':name', $name);
            if ($id) {
                $stmt->bindValue(':excludeId', $id);
            }

            // Executa a consulta
            $stmt->execute();

            // Verifica se o nome já está em uso
            $count = $stmt->fetchColumn();

            // Retorna true se o nome já estiver em uso, caso contrário, false
            return $count > 0;
        }
    }
?>