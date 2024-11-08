<?php
// Incluir o Controller da Tarefa
require_once '../../controllers/TarefaController.php';

// Verificar o tipo de requisição
$option = isset($_REQUEST['option']) ? $_REQUEST['option'] : null;

try {
    // Chamar a função adequada no TarefaController
    $controller = new TaskController();
    
    switch ($option) {
        case 1: // Listar todas as tarefas
            echo $controller->getAll();
            break;
        
        case 2: // Inserir nova tarefa
            echo $controller->insert();
            break;
        
        case 3: // Atualizar tarefa existente
            echo $controller->update();
            break;
        
        case 4: // Deletar tarefa
            echo $controller->delete();
            break;
        
        case 5: // Buscar tarefa por ID
            echo $controller->getById();
            break;
        
        case 6: // Alterar posição das tarefas
            echo $controller->changePosition();
            break;
        
        case 7: // Limpar erro
            echo $controller->clearError();
            break;
        
        default:
            throw new Exception("Opção inválida");
    }
} catch (Exception $e) {
    // Caso ocorra erro, retornar o erro como JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>
