<tr class="<?= $tarefa->cost >= 1000 ? 'mark' : '' ?>" data-id="<?= $tarefa->id ?>">
    <form action="../Controllers/taskController.php?option=4" method="POST">
        <td class="order">
            <button type="button"><img class="icon moveUp" src="../assets/up-arrow.png" alt="Up"></button>
            <span><?= $tarefa->id ?></span>
            <button type="button"><img class="icon moveDown" src="../assets/down-arrow.png" alt="Up"></button>
        </td>
        <td>
            <p class="line-break">
                <?= $tarefa->name; ?>
            </p>
        </td> 
        <td>
            <?= 'R$ ' . formatToBR($tarefa->cost) ?>
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