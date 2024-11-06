<tr class="<?= $tarefa->cost >= 1000 ? 'mark' : '' ?>">
    <form action="../Controllers/taskController.php?option=4" method="POST">
        <td class="order">
            <?php 
            if($index != 0){
                echo ('<button type="button"><img class="icon" src="../assets/up-arrow.png" alt="Up"></button>');
            }
            ?>

            <span><?= $tarefa->id ?></span>
                
            <?php 
                if($index != count($tarefas) - 1){ 
                    echo ('<button type="button"><img class="icon" src="../assets/down-arrow.png" alt="Up"></button>');
                }
            ?>
        </td>
        <td>
            <p class="line-break">
                <?= $tarefa->name; ?>
            </p>
        </td> 
        <td>
            <?= 'R$ ' . $tarefa->cost; ?>
        </td>
        <td>
            <?= formatarData( $tarefa->dateLimit ) ?>
        </td>
        <td>
            <div class="actions">
                <button type="button" class="edit" onclick="openModal(<?= $tarefa->id ?>)"><img class="icon" src="../assets/edit.png" alt="Edit"></button>
                <input type="text" name="id" value="<?= $tarefa->id ?>" hidden>
                <button type="submit" ><img class="icon" src="../assets/delete.png" alt="Delete"></button>
            </div>
        </td>
    </form>
</tr>