<div id="modal">
    <form action="../taskController.php" method="POST">
        <p class="title">New Task</p>
        <div class="column-container">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-input" placeholder="Task name">
        </div>
        <div class="column-container">
            <label for="cost">Cost</label>
            <input type="text" name="cost" class="form-input" placeholder="Task cost">
        </div>
        <div class="column-container">
            <label for="dateLimit" for="datepicker">Date Limit</label>
            <input type="text" name="dateLimit" id="datepicker" class="form-input" placeholder="Choose date limit">
        </div>
        <div class="buttons">
            <input type="hidden" name="option" value="2">
            <input type="hidden" name="id">
            <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>